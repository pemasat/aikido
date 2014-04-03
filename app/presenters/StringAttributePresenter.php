<?php
use Nette\Application\UI\Form;

/**
 * String Attribute presenter.
 */
class StringAttributePresenter extends BasePresenter {
	private $stringAttribute;

	protected function startup() {
		parent::startup();
		$this->stringAttribute = $this->context->stringAttribute;
	}

	public function renderDefault() {
		$this->template->randomPerson = $this->personsRepository->getRandomPerson();
		$this->template->randomGallery = $this->galleriesRepository->getRandomGallery();
		
		$this->template->title = $this->stringAttribute->getValue('test.html/title');
	}
	
	protected function createComponentEditForm($name) {
		 $form = new Form($this, $name);
		 $form->addText('value', 'Hodnota');
		 $form->addSubmit('send', 'Natavit');
		 $form->onSuccess[] = $this->editFormSubmitted;
		 return $form;
	}
	public function editFormSubmitted(Form $form) {
		 $this->newsRepository->create($form->values->title, $form->values->content);
		 $this->flashMessage('Atribut nastaven');
		 $this->redirect('News:');
	}

}
