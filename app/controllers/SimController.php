<?php

class SimController extends Controller {
	private $sim;
	private $household;
	private $hood;
	private $business;
	private $s2sim;
	private $s3sim;
	private $s4sim;
	private $users2data;
	private $users3data;
	private $users4data;
	private $major;
	private $class;
    private $career;
	private $job;
    private $s2job;
	private $s2class;
	private $s3class;
	private $s4class;
	private $userID;

	public function __construct() {
		parent::__construct();
		$this->sim=new Sim($this->db);
		$this->s2sim=new S2Sim($this->db);
		$this->s3sim=new S3Sim($this->db);
		$this->s4sim=new S4Sim($this->db);
		$this->household=new Household($this->db);
		$this->hood=new Hood($this->db);
		$this->business=new Business($this->db);
		$this->users2data=new UserS2Data($this->db);
		$this->users3data=new UserS3Data($this->db);
		$this->users4data=new UserS4Data($this->db);
		$this->major=new UserMajor($this->db);
		$this->class=new UserClass($this->db);
        $this->career=new Career($this->db);
		$this->job=new Job($this->db);
        $this->s2job=new S2Job($this->db);
		$this->s2class=new UserS2Class($this->db);
		$this->s3class=new UserS3Class($this->db);
		$this->s4class=new UserS4Class($this->db);
		$this->userID=$this->f3->get('SESSION.user[2]');
	}

	public function index() {
		$this->f3->clear('SESSION.url');
		$this->f3->set('households',$this->household->getByUser($this->userID));
		$this->f3->set('sims',$this->sim->getByUser($this->userID));
		$this->f3->set('title','Sims');
		$this->f3->set('content','sim/list.html');
	}

