<?php

class BusinessController extends Controller {
	private $biz;
	private $household;
	private $hood;

	public function __construct() {
		parent::__construct();
		$this->biz=new Business($this->db);
		$this->household=new Household($this->db);
		$this->hood=new Hood($this->db);
	}

	public function index() {
		$userID=$this->f3->get('SESSION.user[2]');
		$this->f3->clear('SESSION.url');
		$this->f3->set('households',$this->household->getByUser($userID));
		$this->f3->set('biz',$this->biz->getByUser($userID));
		$this->f3->set('title','Businesses');
		$this->f3->set('content','businesses/list.html');
	}

	public function create() {
		if ($this->f3->exists('POST.create')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$this->f3->scrub($_POST,'p; br;');
				$lastAdded=$this->biz->get('_id');
				$this->biz->add();
				$lastID=$this->biz->get('_id');
				if ($lastID!==$lastAdded) {
					$this->f3->set('SESSION.success','Business has been added.');
				} else {
					$this->f3->set('SESSION.error','Couldn\'t create Business.');
				}

				$this->index();
			}
		} else if ($this->f3->exists('POST.hh')) {
			$this->f3->scrub($_POST,'p; br;');
			$url='/create/'.$this->f3->get('POST.hh');
			$this->f3->reroute($url);
		} else {
			$userID=$this->f3->get('SESSION.user[2]');
			$this->f3->set('userID',$this->f3->get('SESSION.user[2]'));
			$this->f3->set('households',$this->household->getByUser($userID));
			$this->f3->set('hhID',$this->f3->get('PARAMS.id'));
			$this->f3->set('nhID',$this->household->nhID);
			$this->f3->set('title','Create Business');
			$this->f3->set('content','businesses/create.html');
		}
	}

	public function update() {
		if ($this->f3->exists('POST.update')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$this->save();
				$this->f3->scrub($_POST,'p; br;');
				$this->biz->edit($this->f3->get('POST.id'));
				$this->f3->set('SESSION.success','Business has been updated.');
				$this->f3->reroute($this->f3->get('SESSION.url'));
			}
		} else {
			if (!$this->f3->exists('SESSION.url'))
				$this->f3->set('SESSION.url',$this->f3->get('PARAMS.0'));
			$this->biz->getById($this->f3->get('PARAMS.id'));
			$biz=$this->biz;
			$owner=$this->db->exec('SELECT * FROM sim WHERE hhID = ?',$this->biz->hhID);
			if ($this->f3->exists('PARAMS.id')) {
				$this->f3->set('biz',$biz);
				$this->f3->set('sims',$owner);
				$this->f3->set('modified',$this->date);
				$this->f3->set('title','Update Business');
				$this->f3->set('content','businesses/update.html');
			} else {
				$this->f3->set('SESSION.error','Business doesn\'t exist');
				$this->index();
			}
		}
	}


	public function delete() {
		if ($this->f3->exists('PARAMS.id')) {
			$this->biz->delete($this->f3->get('PARAMS.id'));
			$this->f3->set('SESSION.success','Business was deleted');
		} else {
			$this->f3->set('SESSION.error','Business doesn\'t exist');
		}

		$this->f3->reroute('/biz');
	}

	public function view() {
		$this->biz->getById($this->f3->get('PARAMS.id'));
		$name=$this->biz->name;
		if ($this->f3->exists('PARAMS.id')) {
			$this->f3->set('biz',$this->biz);
			$this->f3->set('title',$name);
			$this->f3->set('content','biz/view.html');
		} else {
			$this->f3->set('SESSION.error','Business doesn\'t exist');
			$this->index();
		}
	}

	function save() {
		if (isset($_POST['save'])) {
			$this->f3->set('POST.bestAward',isset($_POST["bestAward"])?1:0);
		}
	}
}