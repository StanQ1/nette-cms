<?php

declare(strict_types=1);

namespace App;

use Nette;
use Nette\Bootstrap\Configurator;

class Bootstrap
{
	private Configurator $configurator;
	private string $rootDir;


	public function __construct()
	{
		$this->rootDir = dirname(__DIR__);
		$this->configurator = new Configurator;
		$this->configurator->setTempDirectory($this->rootDir . '/temp');
	}


	public function bootWebApplication(): Nette\DI\Container
	{
		$this->configurator->setDebugMode(true);
		$this->initializeEnvironment();
		$this->setupContainer();
		return $this->configurator->createContainer();
	}


	public function initializeEnvironment(): void
	{
		//$this->configurator->setDebugMode('secret@23.75.345.200'); // enable for your remote IP
		$this->configurator->enableTracy($this->rootDir . '/log');

		$this->configurator->createRobotLoader()
			->addDirectory(__DIR__)
			->register();
	}


	private function setupContainer(): void
	{
		$configDir = $this->rootDir . '/config';
		$this->configurator->addConfig($configDir . '/common.neon');
		$this->configurator->addConfig($configDir . '/services.neon');

		if (file_exists($configDir . '/config.neon')) {
			$this->configurator->addConfig($configDir . '/config.neon');
		} else {
			echo "Configure your config.neon by instruction in README.md file";
			die();
		}
	}
}
