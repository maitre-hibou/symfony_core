DOCKER_COMPOSE 	= docker compose
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

dc: 						## Shortcut to docker compose command (ex : make dc c="logs -f")
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

phpunit: 					## Run phpunit tests suite
	@$(DOCKER_COMPOSE) run --rm -e APP_ENV=test app php -d memory_limit=-1 vendor/bin/phpunit -c config/.phpunit.xml.dist

psalm: 						## Run Psalm static code analysis
	@$(DOCKER_COMPOSE) run --rm -e APP_ENV=test app php -d memory_limit=-1 vendor/bin/psalm -c config/.psalm.xml ${c}

tests: phpunit psalm 		## Run all tests and QA

.PHONY: phpunit psalm tests
