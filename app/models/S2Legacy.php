<?php

class S2Legacy extends DB\SQL\Mapper {
	public function __construct(DB\SQL $db) {
		$this->table='s2legacy';
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

	public function getByCID($id) {
		$this->load(array('cid=?',$id));
		return $this->query;
	}

	public function getByhhID($id) {
		$this->load(array('hhID=?',$id));
		return $this->query;
	}

	public function getByUser($id) {
		$this->load(array('userID=?',$id));
		return $this->query;
	}

	public function add() {
		$this->reset();
		$this->copyFrom('GET',function($val) {
			// the 'GET' array is passed to our callback function
			return array_intersect_key($val,
				array_flip(array('PARAMS.cid','PARAMS.userID','PARAMS.hhID')));
		});
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