# —— Inspired by ———————————————————————————————————————————————————————————————
# https://www.strangebuzz.com/en/snippets/the-perfect-makefile-for-symfony

# Parameters
PROJECT       = azimer

# Executables
EXEC_PHP      = php
COMPOSER      = composer
GIT           = git

# Alias
SYMFONY       = $(EXEC_PHP) bin/console
# if you use Docker you can replace with: "docker-compose exec my_php_container $(EXEC_PHP) bin/console"

# Executables: vendors
PEST       = ./vendor/bin/pest --configuration=phpunit.unit.xml
PHPSTAN       = ./vendor/bin/phpstan
PHP_CODE_SNIFFER  = ./vendor/bin/phpcs
PHP_CBF  = ./vendor/bin/phpcbf
PSALM = ./vendor/bin/psalm

# Executables: local only
SYMFONY_BIN   = symfony
DOCKER        = docker
DOCKER_COMP   = docker compose

# Misc
.DEFAULT_GOAL = help

## —— The Azimer Symfony Makefile ———————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Composer 🧙‍♂️ ————————————————————————————————————————————————————————————
install: composer.lock ## Install vendors according to the current composer.lock file
	@$(COMPOSER) install --no-progress --prefer-dist --optimize-autoloader

## —— XDEBUG 🧙‍♂️ ————————————————————————————————————————————————————————————
xdebug-config: composer.lock ## Check current xdebug config
	@$(EXEC_PHP) -i | grep xdebug.mode
	@$(EXEC_PHP) -i | grep xdebug.client_port
	@$(EXEC_PHP) -i | grep xdebug.start_with_request
	@$(EXEC_PHP) -i | grep xdebug.client_host
	@$(EXEC_PHP) -i | grep xdebug.discover_client_host
	@$(EXEC_PHP) -i | grep xdebug.log

## —— Symfony 🎵 ———————————————————————————————————————————————————————————————
sf: ## List all Symfony commands
	@$(SYMFONY)

cc: ## Clear the cache. DID YOU CLEAR YOUR CACHE????
	@$(SYMFONY) c:c

fix-var-perms: ## Fix permissions of all var files
	@chmod -R 777 var/*

assets: purge ## Install the assets with symlinks in the public folder
	@$(SYMFONY) assets:install public/  # Don't use "--symlink --relative" with a Docker env

purge: ## Purge cache and logs
	@rm -rf var/cache/* var/logs/*

## —— elasticsearch 🔎 —————————————————————————————————————————————————————————
populate: ## Reset and populate the Elasticsearch index
	@$(SYMFONY) fos:elastica:populate

list-index: ## List all indexes on the cluster - TODO port from parameter
	@curl http://localhost:9209/_cat/indices?v

delete-index: ## Delete a given index (parameters: index=app_2021-01-05-075600")
	@curl -X DELETE "localhost:9209/$(index)?pretty"

## —— Docker 🐳 ————————————————————————————————————————————————————————————————
up: ## Start the docker hub
	HTTP_PORT=77 HTTPS_PORT=777 HTTP3_PORT=777 XDEBUG_MODE=debug $(DOCKER_COMP) up

build-fresh: ## Builds the images (php + caddy)
	$(DOCKER_COMP) build --pull --no-cache

build: ## Builds the images (php + caddy)
	$(DOCKER_COMP) build

down: ## Stop the docker hub
	$(DOCKER_COMP) down --remove-orphans

fix-owner: ## Fix ownership on project files
	$(DOCKER_COMP) run --rm $(EXEC_PHP) chown -R $(id -u):$(id -g) .

sh: ## Log to the docker container
	@$(DOCKER_COMP) exec php sh

bash: ## Connect to the application container
	@$(DOCKER_COMP) exec php bash

db: ## Connect to the database container
	@$(DOCKER_COMP) exec database psql -U app

logs: ## Show live logs
	@$(DOCKER_COMP) logs --tail=0 --follow

## —— Project 🐝 ———————————————————————————————————————————————————————————————
commands: ## Display all commands in the project namespace
	@$(SYMFONY) list $(PROJECT)

## —— Tests ✅ —————————————————————————————————————————————————————————————————
test: ## Run PEST tests with optional filter
	@$(eval filter := $(filter-out $@,$(MAKECMDGOALS)))
	@if [ -n "$(filter)" ]; then \
		$(PEST) --filter="$(filter)"; \
	else \
		$(PEST); \
	fi

## —— Coding standards ✨ ——————————————————————————————————————————————————————
cs: ## Run php code sniffer
	@$(PHP_CODE_SNIFFER) src tests

cs-fix: ## Run tool fixing phpcs errors
	@$(PHP_CBF) src tests

stan: ## Run phpstan analysis
	@$(PHPSTAN) analyse src tests --memory-limit=1G

psalm: ## Run PSALM analysis
	@$(PSALM)

quality: coverage cs-fix cs psalm stan ## Run full quality check

coverage: ## Create the code coverage report with PEST
	@XDEBUG_MODE=coverage $(PEST) --coverage --min=90
