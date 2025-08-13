init:	docker-down-clear docker-pull docker-build-pull docker-up app-init
down:	docker-down-clear
start:	docker-up
stop: docker-stop
check: cs-fix analyze test

docker-up:
	docker-compose up -d

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build-pull:
	docker-compose build --pull

docker-stop:
	docker-compose stop

app-init: composer-install

composer-install:
	docker-compose run --rm php-cli composer install

lint:
	docker-compose run --rm php-cli composer php-cs-fixer fix -- --dry-run --diff --show-progress=dots

cs-fix:
	docker-compose run --rm php-cli composer php-cs-fixer fix -- --show-progress=dots

analyze:
	docker-compose run --rm php-cli composer psalm -- --no-diff

test:
	docker-compose run --rm php-cli composer test