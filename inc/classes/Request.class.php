<?php
if(!defined('RPG')) return;
class Request extends Config {
	
	public static function isAjax() {
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
			return true;
		}
		return false;
	}
	
	public static function bad($id) {
		return print_r(json_encode(array('title' => 'Request #'.$id,'text' => 'Bad request.', 'type' => 'error')));
	}

}