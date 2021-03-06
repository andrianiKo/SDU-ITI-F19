<?php

function restricted ($controller, $method) {

	$restricted_urls = array('HomeController' => array('restricted'),
													'PicturesController' => array('index'),
													'UploadController' => array('index'),
													'UsersController' => array('index'),
													'APIController' => array(''));

	if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
		return false;
	} else if( isset($controller) && in_array($method, $restricted_urls[$controller])) {
		return true;
	} else {
		return false;
	}
}
