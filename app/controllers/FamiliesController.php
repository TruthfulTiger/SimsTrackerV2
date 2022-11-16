<?php

class FamiliesController extends Controller {
	private $users2data;
	private $users3data;
	private $users4data;

	public function __construct() {
		parent::__construct();
		$this->users2data=new UserS2Data($this->db);
		$this->users3data=new UserS3Data($this->db);
		$this->users4data=new UserS4Data($this->db);
	}

	function beforeroute() {

	}

	function index() {
		$userID=$this->f3->get('SESSION.user[2]');
		$this->user->getById($userID);
		$this->users2data->getByUserId($userID);
		$this->users3data->getByUserId($userID);
		$this->users4data->getByUserId($userID);
		$this->f3->set('user',$this->user);
		$this->f3->set('users2',$this->users2data);
		$this->f3->set('users3',$this->users3data);
		$this->f3->set('users4',$this->users4data);
		$this->f3->set('content','families.html');
		$this->f3->set('title','Family Randomiser');
	}
}
