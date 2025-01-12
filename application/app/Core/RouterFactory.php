<?php

declare(strict_types=1);

namespace App\Core;

use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;
		$router->withModule('Front')
			->addRoute('/', 'Home:default')
			->addRoute('/article/<id>', 'Article:default');	
		
		$router->withModule('Admin')
			->addRoute('/admin/dashboard', 'Dashboard:default')
			->addRoute('/admin/setup-welcome', 'Setup:default')
			->addRoute('/admin/setup-project', 'Setup:setup');
					
		return $router;
	}
}
