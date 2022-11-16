<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 23/09/2018
 * Time: 22:59
 */

class CreditsController extends Controller {
	function beforeroute() {

	}

	function index($f3) {
		$f3->set('content','credits.html');
		$f3->set('title','Credits');
	}
}
