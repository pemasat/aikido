<?php

use Nette\Application\Routers\RouteList,
	Nette\Application\Routers\Route,
	Nette\Application\Routers\SimpleRouter;


/**
 * Router factory.
 */
class RouterFactory {
	
	/**
	 * @return Nette\Application\IRouter
	 */
	public function createRouter(Nette\Database\Connection $dbConnection) {
		$router = new RouteList();
		
		$router[] = new Aiki\FrontpageRouter($dbConnection);
		
		$router[] = new Route('/images/<path>/<file>', array(
			'presenter' => 'Image',
			'action' => 'static',
			'path' => 'null',
		));

		$router[] = new Route('<presenter>/<id>/<action>', array(
			 'action' => 'default',
			 'id' => 'null',
			 'presenter' => 'null',
		));
                
		$router[] = new Route('index.php', 'Homepage:default', Route::ONE_WAY);
                
		$router[] = new Route('/', 'Homepage:default');

		return $router;
	}

}
