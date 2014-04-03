<?php

use Nette\Application\UI;

/**
 * The attribute String control
 */
class StringControl extends UI\Control {
	/** @persistent page */
	public $round = '';


	public function __construct() {
		parent::__construct();
	}


	public function render() {
		$template = $this->template;
		$template->setFile(__DIR__ . '/StringControl.latte');
		$template->content = 'abraja';
		$template->render();
	}


	public function handleEdit() {
		Nette\Diagnostics\FireLogger::log('aaaa');
		$template = $this->template;
		$template->setFile(__DIR__ . '/StringControlEdit.latte');
		$template->content = 'aaaaa';
		$template->render();
	}



}
