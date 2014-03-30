<?php

/**
 * Page presenter.
 */
class PagePresenter extends BasePresenter {
	private $newsRepository;
	private $personsRepository;
	private $galleriesRepository;
	
	
	protected function startup() {
		parent::startup();
		$this->newsRepository = $this->context->newsRepository;
		$this->personsRepository = $this->context->personsRepository;
		$this->galleriesRepository = $this->context->galleriesRepository;
	}
	public function beforeRender(){
		$this->template->news = $this->newsRepository->findLast();
	}

	public function renderDefault() {
		$this->template->randomPerson = $this->personsRepository->getRandomPerson();
		$this->template->randomGallery = $this->galleriesRepository->getRandomGallery();

	}

}
