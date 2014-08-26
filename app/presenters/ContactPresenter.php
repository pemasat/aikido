<?php

use Nette\Application\UI\Form;

/**
 * Contact presenter.
 */
class ContactPresenter extends BasePresenter {
	private $contactModel;


	protected function startup() {
		parent::startup();
		$this->contactModel = $this->context->getService('contactModel');
	}
	public function beforeRender(){
	}

	public function renderDefault() {
		$this->template->anyVariable = 'any value';
	}

	
	protected function createComponentContactForm($name) {
		 $form = new Form($this, $name);
		 $form->addText('title', 'Nadpis');
		 $form->addTextArea('content', 'Obsah');
		 $form->addSubmit('send', 'Poslat');
		 $form->onSuccess[] = $this->contactFormSubmitted;
		 return $form;
	}
	public function contactFormSubmitted(Form $form) {
		 $this->contactModel->sendMessage($form->values->title, $form->values->content);
		 $this->flashMessage('Dotaz byl zaslán, ozveme se Vám v co nejbližší době.');
		 $this->redirect('Contact:');
	}


}
