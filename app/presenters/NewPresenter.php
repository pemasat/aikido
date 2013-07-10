<?php


use Nette\Forms\Form;



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
        
        protected function createComponentCreateForm() {
            $form = new Form();
            $form->addText('title', 'Nadpis');
            $form->addTextArea('content', 'Obsah');
            $form->addSubmit('send', 'Založit');
            $form->onSuccess[] = $this->createFormSubmitted;
            return $form;
        }
        public function createFormSubmitted(Form $form) {
            
            $this->flashMessage('Novinka založena');
            $this->redirect('News:');
        }
        

}
