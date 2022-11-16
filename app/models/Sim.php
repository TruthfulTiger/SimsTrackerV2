<?php

class Sim extends DB\SQL\Mapper {

	public function __construct(DB\SQL $db) {
		$this->table='sim';
		parent::__construct($db,$this->table);
	}

	public function all() {
		$this->load();
		return $this->query;
	}

	public function getById($id) {
		$this->load(array('id=?',$id));
		return $this->query;
	}

	public function getByUser($id) {
		$this->load(array('userID=?',$id));
		return $this->query;
	}

	public function getByhhID($id) {
		$this->load(array('hhID=?',$id));
		return $this->query;
	}

	public function getBynhID($id) {
		$this->load(array('nhID=?',$id));
		return $this->query;
	}

	public function getByName($id) {
		$this->load(array('firstName=?',$id));
		return $this->query;
	}

	public function add() {
		$this->reset();
		$this->copyFrom('POST');
		$this->save();
	}

	public function edit($id) {
		$this->load(array('id=?',$id));
		$this->copyFrom('POST');
		$this->update();
	}

	public function delete($id) {
		$lastInsertID=$this->get('_id');
		$this->load(array('id=?',$id));
		$this->erase();
	}
}