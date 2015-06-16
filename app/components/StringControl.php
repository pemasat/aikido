<?php

use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Tracy\Debugger;


/**
 * The attribute String control
 */
class StringControl extends Control {
	private $stringAttribute;
   
   /** @persistent */
   public $mode = 'normal';
	
   /** @persistent */
   public $slug;
	
   /** @persistent */
   public $key;
	
   public function __construct() {
		parent::__construct();
      
	}


	public function render($params) {
		$this->stringAttribute = $this->presenter->context->getService('stringAttribute');
		$this->slug = (isset($params['slug'])) ? $params['slug'] : $this->presenter->params['slug'];
		$this->key = $params['key'];
		
		$template = $this->template;
		
		if (
			$this->mode == 'edit' &&
			$this->params["key"] == $this->key
		) {
			$template->setFile(__DIR__ . '/StringControlEdit.latte');
		} else {
			$template->setFile(__DIR__ . '/StringControl.latte');
		}
		$template->content = $this->stringAttribute->getValue($this->slug, $params['key']);
      $template->mode = $this->mode;
		$template->slug = $this->slug;
		$template->key = $params['key'];
		$template->render();
		
	}
	
	public function handleEdit($param) {
		$this->mode = 'edit';
	}

	protected function createComponentEditForm($name) {
		$this->stringAttribute = $this->presenter->context->getService('stringAttribute');
		
		$form = new Form($this, $name);
		
		$form->addText('value', 'Hodnota')
					->setDefaultValue($this->stringAttribute->getValue($this->params['slug'], $this->params['key']));
		$form->addHidden('slug')
				  ->setDefaultValue($this->params['slug']);
		$form->addHidden('key', $this->params['key']);
		$form->addSubmit('send', 'Uložit');
		$form->onSuccess[] = $this->editFormSubmitted;
		return $form;
	}
	
	public function editFormSubmitted(Form $form, $values) {
		$this->stringAttribute = $this->presenter->context->getService('stringAttribute');
		if (
			$this->stringAttribute->setValue(
				$form->values->slug,
				$form->values->key,
				$form->values->value
			)
		) {
			$this->flashMessage('Hodnota byla nastavena');
		} else {
			$this->flashMessage('Ups, něco nevyšlo');
		}
		$this->presenter->redirectUrl('/' . $form->values->slug);
	}


}
