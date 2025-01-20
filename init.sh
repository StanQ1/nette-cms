#!/bin/bash

echo "Copying .env file"
cp .env.example .env

echo "Please, fill your own data into the .env file before proceeding."
read -r -p "Press Enter to confirm that you have filled the .env file..."

echo "Starting docker containers"
sudo docker-compose up -d --build

echo "Creating and setting right permissions to writable folders"
sudo docker exec -it $(docker ps -q -f name=php-container) mkdir -p /application/temp /application/log
sudo docker exec -it $(docker ps -q -f name=php-container) chmod -R 775 /application/temp /application/log

echo "Copying app configuration file"
sudo docker exec -it $(docker ps -q -f name=php-container) cp /application/config.example.neon /application/config/config.neon

echo "Please, fill your own data into the config.neon file before proceeding."
read -r -p "Press Enter to confirm that you have filled the config.neon file..."

echo "Installing dependencies"
sudo docker exec -it $(docker ps -q -f name=php-container) composer update
sudo docker exec -it $(docker ps -q -f name=php-container) composer install

echo "Running database migrations..."
sudo docker exec -it $(docker ps -q -f name=php-container) php vendor/bin/phinx migrate

echo "Setup complete!"
