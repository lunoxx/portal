<?php
if(!defined('RPG')) return;
class User extends Config {

	public static function init() {
		if(self::isLogged()) {
			$q = DB::prepare('SELECT `ID` FROM `players` WHERE `ID` = ?');
			$q->execute(array(self::get()));
			if(!$q->rowCount()) Redirect::to('logout');
		}
	}

	public static function isLogged() {
		return (isset($_SESSION['v_user']) ? true : false);
	}

	public static function get() {
		return (isset($_SESSION['v_user']) ? $_SESSION['v_user'] : false);
	}

	
	public static function getData($id,$data) {
		if(!is_array($data)) {
			$q = DB::prepare('SELECT `'.$data.'` FROM `players` WHERE `ID` = ?');
			$q->execute(array($id));
			$fdata = $q->fetch();
			return $fdata[$data];
		} else {
			$q = '';
			foreach($data as $d) {
				if(end($data) !== $d) $q .= '`'.$d.'`,';
				else $q .= '`'.$d.'`';
			}
			$q = DB::prepare('SELECT '.$q.' FROM `players` WHERE `ID` = ?');
			$q->execute(array($id));
			return $q->fetch(PDO::FETCH_ASSOC);
		}
	}
	
	public static function login($user,$pass) {
		if(!$user || !$pass) {			$mesaj = '';			if(!$user)			{				$mesaj = '&#8226; Please enter your username.';			}			if(!$user && !$pass) { $mesaj = sprintf('%s<br>', $mesaj); }			if(!$pass)			{				$mesaj = sprintf('%s&#8226; Please enter your password.', $mesaj);			}
			return array('message' => ''.$mesaj.'', 'type' => 'validation');		}

		$q = DB::prepare('SELECT `ID` FROM `players` WHERE (`Name` = ? OR `AName` != "aname" AND `AName` = ?) AND `Password` = ?');
		$q->execute(array($user,$user, md5($pass)));

		if(!$q->rowCount())
			return array('message' => 'Incorrect username or password.','type' => 'validation');
		$udata = $q->fetch();
		$_SESSION['v_user'] = $udata[0];
		Redirect::to('profile',1);
		return array('message' => 'You have successfully logged in. You will be redirected..','type' => 'success');
	}
	
	public static function lostPass($user,$email) {
		if(!$user || !$email) 
			return array('message' => 'Complete all fields.','type' => 'validation');
		
		$q = DB::prepare('SELECT `ID`,`Name` FROM `players` WHERE `Name` = ? AND `Email` = ?');
		$q->execute(array($user,$email));
		
		if(!$q->rowCount()) 
			return array('message' => 'No account found with this username and email combination.', 'type' => 'validation');
		
		$data = $q->fetch(PDO::FETCH_OBJ);
		
		$q = DB::prepare('DELETE FROM `lostpass` WHERE `email` = ?');
		$q->execute(array($email));
		
		
		$token = sha1(md5($email . time() . uniqid(rand(), TRUE)));
		
		$q = DB::prepare('INSERT INTO `lostpass` (`ip`,`token`,`time`,`expire`,`email`,`userid`) VALUES (?,?,?,?,?,?)');
		$q->execute(array($_SERVER['REMOTE_ADDR'],$token,time(),time()+86400,$email,$data->ID));
		
		$_SESSION['lost_pass_token'] = $token;
		
		$link = Config::$data->url . 'recover/' . $token;
		
		$mail = '
			<html>
				<head>
					<title>LimitCS - Lost Password</title>
				</head>
				<body>
					'.$data->Name.',<br>
					This email has been sent from '.Config::$data->url.'<br><br>
					You have received this email because a password recovery for the<br>
					user account "'.$data->Name.'" was instigated by you on LimitCS RPG - Panel.<br><br>
					<hr>
					IMPORTANT!
					<hr><br>
					If you did not request this password change,please IGNORE and DELETE this<br>
					email immediately. Only continue if you wish your password to be reset !<br><br>
					<hr>
					Password Reset Instructions Below
					<hr><br>
					We require that you "validate" your password recovery to ensure that<br>
					you instigated this action. This protects against <br>
					unwanted spam and malicious abuse.<br><br>
					Simply click on the link below and complete the rest of the form.<br>
					'.$link.' <br><br>
					Note that this link expires in 24 hours.
				</body>
			</html>
		';
		
		$headers =
			'From: LimitCS România - Lost password <contact@thegama.ro>' . "\r\n" .
			'Reply-To: contact@thegama.ro' . "\r\n" .
			'Subject: LimitCS România - Lost password' . "\r\n" .
			'MIME-Version: 1.0' . "\r\n" .
			'Content-Type: text/html; charset=ISO-8859-1';
			
		mail($email,'LimitCS România - Lost password',$mail,$headers,'-fcontact@thegama.ro');

		return array('message' => 'You will receive an email with instructions.','type' => 'success');
	}
	
	public static function changePassword($user,$pass,$rpass) {
		if(!$pass || !$rpass) 
			return array('message' => 'Complete all fields.','type' => 'validation');
		
		if($pass !== $rpass)
			return array('message' => 'Passwords don\'t match.','type' => 'validation');
		
		$q = DB::prepare('UPDATE `players` SET `Password` = ? WHERE `ID` = ?');
		$q->execute(array(strtoupper(md5($pass)),$user));
		
		return array('message' => 'Your password has been changed.','type' => 'success');
		
	}
	
	public static function format($id,$name = false) {
		if(!$name) $name = User::getData($id,'Name');
		return '
			<a href="'.Config::$data->url.'profile/'.$id.'">'.$name.'</a>
		';
	}
	
	public static function getId($name) {
		$namea = $name;
		if(strpos($name,']')) { $namea = explode(']',$name); $namea = $namea[1]; }
		$q = DB::prepare('SELECT `ID` FROM `players` WHERE `Name` = ? OR `Name` = ? OR `AName` = ?');
		$q->execute(array($namea,$name,$name));
		if(!$q->rowCount()) return 0;
		$data = $q->fetch(PDO::FETCH_OBJ);
		return $data->ID;
	}

	public static function getLocation($ip) {
		$data = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));
		return $data['geoplugin_countryName'] . ', ' . $data['geoplugin_city'];
	}
	
}
