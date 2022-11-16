<?php

class ChallengeController extends Controller {
	private $challenge;
	private $household;
	private $hood;
	private $sim;
	private $s2legacy;

	public function __construct() {
		parent::__construct();
		$this->challenge=new Challenge($this->db);
		$this->household=new Household($this->db);
		$this->hood=new Hood($this->db);
		$this->sim=new Sim($this->db);
		$this->s2legacy=new S2Legacy($this->db);
		$this->legacygen=new LegacyGen($this->db);
		$this->usercolour=new UserColour($this->db);
		$this->f3->clear('SESSION.url');
		$this->f3->clear('SESSION.challenge');
	}

	public function index() {
		$userID=$this->f3->get('SESSION.user[2]');
		$this->f3->set('households',$this->household->getByUser($userID));
		$this->f3->set('hoods',$this->hood->getByUser($userID));
		$this->f3->set('sims',$this->sim->getByUser($userID));
		$this->f3->set('challenges',$this->challenge->getByUser($userID));
		$this->f3->set('s2legacies',$this->s2legacy->getByUser($userID));
		$this->f3->set('title','Challenges');
		$this->f3->set('content','challenges/list.html');
	}

	public function create() {
		if ($this->f3->exists('POST.create')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$this->f3->scrub($_POST,'p; br;');
				$lastAdded=$this->challenge->get('_id');
				$this->challenge->add();
				$lastID=$this->challenge->get('_id');
				if ($lastID!==$lastAdded) {
					$this->f3->set('SESSION.success','Challenge has been created.');
				} else {
					$this->f3->set('SESSION.error','Couldn\'t create challenge.');
				}

				$this->index();
			}
		} else {
			$userID=$this->f3->get('SESSION.user[2]');
			$this->f3->set('userID',$userID);
			$this->f3->set('hoods',$this->hood->getByUser($userID));
			$this->f3->set('sims',$this->sim->getByUser($userID));
			$this->f3->set('households',$this->household->getByUser($userID));
			$this->hood->getById($this->household->nhID);
			$this->f3->set('hood',$this->hood);
			$this->f3->set('title','Create Challenge');
			$this->f3->set('content','challenges/create.html');
		}
	}

	public function update() {
		if ($this->f3->exists('POST.update')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$this->f3->scrub($_POST,'p; br;');
				try {
					$this->challenge->edit($this->f3->get('POST.id'));
					$this->f3->set('SESSION.success','Challenge has been updated.');
				} catch (PDOException $e) {
					$err=$e->errorInfo;
					$this->f3->set('SESSION.error',$err[2]);
				}
				$this->index();
			}
		} else {
			$this->challenge->getById($this->f3->get('PARAMS.id'));
			$this->s2legacy->getByCID($this->f3->get('PARAMS.id'));
			$this->f3->set('SESSION.challenge',$this->f3->get('PARAMS.id'));
			if ($this->f3->exists('PARAMS.id')) {
				$userID=$this->f3->get('SESSION.user[2]');
				$this->f3->set('userID',$userID);
				$this->f3->set('hoods',$this->hood->getByUser($userID));
				$this->f3->set('sims',$this->sim->getByUser($userID));
				$this->f3->set('households',$this->household->getByUser($userID));
				$this->f3->set('challenge',$this->challenge);
				$this->f3->set('s2legacy',$this->s2legacy);
				$this->f3->set('modified',$this->date);
				$this->f3->set('title','Update Challenge');
				$this->f3->set('content','challenges/update.html');
			} else {
				$this->f3->set('SESSION.error','Challenge doesn\'t exist');
				$this->index();
			}
		}
	}


	public function delete() {
		if ($this->f3->exists('PARAMS.id')) {
			$cid=$this->f3->get('PARAMS.id');
			$this->challenge->delete($cid);
		} else {
			$this->f3->set('SESSION.error','Challenge doesn\'t exist');
		}

		$this->index();
	}
}