<?php

class PetController extends Controller {
	private $pet;
	private $household;
	private $hood;
	private $s2pet;
	private $s3pet;
	private $s4pet;

	public function __construct() {
		parent::__construct();
		$this->pet=new Pet($this->db);
		$this->household=new Household($this->db);
		$this->hood=new Hood($this->db);
		$this->s2pet=new S2Pet($this->db);
		$this->s3pet=new S3Pet($this->db);
		$this->s4pet=new S4Pet($this->db);
	}

	public function index() {
		$userID=$this->f3->get('SESSION.user[2]');
		$this->f3->clear('SESSION.url');
		$this->f3->set('households',$this->household->getByUser($userID));
		$this->f3->set('pets',$this->pet->getByUser($userID));
		$this->f3->set('title','Pets');
		$this->f3->set('content','pet/list.html');
	}

	public function create() {
		if ($this->f3->exists('POST.create')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$this->f3->scrub($_POST,'p; br;');
				$lastAdded=$this->pet->get('_id');
				$this->pet->add();
				$lastID=$this->pet->get('_id');
				if ($lastID!==$lastAdded) {
					$this->f3->set('SESSION.success','Pet has been added.');
				} else {
					$this->f3->set('SESSION.error','Couldn\'t create Pet.');
				}

				$this->index();
			}
		} else if ($this->f3->exists('POST.hh')) {
			$this->f3->scrub($_POST,'p; br;');
			$url='/create/'.$this->f3->get('POST.hh');
			$this->f3->reroute($url);
		} else {
			$userID=$this->f3->get('SESSION.user[2]');
			$hood=$this->hood;
			if ($hood->gameVersion==2)
				$this->f3->config('config/sims2.cfg');
			if ($hood->gameVersion==3)
				$this->f3->config('config/sims3.cfg');
			if ($hood->gameVersion==4)
				$this->f3->config('config/sims4.cfg');
			$this->f3->set('userID',$this->f3->get('SESSION.user[2]'));
			$this->f3->set('households',$this->household->getByUser($userID));
			$this->household->getById($this->f3->get('PARAMS.id'));
			$this->f3->set('hh',$this->household);
			$this->hood->getById($this->household->nhID);
			$this->f3->set('hood',$this->hood);
			$this->f3->set('title','Create Pet');
			$this->f3->set('content','pet/create.html');
		}
	}

	public function update() {
		if ($this->f3->exists('POST.update')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$this->f3->scrub($_POST,'p; br;');
				$pet=$this->f3->get('POST.id');
				$userID=$this->f3->get('SESSION.user[2]');
				$this->pet->getById($pet);
				if ($this->pet->gameVersion==2) {
					//	$this->s2save();
					$this->s2pet->getByPetId($pet);
				}

				if ($this->pet->gameVersion==3) {
					//	$this->s3save();
					$this->s3pet->getByPetId($pet);
				}

				if ($this->pet->gameVersion==4) {
					//	$this->s4save();
					$this->s4pet->getByPetId($pet);
				}
				$this->save();
				$this->f3->scrub($_POST,'p; br;');
				$this->pet->edit($pet);
				if ($this->pet->gameVersion==2)
					$this->s2pet->edit($this->s2pet->id);
				if ($this->pet->gameVersion==3)
					$this->s3pet->edit($this->s3pet->id);
				if ($this->pet->gameVersion==4)
					$this->s4pet->edit($this->s4pet->id);
				$this->f3->set('SESSION.success','Pet has been updated.');
				$this->f3->reroute($this->f3->get('SESSION.url'));
			}
		} else {
			if (!$this->f3->exists('SESSION.url'))
				$this->f3->set('SESSION.url',$this->f3->get('PARAMS.0'));
			$this->pet->getById($this->f3->get('PARAMS.id'));
			$this->hood->getById($this->pet->nhID);
			$pet=$this->pet;
			$hood=$this->hood;
			$parents=$this->db->exec('SELECT * FROM pet WHERE nhID = ?',$this->pet->nhID);
			if ($hood->gameVersion==2)
				$this->f3->config('config/sims2.cfg');
			if ($hood->gameVersion==3)
				$this->f3->config('config/sims3.cfg');
			if ($hood->gameVersion==4)
				$this->f3->config('config/sims4.cfg');
			if ($this->f3->exists('PARAMS.id')) {
				$this->f3->set('pet',$pet);
				if ($this->pet->gameVersion==2) {
					$this->s2pet->getByPetId($this->f3->get('PARAMS.id'));
					$this->f3->set('s2pet',$this->s2pet);
				}

				if ($this->pet->gameVersion==3) {
					$this->s3pet->getByPetId($this->f3->get('PARAMS.id'));
					$this->f3->set('s3pet',$this->s3pet);
				}

				if ($this->pet->gameVersion==4) {
					$this->s4pet->getByPetId($this->f3->get('PARAMS.id'));
					$this->f3->set('s4pet',$this->s4pet);
				}
				$this->f3->set('parents',$parents);
				$this->f3->set('hood',$hood);
				$this->f3->set('modified',$this->date);
				$this->f3->set('title','Update Pet');
				$this->f3->set('content','pet/update.html');
			} else {
				$this->f3->set('SESSION.error','Pet doesn\'t exist');
				$this->index();
			}
		}
	}


	public function delete() {
		if ($this->f3->exists('PARAMS.id')) {
			$this->pet->delete($this->f3->get('PARAMS.id'));
			$this->f3->set('SESSION.success','Pet was deleted');
		} else {
			$this->f3->set('SESSION.error','Pet doesn\'t exist');
		}

		$this->f3->reroute('/pets');
	}

	public function move() {
		if (!empty($_POST['hptrap'])) {
			die('Nice try, Spam-A-Lot');
		} else {
			$this->f3->scrub($_POST,'p; br;');
			$hhID=$_POST['hhID'];
			if ($this->f3->exists('POST.hhPets')) {
				$sims[]=$this->f3->get('POST.hhPets');
				foreach ($sims[0] as $sim) {
					$this->db->exec('UPDATE pet SET hhID = ? WHERE id = ?',
						array(
							$hhID,
							$sim
						));
				}
				$this->f3->set('SESSION.success','Pet has been moved.');
			} else {
				$this->f3->set('SESSION.error','Please choose at least one pet.');
			}
			$this->index();
		}
	}

	public function view() {
		$this->pet->getById($this->f3->get('PARAMS.id'));
		$name=$this->pet->name;
		$hood=$this->hood;
		if ($hood->gameVersion==2)
			$this->f3->config('config/sims2.cfg');
		if ($hood->gameVersion==3)
			$this->f3->config('config/sims3.cfg');
		if ($hood->gameVersion==4)
			$this->f3->config('config/sims4.cfg');
		if ($this->f3->exists('PARAMS.id')) {
			$this->f3->set('pet',$this->pet);
			$this->f3->set('title',$name);
			$this->f3->set('content','pet/view.html');
		} else {
			$this->f3->set('SESSION.error','Pet doesn\'t exist');
			$this->index();
		}
	}

	function save() {
		if (isset($_POST['save'])) {
			$this->f3->set('POST.learnedSit',isset($_POST["learnedSit"])?1:0);
			$this->f3->set('POST.learnedStay',isset($_POST["learnedStay"])?1:0);
			$this->f3->set('POST.learnedCome',isset($_POST["learnedCome"])?1:0);
			$this->f3->set('POST.learnedRoll',isset($_POST["learnedRoll"])?1:0);
			$this->f3->set('POST.learnedSpeak',isset($_POST["learnedSpeak"])?1:0);
			$this->f3->set('POST.learnedShake',isset($_POST["learnedShake"])?1:0);
			$this->f3->set('POST.learnedDead',isset($_POST["learnedDead"])?1:0);
			$this->f3->set('POST.toiletTrained',isset($_POST["toiletTrained"])?1:0);
			$this->f3->set('POST.retired',isset($_POST["retired"])?1:0);
		}
	}
}