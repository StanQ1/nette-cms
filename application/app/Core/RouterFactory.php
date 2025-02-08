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

        $router->withModule('Setup')
            ->addRoute('/welcome', 'Setup:default')
            ->addRoute('/setup-project', 'Setup:setup');

		$router->withModule('Front')
			->addRoute('/', 'Home:default')
			->addRoute('/article/<id>', 'Article:default');
		
		// Funkce withPath() v podstate nefunguje a udelava v aplk. chybu 404, tak to napisu hardkodem
		$router->withModule('Admin')
			//ERROR: ->withPath('admin')
			->addRoute('admin', 'Dashboard:default')
            ->addRoute('admin/monitoring', 'Dashboard:monitoring')
            // TODO: Users have access to dynamic paths
			->addRoute('admin/article/<action>[/<id>]', 'Article:default')
            ->addRoute('admin/category/<action>[/<id>]', 'Category:default');

        $router->withModule('Auth')
            ->addRoute('auth/register', 'Register:default')
            ->addRoute('auth/login', 'Login:default')
            ->addRoute('auth/logout', 'Logout:default');
		
		return $router;
	}
}
