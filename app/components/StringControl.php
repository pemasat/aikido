<?php

use Nette\Application\UI;
use Nette\Application\UI\Form;


/**
 * The attribute String control
 */
class StringControl extends UI\Control {
	/** @persistent page */
	public $round = '';
	private $stringAttribute;


	public function __construct() {
		parent::__construct();
	}


	public function render($params) {
		$this->stringAttribute = $this->presenter->context->stringAttribute;
		
		$template = $this->template;
		$template->setFile(__DIR__ . '/StringControl.latte');
		$template->content = $this->stringAttribute->getValue($params['uri'], $params['key']);
		$template->uri = $params['uri'];
		$template->key = $params['key'];
		$template->render();
		
	}
	
	public function handleEdit($param) {
		$this->stringAttribute = $this->presenter->context->stringAttribute;		
		Nette\Diagnostics\FireLogger::log($this->params['uri']. '::' . $this->params['key']);
		Nette\Diagnostics\FireLogger::log($this->stringAttribute->getValue($param['uri'], $param['key']));
		$template = $this->template;
		$template->setFile(__DIR__ . '/StringControlEdit.latte');
		$template->content = $this->stringAttribute->getValue($this->params['uri'], $this->params['key']);
		$template->render();
	}

	protected function createComponentEditForm($name) {
		 $form = new Form($this, $name);
		 $form->addText('value', 'Hodnota');
		 $form->addSubmit('send', 'Uložit');
		 $form->onSuccess[] = $this->editFormSubmitted;
		 return $form;
	}
	public function editFormSubmitted(Form $form) {
		/*
		$this->stringAttribute->setValue(
			$form->values->
		);
		$this->personsRepository->create(
			$form->values->title,
			$form->values->level,
			$form->values->perex,
			$form->values->content
		);
		$this->flashMessage('Uživatel byl založen');
		$this->redirect('Persons:');
	 */
	}


}
