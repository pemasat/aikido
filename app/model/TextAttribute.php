<?php

namespace Aiki;
Use Nette;


class TextAttribute extends Nette\Object {
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
		$value = $this->connection->query('SELECT value FROM attribute_text WHERE uri=? AND key=?', $uri, $key)->fetchField();
		if($value == false) {
			$this->createNewValue($uri, $key);
			return '';
		} else {
			return $value;
		}
	}
	
	/**
	 * Create new item
	 * @param string $uri
	 * @param string $key
	 * @return boolean
	 */
	public function createNewValue($uri, $key) {
		return $this->connection->query('INSERT INTO attribute_text', array(
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
		return $this->connection->query('UPDATE attribute_text SET value=? WHERE uri=? AND key=?', $value, $uri, $key);
	}

}
