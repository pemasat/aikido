<?php

namespace Aiki;
use Nette;
use Nette\Image;

class GalleriesRepository extends Repository {
	
	public function findLast() {
		//return $this->findBy(array('done' => false))->order('created ASC');
		
	}
	
	public function getGallery($galleryId) {
		return $this->connection->fetch('SELECT * FROM galleries WHERE id = '. $galleryId);
	}
	
	public function getPhotos($galleryId) {
		return $this->connection->table('galleries_items')->where($galleryId);
	}


	public function create($title, $date) {
			$this->connection->query('INSERT INTO galleries', array(
					'title' => $title,
					'created' => $date
			));
	return $this->connection->lastInsertId();
	}

	public function addPhotos($id, $photos){
		$workingDir = GALLERIES_TEMP_DIR . '/' . $id;
		$finalDir = GALLERIES_DIR . '/' . $id;

		$this->prepareDirIfNotReady($workingDir);
		$this->prepareDirIfNotReady($finalDir);

		foreach ($photos as $photo) {
			$photo->move($workingDir . '/' . $photo->getName());
		}

		$maxOrder = $this->connection->fetchField('SELECT `order` FROM galleries_items ORDER BY `order` DESC');
		if($maxOrder != null) {
			$actOrder = $maxOrder + 1;
		} else {
			$actOrder = 0;
		}


		foreach (glob($workingDir. '/*.*') as $filename) { // používám glob, protože automaticky sortí soubory dle názvu

			$key = time() . '' . $actOrder;

			$this->connection->query('INSERT INTO galleries_items', array(
				'order' => $actOrder,
				'key' => $key,
				'gallery_id' => $id
			));

			$image = Image::fromFile($filename);
			$image->resize(1024, NULL);
			$image->save($finalDir . '/' . $key . '.jpg', 80, Image::JPEG);
			unset($image);

			$image = Image::fromFile($filename);
			$image->resize(120, NULL);
			$image->save($finalDir . '/' . $key . '-prev.jpg', 80, Image::JPEG);

			$actOrder++;
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
