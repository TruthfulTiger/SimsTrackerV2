<?php

class LegacyGenController extends Controller {
	private $legacygen;
	private $challenge;
	private $challengeID;

	public function __construct() {
		parent::__construct();
		$this->legacygen=new LegacyGen($this->db);
		$this->challenge=new Challenge($this->db);
		$this->f3->set('SESSION.challenge',$this->f3->get('PARAMS.id'));
	}

	public function index() {
		$this->challengeID=$this->f3->get('SESSION.challenge');
		$this->f3->set('legacygen',$this->legacygen->getByChallenge($this->challengeID));
		$this->f3->set('challenge',$this->challenge->getById($this->challengeID));
		$this->f3->set('title','Heir(ess) list for '.$this->challenge->challengeName);
		$this->f3->set('content','legacygen/list.html');
	}

	public function create() {
		if (!empty($_POST['hptrap'])) {
			die('Nice try, Spam-A-Lot');
		} else {
			$this->f3->scrub($_POST,'p; br;');
			if (!is_numeric($this->f3->get('PARAMS.simID'))) {
				$this->f3->set('SESSION.error','There is no sim to save.');
			} else {
				$this->db->exec(
					'INSERT INTO legacygen (userID, generation, challengeID, simID) VALUES (?, ?, ?, ?)',
					array($this->f3->get('PARAMS.userID'),
						$this->f3->get('PARAMS.generation'),
						$this->f3->get('PARAMS.challengeID'),
						$this->f3->get('PARAMS.simID')
					)
				);
				$this->f3->set('SESSION.success','Details have been saved.');
			}
			$this->f3->reroute($_SESSION['url']);
		}
	}

	function update() {
		if (!empty($_POST['hptrap'])) {
			die("Nice try, Spam-A-Lot");
		} else {
			$this->f3->scrub($_POST,'p; br;');

			if ($this->f3->exists('PARAMS.id')) {
				$this->db->exec(
					'UPDATE legacygen SET simID = ? WHERE id = ?',
					array(
						$this->f3->get('PARAMS.simID'),
						$this->f3->get('PARAMS.id'),
					)
				);
				$this->f3->set('SESSION.success','Details have been saved.');
			}

			$this->f3->reroute($_SESSION['url']);
		}
	}

	public function delete() {
		if ($this->f3->exists('PARAMS.id')) {
			$this->legacygen->delete($this->f3->get('PARAMS.id'));
			$this->f3->set('SESSION.success','Generation data was deleted');
		} else {
			$this->f3->set('SESSION.error','Generation data doesn\'t exist');
		}
		$this->f3->reroute($_SESSION['url']);
	}
}