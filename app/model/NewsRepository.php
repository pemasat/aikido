<?php

namespace Aiki;
Use Nette;


class NewsRepository extends Repository {
	
	public function findLast() {
		//return $this->findBy(array('done' => false))->order('created ASC');
		
	}
        
        public function createNew($title, $content) {
            $this->connection->exec('INSERT INTO news', array(
                'title' => $title,
                'content' => $content
            ));
            return true;
        }
}
