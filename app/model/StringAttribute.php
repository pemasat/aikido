<?php

namespace Aiki;
Use Nette;


class StringAttribute extends Nette\Object {
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
		return $this->connection->query('SELECT value FROM attribute_string WHERE uri=? AND key=?', $uri, $key)->fetchField();
	}
	 
	/**
	 * Set value for key/uri
	 * @param string $uri
	 * @param string $key
	 * @param string $value
	 * @return boolean
	 */ 
	public function setValue($uri, $key, $value) {
		return $this->connection->query('UPDATE attribute_string SET value=? WHERE uri=? AND key=?', $value, $uri, $key);
	}

}
