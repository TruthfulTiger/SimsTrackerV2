<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 23/09/2018
 * Time: 22:59
 */

class AboutController extends Controller {
	function beforeroute() {

	}

	function index($f3) {
		$f3->set('content','about.html');
		$f3->set('title','About');
	}
}
