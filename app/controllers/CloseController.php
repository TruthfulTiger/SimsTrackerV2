<?php

class CloseController extends Controller {
	public function __construct() {
		parent::__construct();
		$this->users2data=new UserS2Data($this->db);
	}

	function beforeroute() {

	}

	function index() {
		$this->f3->set('content','close.html');
		$this->f3->set('title','Close window');
	}
}
