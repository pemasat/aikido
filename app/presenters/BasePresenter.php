<?php

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	protected function startup() {
		parent::startup();
		
		\Nette\Application\UI\Form::extensionMethod('addMultiUpload', function(\Nette\Application\UI\Form $form, $name, $label = NULL) {
			 $form[$name] = new \Nette\Forms\Controls\MultiUploadControl($label);
			 return $form[$name];
		});
		// @todo: vymyslet jak se nechytat skrze to string-slug
		if (isset($this->request->parameters['slug'])) {
			$this->template->slug = $this->request->parameters['slug'];
		} else if (isset ($this->request->parameters['string-slug'])) {
			$this->template->slug = $this->request->parameters['string-slug'];
		} else {
			$this->template->slug = '';
		}
	}
	

}
