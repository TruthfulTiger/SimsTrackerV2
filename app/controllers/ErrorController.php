<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 23/09/2018
 * Time: 23:21
 */

class ErrorController extends Controller {
	function beforeroute() {

	}

	function afterroute() {
		echo Template::instance()->render('error.html');
		$this->f3->clear('SESSION.error');
		$this->f3->clear('SESSION.success');
		$this->f3->clear('SESSION.info');
		$this->f3->clear('SESSION.warning');
	}
}