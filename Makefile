DOCKER_COMPOSE 	= docker compose
IS_DOCKER_COMPOSE_2 = $($(DOCKER_COMPOSE) ps 2> /dev/null; echo $$?)
ifeq ($(IS_DOCKER_COMPOSE_2),1)
	DOCKER_COMPOSE 	= docker-compose
endif

PHP 			= $(DOCKER_COMPOSE) exec -u www-data app php
COMPOSER 		= $(PHP) /usr/bin/composer
NODE 			= $(DOCKER_COMPOSE) run --rm -u node node
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
	@$(DOCKER_COMPOSE) pull --parallel --quiet --ignore-pull-failures 2> /dev/null
	@$(DOCKER_COMPOSE) build --pull

dc: 						## Shortcut to $(DOCKER_COMPOSE) command (ex : make dc c="logs -f")
	@$(DOCKER_COMPOSE) ${c}

down: 						## Kill and removes containers and volumes
	@$(DOCKER_COMPOSE) kill
	@$(DOCKER_COMPOSE) down -v --remove-orphans

install: build up 			## Initialize and start project

logs:						## Show project containers logs
	@$(DOCKER_COMPOSE) logs -f ${c}

up:							## Start project containers
	@$(DOCKER_COMPOSE) up -d --force-recreate
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
	@$(DOCKER_COMPOSE) run --rm database sh -c 'mysql -hdatabase -uroot -p$${MYSQL_ROOT_PASSWORD} -e "DROP DATABASE IF EXISTS $${MYSQL_DATABASE}_test; CREATE DATABASE $${MYSQL_DATABASE}_test; GRANT ALL ON $${MYSQL_DATABASE}_test.* TO \"$${MYSQL_USER}\""'
	@$(DOCKER_COMPOSE) run --rm -e APP_ENV=test app sh -c 'php -d memory_limit=-1 bin/console --no-interaction doctrine:schema:update --force --dump-sql'

phpcs: 						## Run PHPCS QA
	@$(DOCKER_COMPOSE) run --rm -e APP_ENV=test app php -d memory_limit=-1 vendor/bin/php-cs-fixer fix --config=config/.php_cs.dist.php --dry-run --diff --verbose --allow-risky=yes

phpunit: create_test_db		## Run phpunit tests suite
	@$(DOCKER_COMPOSE) run --rm -e APP_ENV=test app php -d memory_limit=-1 vendor/bin/phpunit -c config/.phpunit.dist.xml

psalm: 						## Run Psalm static code analysis
	@$(DOCKER_COMPOSE) run --rm -e APP_ENV=test app php -d memory_limit=-1 vendor/bin/psalm -c config/.psalm.xml ${c}

quality: phpcs				## Run all quality checks

tests: phpunit psalm 		## Run all tests suites

.PHONY: create_test_db phpcs phpunit psalm quality tests
