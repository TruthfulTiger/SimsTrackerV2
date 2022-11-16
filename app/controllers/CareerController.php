<?php

class CareerController extends Controller {
	private $career;
	private $pcareer;
	private $job;
	private $pjob;
	private $s2job;
	private $s3job;
	private $s4job;

	public function __construct() {
		parent::__construct();
		$this->career=new Career($this->db);
		$this->pcareer=new PCareer($this->db);
		$this->job=new Job($this->db);
		$this->pjob=new PJob($this->db);
		$this->s2job=new S2Job($this->db);
		$this->s3job=new S3Job($this->db);
		$this->s4job=new S4Job($this->db);
	}

	function beforeroute() {
		parent::beforeroute();
		if ($this->f3->get('SESSION.user[1]')!=='Admin') {
			$this->f3->set('SESSION.error',
				'You need admin rights to access that page.');
			$this->f3->reroute('/');
			exit;
		}
	}

	public function index() {
		$this->career->jobs=
			'SELECT COUNT(*) as jobscount FROM job where career.id = job.careerID and job.gameVersion > 0 GROUP BY career.id ';
		$this->pcareer->pjobs=
			'SELECT COUNT(*) as pjobscount FROM pjob where pcareer.id = pjob.pcareerID GROUP BY pcareer.id ';
		$this->f3->set('careers',$this->career->all());
		$this->f3->set('pcareers',$this->pcareer->all());
		$this->f3->set('title','Careers');
		$this->f3->set('content','career/list.html');
	}

