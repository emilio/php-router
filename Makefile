PHPCS := ./vendor/squizlabs/php_codesniffer/scripts/phpcs
PHPCFB := ./vendor/squizlabs/php_codesniffer/scripts/phpcbf
PHPUNIT := ./vendor/phpunit/phpunit/phpunit
PHPDOC := ./vendor/phpdocumentor/phpdocumentor/bin/phpdoc
PHP_STANDARD ?= PSR2

.PHONY: tests
tests:
	$(PHPCS) --standard=$(PHP_STANDARD) src tests
	$(PHPUNIT) -v --bootstrap vendor/autoload.php tests

.PHONY: autofix
autofix:
	$(PHPCFB) --standard=$(PHP_STANDARD) src tests

docs:
	$(PHPDOC) -d src -t docs
