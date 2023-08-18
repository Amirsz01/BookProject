PHP_SERVICE := php-fpm

build:
	@docker-compose build

up:
	@docker-compose up -d

composer:
	@docker-compose exec -T $(PHP_SERVICE) composer install

migration:
	@docker-compose exec -T $(PHP_SERVICE) bin/console doctrine:migrations:migrate

parse:
	@docker-compose exec -T $(PHP_SERVICE) bin/console app:books:parse

down:
	@docker-compose down --volumes
