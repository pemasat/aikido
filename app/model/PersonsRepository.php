<?php

namespace Aiki;
Use Nette;


class PersonsRepository extends Repository {
	
	public function findLast() {
		//return $this->findBy(array('done' => false))->order('created ASC');
		
	}
        
	public function create($title, $level, $perex, $content) {
		 $this->connection->query('INSERT INTO persons', array(
			  'title' => $title,
			  'level' => $level,
			  'perex' => $perex,
			  'content' => $content
		 ));
		 return true;
	}

	public function edit($id, $title, $level, $perex, $content) {
		 $this->connection->query('UPDATE persons SET ? WHERE id=?', array(
			  'title' => $title,
			  'level' => $level,
			  'perex' => $perex,
			  'content' => $content
		 ), $id);
		 return true;
	}

	public function delete($id) {
		 return $this->connection->query('DELETE FROM persons WHERE id=?', $id);
	}
	
	public function getRandomPerson() {
		return $this->connection->fetch('SELECT * FROM persons ORDER BY RANDOM() LIMIT 1;');
	}

}
