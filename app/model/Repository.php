<?php
namespace Aiki;
use Nette;

abstract class Repository extends Nette\Object {
    /** @var Nette\Database\Connection */
    protected $connection;

    /**
	  * @param Nette\Database\Context $db
	  */
	 public function __construct(Nette\Database\Context $db) {
        $this->connection = $db;
    }

    /**
     * Vrací objekt reprezentující databázovou tabulku.
     * @return Nette\Database\Table\Selection
     */
    protected function getTable() {
        // název tabulky odvodíme z názvu třídy
        preg_match('#(\w+)Repository$#', get_class($this), $m);
        return $this->connection->table(lcfirst($m[1]));
		  
    }

    /**
     * Vrací všechny řádky z tabulky.
     * @return Nette\Database\Table\Selection
     */
    public function findAll() {
        return $this->getTable();
    }

    /**
     * Vrací řádky podle filtru, např. array('name' => 'John').
     * @return Nette\Database\Table\Selection
     */
    public function findBy(array $by) {
        return $this->getTable()->where($by);
    }
    
    /*
     * Vrací jen první záznam hledaného řetězce
     */
    public function findFirstBy(array $by) {
        return $this->findBy($by)->fetch();
    }

}