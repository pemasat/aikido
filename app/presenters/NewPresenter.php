<?php


use Nette\Application\UI\Form;



/**
 * Homepage presenter.
 */
class NewsPresenter extends BasePresenter {
	private $newsRepository;
	
	protected function startup() {
		parent::startup();
		$this->newsRepository = $this->context->newsRepository;
	}
	public function beforeRender(){
            $this->template->news = $this->newsRepository->findAll();
	}

	public function renderDefault() {
		
	}
        
        protected function createComponentCreateForm($name) {
            $form = new Form($this, 'createForm');
            $form->addText('title', 'Nadpis');
            $form->addTextArea('content', 'Obsah');
            $form->addSubmit('send', 'Založit');
            $form->onSuccess[] = $this->createFormSubmitted;
            return $form;
        }
        public function createFormSubmitted(Form $form) {
            $this->newsRepository->createNew($form->values->title, $form->values->content);
            $this->flashMessage('Novinka založena');
            $this->redirect('News:');
        }
        
        

}
