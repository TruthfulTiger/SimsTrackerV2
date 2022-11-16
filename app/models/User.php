<?php

class User extends DB\SQL\Mapper {

	public function __construct(DB\SQL $db) {
		$this->table='user';
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

	public function getByName($name) {
		$this->load(array('email=?',$name));
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

	public function editNP($id) {
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