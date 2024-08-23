up:
    docker compose up -d

down:
    docker compose down

start:
    docker compose start

stop:
    docker compose stop

web:
    docker compose exec web /bin/ash

backend:
    docker compose exec backend /bin/bash

db:
    docker compose exec db bash -c 'mysql -u root'

phpstan *memory-limit="1G":
    docker compose exec backend bash -c 'vendor/bin/phpstan clear-result-cache && vendor/bin/phpstan analyse --memory-limit {{ memory-limit }}'

pint:
    docker compose exec backend bash -c 'vendor/bin/pint'

phpunit:
    docker compose exec backend bash -c 'php artisan config:clear && php artisan test'
