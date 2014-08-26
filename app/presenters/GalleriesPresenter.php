<?php


use Nette\Application\UI\Form;



/**
 * Galleries presenter.
 */
class GalleriesPresenter extends BasePresenter {
	private $galleriesModel;
	
	protected function startup() {
		parent::startup();
		$this->galleriesModel = $this->context->getService('galleriesModel');
	}
	public function beforeRender(){
		$this->template->galleries = $this->galleriesModel->findAll();
	}

	public function renderDefault() {
		
	}
	
	public function renderDetail() {
		$this->template->gallery = $this->galleriesModel->getGallery($this->params['id']);
		$this->template->photos = $this->galleriesModel->getPhotos($this->params['id']);
		
	}

	protected function createComponentCreateForm($name) {
		 $form = new Form($this, $name);
		 $form->addText('title', 'Název fotogalerie');
		 $form->addText('date', 'Datum focení');
		 $form->addSubmit('send', 'Založit');
		 $form->onSuccess[] = $this->createFormSubmitted;
		 return $form;
	}
	public function createFormSubmitted(Form $form) {
		 $idOfNewGallery = $this->galleriesModel->create($form->values->title, $form->values->date);
		 $this->flashMessage('Fotogalerie založena, nyní do ní prosím naplňte nějaké fotky');
		 $this->redirect('Galleries:upload', array(
			  'id' => $idOfNewGallery
		));
	}
	
	protected function createComponentUploadForm($name) {
		$form = new Form($this, $name);
		$form->addHidden('id', $this->params['id']);
		$form->addMultiUpload("photos", "Fotky")->addRule(Form::IMAGE, "Lze vložit pouze obrázky");
		$form->addSubmit('send', 'Odeslat');
		$form->onSuccess[] = $this->uploadFormSubmitted;
		return $form;
	}
	public function uploadFormSubmitted(Form $form) {
		$this->galleriesModel->addPhotos($form->values->id, $form->values->photos);
		$this->flashMessage('Fotky byli úspěšně nahrány');
		$this->redirect('Galleries:detail', array(
			 'id' => $form->values->id
		));
	}
	
	protected function createComponentGrid($name)
	{
		 $grid = new Grido\Grid($this, $name);
		 $grid->setModel($this->context->database->table('user'));
	}	

		
}
