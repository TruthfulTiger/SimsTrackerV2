<?php

class UserController extends Controller {
	private $users2data;
	private $users3data;
	private $users4data;

	public function __construct() {
		parent::__construct();
		$this->users2data=new UserS2Data($this->db);
		$this->users3data=new UserS3Data($this->db);
		$this->users4data=new UserS4Data($this->db);
	}

	public function index() {
		$this->f3->set('users',$this->user->all());
		$this->f3->set('title','User List');
		$this->f3->set('content','user/list.html');
	}

	public function create() {
		if ($this->f3->exists('POST.create')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$this->f3->scrub($_POST,'p; br;');
				$lastAdded=$this->user->get('_id');
				$this->user->add();
				$lastID=$this->user->get('_id');
				if ($lastID!==$lastAdded) {
					$this->f3->set('SESSION.success','User has been added.');
				} else {
					$this->f3->set('SESSION.error','Couldn\'t create user.');
				}
				$this->index();
			}
		} else {
			$this->f3->set('title','Create User');
			$this->f3->set('content','user/create.html');
		}
	}

	public function update() {
		if ($this->f3->exists('POST.update')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$this->f3->scrub($_POST,'p; br;');
				$this->user->edit($this->f3->get('POST.id'));
				$this->f3->set('SESSION.success','User has been updated.');
				$this->index();
			}
		} else {
			$this->user->getById($this->f3->get('PARAMS.id'));
			if ($this->f3->exists('PARAMS.id')) {
				$this->f3->set('user',$this->user);
				$this->f3->set('title','Update User');
				$this->f3->set('content','user/update.html');
			} else {
				$this->f3->set('SESSION.error','User doesn\'t exist');
				$this->index();
			}
		}
	}


	public function delete() {
		if ($this->f3->exists('PARAMS.id')) {
			$this->user->delete($this->f3->get('PARAMS.id'));
		} else {
			$this->f3->set('SESSION.error','User doesn\'t exist');
		}

		$this->f3->reroute('/users');
	}

	public function profile() {
		if (isset($_POST['update'])) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				if (!empty($_POST['password'])) {
					$password=
						password_hash($this->f3->get('POST.password'),PASSWORD_DEFAULT);
					$this->f3->set('POST.password',$password);
				} else {
					unset($_POST['password']);
				}
				if (!empty($_POST['memorableWord'])) {
					$memWord=$this->f3->get('POST.memorableWord');
					$this->f3->set('POST.memorableWord',$memWord);
				} else {
					unset($_POST['memorableWord']);
				}
				$userID=$this->f3->get('SESSION.user[2]');
				$this->f3->set('POST.sims2',isset($_POST["sims2"])?1:0);
				$this->f3->set('POST.sims3',isset($_POST["sims3"])?1:0);
				$this->f3->set('POST.sims4',isset($_POST["sims4"])?1:0);
				$this->f3->set('POST.uni',isset($_POST["uni"])?1:0);
				$this->f3->set('POST.nl',isset($_POST["nl"])?1:0);
				$this->f3->set('POST.ofb',isset($_POST["ofb"])?1:0);
				$this->f3->set('POST.pets',isset($_POST["pets"])?1:0);
				$this->f3->set('POST.sns',isset($_POST["sns"])?1:0);
				$this->f3->set('POST.ft',isset($_POST["ft"])?1:0);
				$this->f3->set('POST.bv',isset($_POST["bv"])?1:0);
				$this->f3->set('POST.al',isset($_POST["al"])?1:0);

				$this->f3->set('POST.uni3',isset($_POST["uni3"])?1:0);
				$this->f3->set('POST.wa',isset($_POST["wa"])?1:0);
				$this->f3->set('POST.amb',isset($_POST["amb"])?1:0);
				$this->f3->set('POST.pets3',isset($_POST["pets3"])?1:0);
				$this->f3->set('POST.sns3',isset($_POST["sns3"])?1:0);
				$this->f3->set('POST.ln',isset($_POST["ln"])?1:0);
				$this->f3->set('POST.gns',isset($_POST["gns"])?1:0);
				$this->f3->set('POST.st',isset($_POST["st"])?1:0);
				$this->f3->set('POST.sn',isset($_POST["sn"])?1:0);
				$this->f3->set('POST.ip',isset($_POST["ip"])?1:0);
				$this->f3->set('POST.itf',isset($_POST["itf"])?1:0);

				$this->f3->set('POST.uni4',isset($_POST["uni4"])?1:0);
				$this->f3->set('POST.gtw',isset($_POST["gtw"])?1:0);
				$this->f3->set('POST.gt',isset($_POST["gt"])?1:0);
				$this->f3->set('POST.pets4',isset($_POST["pets4"])?1:0);
				$this->f3->set('POST.sns4',isset($_POST["sns4"])?1:0);
				$this->f3->set('POST.cl',isset($_POST["cl"])?1:0);
				$this->f3->set('POST.gf',isset($_POST["gf"])?1:0);
				$this->f3->set('POST.il',isset($_POST["il"])?1:0);
				$this->f3->set('POST.eco',isset($_POST["eco"])?1:0);
				$this->f3->set('POST.otrt',isset($_POST["otrt"])?1:0);
				$this->f3->set('POST.spa',isset($_POST["spa"])?1:0);
				$this->f3->set('POST.do',isset($_POST["do"])?1:0);
				$this->f3->set('POST.vamps',isset($_POST["vamps"])?1:0);
				$this->f3->set('POST.ph',isset($_POST["ph"])?1:0);
				$this->f3->set('POST.ja',isset($_POST["ja"])?1:0);
				$this->f3->set('POST.sv',isset($_POST["sv"])?1:0);
				$this->f3->set('POST.rom',isset($_POST["rom"])?1:0);
				$this->f3->set('POST.jtb',isset($_POST["jtb"])?1:0);

				$this->f3->scrub($_POST,'p; br;');
				$this->user->edit($userID);
				$this->users2data->getByUserId($userID);
				$s2=$this->users2data->id;
				$this->users2data->edit($s2);
				$this->users3data->getByUserId($userID);
				$s3=$this->users3data->id;
				$this->users3data->edit($s3);
				$this->users4data->getByUserId($userID);
				$s4=$this->users4data->id;
				$this->users4data->edit($s4);

				$this->f3->set('SESSION.success','Profile has been updated.');
				$this->f3->reroute('/user/profile');
			}
		} else {
			$userID=$this->f3->get('SESSION.user[2]');
			$this->user->getById($userID);
			$this->users2data->getByUserId($userID);
			if ($this->users2data->dry()) {
				$this->db->exec('INSERT INTO users2data (userID) VALUES (?)',
					array(
						$userID
					));
				$this->users2data->getById($this->users2data->get('_id'));
			}

			$this->users3data->getByUserId($userID);
			if ($this->users3data->dry()) {
				$this->db->exec('INSERT INTO users3data (userID) VALUES (?)',
					array(
						$userID
					));
				$this->users3data->getById($this->users3data->get('_id'));
			}

			$this->users4data->getByUserId($userID);
			if ($this->users4data->dry()) {
				$this->db->exec('INSERT INTO users4data (userID) VALUES (?)',
					array(
						$userID
					));
				$this->users4data->getById($this->users4data->get('_id'));
			}

			$this->f3->set('user',$this->user);
			$this->f3->set('users2',$this->users2data);
			$this->f3->set('users3',$this->users3data);
			$this->f3->set('users4',$this->users4data);
			$this->f3->set('title','Profile');
			$this->f3->set('content','user/profile.html');
		}
	}
}