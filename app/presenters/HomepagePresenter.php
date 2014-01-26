<?php

/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter {
	private $newsRepository;
	private $personsRepository;
	
	
	protected function startup() {
		parent::startup();
		$this->newsRepository = $this->context->newsRepository;
		$this->personsRepository = $this->context->personsRepository;
	}
	public function beforeRender(){
		$this->template->news = $this->newsRepository->findAll();
	}

	public function renderDefault() {
		$this->template->randomPerson = $this->personsRepository->getRandomPerson();

	}

}
