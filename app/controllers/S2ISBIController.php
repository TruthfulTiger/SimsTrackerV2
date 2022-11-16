<?php

class S2ISBIController extends Controller {
	private $legacy;
	private $household;
	private $challenge;
	private $sim;
	private $colour;
	private $legacygen;
	private $id;

	public function __construct() {
		parent::__construct();
		$this->legacy=new S2ISBI($this->db);
		$this->household=new Household($this->db);
		$this->challenge=new Challenge($this->db);
		$this->sim=new Sim($this->db);
		$this->colour=new UserColour($this->db);
		$this->legacygen=new LegacyGen($this->db);
		$this->id=0;
		if (!$this->f3->exists('SESSION.url')) {
			$this->f3->set('SESSION.url',$this->f3->get('PARAMS.0'));
		}
	}

	public function create() {
		$lastAdded=$this->legacy->get('_id');
		$this->legacy->cid=$this->f3->get('PARAMS.cid');
		$this->f3->set('SESSION.challenge',$this->f3->get('PARAMS.cid'));
		$this->legacy->userID=$this->f3->get('PARAMS.userID');
		$this->legacy->hhID=$this->f3->get('PARAMS.hhID');
		$this->legacy->save();
		$lastID=$this->legacy->get('_id');
		if ($lastID!==$lastAdded) {
			$this->f3->set('SESSION.success','Scoresheet has been added.');
			$this->challenge->scores($this->f3->get('PARAMS.cid'),1);
			$this->update();
		} else {
			$this->f3->set('SESSION.error','Couldn\'t create scoresheet.');
			$this->f3->reroute('/challenges');
		}
	}

	public function update() {
		if ($this->f3->exists('POST.update')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$this->f3->scrub($_POST,'p; br;');
				$this->household->edit($this->f3->get('POST.hhID'));
				$this->legacy->edit($this->f3->get('POST.id'));
				$this->f3->set('SESSION.success','Scoresheet has been updated.');
				$this->id=$this->f3->get('POST.cid');
			}
		} else {
			$this->id=$this->f3->get('PARAMS.cid');
		}
		$this->f3->set('SESSION.challenge',$this->f3->get('PARAMS.cid'));
		$this->f3->set('modified',$this->date);
		$this->load($this->id);
	}


	public function delete() {
		if ($this->colour) {
			$lastInsertID=$this->colour->get('_id');
			$this->db->exec(
				array(
					'DELETE FROM usercolour WHERE challengeID=?',
					'ALTER TABLE usercolour AUTO_INCREMENT = '.intval($lastInsertID)
				),
				array($this->f3->get('POST.cid'))
			);
		}
		$lastInsertID=$this->legacygen->get('_id');
		$this->db->exec(
			array(
				'DELETE FROM legacygen WHERE challengeID=?',
				'ALTER TABLE legacygen AUTO_INCREMENT = '.intval($lastInsertID)
			),
			array($this->f3->get('POST.cid'))
		);
		$this->challenge->scores($this->f3->get('POST.cid'),0);
		$this->legacy->delete($this->f3->get('PARAMS.id'));
		$this->f3->clear('SESSION.url');
		$this->f3->reroute('/challenges');
	}

	function load($id) {
		$this->legacy->getByCID($id);
		$this->household->getById($this->legacy->hhID);
		$this->challenge->getById($id);
		$this->f3->set('household',$this->household);
		$this->user->getById($this->f3->get('SESSION.user[2]'));
		$this->f3->set('user',$this->user);
		$this->f3->set('challenge',$this->challenge);
		$this->f3->set('colours',$this->colour->getByChallenge($id));
		$this->f3->set('sims',$this->sim->getByhhID($this->legacy->hhID));
		$this->f3->set('legacygen',$this->legacygen->getByChallenge($id));
		$this->f3->set('isbi',$this->legacy);
		$this->f3->set('content','isbi.html');
		$this->f3->set('title','ISBI Scorecard');
	}
}