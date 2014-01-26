<?php


use Nette\Application\UI\Form;



/**
 * Persons presenter.
 */
class PersonsPresenter extends BasePresenter {
	private $personsRepository;
	
	protected function startup() {
		parent::startup();
		$this->personsRepository = $this->context->personsRepository;
	}
	public function beforeRender(){
            $this->template->persons = $this->personsRepository->findAll();
	}

	public function renderDefault() {
		
	}
        
        public function renderDelete() {
            $this->personsRepository->delete($this->request->getParameters()['id']);
            $this->flashMessage('Člen byl smazán.');
            $this->redirect('Persons:');
            
        }


        protected function createComponentCreateForm($name) {
            $form = new Form($this, $name);
            $form->addText('title', 'Oslovení');
            $form->addText('level', 'Dosažený stupeň');
            $form->addText('perex', 'Krátký info text');
            $form->addTextArea('content', 'Popis');
            $form->addSubmit('send', 'Založit');
            $form->onSuccess[] = $this->createFormSubmitted;
            return $form;
        }
        public function createFormSubmitted(Form $form) {
            $this->personsRepository->create(
					$form->values->title,
					$form->values->level,
					$form->values->perex,
					$form->values->content
				);
            $this->flashMessage('Uživatel byl založen');
            $this->redirect('Persons:');
        }
        
        protected function createComponentEditForm($name) {
            $form = new Form($this, $name);

            if ($this->request->getParameters()['id'] != 'null') {
                $id = $this->request->getParameters()['id'];
            } else if ($form->getHttpData()['id']  != 'null') {
                $id = $form->getHttpData()['id'];
            } else {
                throw new Nette\IOException('Nebylo nalezeno id pro uživetele');
            }
            
            $item = $this->personsRepository->findFirstBy(array('id' => $id));
            $form->addHidden('id', $id);
            $form->addText('title', 'Oslovení')
                    ->setDefaultValue($item->title);
            $form->addText('level', 'Dosažený stupeň')
                    ->setDefaultValue($item->level);
            $form->addText('perex', 'Krátký info text')
                    ->setDefaultValue($item->perex);
            $form->addTextArea('content', 'Obsah')
                    ->setDefaultValue($item->content);
            $form->addSubmit('send', 'Aktualizovat');
            $form->onSuccess[] = $this->editFormSubmitted;
            return $form;
        }
        public function editFormSubmitted(Form $form) {
            $this->personsRepository->edit(
					$form->values->id,
					$form->values->title,
					$form->values->level,
					$form->values->perex,
					$form->values->content
				);
            $this->flashMessage('Uživatel byl aktualizovaný');
            $this->redirect('Persons:');
        }
        

}
