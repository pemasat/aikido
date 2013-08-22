<?php

namespace Aiki;
Use Nette;


class GalleriesRepository extends Repository {
	
	public function findLast() {
		//return $this->findBy(array('done' => false))->order('created ASC');
		
	}
        
        public function create($title, $date) {
            return $this->connection->exec('INSERT INTO galleries', array(
                'title' => $title,
                'created' => $date
            ));
        }
        
        public function edit($id, $title, $content) {
			  // ToDo: přepsat
            $this->connection->exec('UPDATE news SET ? WHERE id=?', array(
                'title' => $title,
                'content' => $content
            ), $id);
            return true;
        }
        
        public function delete($id) {
            return $this->connection->exec('DELETE FROM news WHERE id=?', $id);
            
        }

}
