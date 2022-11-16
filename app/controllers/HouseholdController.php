<?php

class HouseholdController extends Controller {
	private $household;
	private $hood;
	private $sim;
	private $s2hh;
	private $s3hh;
	private $s4hh;
	private $users2data;
	private $users3data;
	private $users4data;

	public function __construct() {
		parent::__construct();
		$this->household=new Household($this->db);
		$this->hood=new Hood($this->db);
		$this->sim=new Sim($this->db);
		$this->s2hh=new S2HH($this->db);
		$this->s3hh=new S3HH($this->db);
		$this->s4hh=new S4HH($this->db);
		$this->users2data=new UserS2Data($this->db);
		$this->users3data=new UserS3Data($this->db);
		$this->users4data=new UserS4Data($this->db);
	}


	public function index() {
		$userID=$this->f3->get('SESSION.user[2]');
		$this->household->sims=
			'SELECT COUNT(*) as simscount FROM sim where sim.hhID = household.hhID and sim.lifeState = "Alive" GROUP BY hhID ';
		$this->household->pets=
			'SELECT COUNT(*) as petscount FROM pet where pet.hhID = household.hhID and pet.lifeState = "Alive" GROUP BY hhID ';

		$this->f3->set('hoods',$this->hood->getByUser($userID));
		$this->f3->set('households',$this->household->getByUser($userID));
		$this->f3->set('title','Households');
		$this->f3->set('content','household/list.html');
	}

	public function create() {
		if ($this->f3->exists('POST.create')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$this->f3->scrub($_POST,'p; br;');
				$lastAdded=$this->household->get('_id');
				$this->household->add();
				$lastID=$this->household->get('_id');
				if ($lastID!==$lastAdded) {
					if ($this->f3->exists('POST.hhSims')) {
						$sims[]=$this->f3->get('POST.hhSims');
						foreach ($sims[0] as $sim) {
							$this->db->exec('UPDATE sims SET hhID = ? WHERE id = ?',
								array(
									$lastID,
									$sim
								));
						}
					}
					$this->f3->set('SESSION.success','Household has been added.');
				} else {
					$this->f3->set('SESSION.error','Couldn\'t create household.');
				}
				$this->index();
			}
		} else if ($this->f3->exists('POST.nh')) {
			$this->f3->scrub($_POST,'p; br;');
			$url='/create/'.$this->f3->get('POST.nh');
			$this->f3->reroute($url);
		} else {
			$userID=$this->f3->get('SESSION.user[2]');
			$nhID=$this->f3->get('PARAMS.id');
			$hood=$this->hood;
			$parent=$this->db->exec(
				"SELECT p.id, sh.parentHood, sh.type, p.`name` from hood p, hood sh WHERE sh.parentHood > 0 AND p.userID = ? GROUP BY p.`name`",
				$userID
			);
			if ($hood->gameVersion==2)
				$this->f3->config('config/sims2.cfg');
			if ($hood->gameVersion==3)
				$this->f3->config('config/sims3.cfg');
			if ($hood->gameVersion==4)
				$this->f3->config('config/sims4.cfg');
			$this->f3->set('userID',$this->f3->get('SESSION.user[2]'));
			$this->f3->set('hoods',$this->hood->getByUser($userID));
			$this->f3->set('parents',$parent);
			$this->hood->getById($nhID);
			$this->f3->set('hood',$hood);
			$this->f3->set('sims',$this->sim->getBynhID($nhID));
			$this->f3->set('title','Create Household');
			$this->f3->set('content','household/create.html');
		}
	}

	public function move() {
		if (!empty($_POST['hptrap'])) {
			die('Nice try, Spam-A-Lot');
		} else {
			$this->f3->scrub($_POST,'p; br;');
			$nhID=$_POST['nhID'];
			if ($this->f3->exists('POST.nhHousehold')) {
				$households[]=$this->f3->get('POST.nhHousehold');
				foreach ($households[0] as $hh) {
					$this->db->exec('UPDATE household SET nhID = ? WHERE hhID = ?',
						array(
							$nhID,
							$hh
						));
				}
				$this->f3->set('SESSION.success','Household has been moved.');
			} else {
				$this->f3->set('SESSION.error','Please choose at least one household.');
			}
			$this->index();
		}
	}

	public function update() {
		if ($this->f3->exists('POST.update')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$this->f3->scrub($_POST,'p; br;');
				$hh=$this->f3->get('POST.id');
				$this->household->edit($hh);
				if ($this->household->gameVersion==2) {
					$this->s2hh->getByHHId($hh);
					$this->s2hh->edit($this->s2hh->id);
				}

				if ($this->household->gameVersion==3) {
					$this->s3hh->getByHHId($hh);
					$this->s3hh->edit($this->s3hh->id);
				}

				if ($this->household->gameVersion==4) {
					$this->s4hh->getByHHId($hh);
					$this->s4hh->edit($this->s4hh->id);
				}

				$this->f3->set('SESSION.success','Household has been updated.');
				$this->index();
			}
		} else {
			$this->household->getById($this->f3->get('PARAMS.id'));
			if ($this->f3->exists('PARAMS.id')) {
				$this->f3->set('household',$this->household);
				$userID=$this->f3->get('SESSION.user[2]');
				$nhID=$this->household->nhID;
				$this->users2data->getByUserId($userID);

				$this->user->getById($userID);
				if ($this->household->gameVersion==2) {
					$this->f3->config('config/sims2.cfg');
					$this->s2hh->getByHHId($this->f3->get('PARAMS.id'));
					$this->f3->set('s2hh',$this->s2hh);
					$this->users2data->getByUserId($userID);
					$this->f3->set('users2',$this->users2data);
				}
				if ($this->household->gameVersion==3) {
					$this->f3->config('config/sims3.cfg');
					$this->s3hh->getByHHId($this->f3->get('PARAMS.id'));
					$this->f3->set('s3hh',$this->s3hh);
					$this->users3data->getByUserId($userID);
					$this->f3->set('users3',$this->users3data);
				}
				if ($this->household->gameVersion==4) {
					$this->f3->config('config/sims4.cfg');
					$this->s4hh->getByHHId($this->f3->get('PARAMS.id'));
					$this->f3->set('s4hh',$this->s4hh);
					$this->users4data->getByUserId($userID);
					$this->f3->set('users4',$this->users4data);
				}
				$this->f3->set('userID',$this->f3->get('SESSION.user[2]'));
				$this->f3->set('hoods',$this->hood->getByUser($userID));
				$this->hood->getById($nhID);
				$this->f3->set('hood',$this->hood);
				$this->f3->set('user',$this->user);
				$this->f3->set('sims',$this->sim->getBynhID($nhID));
				$this->f3->set('title','Update Household');
				$this->f3->set('modified',$this->date);
				$this->f3->set('content','household/update.html');
			} else {
				$this->f3->set('SESSION.error','Household doesn\'t exist');
				$this->index();
			}
		}
	}


	public function delete() {
		if ($this->f3->exists('PARAMS.id')) {
			$this->household->delete($this->f3->get('PARAMS.id'));
			$this->f3->set('SESSION.success','Household was deleted');
		} else {
			$this->f3->set('SESSION.error','Household doesn\'t exist');
		}
		$this->f3->reroute('/households');
	}
}