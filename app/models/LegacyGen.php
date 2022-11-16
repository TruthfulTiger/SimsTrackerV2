<?php

class LegacyGen extends DB\SQL\Mapper {

	public function __construct(DB\SQL $db) {
		$this->table='legacygen';
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

	public function getByChallenge($id) {
		$this->load(array('challengeID=?',$id));
		return $this->query;
	}

	public function add() {
		$this->reset();
		$this->copyFrom('GET',function($val) {
			// the 'GET' array is passed to our callback function
			return array_intersect_key($val,
				array_flip(array('PARAMS.userID','PARAMS.generation','PARAMS.challengeID',
					'PARAMS.simID')));
		});
		$this->save();
	}

	public function edit($id) {
		$this->load(array('id=?',$id));
		$this->copyFrom('GET',function($val) {
			// the 'GET' array is passed to our callback function
			return array_intersect_key($val,array_flip(array('PARAMS.simID')));
		});
		$this->update();
	}

	public function delete($id) {
		$lastInsertID=$this->get('_id');
		$this->load(array('id=?',$id));
		$this->erase();
	}
}