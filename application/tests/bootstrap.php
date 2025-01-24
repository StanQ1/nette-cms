<?php declare(strict_types=1);
require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;
$configurator
    ->setDebugMode(false)
    ->setTempDirectory(__DIR__ . '/../temp')
    ->addConfig(__DIR__ . '/../config/config.neon')
    ->addConfig(__DIR__ . '/../config/services.neon')
    ->addConfig(__DIR__ . '/../config/common.neon');

return $configurator->createContainer();