	public function create() {
		if ($this->f3->exists('POST.create')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$this->f3->scrub($_POST,'p; br;');
				$lastAdded=$this->career->get('_id'); // Store last ID before adding
				$this->career->add();
				$lastID=$this->career->get('_id'); // Store last ID after adding
				if ($lastID!==
					$lastAdded) { // If the two are different, that means a career has been added
					$this->f3->set('SESSION.success','Career has been added.');
				} else {
					$this->f3->set('SESSION.error','Couldn\'t create career.');
				}

				$this->index();
			}
		} else {
			$this->f3->set('title','Create Career');
			$this->f3->set('game','');
			$this->f3->set('content','career/create.html');
		}
	}

	public function pcreate() {
		if ($this->f3->exists('POST.create')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$this->f3->scrub($_POST,'p; br;');
				$lastAdded=$this->pcareer->get('_id'); // Store last ID before adding
				$this->pcareer->add();
				$lastID=$this->pcareer->get('_id'); // Store last ID after adding
				if ($lastID!==
					$lastAdded) { // If the two are different, that means a career has been added
					$this->f3->set('SESSION.success','Career has been added.');
				} else {
					$this->f3->set('SESSION.error','Couldn\'t create career.');
				}

				$this->index();
			}
		} else {
			$this->f3->set('title','Create Pet Career');
			$this->f3->set('content','career/pet/create.html');
		}
	}

	public function createJob() {
		if ($this->f3->exists('POST.create')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$id=$this->f3->get('POST.careerID');
				$this->f3->scrub($_POST,'p; br;');
				for ($i=1;$i<=13;$i++) {
					$this->db->exec(
						'INSERT INTO job (careerID, gameVersion, age, jobLevel, jobName) VALUES (:id, :gv, :age, :jlevel, :jname)',
						array(
							':id'=>$id,
							':jlevel'=>$this->f3->get('POST.jobLevel'.$i),
							':gv'=>$this->f3->get('POST.gameVersion'.$i),
							':age'=>$this->f3->get('POST.age'.$i),
							':jname'=>$this->f3->get('POST.jobName'.$i)
						)
					);
				}
				$this->index();
			}
		} else {
			$this->career->getById($this->f3->get('PARAMS.id'));
			$career=$this->career;
			$this->f3->set('career',$career);
			$this->f3->set('title','Create Jobs for '.$career->careerName);
			$this->f3->set('content','career/sim/jobs/create.html');
		}
	}

	public function createPJob() {
		if ($this->f3->exists('POST.create')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$id=$this->f3->get('POST.pcareerID');
				$this->f3->scrub($_POST,'p; br;');
				for ($i=1;$i<=4;$i++) {
					$this->db->exec(
						'INSERT INTO pjob (pcareerID, jobLevel, jobName) VALUES (:id, :jlevel, :jname)',
						array(
							':id'=>$id,
							':jlevel'=>$i,
							':jname'=>$this->f3->get('POST.jobName'.$i)
						)
					);
				}
				$this->index();
			}
		} else {
			$this->f3->set('career',$this->pcareer->getById($this->f3->get('PARAMS.id')));
			$this->f3->set('title','Create Jobs for '.$this->pcareer->careerName);
			$this->f3->set('careerID',$this->f3->get('PARAMS.id'));
			$this->f3->set('content','career/pet/jobs/create.html');
		}
	}

	public function updatePJob() {
		if ($this->f3->exists('POST.update')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$this->f3->scrub($_POST,'p; br;');
				$this->save();
				$this->pjob->edit($this->f3->get('POST.id'));
				$this->f3->set('SESSION.success','Job has been updated.');
				$this->f3->reroute('/close');
			}
		} else {
			if ($this->f3->exists('PARAMS.id')) {
				$this->pjob->getById($this->f3->get('PARAMS.id'));
				$this->f3->set('job',$this->pjob);
				$this->f3->set('title','Update Job');
				$this->f3->set('content','career/pet/jobs/update.html');
				$this->f3->set('modified',$this->date);
			} else {
				$this->f3->set('SESSION.error','Job doesn\'t exist');
			}
		}
	}

	public function updateJob() {
		if ($this->f3->exists('POST.update')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$this->f3->scrub($_POST,'p; br;');
				$job=$this->f3->get('POST.id');
				$this->save();
				$this->job->getById($job);
				if ($this->job->gameVersion==2)
					$this->s2job->getByJobId($job);
				if ($this->job->gameVersion==3)
					$this->s3job->getByJobId($job);
				if ($this->job->gameVersion==4)
					$this->s4job->getByJobId($job);
				$this->job->edit($job);
				if ($this->job->gameVersion==2)
					$this->s2job->edit($this->s2job->id);
				if ($this->job->gameVersion==3)
					$this->s3job->edit($this->s3job->id);
				if ($this->job->gameVersion==4)
					$this->s4job->edit($this->s4job->id);
				$this->f3->set('SESSION.success','Job has been updated.');
				$this->f3->reroute('/close');
			}
		} else {
			if ($this->f3->exists('PARAMS.id')) {
				$this->job->getById($this->f3->get('PARAMS.id'));
				$this->f3->set('job',$this->job);
				if ($this->job->gameVersion==2) {
					$this->f3->config('config/sims2.cfg');
					$this->s2job->getByJobId($this->f3->get('PARAMS.id'));
					$this->f3->set('s2job',$this->s2job);
				}

				$this->f3->set('title','Update Job');
				$this->f3->set('content','career/sim/jobs/update.html');
				$this->f3->set('modified',$this->date);
			} else {
				$this->f3->set('SESSION.error','Job doesn\'t exist');
			}
		}
	}

	public function update() {
		if ($this->f3->exists('POST.update')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$this->f3->scrub($_POST,'p; br;');
				$this->career->edit($this->f3->get('POST.id'));
				$this->f3->set('SESSION.success','Career has been updated.');
				$this->index();
			}
		} else {
			if ($this->f3->exists('PARAMS.id')) {
				$this->career->getById($this->f3->get('PARAMS.id'));
				$this->f3->set('career',$this->career);
				$this->f3->set('title','Update Career');
				$this->f3->set('jobs',$this->job->getByCareer($this->career->id));
				$this->f3->set('content','career/update.html');
				$this->f3->set('modified',$this->date);
			} else {
				$this->f3->set('SESSION.error','Career doesn\'t exist');
				$this->index();
			}
		}
	}

	public function pupdate() {
		if ($this->f3->exists('POST.update')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$this->f3->scrub($_POST,'p; br;');
				$maxsize=$this->f3->get('POST.MAX_FILE_SIZE');
				$file=$_FILES["image-raw"];
				$this->pcareer->edit($this->f3->get('POST.id'));
				if (!empty($file)) {
					$is=new UploadController;
					$is->imageUpload($file,$maxsize);
				}
				$this->f3->set('SESSION.success','Career has been updated.');
				$this->index();
			}
		} else {
			if ($this->f3->exists('PARAMS.id')) {
				$this->pcareer->getById($this->f3->get('PARAMS.id'));
				$this->f3->set('pcareer',$this->pcareer);
				$this->f3->set('title','Update Career');
				$this->f3->set('pjobs',$this->pjob->getByCareer($this->pcareer->id));
				$this->f3->set('content','career/pet/update.html');
				$this->f3->set('modified',$this->date);
			} else {
				$this->f3->set('SESSION.error','Career doesn\'t exist');
				$this->index();
			}
		}
	}


	public function delete() {
		if ($this->f3->exists('PARAMS.id')) {
			$this->career->delete($this->f3->get('PARAMS.id'));
		} else {
			$this->f3->set('SESSION.error','Career doesn\'t exist');
		}

		$this->f3->reroute('/careers');
	}

	public function pdelete() {
		if ($this->f3->exists('PARAMS.id')) {
			$this->pcareer->delete($this->f3->get('PARAMS.id'));
		} else {
			$this->f3->set('SESSION.error','Career doesn\'t exist');
		}

		$this->f3->reroute('/careers');
	}

	public function deleteJob() {
		if ($this->f3->exists('PARAMS.id')) {
			$this->job->delete($this->f3->get('PARAMS.id'));
		} else {
			$this->f3->set('SESSION.error','Job doesn\'t exist');
		}

		$this->f3->reroute('/careers');
	}

	public function deletePJob() {
		if ($this->f3->exists('PARAMS.id')) {
			$this->pjob->delete($this->f3->get('PARAMS.id'));
		} else {
			$this->f3->set('SESSION.error','Job doesn\'t exist');
		}

		$this->f3->reroute('/careers');
	}

	public function save() {
		if (isset($_POST['save'])) {
			$this->f3->set('POST.sun',isset($_POST["sun"])?1:0);
			$this->f3->set('POST.mon',isset($_POST["mon"])?1:0);
			$this->f3->set('POST.tue',isset($_POST["tue"])?1:0);
			$this->f3->set('POST.wed',isset($_POST["wed"])?1:0);
			$this->f3->set('POST.thu',isset($_POST["thu"])?1:0);
			$this->f3->set('POST.fri',isset($_POST["fri"])?1:0);
			$this->f3->set('POST.sat',isset($_POST["sat"])?1:0);
			$this->f3->set('POST.sit',isset($_POST["sit"])?1:0);
			$this->f3->set('POST.stay',isset($_POST["stay"])?1:0);
			$this->f3->set('POST.come',isset($_POST["come"])?1:0);
			$this->f3->set('POST.shake',isset($_POST["shake"])?1:0);
			$this->f3->set('POST.rollOver',isset($_POST["rollOver"])?1:0);
			$this->f3->set('POST.speak',isset($_POST["speak"])?1:0);
			$this->f3->set('POST.playDead',isset($_POST["playDead"])?1:0);
		}
	}
}