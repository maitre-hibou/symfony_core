SHELL  			:= /bin/bash
DOCKER_COMPOSE 	= docker-compose
PHP 			= $(DOCKER_COMPOSE) exec -u www-data app php -d memory_limit=-1
COMPOSER 		= $(PHP) /usr/bin/composer
CONSOLE 		= $(PHP) bin/console
YARN 			= $(DOCKER_COMPOSE) run --rm -u node node yarn

.DEFAULT_GOAL := help

help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
.PHONY: help

##
## Docker stack
## -------
##

build:  					## Build project images
	@$(DOCKER_COMPOSE) pull --parallel --quiet --ignore-pull-failures 2> /dev/null
	$(DOCKER_COMPOSE) build --pull

docker-compose:
	@$(DOCKER_COMPOSE) ${c}

down: 						## Kill and removes containers and volumes
	@read -r -p "Are you sure ? [Y/n] " -n 1 input; \
	if [[ $$input =~ ^[Y]$$ ]]; then \
	  $(DOCKER_COMPOSE) kill; \
	  $(DOCKER_COMPOSE) down -v --remove-orphans; \
	fi

install: build up 			## Initialize and start project

logs:						## Show project containers logs
	$(DOCKER_COMPOSE) logs -f ${c}

stop: 						## Stop project containers
	$(DOCKER_COMPOSE) stop

up:							## Start project containers
	@$(DOCKER_COMPOSE) up -d --force-recreate
	@$(PHP) -r 'echo "Waiting for initial installation ..."; for(;;) { if (false === file_exists("/tmp/DOING_COMPOSER_INSTALL")) { echo " Ready !\n"; break; }}'

.PHONY: build clean docker-compose down install stop up

##
## Application
## -------
##

cache:  					## Reset app cache
	@$(CONSOLE) ca:cl
	@$(CONSOLE) ca:wa

composer: 					## Shortcut to use Composer within project app container (ex : make composer c="install --no-suggest")
	@$(COMPOSER) ${c}

console:					## Execute command in Symfony console (ex : make console c="ca:cl")
	@$(CONSOLE) ${c}

.PHONY: cache composer console

##
## Tests & QA
## -------
##

create_test_env:
	@$(DOCKER_COMPOSE) run --rm database sh -c 'mysql -hdatabase -uroot -p$${MYSQL_ROOT_PASSWORD} -e "DROP DATABASE IF EXISTS $${MYSQL_DATABASE}_test; CREATE DATABASE $${MYSQL_DATABASE}_test; GRANT ALL ON $${MYSQL_DATABASE}_test.* TO \"$${MYSQL_USER}\""'
	@$(DOCKER_COMPOSE) run --rm -e APP_ENV=test app sh -c '\
		php -d memory_limit=-1 bin/console --no-interaction doctrine:schema:create &&\
		php -d memory_limit=-1 bin/console --no-interaction doctrine:fixtures:load --append'

lint-twig:
	@$(DOCKER_COMPOSE) run --rm -e APP_ENV=test app php -d memory_limit=-1 bin/console lint:twig resources/templates/

lint-yaml:
	@$(DOCKER_COMPOSE) run --rm -e APP_ENV=test app php -d memory_limit=-1 bin/console lint:yaml config/

lints: lint-twig lint-yaml 	## Execute Symfony linters on twig templates and yaml config files

phpcs: 						## Run php-cs-fixer QA tool in dry run mode
	@$(DOCKER_COMPOSE) run --rm -e APP_ENV=test app vendor/bin/php-cs-fixer fix --config=config/.php_cs.dist.php --dry-run --diff --verbose

phpstan: 					## Run phpstan static code analysis
	@$(DOCKER_COMPOSE) run --rm -e APP_ENV=test app sh -c 'php -d memory_limit=-1 vendor/bin/phpstan analyse -c config/.phpstan.neon --level 6 src/ &&\
		php -d memory_limit=-1 vendor/bin/phpstan analyse -c config/.phpstan.neon --level 1 tests/'

phpunit: 					## Run phpunit tests suite
	@$(DOCKER_COMPOSE) run --rm -e APP_ENV=test app php -d memory_limit=-1 vendor/bin/phpunit -c config/.phpunit.dist.xml

tests: lints phpcs phpstan create_test_env phpunit	## Run full QA & tests tools

.PHONY: create_test_env lint-twig lint-yaml lints phpcs phpstan phpunit tests
