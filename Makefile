.PHONY: up
up:
	docker compose up -d

.PHONY: down
down:
	docker compose down

.PHONY: start
start:
	docker compose start

.PHONY: stop
stop:
	docker compose stop

.PHONY: web
web:
	docker compose exec web /bin/ash

.PHONY: backend
backend:
	docker compose exec backend /bin/bash

.PHONY: db
db:
	docker compose exec db bash -c 'mysql -u root'

.PHONY: phpstan
phpstan:
	docker compose exec backend bash -c 'vendor/bin/phpstan clear-result-cache && vendor/bin/phpstan analyse'
