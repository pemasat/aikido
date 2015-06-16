<?php


use Nette\Application\UI\Form;



/**
 * Homepage presenter.
 */
class NewsPresenter extends BasePresenter {
	private $newsModel;
	
	protected function startup() {
		parent::startup();
		$this->newsModel = $this->context->getService('newsModel');;
	}
	public function beforeRender(){
            $this->template->news = $this->newsModel->findAll();
	}

	public function renderDefault() {
		
	}
        
        public function renderDelete() {
            $this->newsModel->delete($this->request->getParameters()['id']);
            $this->flashMessage('Novinka byla smazaná.');
            $this->redirect('News:');
            
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
            $this->newsModel->create($form->values->title, $form->values->content);
            $this->flashMessage('Novinka založena');
            $this->redirect('News:');
        }
        
        protected function createComponentEditForm($name) {
            $form = new Form($this, $name);

            if ($this->request->getParameters()['id'] != 'null') {
                $id = $this->request->getParameters()['id'];
            } else if ($form->getHttpData()['id']  != 'null') {
                $id = $form->getHttpData()['id'];
            } else {
                throw new Nette\IOException('Nebylo nalezeno id pro novinku');
            }
            
            $item = $this->newsModel->findFirstBy(array('id' => $id));
            $form->addHidden('id', $id);
            $form->addText('title', 'Nadpis')
                    ->setDefaultValue($item->title);
            $form->addTextArea('content', 'Obsah')
                    ->setDefaultValue($item->content);
            $form->addSubmit('send', 'Aktualizovat');
            $form->onSuccess[] = $this->editFormSubmitted;
            return $form;
        }
        public function editFormSubmitted(Form $form) {
            $this->newsModel->edit($form->values->id, $form->values->title, $form->values->content);
            $this->flashMessage('Novinka byla aktualizovaná');
            $this->redirect('News:');
        }
        

}
