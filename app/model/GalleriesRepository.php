<?php

namespace Aiki;
Use Nette;
Use \Nette\Utils\Finder;


class GalleriesRepository extends Repository {
	
	public function findLast() {
		//return $this->findBy(array('done' => false))->order('created ASC');
		
	}
        
        public function create($title, $date) {
            $this->connection->exec('INSERT INTO galleries', array(
                'title' => $title,
                'created' => $date
            ));
				return $this->connection->lastInsertId();
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
		  
		  public function addPhotos($id, $photos){
			  $workingDir = GALLERIES_TEMP_DIR . '/' . $id;
			  
			  $this->prepareDirIfNotReady($workingDir);
			  
			  foreach ($photos as $photo) {
				  $photo->move($workingDir . '/' . $photo->getName());
			  }
				foreach (Finder::findFiles('*')->in($workingDir) as $key => $file) {
					\Nette\Diagnostics\FireLogger::log($key);
					\Nette\Diagnostics\FireLogger::log($file->getFilename());
 
					// $key je řetězec s názvem souboru včetně cesty
					// $file je objektem SplFileInfo
				}

		  }
		  
		  private function prepareDirIfNotReady($dir) {
			  if (!file_exists($dir)) {
				  mkdir($dir, 0777);
			  }
		  }

		  private function copyPhotos($id, $photos) {
			  
		  }

}
