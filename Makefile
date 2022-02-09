PHP 			= docker compose exec -u www-data app php
COMPOSER 		= $(PHP) /usr/bin/composer
NODE 			= docker compose run --rm -u node node
YARN  			= $(NODE) yarn

.DEFAULT_GOAL := help

help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
.PHONY: help

##
## Docker stack
## -------
##

build: 					 	## Build project images
	@docker compose pull --parallel --quiet --ignore-pull-failures 2> /dev/null
	@docker compose build --pull

dc: 						## Shortcut to docker compose command (ex : make dc c="logs -f")
	@docker compose ${c}

down: 						## Kill and removes containers and volumes
	@docker compose kill
	@docker compose down -v --remove-orphans

install: build up 			## Initialize and start project

logs:						## Show project containers logs
	@docker compose logs -f ${c}

up:							## Start project containers
	@docker compose up -d --force-recreate
	@$(PHP) -r 'echo "Waiting for initial installation ..."; for(;;) { if (false === file_exists("/tmp/DOING_COMPOSER_INSTALL")) { echo " Ready !\n"; break; }}'

.PHONY: build clean dc down install up

##
## Application
## -------
##

assets: 					## Compile frontend assets using Webpack in node container
	@$(YARN) run build

composer:  					## Shortcut to use Composer within project app container (ex : make composer c="install --no-suggest")
	@$(COMPOSER) ${c}

console: 					## Shortcut to use Symfony console within project app container (ex : make console c="ca:cl")
	@$(PHP) bin/console ${c}

yarn:  						## Shortcut to use Yarn within node container (ex : make yarn c="add --save-dev webpack")
	@$(YARN) ${c}

.PHONY: assets composer console yarn

##
## Tests & QA
## -------
##

create_test_db:
	@docker compose run --rm database sh -c 'mysql -hdatabase -uroot -p$${MYSQL_ROOT_PASSWORD} -e "DROP DATABASE IF EXISTS $${MYSQL_DATABASE}_test; CREATE DATABASE $${MYSQL_DATABASE}_test; GRANT ALL ON $${MYSQL_DATABASE}_test.* TO \"$${MYSQL_USER}\""'
	@docker compose run --rm -e APP_ENV=test app sh -c 'php -d memory_limit=-1 bin/console --no-interaction doctrine:schema:update --force --dump-sql'

phpcs: 						## Run PHPCS QA
	@docker compose run --rm -e APP_ENV=test app php -d memory_limit=-1 vendor/bin/php-cs-fixer fix --config=config/.php_cs.dist.php --dry-run --diff --verbose --allow-risky=yes

phpunit: create_test_db		## Run phpunit tests suite
	@docker compose run --rm -e APP_ENV=test app php -d memory_limit=-1 vendor/bin/phpunit -c config/.phpunit.xml.dist

psalm: 						## Run Psalm static code analysis
	@docker compose run --rm -e APP_ENV=test app php -d memory_limit=-1 vendor/bin/psalm -c config/.psalm.xml ${c}

tests: phpunit psalm 		## Run all tests and QA

.PHONY: phpunit psalm tests
