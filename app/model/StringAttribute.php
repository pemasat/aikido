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
	 
	 public function getValue($uri, $key) {
		 return $this->connection->query('SELECT value FROM attribute_string WHERE uri=? AND key=?', $uri, $key)->fetchField();
	 }

	 public function setValue($uri, $key, $value) {
		 \Tracy\FireLogger::log('XXXXXEEEEEEE');
		 \Tracy\FireLogger::log($uri, $key, $value);
		 return $this->connection->query('UPDATE attribute_string SET ? WHERE uri=? AND key=?', array(
			  'value' => $value
		 ), $uri, $key);
	 }

}
