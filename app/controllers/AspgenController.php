<?php

class AspgenController extends Controller {
	private $users2data;

	public function __construct() {
		parent::__construct();
		$this->users2data=new UserS2Data($this->db);
	}

	function beforeroute() {

	}

	function index() {
		$userID=$this->f3->get('SESSION.user[2]');
		$this->user->getById($userID);
		$this->users2data->getByUserId($userID);
		$this->f3->set('user',$this->user);
		$this->f3->set('users2',$this->users2data);
		$this->f3->set('content','aspgen.html');
		$this->f3->set('title','Aspiration Randomiser');
	}
}