	public function create() {
		if ($this->f3->exists('POST.create')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$this->f3->scrub($_POST,'p; br;');
				$lastAdded=$this->sim->get('_id');
				$this->sim->add();
				$lastID=$this->sim->get('_id');
				if ($lastID!==$lastAdded) {
					$this->f3->set('SESSION.success','Sim has been added.');
				} else {
					$this->f3->set('SESSION.error','Couldn\'t create Sim.');
				}

				$this->index();
			}
		} else if ($this->f3->exists('POST.hh')) {
			$this->f3->scrub($_POST,'p; br;');
			$url='/create/'.$this->f3->get('POST.hh');
			$this->f3->reroute($url);
		} else {
			$this->f3->set('userID',$this->userID);
			$this->f3->set('households',$this->household->getByUser($this->userID));
			$this->household->getById($this->f3->get('PARAMS.id'));
			$this->f3->set('hh',$this->household);
			$this->hood->getById($this->household->nhID);
			$this->f3->set('hood',$this->hood);

			$this->f3->set('title','Create Sim');
			$this->f3->set('content','sim/create.html');
		}
	}

	public function move() {
		if (!empty($_POST['hptrap'])) {
			die('Nice try, Spam-A-Lot');
		} else {
			$this->f3->scrub($_POST,'p; br;');
			$hhID=$_POST['hhID'];
			if ($this->f3->exists('POST.hhSims')) {
				$sims[]=$this->f3->get('POST.hhSims');
				foreach ($sims[0] as $sim) {
					$this->db->exec('UPDATE sim SET hhID = ? WHERE id = ?',
						array(
							$hhID,
							$sim
						));
				}
				$this->f3->set('SESSION.success','Sim has been moved.');
			} else {
				$this->f3->set('SESSION.error','Please choose at least one sim.');
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
				$sim=$this->f3->get('POST.id');
				$maxsize=$this->f3->get('POST.MAX_FILE_SIZE');
				$file=$_FILES["image-raw"];
				$this->sim->getById($sim);
				$this->save();
				if ($this->sim->gameVersion==2) {
					$this->s2save();
					$this->s2sim->getBySimId($sim);
				}

				if ($this->sim->gameVersion==3) {
					//	$this->s3save();
					$this->s3sim->getBySimId($sim);
				}

				if ($this->sim->gameVersion==4) {
					//	$this->s4save();
					$this->s4sim->getBySimId($sim);
				}
				$this->sim->edit($sim);
				if ($this->sim->gameVersion==2)
					$this->s2sim->edit($this->s2sim->id);
				if ($this->sim->gameVersion==3)
					$this->s3sim->edit($this->s3sim->id);
				if ($this->sim->gameVersion==4)
					$this->s4sim->edit($this->s4sim->id);

				if (!empty($file)) {
					$is=new UploadController;
					$is->imageUpload($file,$maxsize);
				}
				$this->f3->set('SESSION.success','Sim has been updated.');
				$this->f3->reroute($this->f3->get('SESSION.url'));
			}
		} else {
			if (!$this->f3->exists('SESSION.url'))
				$this->f3->set('SESSION.url',$this->f3->get('PARAMS.0'));
			$this->sim->getById($this->f3->get('PARAMS.id'));
			$this->hood->getById($this->sim->nhID);
			$parents=
				$this->db->exec('SELECT id, firstName, lastName FROM sim WHERE nhID = ?',
					$this->sim->nhID);

			if ($this->f3->exists('PARAMS.id')) {
				$this->f3->set('sim',$this->sim);
				if ($this->sim->gameVersion==2) {
					$this->f3->config('config/sims2.cfg');
					$this->s2sim->getBySimId($this->f3->get('PARAMS.id'));
					$this->f3->set('s2sim',$this->s2sim);
					$this->users2data->getByUserId($this->userID);
					$this->f3->set('users2',$this->users2data);
				}

				if ($this->sim->gameVersion==3) {
					$this->f3->config('config/sims3.cfg');
					$this->s3sim->getBySimId($this->f3->get('PARAMS.id'));
					$this->f3->set('s3sim',$this->s3sim);
					$this->users3data->getByUserId($this->userID);
					$this->f3->set('users3',$this->users3data);
				}

				if ($this->sim->gameVersion==4) {
					$this->f3->config('config/sims4.cfg');
					$this->s4sim->getBySimId($this->f3->get('PARAMS.id'));
					$this->f3->set('s4sim',$this->s4sim);
					$this->users4data->getByUserId($this->userID);
					$this->f3->set('users4',$this->users4data);
				}
				$this->f3->set('hood',$this->hood);
				$this->user->getById($this->userID);
				$this->f3->set('majors',$this->major->getByUserId($this->userID));
				$this->major->getById($this->sim->major);
                $this->career->getById($this->sim->careerTrack);
				$this->f3->set('major',$this->major);
				$this->f3->set('classes',$this->class->getByMajor($this->major->id));
                $this->f3->set('career',$this->career);
                $this->f3->set('jobs',$this->job->getByCareer($this->sim->careerTrack));
				$this->f3->set('households',$this->household->getByUser($this->userID));
				$this->household->getById($this->sim->hhID);
				$this->f3->set('hh',$this->household);
				$this->f3->set('user',$this->user);
				$this->f3->set('parents',$parents);
				$this->f3->set('modified',$this->date);
				$this->f3->set('title','Update Sim');
				$this->f3->set('content','sim/update.html');
			} else {
				$this->f3->set('SESSION.error','Sim doesn\'t exist');
				$this->index();
			}
		}
	}


	public function delete() {
		if ($this->f3->exists('PARAMS.id')) {
			$this->sim->delete($this->f3->get('PARAMS.id'));
			$this->f3->set('SESSION.success','Sim was deleted');
		} else {
			$this->f3->set('SESSION.error','Sim doesn\'t exist');
		}

		$this->f3->reroute('/sims');
	}

	public function view() {
		if ($this->f3->exists('PARAMS.id')) {
			$this->sim->getById($this->f3->get('PARAMS.id'));
			$this->hood->getById($this->sim->nhID);
            $this->household->getById($this->sim->hhID);
			$this->major->getById($this->sim->major);
			$this->class->getById($this->sim->class);
            $this->career->getById($this->sim->careerTrack);
            $this->job->getById($this->sim->jobLevel);
			$this->business->getByOwner($this->f3->get('PARAMS.id'));
			$name=$this->sim->firstName.' '.$this->sim->lastName;
			$human=TRUE;
			if ($this->hood->gameVersion==2) {
				$this->f3->config('config/sims2.cfg');
				$this->s2sim->getBySimId($this->sim->id);
				$this->s2class->getByClassId($this->sim->class);
                $this->s2job->getByJobId($this->sim->jobLevel);

			}

			if ($this->hood->gameVersion==3) {
				$this->f3->config('config/sims3.cfg');
				$this->s3sim->getBySimId($this->sim->id);
				$this->s3class->getByClassId($this->sim->class);
			}

			if ($this->hood->gameVersion==4) {
				$this->f3->config('config/sims4.cfg');
				$this->s4sim->getBySimId($this->sim->id);
				$this->s4class->getByClassId($this->sim->class);
			}

			$this->f3->set('sim',$this->sim);
            $this->f3->set('hood',$this->hood);
            $this->f3->set('hh',$this->household);
            $this->f3->set('business',$this->business);
            $this->f3->set('major',$this->major);
            $this->f3->set('class',$this->class);
            $this->f3->set('career',$this->career);
            $this->f3->set('job',$this->job);

			if ($this->sim->gameVersion==2) {
				$this->s2sim->getBySimId($this->f3->get('PARAMS.id'));
				$this->f3->set('s2sim',$this->s2sim);
				$this->f3->set('s2class',$this->s2class);
                $this->f3->set('s2job',$this->s2job);
				$s2sim=$this->s2sim;
				if ($s2sim->isAlien==1 || $s2sim->isZombie==1 || $s2sim->isVampire==1 ||
					$s2sim->isServo==1 || $s2sim->isWerewolf==1 ||
					$s2sim->isPlantSim==1 || $s2sim->isWitch==1) {
					$human=FALSE;
				}
			}

			if ($this->sim->gameVersion==3) {
				$this->s3sim->getBySimId($this->f3->get('PARAMS.id'));
				$this->f3->set('s3sim',$this->s3sim);
				$this->f3->set('s3class',$this->s3class);
			}

			if ($this->sim->gameVersion==4) {
				$this->s4sim->getBySimId($this->f3->get('PARAMS.id'));
				$this->f3->set('s4sim',$this->s4sim);
				$this->f3->set('s4class',$this->s4class);
			}
			$this->f3->set('human',$human);
			$this->f3->set('title',$name);
			$this->f3->set('content','sim/view.html');
		} else {
			$this->f3->set('SESSION.error','Sim doesn\'t exist');
			$this->index();
		}
	}

	function save() {
		if (isset($_POST['save'])) {
			$this->f3->set('POST.walking',isset($_POST["walking"])?1:0);
			$this->f3->set('POST.talking',isset($_POST["talking"])?1:0);
			$this->f3->set('POST.housebroken',isset($_POST["housebroken"])?1:0);
			$this->f3->set('POST.ltwDone',isset($_POST["ltwDone"])?1:0);
			$this->f3->set('POST.retired',isset($_POST["retired"])?1:0);
		}
	}

	function s2save() {
		if (isset($_POST['save'])) {
			$this->f3->set('POST.isAlien',isset($_POST["isAlien"])?1:0);
			$this->f3->set('POST.isZombie',isset($_POST["isZombie"])?1:0);
			$this->f3->set('POST.isVampire',isset($_POST["isVampire"])?1:0);
			$this->f3->set('POST.isServo',isset($_POST["isServo"])?1:0);
			$this->f3->set('POST.isWerewolf',isset($_POST["isWerewolf"])?1:0);
			$this->f3->set('POST.isPlantSim',isset($_POST["isPlantSim"])?1:0);
			$this->f3->set('POST.isWitch',isset($_POST["isWitch"])?1:0);
			$this->f3->set('POST.rhyme',isset($_POST["rhyme"])?1:0);

			$this->f3->set('POST.earnedAthletics',isset($_POST["earnedAthletics"])?1:0);
			$this->f3->set('POST.earnedCharisma',isset($_POST["earnedCharisma"])?1:0);
			$this->f3->set('POST.earnedHygienics',isset($_POST["earnedHygienics"])?1:0);
			$this->f3->set('POST.earnedCulinary',isset($_POST["earnedCulinary"])?1:0);
			$this->f3->set('POST.earnedGenius',isset($_POST["earnedGenius"])?1:0);
			$this->f3->set('POST.earnedEngineering',
				isset($_POST["earnedEngineering"])?1:0);
			$this->f3->set('POST.earnedArts',isset($_POST["earnedArts"])?1:0);
			$this->f3->set('POST.earnedYEA',isset($_POST["earnedYEA"])?1:0);
			$this->f3->set('POST.earnedScholar',isset($_POST["earnedScholar"])?1:0);
			$this->f3->set('POST.earnedBilliards',isset($_POST["earnedBilliards"])?1:0);
			$this->f3->set('POST.earnedFootwork',isset($_POST["earnedFootwork"])?1:0);
			$this->f3->set('POST.earnedUndead',isset($_POST["earnedUndead"])?1:0);
			$this->f3->set('POST.earnedOrphan',isset($_POST["earnedOrphan"])?1:0);
			$this->f3->set('POST.earnedET',isset($_POST["earnedET"])?1:0);

			$this->f3->set('POST.cash1',isset($_POST["cash1"])?1:0);
			$this->f3->set('POST.cash2',isset($_POST["cash2"])?1:0);
			$this->f3->set('POST.cash3',isset($_POST["cash3"])?1:0);
			$this->f3->set('POST.cash4',isset($_POST["cash4"])?1:0);
			$this->f3->set('POST.cash5',isset($_POST["cash5"])?1:0);
			$this->f3->set('POST.wholesale1',isset($_POST["wholesale1"])?1:0);
			$this->f3->set('POST.wholesale2',isset($_POST["wholesale2"])?1:0);
			$this->f3->set('POST.wholesale3',isset($_POST["wholesale3"])?1:0);
			$this->f3->set('POST.wholesale4',isset($_POST["wholesale4"])?1:0);
			$this->f3->set('POST.wholesale5',isset($_POST["wholesale5"])?1:0);
			$this->f3->set('POST.perception1',isset($_POST["perception1"])?1:0);
			$this->f3->set('POST.perception2',isset($_POST["perception2"])?1:0);
			$this->f3->set('POST.perception3',isset($_POST["perception3"])?1:0);
			$this->f3->set('POST.perception4',isset($_POST["perception4"])?1:0);
			$this->f3->set('POST.perception5',isset($_POST["perception5"])?1:0);
			$this->f3->set('POST.motivation1',isset($_POST["motivation1"])?1:0);
			$this->f3->set('POST.motivation2',isset($_POST["motivation2"])?1:0);
			$this->f3->set('POST.motivation3',isset($_POST["motivation3"])?1:0);
			$this->f3->set('POST.motivation4',isset($_POST["motivation4"])?1:0);
			$this->f3->set('POST.motivation5',isset($_POST["motivation5"])?1:0);
			$this->f3->set('POST.connections1',isset($_POST["connections1"])?1:0);
			$this->f3->set('POST.connections2',isset($_POST["connections2"])?1:0);
			$this->f3->set('POST.connections3',isset($_POST["connections3"])?1:0);
			$this->f3->set('POST.connections4',isset($_POST["connections4"])?1:0);
			$this->f3->set('POST.connections5',isset($_POST["connections5"])?1:0);

			$this->f3->set('POST.goodHols',isset($_POST["goodHols"])?1:0);
			$this->f3->set('POST.goodHols3',isset($_POST["goodHols3"])?1:0);
			$this->f3->set('POST.goodHols5',isset($_POST["goodHols5"])?1:0);
			$this->f3->set('POST.tour',isset($_POST["tour"])?1:0);
			$this->f3->set('POST.tours5',isset($_POST["tours5"])?1:0);
			$this->f3->set('POST.allTours',isset($_POST["allTours"])?1:0);
			$this->f3->set('POST.allGestures',isset($_POST["allGestures"])?1:0);
			$this->f3->set('POST.roomService',isset($_POST["roomService"])?1:0);
			$this->f3->set('POST.photoAlbum',isset($_POST["photoAlbum"])?1:0);
			$this->f3->set('POST.secretMap',isset($_POST["secretMap"])?1:0);
			$this->f3->set('POST.secretLot',isset($_POST["secretLot"])?1:0);
			$this->f3->set('POST.secretLotAll',isset($_POST["secretLotAll"])?1:0);
			$this->f3->set('POST.mountainHols',isset($_POST["mountainHols"])?1:0);
			$this->f3->set('POST.flapjacks',isset($_POST["flapjacks"])?1:0);
			$this->f3->set('POST.chestPound',isset($_POST["chestPound"])?1:0);
			$this->f3->set('POST.slapDance',isset($_POST["slapDance"])?1:0);
			$this->f3->set('POST.dtMassage',isset($_POST["dtMassage"])?1:0);
			$this->f3->set('POST.tent',isset($_POST["tent"])?1:0);
			$this->f3->set('POST.logRoll',isset($_POST["logRoll"])?1:0);
			$this->f3->set('POST.axes',isset($_POST["axes"])?1:0);
			$this->f3->set('POST.treeRing',isset($_POST["treeRing"])?1:0);
			$this->f3->set('POST.bigfoot',isset($_POST["bigfoot"])?1:0);
			$this->f3->set('POST.islandHols',isset($_POST["islandHols"])?1:0);
			$this->f3->set('POST.pineapple',isset($_POST["pineapple"])?1:0);
			$this->f3->set('POST.hangLoose',isset($_POST["hangLoose"])?1:0);
			$this->f3->set('POST.hulaDance',isset($_POST["hulaDance"])?1:0);
			$this->f3->set('POST.fireDance',isset($_POST["fireDance"])?1:0);
			$this->f3->set('POST.hsMassage',isset($_POST["hsMassage"])?1:0);
			$this->f3->set('POST.monkeyOffering',isset($_POST["monkeyOffering"])?1:0);
			$this->f3->set('POST.playPirate',isset($_POST["playPirate"])?1:0);
			$this->f3->set('POST.seaChantey',isset($_POST["seaChantey"])?1:0);
			$this->f3->set('POST.beachTreasure',isset($_POST["beachTreasure"])?1:0);
			$this->f3->set('POST.treasureChest',isset($_POST["treasureChest"])?1:0);
			$this->f3->set('POST.mrMickles',isset($_POST["mrMickles"])?1:0);
			$this->f3->set('POST.easternHols',isset($_POST["easternHols"])?1:0);
			$this->f3->set('POST.chirashi',isset($_POST["chirashi"])?1:0);
			$this->f3->set('POST.bow',isset($_POST["bow"])?1:0);
			$this->f3->set('POST.taiChi',isset($_POST["taiChi"])?1:0);
			$this->f3->set('POST.apMassage',isset($_POST["apMassage"])?1:0);
			$this->f3->set('POST.drankTea',isset($_POST["drankTea"])?1:0);
			$this->f3->set('POST.zen',isset($_POST["zen"])?1:0);
			$this->f3->set('POST.mahjong',isset($_POST["mahjong"])?1:0);
			$this->f3->set('POST.shrine',isset($_POST["shrine"])?1:0);
			$this->f3->set('POST.teleport',isset($_POST["teleport"])?1:0);
			$this->f3->set('POST.dragon',isset($_POST["dragon"])?1:0);

			$this->f3->set('POST.dpBeetle',isset($_POST["dpBeetle"])?1:0);
			$this->f3->set('POST.pBeetle',isset($_POST["pBeetle"])?1:0);
			$this->f3->set('POST.cpBeetle',isset($_POST["cpBeetle"])?1:0);
			$this->f3->set('POST.gmBeetle',isset($_POST["gmBeetle"])?1:0);
			$this->f3->set('POST.jBeetle',isset($_POST["jBeetle"])?1:0);
			$this->f3->set('POST.prBeetle',isset($_POST["prBeetle"])?1:0);
			$this->f3->set('POST.thgBeetle',isset($_POST["thgBeetle"])?1:0);
			$this->f3->set('POST.rBeetle',isset($_POST["rBeetle"])?1:0);
			$this->f3->set('POST.mlBeetle',isset($_POST["mlBeetle"])?1:0);
			$this->f3->set('POST.gbBeetle',isset($_POST["gbBeetle"])?1:0);
			$this->f3->set('POST.jButterfly',isset($_POST["jButterfly"])?1:0);
			$this->f3->set('POST.pbButterfly',isset($_POST["pbButterfly"])?1:0);
			$this->f3->set('POST.eButterfly',isset($_POST["eButterfly"])?1:0);
			$this->f3->set('POST.bfwButterfly',isset($_POST["bfwButterfly"])?1:0);
			$this->f3->set('POST.mgButterfly',isset($_POST["mgButterfly"])?1:0);
			$this->f3->set('POST.mButterfly',isset($_POST["mButterfly"])?1:0);
			$this->f3->set('POST.vButterfly',isset($_POST["vButterfly"])?1:0);
			$this->f3->set('POST.pButterfly',isset($_POST["pButterfly"])?1:0);
			$this->f3->set('POST.cpButterfly',isset($_POST["cpButterfly"])?1:0);
			$this->f3->set('POST.sButterfly',isset($_POST["sButterfly"])?1:0);
			$this->f3->set('POST.ssSpider',isset($_POST["ssSpider"])?1:0);
			$this->f3->set('POST.gwSpider',isset($_POST["gwSpider"])?1:0);
			$this->f3->set('POST.pSpider',isset($_POST["pSpider"])?1:0);
			$this->f3->set('POST.mSpider',isset($_POST["mSpider"])?1:0);
			$this->f3->set('POST.ibSpider',isset($_POST["ibSpider"])?1:0);
			$this->f3->set('POST.hdSpider',isset($_POST["hdSpider"])?1:0);
			$this->f3->set('POST.qcSpider',isset($_POST["qcSpider"])?1:0);
			$this->f3->set('POST.hpSpider',isset($_POST["hpSpider"])?1:0);
			$this->f3->set('POST.sfbSpider',isset($_POST["sfbSpider"])?1:0);
			$this->f3->set('POST.tbSpider',isset($_POST["tbSpider"])?1:0);

			$this->f3->set('POST.artsplq',isset($_POST["artsplq"])?1:0);
			$this->f3->set('POST.filmplq',isset($_POST["filmplq"])?1:0);
			$this->f3->set('POST.fitplq',isset($_POST["fitplq"])?1:0);
			$this->f3->set('POST.cusplaq',isset($_POST["cusplaq"])?1:0);
			$this->f3->set('POST.gamesplq',isset($_POST["gamesplq"])?1:0);
			$this->f3->set('POST.musicplq',isset($_POST["musicplq"])?1:0);
			$this->f3->set('POST.natplq',isset($_POST["natplq"])?1:0);
			$this->f3->set('POST.sciplq',isset($_POST["sciplq"])?1:0);
			$this->f3->set('POST.sportplq',isset($_POST["sportplq"])?1:0);
			$this->f3->set('POST.tinkplq',isset($_POST["tinkplq"])?1:0);

			$this->f3->set('POST.learnedFire',isset($_POST["learnedFire"])?1:0);
			$this->f3->set('POST.learnedAnger',isset($_POST["learnedAnger"])?1:0);
			$this->f3->set('POST.learnedHappiness',isset($_POST["learnedHappiness"])?1:0);
			$this->f3->set('POST.learnedPhysio',isset($_POST["learnedPhysio"])?1:0);
			$this->f3->set('POST.learnedCounseling',
				isset($_POST["learnedCounseling"])?1:0);
			$this->f3->set('POST.learnedParenting',isset($_POST["learnedParenting"])?1:0);
			$this->f3->set('POST.friendsBenefit',isset($_POST["friendsBenefit"])?1:0);
		}
	}
}