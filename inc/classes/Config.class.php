<?php
if(!defined('RPG')) return;
class Config {

	private static $instance;
	public static $_url;
	public static $data;

	public function __construct() {
		if(defined('MAINTENANCE')) return;
		/*DB::init();
		Arrays::init();
		User::init();*/
	}
	
	public static function init()
	{
		$url = isset($_GET['page']) ? $_GET['page'] : null;
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        self::$_url = explode('/', $url);
	
		if (is_null(self::$instance))
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

	public static function getContent() {
		if(defined('MAINTENANCE')) { include PAGES_PATH . 'maintenance.p.php'; return; }
		if(self::$_url[0] === 'action' && file_exists(ACTIONS_PATH . self::$_url[1] . '.a.php')) { include ACTIONS_PATH . self::$_url[1] . '.a.php'; return; }
		if(in_array(self::$_url[0],array('signature','avatar'))) { include PAGES_PATH . self::$_url[0] . '.php'; return; }
		include_once THEME_PATH . 'header.inc.php';
		if(in_array(self::$_url[0],Arrays::$_pages))
			include PAGES_PATH . self::$_url[0] . '.p.php';
		else
			include_once PAGES_PATH . 'index.p.php'; 
		include_once THEME_PATH . 'footer.inc.php';	
	}

	public static function format($number) {
		return number_format($number,0,'.','.');
	}

	public static function date($data,$reverse = false) {
		return (!$reverse ? date('H:i:s d-m-Y',$data) : date('d-m-Y H:i:s',$data));
	}

	public static function getDate($timestamp,$time = false){
		if(!$timestamp) return 1;
		$difference = time() - $timestamp;
		if($difference == 0)
			return 'just now';
		$periods = array("second", "minute", "hour", "day", "week",
		"month", "year", "decade");
		$lengths = array("60","60","24","7","4.35","12","10");
		if ($difference > 0) {
			$ending = "ago";
		} else {
			$difference = -$difference;
			$ending = "to go";
		}
		if(!$difference) return 'just now';
		for($j = 0; $difference >= $lengths[$j]; $j++)
		$difference /= $lengths[$j];
		$difference = round($difference);
		if($difference != 1) $periods[$j].= "s";
		if($time) $text = "$difference $periods[$j]";
		else $text = "$difference $periods[$j] $ending";
		return $text;
	}


}