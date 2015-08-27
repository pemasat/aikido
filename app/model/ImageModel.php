<?php

namespace Aiki;
Use Nette;


class ImageAttribute extends Nette\Object {
	/** @var \Nette\Database\Context */
	protected $connection;

	/**
	 * @param Nette\Database\Context $db
	 */
	public function __construct(Nette\Database\Context $db) {
      $this->connection = $db;
   }
	 
	/**
	 * Get value for key/uri
	 * @param string $uri
	 * @param string $key
	 * @return boolean
	 */
	public function getValue($uri, $key) {
		$table = $this->connection->table('attribute_image')
						->where('uri = ?', $uri)
						->where('key = ?', $key);
		if($table->count() == 0) {
			$this->createNewValue($uri, $key);
			return '';
		} else {
			return $table->fetch()->value;
		}
	}
	
	/**
	 * Create new item
	 * @param string $uri
	 * @param string $key
	 * @return boolean
	 */
	public function createNewValue($uri, $key) {
		return $this->connection->query('INSERT INTO attribute_image', array(
			'uri' => $uri,
			'key' => $key
		));
	}
	 
	/**
	 * Set value for key/uri
	 * @param string $uri
	 * @param string $key
	 * @param string $value
	 * @return boolean
	 */ 
	public function setValue($uri, $key, $value) {
		return $this->connection->query('UPDATE attribute_image SET value=? WHERE uri=? AND key=?', $value, $uri, $key);
	}

}
