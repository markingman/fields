# Makefile for local development

.DEFAULT_GOAL := help
.PHONY: help
NAME=fields-test
PHP_SERVER_CMD = php -S 0.0.0.0:80 -t /var/www/tests/fixtures/app/html /var/www/tests/fixtures/app/router.php

help:
	@grep -E '^[a-zA-Z0-9._-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ": ## "}; {printf "\033[36m%-28s\033[0m %s\n", $$1, $$2}' | sed 's/Makefile://g'

build8.3: ## Build a PHP 8.3 Docker image for local development
	@docker build --build-arg PHP_VERSION=8.3 -t $(NAME) .

build8.4: ## Build a PHP 8.4 Docker image for local development
	@docker build --build-arg PHP_VERSION=8.4 -t $(NAME) .

build8.5: ## Build a PHP 8.4 Docker image for local development
	@docker build --build-arg PHP_VERSION=8.5 -t $(NAME) .

run: ## Run container (`curl http://localhost/`)
	@docker run -d --rm \
	-v `pwd`:/var/www \
	-p 80:80 --name $(NAME) $(NAME) \
	sh -lc '$(PHP_SERVER_CMD)'

test: ## Run tests (can optionally use like `run test ARGS=tests/unit/ExampleTest.php --filter testSpecificMethod`)
	@docker run -it --rm \
	-v `pwd`:/var/www \
	-p 80:80 $(NAME) \
	sh -lc '$(PHP_SERVER_CMD) > /dev/null 2>&1 & \
		until curl -fsS http://127.0.0.1:80/ >/dev/null; do sleep 0.1; done && \
		vendor/bin/phpunit $(ARGS)'

analyse: ## Run analyse
	@docker run -it --rm \
	-v `pwd`:/var/www \
	$(NAME) \
	php -d memory_limit=196M vendor/bin/phpstan analyse -c phpstan.neon
