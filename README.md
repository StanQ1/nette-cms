[ENG] Installing and configure nette-cms project:

1. Up docker containers:
	docker-compose up --build

2. Chmod initialization script:
   chmod +x ./init.sh

3. After containers was upped execute init script:  
	./init.sh

4. After successful initialization change default values to your owns
	.env file in project core
	config.neon file in application/config folder

Easier way to configure and manage with make commands:

    make up
    make setup
    After change environment values
    make restart

Next instructions on web. Enjoy that!

--------------------------------------------------------

[CZ] Instalace a konfigurace projektu nette-cms:

1. Inicializační skript сhmod:
   chmod +x ./init.sh

2. Up dokovací kontejnery:
   docker-compose up --build

3. Po zvednutí kontejnerů spusťte init skript:  
   ./init.sh

4. Po úspěšné inicializaci změňte výchozí hodnoty na své vlastní
   .env soubor v jádru projektu
   config.neon ve složce application/config

Jednodušší způsob konfigurace a správy pomocí příkazů make:

    make up
    make setup
    After change environment values
    make restart

Další pokyny na webu. Užijte si to!