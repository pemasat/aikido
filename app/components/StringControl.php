<?php

use Nette\Application\UI\Control;
use Nette\Application\UI\Form;


/**
 * The attribute String control
 */
class StringControl extends Control {
	/** @persistent page */
	public $round = '';
	private $stringAttribute;
   
   /** @persistent */
   public $mode = 'normal';


   public function __construct() {
		parent::__construct();
      
	}


	public function render($params) {
		$this->stringAttribute = $this->presenter->context->stringAttribute;
		
		$template = $this->template;
		$template->setFile(__DIR__ . '/StringControl.latte');
		$template->content = $this->stringAttribute->getValue($params['uri'], $params['key']);
      $template->mode = $this->mode;
		$template->uri = $params['uri'];
		$template->key = $params['key'];
		$template->render();
		
	}
	
	public function handleEdit($param) {
		// @todo napojit se na stringAtribute ne skrze presenter
		/*
      $this->stringAttribute = $this->presenter->context->stringAttribute;
		$template = $this->template;
		$template->setFile(__DIR__ . '/StringControlEdit.latte');
		$template->content = $this->stringAttribute->getValue($this->params['uri'], $this->params['key']);
		$template->render();
      
       */
      $this->mode = 'edit';
	}

	protected function createComponentEditForm($name) {
		$this->stringAttribute = $this->presenter->context->stringAttribute;
		
		$form = new Form($this, $name);
		
		// @todo Předělat na něco stabilnějšího
		$uri = isset($this->params['uri']) ? $this->params['uri'] : $form->httpData['uri'];
		$key = isset($this->params['key']) ? $this->params['key'] : $form->httpData['key'];
		
		$form->addText('value', 'Hodnota')
					->setDefaultValue($this->stringAttribute->getValue($uri, $key));
		$form->addHidden('uri', $uri);
		$form->addHidden('key', $key);
		$form->addSubmit('send', 'Uložit');
		$form->onSuccess[] = $this->editFormSubmitted;
		return $form;
	}
	public function editFormSubmitted(Form $form) {
		$this->stringAttribute = $this->presenter->context->stringAttribute;
		if (
			$this->stringAttribute->setValue(
				$form->values->uri,
				$form->values->key,
				$form->values->value
			)
		) {
			$this->flashMessage('Hodnota byla nastavena');
		} else {
			$this->flashMessage('Ups, něco nevyšlo');
		}
		$this->presenter->redirectUrl('/' . $form->values->uri);
	}


}
