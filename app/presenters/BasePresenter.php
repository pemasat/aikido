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
		// @todo: tady to chytat případně i z params['uri']
		// \Nette\Diagnostics\FireLogger::log($this->context);
		$this->template->uri = isset($this->request->parameters['slug']) ? $this->request->parameters['slug'] : '';
	}
	

}
