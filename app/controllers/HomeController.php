<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 23/09/2018
 * Time: 23:21
 */

class HomeController extends Controller {
	function beforeroute() {

	}

	function index() {
		$this->f3->set('content','home.html');
		$this->f3->set('title','Home');
	}
}