<?php
namespace Aiki;

use Nette;
use Nette\Application as App;
use Nette\Http;


class FrontpageRouter extends Nette\Object implements Nette\Application\IRouter {
	/** @var Nette\Database\Connection */
	private $connection;
	
	/**
	 * @param Nette\Database\Connection $connection
	 */
	public function __construct(Nette\Database\Connection $connection) {
		$this->connection = $connection;
	}
	
	/**
	* Maps HTTP request to a Request object.
	*
	* @return App\Request|NULL
	*/
	public function match(Http\IRequest $httpRequest) {
		$slug = $httpRequest->getUrl()->getPathInfo();
		
		$typeId = $this->connection->query('SELECT type_id FROM pages WHERE url = ?', $slug)->fetchField();
		if (!$typeId) return NULL;
		
		$presenter = $this->connection->query('SELECT presenter FROM types WHERE id = ?', $typeId)->fetchField();
		if (!$presenter) return NULL;
		
		$params = $httpRequest->getQuery();
		$params['action'] = 'default';
		$params['slug'] = $slug;
		
		return new App\Request(
			$presenter,
			$httpRequest->getMethod(),
			$params,
			$httpRequest->getPost(),
			$httpRequest->getFiles(),
			array(App\Request::SECURED => $httpRequest->isSecured())
		);
	}

	/**
	* Constructs absolute URL from Request object.
	*
	* @return string|NULL
	*/
	public function constructUrl(App\Request $appRequest, Http\Url $refUrl) {
		// if (!in_array($appRequest->presenterName, $this->presenters)) return NULL;
		
		$params = $appRequest->getParameters();
		$slug = isset($params['slug']) ? $params['slug'] : NULL;
		$action = isset($params['action']) ? $params['action'] : NULL;
		if ($action !== 'default' || !is_string($slug)) return NULL;
		unset($params['action'], $params['slug']); // we don't want to have 'action' and 'slug' in query parameters
		
		$url = new Http\Url($refUrl->getBaseUrl() . $slug);
		$url->setQuery($params);
		return $url->getAbsoluteUrl();
		
	}
}

