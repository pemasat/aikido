<?php


use Nette\Application\UI\Form;



/**
 * Galleries presenter.
 */
class GalleriesPresenter extends BasePresenter {
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
	
	protected function createComponentCreateForm($name) {
		 $form = new Form($this, $name);
		 $form->addText('title', 'Název fotogalerie');
		 $form->addText('date', 'Datum focení');
		 $form->addSubmit('send', 'Založit');
		 $form->onSuccess[] = $this->createFormSubmitted;
		 return $form;
	}
	public function createFormSubmitted(Form $form) {
		 $this->galleriesRepository->create($form->values->title, $form->values->date);
		 $this->flashMessage('Fotogalerie založena, nyní do ní prosím naplňte nějaké fotky');
		 $this->redirect('Galleries:upload', array(
			  'id' => 1
		));
	}
	
	protected function createComponentUploadForm($name) {
   // Main object
    $uploader = new Echo511\Plupload\Rooftop();

    // Use magic for loading Js and Css?
    // $uploader->disableMagic();

    // Configuring paths
    $uploader->setWwwDir(WWW_DIR) // Full path to your frontend directory
             ->setBasePath($this->template->basePath) // BasePath provided by Nette
             ->setTempLibsDir(WWW_DIR . '/plupload511/test'); // Full path to the location of plupload libs (js, css)

    // Configuring plupload
    $uploader->createSettings()
             ->setRuntimes(array('html5')) // Available: gears, flash, silverlight, browserplus, html5
             ->setMaxFileSize('1000mb')
             ->setMaxChunkSize('1mb'); // What is chunk you can find here: http://www.plupload.com/documentation.php

    // Configuring uploader
    $uploader->createUploader()
             ->setTempUploadsDir(WWW_DIR . '/plupload511/tempDir') // Where should be placed temporaly files
             ->setToken("ahoj") // Resolves file names collisions in temp directory
             ->setOnSuccess(array($this, 'tests')); // Callback when upload is successful: returns Nette\Http\FileUpload

    return $uploader->getComponent();
	 }
	public function uploadFormSubmitted(Form $form) {
		// ToDo!!!
	}
	
	
/*	
	public function renderDelete() {
		 $this->newsRepository->delete($this->request->getParameters()['id']);
		 $this->flashMessage('Novinka byla smazaná.');
		 $this->redirect('News:');

	}



	protected function createComponentEditForm($name) {
		 $form = new Form($this, $name);

		 if ($this->request->getParameters()['id'] != 'null') {
			  $id = $this->request->getParameters()['id'];
		 } else if ($form->getHttpData()['id']  != 'null') {
			  $id = $form->getHttpData()['id'];
		 } else {
			  throw new Nette\IOException('Nebylo nalezeno id pro novinku');
		 }

		 $item = $this->newsRepository->findFirstBy(array('id' => $id));
		 $form->addHidden('id', $id);
		 $form->addText('title', 'Nadpis')
					->setDefaultValue($item->title);
		 $form->addTextArea('content', 'Obsah')
					->setDefaultValue($item->content);
		 $form->addSubmit('send', 'Aktualizovat');
		 $form->onSuccess[] = $this->editFormSubmitted;
		 return $form;
	}
	public function editFormSubmitted(Form $form) {
		 $this->newsRepository->edit($form->values->id, $form->values->title, $form->values->content);
		 $this->flashMessage('Novinka byla aktualizovaná');
		 $this->redirect('News:');
	}
*/

}
