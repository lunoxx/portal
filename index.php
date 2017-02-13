<?php
session_start();

define('RPG',true);

define('INC_PATH',__DIR__ . '/inc/');
define('CLASSES_PATH',INC_PATH . '/classes/');
define('THEME_PATH',INC_PATH . '/theme/');
define('PAGES_PATH',INC_PATH . '/pages/');
define('ACTIONS_PATH',INC_PATH . '/actions/');

include_once CLASSES_PATH . 'Config.class.php';
include_once CLASSES_PATH . 'Menu.class.php';
include_once CLASSES_PATH . 'Form.class.php';
include_once CLASSES_PATH . 'DB.class.php';
include_once CLASSES_PATH . 'User.class.php';
include_once CLASSES_PATH . 'Arrays.class.php';
include_once CLASSES_PATH . 'Redirect.class.php';
include_once CLASSES_PATH . 'Request.class.php';
include_once CLASSES_PATH . 'Pagination.class.php';

/*DB::$db['mysql'] = array(
	'host' 		=> 	'pawn-services.com',
	'username' 	=> 	'pawnserv_portal',
	'password' 	=> 	')$2tiQD.V(*]',
	'dbname' 	=> 	'pawnserv_portal'
);*/

Config::$data = (object)[
	'url' => 'http://localhost/portal/',
];

Config::init()->getContent();
