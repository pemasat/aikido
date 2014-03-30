<?php

namespace Aiki;
Use Nette;


//class FrontpageRepository extends Repository {
class FrontpageRepository extends Nette\Object {
	
	
	public function __construct(Nette\Database\Context $database) {
		\Nette\Diagnostics\FireLogger::log($database);
	}
	
	public function getIdByUrl($url) {
		/*
			$query = $this->database->query('SELECT idAd FROM ad WHERE slug = ?', $slug);
			if($row = $query->fetch()) {
				return $row->idAd;
			}
		*/
		if ($url == 'test.html')  {
			return 1;
		} else {
			return NULL;
		}
	}	
	
	public static function getUrlById($id) {
		if ($id == 1) {
			return 'test.html';
		} else {
			return NULL;
		}
	}
}
