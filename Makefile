# Makefile for local development

.DEFAULT_GOAL := help
.PHONY: help
NAME=fields-test
PHP_SERVER_CMD = php -S 0.0.0.0:80 -t /var/www/tests/fixtures/app/html /var/www/tests/fixtures/app/router.php

help:
	@grep -E '^[a-zA-Z0-9._-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ": ## "}; {printf "\033[36m%-28s\033[0m %s\n", $$1, $$2}' | sed 's/Makefile://g'

build8.3: ## Build a PHP 8.3 Docker image for local development
	@docker build --build-arg PHP_VERSION=8.3 --no-cache -t $(NAME) .

build8.4: ## Build a PHP 8.4 Docker image for local development
	@docker build --build-arg PHP_VERSION=8.4 -t $(NAME) .

run: ## Run container (`curl http://localhost/`)
	@docker run -d --rm \
	-v `pwd`/src:/var/www/src \
	-v `pwd`/tests:/var/www/tests \
	-v `pwd`/phpunit-coverage:/var/www/phpunit-coverage \
	-p 80:80 --name $(NAME) $(NAME) \
	sh -lc '$(PHP_SERVER_CMD)'

test: ## Run tests
	@docker run -it --rm \
	-v `pwd`/src:/var/www/src \
	-v `pwd`/tests:/var/www/tests \
	-v `pwd`/phpunit-coverage:/var/www/phpunit-coverage \
	-p 80:80 $(NAME) \
	sh -lc '$(PHP_SERVER_CMD) > /dev/null 2>&1 & \
		until curl -fsS http://127.0.0.1:80/ >/dev/null; do sleep 0.1; done && \
		vendor/bin/phpunit --no-coverage'
	
analyse: ## Run analyse
	@docker run -it --rm \
	-v `pwd`/src:/var/www/src \
	-v `pwd`/tests:/var/www/tests $(NAME) \
	php -d memory_limit=256M vendor/bin/phpstan analyse -c phpstan.neon
