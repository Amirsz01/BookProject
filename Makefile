PHP_SERVICE := php-fpm

build:
	@docker-compose up

migration:
	@docker-compose exec -T $(PHP_SERVICE) bin/console doctrine:migrations:migrate

parse:
	@docker-compose exec -T $(PHP_SERVICE) bin/console app:books:parse

