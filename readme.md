[ENG] OPTIONALLY in case if you use docker (else you can skip this step):

!IMPORTANT! If you use docker: in any configs into HOST fields write container names

Copy environment example file to use:
	cp .env.example .env

	1.1. Fill data into copied file by example
	...
	# PORTS
	PHPMYADMIN_PORT="8080:80"
	...

1. Chmoding ONLY writable folders
	chmod -R 775 ./application/temp
	chmod -R 775 ./application/log

	1.1 If they not exists just create:
		mkdir temp/ log/

Before second step you must install, configure and start MYSQL server
2. Configuring NETTE application
		cd ./application

	2.1: Inside a application folder in terminal write next commands:
		composer update
		composer install

	2.2: Before composer configuration let's copy main neon config:
		cp config.example.neon ./config/config.neon

	2.3: Fill gapes by example:
		...
		database:
			...
			user: 'root'
			...

3. Migrate basic tables
	php vendor/bin/phinx migrate

	Default admin login: cmshero
	Default admin password: heropassword

	!IMPORTANT! But if you using docker, you must migrate from docker container with command:
		docker exec -it php-container bash
		php vendor/bin/phinx migrate

	Next instructions on web. Enjoy that!


---

[CS] OPTIONÁLNĚ, pokud používáte Docker (jinak tento krok přeskočte):

!DŮLEŽITÉ! Pokud používáte Docker: do všech konfiguračních souborů, kde jsou pole HOST, zadejte názvy kontejnerů.

Kopírování příkladového souboru prostředí pro použití:
	cp .env.example .env

	Vyplňte data do zkopírovaného souboru podle příkladu:
	...
	#PORTS
	PHPMYADMIN_PORT="8080:80"
	...

1. Nastavení přístupových práv pouze pro zapisovatelné složky:
	chmod -R 775 ./application/temp
	chmod -R 775 ./application/log

	1.1. Pokud složky neexistují, vytvořte je:
		mkdir temp/ log/

Před druhým krokem musíte nainstalovat, nakonfigurovat a spustit MySQL server.

2. Konfigurace aplikace NETTE:
		cd ./application

	2.1. V terminálu ve složce aplikace zadejte následující příkazy:
		composer update
		composer install

	2.2. Před konfigurací composeru zkopírujte hlavní neon konfigurační soubor:
		cp config.example.neon ./config/config.neon

	2.3. Vyplňte mezeru podle příkladu:
		...
		database:
			...
			user: 'root'
			...

3. Migrace základních tabulek:
	php vendor/bin/phinx migrate

	Default admin login: cmshero
	Default admin password: heropassword

	!DŮLEŽITÉ! Jinak jestli používáte Docker, musíte migrace provést z kontejneru pomocí příkazu:
		docker exec -it php-container bash
		php vendor/bin/phinx migrate

	Další instrukcí na webu. Užijte si to!