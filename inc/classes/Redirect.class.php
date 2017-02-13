<?php
if(!defined('RPG')) return;
class Redirect extends Config {

	public static function to($page,$delay = false) {
		if($delay != false) {
			echo '<meta http-equiv="refresh" content="' . $delay . ';' . self::$data->url . $page  . '">';
			return;
		}
		header('Location: ' . self::$data->url . $page);
	}

}