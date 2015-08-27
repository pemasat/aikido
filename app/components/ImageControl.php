<?php

use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Tracy\Debugger;


/**
 * The attribute image control
 */
class ImageControl extends Control {
	private $imageAttribute;
   
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
		$this->imageAttribute = $this->presenter->context->getService('imageAttribute');
		$this->slug = (isset($params['slug'])) ? $params['slug'] : $this->presenter->params['slug'];
		$this->key = $params['key'];
		
		$template = $this->template;
		if (
			$this->mode == 'edit' &&
			$this->params["key"] == $this->key
		) {
			$template->setFile(__DIR__ . '/ImageControlEdit.latte');
		} else {
			$template->setFile(__DIR__ . '/ImageControl.latte');
		}
		$template->content = $this->imageAttribute->getValue($this->slug, $params['key']);
      	$template->mode = $this->mode;
		$template->slug = $this->slug;
		$template->key = $params['key'];
		$template->render();
		
	}
	
	public function handleEdit($param) {
		$this->imageAttribute = $this->presenter->context->getService('imageAttribute');
		if ($this->presenter->getRequest()->getParameters()['do'] == 'text-edit') {
			$this->mode = 'edit';
		}
	}

	protected function createComponentEditForm($name) {
		$this->imageAttribute = $this->presenter->context->getService('imageAttribute');
		
		$form = new Form($this, $name);
		
		$form->addTextArea('value', 'Hodnota')
					->setDefaultValue($this->imageAttribute->getValue($this->params['slug'], $this->params['key']));
		$form->addHidden('slug')
				  ->setDefaultValue($this->params['slug']);
		$form->addHidden('key', $this->params['key']);
		$form->addSubmit('send', 'Uložit');
		$form->onSuccess[] = $this->editFormSubmitted;
		return $form;
	}
	
	public function editFormSubmitted(Form $form, $values) {
		$this->imageAttribute = $this->presenter->context->getService('imageAttribute');
		if (
			$this->imageAttribute->setValue(
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
