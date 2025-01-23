#!/bin/bash
echo "!IMPORTANT! DON'T FORGET ABOUT WRITING YOUR OWN DATA INTO CONFIGS LIKE A .ENV IN PROJECT CORE AND CONFIG.NEON IN CONFIG FOLDER"

echo "Installing dependencies"
sudo docker exec -it php-container composer update
sudo docker exec -it php-container composer install

echo "Copying config.neon"
sudo docker exec -it php-container cp config.example.neon config/config.neon

echo "Running database migrations..."
sudo docker exec -it php-container php /var/www/html/vendor/bin/phinx migrate

echo "Setup complete!"