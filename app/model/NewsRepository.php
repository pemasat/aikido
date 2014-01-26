<?php

namespace Aiki;
Use Nette;


class NewsRepository extends Repository {
	
    /**
     * Vrací všechny řádky novinky
     * @return Nette\Database\Table\Selection
     */
    public function findAll() {
		return $this->getTable()->order('created DESC');
    }
	 
	public function findLast($limit = 2) {
		return $this->getTable()->order('created DESC')->limit($limit);
	}
        
	public function create($title, $content) {
		 $this->connection->query('INSERT INTO news', array(
			  'title' => $title,
			  'content' => $content
		 ));
		 return true;
	}

	public function edit($id, $title, $content) {
		 $this->connection->query('UPDATE news SET ? WHERE id=?', array(
			  'title' => $title,
			  'content' => $content
		 ), $id);
		 return true;
	}

	public function delete($id) {
		 return $this->connection->query('DELETE FROM news WHERE id=?', $id);

	}

}
