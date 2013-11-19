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
	
	public function renderDetail() {
		Nette\Diagnostics\FireLogger::log('aaaaa');
		$this->template->photos = $this->galleriesRepository->getPhotos($this->params['id']);
		
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
		 $idOfNewGallery = $this->galleriesRepository->create($form->values->title, $form->values->date);
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
		$this->galleriesRepository->addPhotos($form->values->id, $form->values->photos);
		$this->flashMessage('Fotky byli úspěšně nahrány');
		$this->redirect('Galleries:detail', array(
			 'id' => $form->values->id
		));
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
