<?php


use Nette\Application\UI\Form;



/**
 * Homepage presenter.
 */
class MediaPresenter extends BasePresenter {
	private $galleriesRepository;
	
	protected function startup() {
		parent::startup();
		$this->galleriesRepository = $this->context->galleriesRepository;
	}
	public function beforeRender(){
      $this->template->galleries = $this->galleriesRepository->findAll();
	}

	public function renderDefault() {
		
	}
        

}
