<?php

namespace Aiki;
Use Nette;


class NewsRepository extends Repository {
	
	public function findLast() {
		//return $this->findBy(array('done' => false))->order('created ASC');
		
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
