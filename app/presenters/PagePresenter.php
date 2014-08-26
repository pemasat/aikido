<?php

/**
 * Page presenter.
 */
class PagePresenter extends BasePresenter {
	private $newsModel;
	private $personsModel;
	private $galleriesModel;
	
	private $stringAttribute;




	protected function startup() {
		parent::startup();
		$this->newsModel = $this->context->getService('newsModel');
		$this->personsModel = $this->context->getService('personsModel');
		$this->galleriesModel = $this->context->getService('galleriesModel');
		$this->stringAttribute = $this->context->stringAttribute;
	}
	public function beforeRender(){
		$this->template->news = $this->newsModel->findLast();
	}

	public function renderDefault() {
		$this->template->randomPerson = $this->personsModel->getRandomPerson();
		$this->template->randomGallery = $this->galleriesModel->getRandomGallery();
		
		$this->template->title = 'aaa';

	}
	/**
	* String control factory.
	* @return StringControl
	*/
	protected function createComponentString() {
		$string = new StringControl;
		// $fifteen->onGameOver[] = $this->gameOver;
		$string->redrawControl();
		return $string;
	}


}
