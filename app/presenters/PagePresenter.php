<?php

/**
 * Page presenter.
 */
class PagePresenter extends BasePresenter {
	private $newsModel;
	private $personsModel;
	private $galleriesModel;
	
	private $stringAttribute;
	private $textAttribute;
	private $imageAttribute;
	



	protected function startup() {
		parent::startup();
		$this->newsModel = $this->context->getService('newsModel');
		$this->personsModel = $this->context->getService('personsModel');
		$this->galleriesModel = $this->context->getService('galleriesModel');
		$this->stringAttribute = $this->context->getService('stringAttribute');
		$this->textAttribute = $this->context->getService('textAttribute');
		$this->imageAttribute = $this->context->getService('imageAttribute');
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
		$string->redrawControl();
		return $string;
	}

	/**
	* Text control factory.
	* @return TextControl
	*/
	protected function createComponentText() {
		$text = new TextControl;
		$text->redrawControl();
		return $text;
	}

	/**
	* Image control factory.
	* @return ImageControl
	*/
	protected function createComponentImage() {
		$text = new ImageControl;
		$text->redrawControl();
		return $text;
	}


}
