# vim: set tabstop=8 softtabstop=8 noexpandtab:
.PHONY: help
help: ## Displays this list of targets with descriptions
	@grep -E '^[a-zA-Z0-9_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: check-symfony
check-symfony: ## Checks if the symfony binary is installed
	@command -v symfony >/dev/null 2>&1 || { echo >&2 "Symfony binary is not installed. Please install it first. https://github.com/symfony-cli/symfony-cli"; exit 1; }

.PHONY: cs
cs: check-symfony vendor ## Normalizes composer.json with ergebnis/composer-normalize and fixes code style issues with friendsofphp/php-cs-fixer
	symfony composer normalize
	mkdir -p .build/php-cs-fixer
	symfony php vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --diff --verbose

.PHONY: static-code-analysis
static-code-analysis: check-symfony vendor ## Runs a static code analysis with phpstan/phpstan
	symfony php vendor/bin/phpstan analyse --configuration=phpstan-default.neon.dist --memory-limit=-1

.PHONY: static-code-analysis-baseline
static-code-analysis-baseline: check-symfony vendor ## Generates a baseline for static code analysis with phpstan/phpstan
	symfony php vendor/bin/phpstan analyze --configuration=phpstan-default.neon.dist --generate-baseline=phpstan-default-baseline.neon --memory-limit=-1

.PHONY: tests
tests: check-symfony vendor
	symfony php vendor/bin/phpunit tests

.PHONY: vendor
vendor: composer.json composer.lock ## Installs composer dependencies
	symfony composer install

.PHONY: refactoring
refactoring: check-symfony vendor ## Refactor the code using rector/rector
	symfony php vendor/bin/rector process --config rector.php
