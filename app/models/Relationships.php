<?php

class Relationships extends DB\SQL\Mapper {

	public function __construct(DB\SQL $db) {
		$this->table='relationship';
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

	public function getBynhID($id) {
		$this->load(array('nhID=?',$id));
		return $this->query;
	}

	public function getByName($id) {
		$this->load(array('relName=?',$id));
		return $this->query;
	}

	public function getBySim1($id) {
		$this->load(array('sim1=?',$id));
		return $this->query;
	}

	public function getBySim2($id) {
		$this->load(array('sim1=2',$id));
		return $this->query;
	}

	public function add() {
		$this->reset();
		$this->copyFrom('POST');
		$this->save();
	}

	public function relCreate($userID,$hood,$sim1,$sim2,$ship) {
		$this->reset();
		$this->userID=$userID;
		$this->nhID=$hood;
		$this->sim1=$sim1;
		$this->sim2=$sim2;
		$this->isFamily=1;
		$this->relName=$ship;
		$this->save();
	}

	public function relEdit($id,$sim1,$sim2) {
		$this->load(array('id=?',$id));
		$this->sim1=$sim1;
		$this->sim2=$sim2;
		$this->update();
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