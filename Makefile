# Constants
PHP_CONTAINER = php-container

# Commands

# Docker manage
up:
	docker-compose up --build

down:
	docker-compose down

restart:
	docker-compose down
	docker-compose up --build

stop:
	docker-compose stop

# Remove containers
rm:
	docker-compose rm

# Clear docker images
prune:
	docker volume prune

# List of all running containers
containers:
	docker ps -a

# First initialization
setup:
	chmod +x init.sh
	./init.sh

# Enter Docker to write non-typical commands
docker:
	docker exec -it $(PHP_CONTAINER) bash

# Composer install
composer:
	docker exec -it $(PHP_CONTAINER) composer install

# Phinx DB migrations
migrate:
	docker exec -it $(PHP_CONTAINER) vendor/bin/phinx migrate

rollback:
	docker exec -it $(PHP_CONTAINER) vendor/bin/phinx rollback

# Clear nette cache
clean:
	docker exec -it $(PHP_CONTAINER) rm -rf ./temp/cache