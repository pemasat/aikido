<?php

/**
 * Page presenter.
 */
class PagePresenter extends BasePresenter {
	private $newsRepository;
	private $personsRepository;
	private $galleriesRepository;
	
	private $stringAttribute;




	protected function startup() {
		parent::startup();
		$this->newsRepository = $this->context->newsRepository;
		$this->personsRepository = $this->context->personsRepository;
		$this->galleriesRepository = $this->context->galleriesRepository;
		$this->stringAttribute = $this->context->stringAttribute;
	}
	public function beforeRender(){
		$this->template->news = $this->newsRepository->findLast();
	}

	public function renderDefault() {
		$this->template->randomPerson = $this->personsRepository->getRandomPerson();
		$this->template->randomGallery = $this->galleriesRepository->getRandomGallery();
		
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
