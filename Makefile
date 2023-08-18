PHP_SERVICE := php-fpm

up:
	@docker-compose up -d

migration:
	@docker-compose exec -T $(PHP_SERVICE) bin/console doctrine:migrations:migrate

parse:
	@docker-compose exec -T $(PHP_SERVICE) bin/console app:books:parse

down:
	@docker-compose down --volumes
