<?php

declare(strict_types=1);

use Nette\Bootstrap\Configurator;

require __DIR__ . '/../vendor/autoload.php';

$configurator = new Configurator();

$configurator->setDebugMode(true);
$configurator->enableTracy(__DIR__ . '/log');

$configurator->setTempDirectory(__DIR__ . '/temp');

$configurator->addConfig(__DIR__ . '/../config/common.neon');
$configurator->addConfig(__DIR__ . '/../config/services.neon');
$configurator->addConfig(__DIR__ . '/../config/config.neon');

return $configurator->createContainer();
