run:
	docker compose up -d

env:
	cp .env.example .env

migrate:
	docker compose run --rm laravel php artisan migrate

bash:
	docker compose exec app bash

down:
	docker compose down -v --rmi all

stop:
	docker compose stop

build:
	docker compose up --build
