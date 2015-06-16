<?php


use Nette\Application\UI\Form;



/**
 * Homepage presenter.
 */
class MediaPresenter extends BasePresenter {
	private $galleriesModel;
	
	protected function startup() {
		parent::startup();
		$this->galleriesModel = $this->context->getService('galleriesModel');;
	}
	public function beforeRender(){
      $this->template->galleries = $this->galleriesModel->findAll();
	}

	public function renderDefault() {
		
	}
        

}
