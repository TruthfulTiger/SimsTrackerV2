<?php

class RelationshipsController extends Controller {
	private $relationship;
	private $sim;
	private $household;
	private $hood;
	private $version;

	public function __construct() {
		parent::__construct();
		$this->relationship=new Relationships($this->db);
		$this->sim=new Sim($this->db);
		$this->household=new Household($this->db);
		$this->hood=new Hood($this->db);
		$this->version=$this->f3->set('SESSION.version',$this->hood->gameVersion);
	}

	public function index() {
		$userID=$this->f3->get('SESSION.user[2]');
		$this->f3->set('hoods',$this->hood->getByUser($userID));
		$this->f3->set('sims',$this->sim->getByUser($userID));
		$this->f3->set('relationships',$this->relationship->getByUser($userID));
		$this->f3->set('title','Relationships');
		$this->f3->set('content','relationships/list.html');
	}

	public function create() {
		if ($this->f3->exists('POST.create')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$this->f3->scrub($_POST,'p; br;');
				$lastAdded=$this->relationship->get('_id');
				$this->relationship->add();
				$lastID=$this->relationship->get('_id');
				if ($lastID!==$lastAdded) {
					$this->f3->set('SESSION.success','Relationship has been added.');
				} else {
					$this->f3->set('SESSION.error','Couldn\'t create relationship.');
				}

				$this->index();
			}
		} else if ($this->f3->exists('POST.nh')) {
			$this->f3->scrub($_POST,'p; br;');
			$url='/create/'.$this->f3->get('POST.nh');
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
			$this->f3->set('hoods',$this->hood->getByUser($userID));
			$this->f3->set('nhID',$this->f3->get('PARAMS.id'));
			$this->f3->set('gameVersion',$hood->gameVersion);
			$this->f3->set('relationships',$this->relationship->getByUser($userID));
			$this->f3->set('sims',$this->sim->getBynhID($this->f3->get('PARAMS.id')));
			$this->f3->set('title','Create Relationship');
			$this->f3->set('content','relationships/create.html');
		}
	}

	public function update() {
		if ($this->f3->exists('POST.update')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$this->f3->scrub($_POST,'p; br;');
				$this->f3->set('POST.isFamily',isset($_POST["isFamily"])?1:0);
				$this->f3->set('POST.isEnemy',isset($_POST["isEnemy"])?1:0);
				$this->f3->set('POST.isFriend',isset($_POST["isFriend"])?1:0);
				$this->f3->set('POST.isBF',isset($_POST["isBF"])?1:0);
				$this->f3->set('POST.isCrush',isset($_POST["isCrush"])?1:0);
				$this->f3->set('POST.isLove',isset($_POST["isLove"])?1:0);
				$this->f3->set('POST.isSteady',isset($_POST["isSteady"])?1:0);
				$this->f3->set('POST.isEngaged',isset($_POST["isEngaged"])?1:0);
				$this->f3->set('POST.isMarried',isset($_POST["isMarried"])?1:0);
				$this->relationship->edit($this->f3->get('POST.id'));
				$this->f3->set('SESSION.success','Relationship has been updated.');
				$this->index();
			}
		} else {
			if ($this->f3->exists('PARAMS.id')) {
				$hood=$this->hood;
				if ($hood->gameVersion==2)
					$this->f3->config('config/sims2.cfg');
				if ($hood->gameVersion==3)
					$this->f3->config('config/sims3.cfg');
				if ($hood->gameVersion==4)
					$this->f3->config('config/sims4.cfg');
				$this->relationship->getById($this->f3->get('PARAMS.id'));
				$this->f3->set('relationship',$this->relationship);
				$this->f3->set('sims',$this->sim->getBynhID($this->relationship->nhID));
				$this->f3->set('title','Update Relationship');
				$this->f3->set('modified',$this->date);
				$this->f3->set('content','relationships/update.html');
			} else {
				$this->f3->set('SESSION.error','Relationship doesn\'t exist');
				$this->index();
			}
		}
	}

	public function delete() {
		if ($this->f3->exists('PARAMS.id')) {
			$this->relationship->delete($this->f3->get('PARAMS.id'));
			$this->f3->set('SESSION.success','Relationship was deleted');
		} else {
			$this->f3->set('SESSION.error','Relationship doesn\'t exist');
		}

		$this->f3->reroute('/relationships');
	}

	public function view() {
		$this->sim->getById($this->f3->get('PARAMS.id'));
		$name=$this->sim->firstName.' '.$this->sim->lastName;
		$hood=$this->hood;
		if ($hood->gameVersion==2)
			$this->f3->config('config/sims2.cfg');
		if ($hood->gameVersion==3)
			$this->f3->config('config/sims3.cfg');
		if ($hood->gameVersion==4)
			$this->f3->config('config/sims4.cfg');
		if ($this->f3->exists('PARAMS.id')) {
			$this->f3->set('sim',$this->sim);
			$this->f3->set('title',$name);
			$this->f3->set('content','relationships/view.html');
		} else {
			$this->f3->set('SESSION.error','Relationship doesn\'t exist');
			$this->index();
		}
	}
}