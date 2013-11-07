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
	
	public function createComponentTestForm($galleryId) {
	    $form = new Form;
	    $form->addMultipleFileUpload("pokus1","Testík",20)
		->addRule("MultipleFileUpload::validateFilled","Musíte odeslat alespoň jeden soubor!")
		->addRule("MultipleFileUpload::validateFileSize","Soubory jsou dohromady moc veliké!",1024); // 1 KB
	    
	    // $form->addHidden('galleryId', $galleryId);
	    
	    
	    return $form;
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
		 $form = new Form($this, $name);
		 // $form->addFile();
		 $form->addUpload('test', 'test')
			 ->getControlPrototype()
			 ->multiple('multiple');
		 $form->addSubmit('send', 'Odeslat');
		 $form->onSuccess[] = $this->createFormSubmitted;
		 return $form;
	}
	public function uploadFormSubmited($form) {
	    \Nette\Diagnostics\Debugger::fireLog($form);
	    
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
