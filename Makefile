PHP_SERVICE := php-fpm

build:
	@docker-compose up -d

migration:
	@docker-compose exec -T $(PHP_SERVICE) bin/console doctrine:migrations:migrate

parse:
	@docker-compose exec -T $(PHP_SERVICE) bin/console app:books:parse

down:
	@docker-compose down --volumes
	@make -s clean
