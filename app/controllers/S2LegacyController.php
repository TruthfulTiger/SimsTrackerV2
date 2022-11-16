<?php

class S2LegacyController extends Controller {
	private $legacy;
	private $household;
	private $challenge;
	private $sim;
	private $colour;
	private $legacygen;
	private $id;

	public function __construct() {
		parent::__construct();
		$this->legacy=new S2Legacy($this->db);
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
				$this->save();
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
		$this->f3->config('config/legacy.cfg');
		$this->f3->config('config/sims2.cfg');
		$this->household->getById($this->legacy->hhID);
		$this->challenge->getById($id);
		$this->f3->set('household',$this->household);
		$this->user->getById($this->f3->get('SESSION.user[2]'));
		$this->f3->set('user',$this->user);
		$this->f3->set('challenge',$this->challenge);
		$this->f3->set('colours',$this->colour->getByChallenge($id));
		$this->f3->set('sims',$this->sim->getByhhID($this->legacy->hhID));
		$this->f3->set('legacygen',$this->legacygen->getByChallenge($id));
		$this->f3->set('s2legacy',$this->legacy);
		$this->f3->set('content','legacy.html');
		$this->f3->set('title','Legacy Scorecard');
	}

	function save() {
		if (isset($_POST['save'])) {
			if (!empty($_POST['hptrap'])) {
				die("Nice try, Spam-A-Lot");
			} else {
				if (isset($_POST['casfounder'])) {
					$this->f3->set('POST.casfounder',1);
				} else {
					$this->f3->set('POST.casfounder',0);
				}
				if (isset($_POST['pdhobby'])) {
					$this->f3->set('POST.pdhobby',1);
				} else {
					$this->f3->set('POST.pdhobby',0);
				}
				if (isset($_POST['vhome'])) {
					$this->f3->set('POST.vhome',1);
				} else {
					$this->f3->set('POST.vhome',0);
				}
				if (isset($_POST['vhfounder'])) {
					$this->f3->set('POST.vhfounder',1);
				} else {
					$this->f3->set('POST.vhfounder',0);
				}
				if (isset($_POST['souvenirs'])) {
					$this->f3->set('POST.souvenirs',1);
				} else {
					$this->f3->set('POST.souvenirs',0);
				}
				if (isset($_POST['fish'])) {
					$this->f3->set('POST.fish',1);
				} else {
					$this->f3->set('POST.fish',0);
				}
				if (isset($_POST['juice'])) {
					$this->f3->set('POST.juice',1);
				} else {
					$this->f3->set('POST.juice',0);
				}
				if (isset($_POST['allwants'])) {
					$this->f3->set('POST.allwants',1);
				} else {
					$this->f3->set('POST.allwants',0);
				}
				if (isset($_POST['allbugs'])) {
					$this->f3->set('POST.allbugs',1);
				} else {
					$this->f3->set('POST.allbugs',0);
				}
				if (isset($_POST['allhobbies'])) {
					$this->f3->set('POST.allhobbies',1);
				} else {
					$this->f3->set('POST.allhobbies',0);
				}
				if (isset($_POST['allcareers'])) {
					$this->f3->set('POST.allcareers',1);
				} else {
					$this->f3->set('POST.allcareers',0);
				}
				if (isset($_POST['oldage'])) {
					$this->f3->set('POST.oldage',1);
				} else {
					$this->f3->set('POST.oldage',0);
				}
				if (isset($_POST['cow'])) {
					$this->f3->set('POST.cow',1);
				} else {
					$this->f3->set('POST.cow',0);
				}
				if (isset($_POST['drown'])) {
					$this->f3->set('POST.drown',1);
				} else {
					$this->f3->set('POST.drown',0);
				}
				if (isset($_POST['sparky'])) {
					$this->f3->set('POST.sparky',1);
				} else {
					$this->f3->set('POST.sparky',0);
				}
				if (isset($_POST['lifts'])) {
					$this->f3->set('POST.lifts',1);
				} else {
					$this->f3->set('POST.lifts',0);
				}
				if (isset($_POST['fire'])) {
					$this->f3->set('POST.fire',1);
				} else {
					$this->f3->set('POST.fire',0);
				}
				if (isset($_POST['flies'])) {
					$this->f3->set('POST.flies',1);
				} else {
					$this->f3->set('POST.flies',0);
				}
				if (isset($_POST['fright'])) {
					$this->f3->set('POST.fright',1);
				} else {
					$this->f3->set('POST.fright',0);
				}
				if (isset($_POST['hail'])) {
					$this->f3->set('POST.hail',1);
				} else {
					$this->f3->set('POST.hail',0);
				}
				if (isset($_POST['illness'])) {
					$this->f3->set('POST.illness',1);
				} else {
					$this->f3->set('POST.illness',0);
				}
				if (isset($_POST['rallyforth'])) {
					$this->f3->set('POST.rallyforth',1);
				} else {
					$this->f3->set('POST.rallyforth',0);
				}
				if (isset($_POST['crushed'])) {
					$this->f3->set('POST.crushed',1);
				} else {
					$this->f3->set('POST.crushed',0);
				}
				if (isset($_POST['scissors'])) {
					$this->f3->set('POST.scissors',1);
				} else {
					$this->f3->set('POST.scissors',0);
				}
				if (isset($_POST['starved'])) {
					$this->f3->set('POST.starved',1);
				} else {
					$this->f3->set('POST.starved',0);
				}
				if (isset($_POST['sun'])) {
					$this->f3->set('POST.sun',1);
				} else {
					$this->f3->set('POST.sun',0);
				}
				if (isset($_POST['nowhere'])) {
					$this->f3->set('POST.nowhere',1);
				} else {
					$this->f3->set('POST.nowhere',0);
				}
				if (isset($_POST['dressed'])) {
					$this->f3->set('POST.dressed',1);
				} else {
					$this->f3->set('POST.dressed',0);
				}
				if (isset($_POST['green'])) {
					$this->f3->set('POST.green',1);
				} else {
					$this->f3->set('POST.green',0);
				}
				if (isset($_POST['diy'])) {
					$this->f3->set('POST.diy',1);
				} else {
					$this->f3->set('POST.diy',0);
				}
				if (isset($_POST['noble'])) {
					$this->f3->set('POST.noble',1);
				} else {
					$this->f3->set('POST.noble',0);
				}
				if (isset($_POST['fearless'])) {
					$this->f3->set('POST.fearless',1);
				} else {
					$this->f3->set('POST.fearless',0);
				}
				if (isset($_POST['isbi'])) {
					$this->f3->set('POST.isbi',1);
				} else {
					$this->f3->set('POST.isbi',0);
				}
				if (isset($_POST['jobs'])) {
					$this->f3->set('POST.jobs',1);
				} else {
					$this->f3->set('POST.jobs',0);
				}
				if (isset($_POST['obey'])) {
					$this->f3->set('POST.obey',1);
				} else {
					$this->f3->set('POST.obey',0);
				}
				if (isset($_POST['behind'])) {
					$this->f3->set('POST.behind',1);
				} else {
					$this->f3->set('POST.behind',0);
				}
				if (isset($_POST['large'])) {
					$this->f3->set('POST.large',1);
				} else {
					$this->f3->set('POST.large',0);
				}
				if (isset($_POST['patriarchy'])) {
					$this->f3->set('POST.patriarchy',1);
				} else {
					$this->f3->set('POST.patriarchy',0);
				}
				if (isset($_POST['oneway'])) {
					$this->f3->set('POST.oneway',1);
				} else {
					$this->f3->set('POST.oneway',0);
				}
				if (isset($_POST['aspiring'])) {
					$this->f3->set('POST.aspiring',1);
				} else {
					$this->f3->set('POST.aspiring',0);
				}
				if (isset($_POST['extreme'])) {
					$this->f3->set('POST.extreme',1);
				} else {
					$this->f3->set('POST.extreme',0);
				}
				if (isset($_POST['love'])) {
					$this->f3->set('POST.love',1);
				} else {
					$this->f3->set('POST.love',0);
				}
				if (isset($_POST['familyvals'])) {
					$this->f3->set('POST.familyvals',1);
				} else {
					$this->f3->set('POST.familyvals',0);
				}
				if (isset($_POST['fitness'])) {
					$this->f3->set('POST.fitness',1);
				} else {
					$this->f3->set('POST.fitness',0);
				}
				if (isset($_POST['hypo'])) {
					$this->f3->set('POST.hypo',1);
				} else {
					$this->f3->set('POST.hypo',0);
				}
				if (isset($_POST['paranoid'])) {
					$this->f3->set('POST.paranoid',1);
				} else {
					$this->f3->set('POST.paranoid',0);
				}
				if (isset($_POST['ghosts'])) {
					$this->f3->set('POST.ghosts',1);
				} else {
					$this->f3->set('POST.ghosts',0);
				}
				if (isset($_POST['entrepreneur'])) {
					$this->f3->set('POST.entrepreneur',1);
				} else {
					$this->f3->set('POST.entrepreneur',0);
				}
				if (isset($_POST['storyteller'])) {
					$this->f3->set('POST.storyteller',1);
				} else {
					$this->f3->set('POST.storyteller',0);
				}
				if (isset($_POST['apocalypse'])) {
					$this->f3->set('POST.apocalypse',1);
				} else {
					$this->f3->set('POST.apocalypse',0);
				}
				if (isset($_POST['gas'])) {
					$this->f3->set('POST.gas',1);
				} else {
					$this->f3->set('POST.gas',0);
				}
				if (isset($_POST['cultured'])) {
					$this->f3->set('POST.cultured',1);
				} else {
					$this->f3->set('POST.cultured',0);
				}
				if (isset($_POST['turmoil'])) {
					$this->f3->set('POST.turmoil',1);
				} else {
					$this->f3->set('POST.turmoil',0);
				}
				if (isset($_POST['zone'])) {
					$this->f3->set('POST.zone',1);
				} else {
					$this->f3->set('POST.zone',0);
				}
				if (isset($_POST['sheep'])) {
					$this->f3->set('POST.sheep',1);
				} else {
					$this->f3->set('POST.sheep',0);
				}
				if (isset($_POST['bunnies'])) {
					$this->f3->set('POST.bunnies',1);
				} else {
					$this->f3->set('POST.bunnies',0);
				}
				if (isset($_POST['spotless'])) {
					$this->f3->set('POST.spotless',1);
				} else {
					$this->f3->set('POST.spotless',0);
				}
				if (isset($_POST['started'])) {
					$this->f3->set('POST.started',1);
				} else {
					$this->f3->set('POST.started',0);
				}
				if (isset($_POST['prodigy'])) {
					$this->f3->set('POST.prodigy',1);
				} else {
					$this->f3->set('POST.prodigy',0);
				}
				if (isset($_POST['birthday'])) {
					$this->f3->set('POST.birthday',1);
				} else {
					$this->f3->set('POST.birthday',0);
				}
				if (isset($_POST['regrets'])) {
					$this->f3->set('POST.regrets',1);
				} else {
					$this->f3->set('POST.regrets',0);
				}
				if (isset($_POST['capitalist'])) {
					$this->f3->set('POST.capitalist',1);
				} else {
					$this->f3->set('POST.capitalist',0);
				}
				if (isset($_POST['league'])) {
					$this->f3->set('POST.league',1);
				} else {
					$this->f3->set('POST.league',0);
				}
				if (isset($_POST['hhorse'])) {
					$this->f3->set('POST.hhorse',1);
				} else {
					$this->f3->set('POST.hhorse',0);
				}
				if (isset($_POST['finish'])) {
					$this->f3->set('POST.finish',1);
				} else {
					$this->f3->set('POST.finish',0);
				}
			}
		}
	}
}