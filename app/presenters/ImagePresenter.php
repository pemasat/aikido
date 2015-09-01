<?php

use Nette\Utils\Finder;

/**
 * Image presenter.
 */
class ImagePresenter extends BasePresenter {

	protected function startup() {
		parent::startup();
	}
	public function beforeRender(){
	}

	public function renderDefault() {

	}

	public function renderStatic() {
		header ('Content-Type: image/png');
		echo file_get_contents("/var/www/aikido/images/static/logo.png");
		exit();
	}



}
