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
            $form = new Form($this, $name);
            $form->addText('title', 'Nadpis');
            $form->addTextArea('content', 'Obsah');
            $form->addSubmit('send', 'Založit');
            $form->onSuccess[] = $this->createFormSubmitted;
            return $form;
        }
        public function createFormSubmitted(Form $form) {
            $this->newsRepository->create($form->values->title, $form->values->content);
            $this->flashMessage('Novinka založena');
            $this->redirect('News:');
        }
        
        protected function createComponentEditForm($name) {
            $form = new Form($this, $name);
            $form->addHidden('id', $this->request->getParameters()['id']);
            $form->addText('title', 'Nadpis');
            $form->addTextArea('content', 'Obsah');
            $form->addSubmit('send', 'Aktualizovat');
            $form->onSuccess[] = $this->editFormSubmitted;
            return $form;
        }
        public function editFormSubmitted(Form $form) {
            $this->newsRepository->edit($form->values->id, $form->values->title, $form->values->content);
            $this->flashMessage('Novinka byla aktualizovaná');
            $this->redirect('News:');
        }
        

}
