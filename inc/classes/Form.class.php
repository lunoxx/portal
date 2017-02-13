<?php
if(!defined('RPG')) return;
class Form extends Config {

	public static function getToken() {
    	return $_SESSION['tkn'] = base64_encode(md5(uniqid(rand(), TRUE)));
	}

	public static function checkToken($token) {
		if(isset($_SESSION['tkn']) && $token === $_SESSION['tkn']) {
			unset($_SESSION['tkn']);
			return true;
		}
		return false;
	}

}