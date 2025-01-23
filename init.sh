#!/bin/bash
echo "Installing dependencies"
sudo docker exec -it php-container composer update
sudo docker exec -it php-container composer install

echo "Running database migrations..."
sudo docker exec -it php-container php /var/www/html/vendor/bin/phinx migrate

echo "Setup complete!"