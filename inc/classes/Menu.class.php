<?php
if(!defined('RPG')) return;
class Menu extends Config {

	public static function isActive($active) {
		if(!$active && !in_array(Config::$_url[0],Arrays::$_pages)) return ' class="active"';
		if(is_array($active)) {
			foreach($active as $ac) {
				if($ac === self::$_url[0]) return ' class="active"';
			}
			return;
		} else return self::$_url[0] === $active ? ' class="active"' : false;
	}

}