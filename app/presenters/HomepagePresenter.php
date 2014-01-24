<?php

/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter {
	private $newsRepository;
	
	protected function startup() {
		parent::startup();
		$this->newsRepository = $this->context->newsRepository;
	}
	public function beforeRender(){
		$this->template->news = $this->newsRepository->findAll();
	}

	public function renderDefault() {
		$this->template->anyVariable = 'any value';

	}

}
