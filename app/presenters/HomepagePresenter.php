<?php

/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter {
	private $newsModel;
	private $personsModel;
	private $galleriesModel;
	
	
	protected function startup() {
		parent::startup();
		$this->newsModel = $this->context->getService('newsModel');
		$this->personsModel = $this->context->getService('personsModel');
		$this->galleriesModel = $this->context->getService('galleriesModel');
	}
	public function beforeRender(){
		$this->template->news = $this->newsModel->findLast();
	}

	public function renderDefault() {
		$this->template->randomPerson = $this->personsModel->getRandomPerson();
		$this->template->randomGallery = $this->galleriesModel->getRandomGallery();

	}

}
