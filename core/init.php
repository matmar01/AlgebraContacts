<?php
	
	
	session_start();
	//session_regenerate_id();
	//stvara novi id na reload
	
	spl_autoload_register(function($class){
		require_once 'classes/' . $class . '.php';
		});//sam require sve fajlove .php u
			//folder classes 
	
	error_reporting(Config::get('app')['error_reporting']);
	
	$displayError = Config::get('app')['display_errors'];
	//$displayErrors = Config::get('app');
	ini_set('display_errors',$displayError);
	ini_set('display_startup_errors',$displayError);
	//ispisuju sve greske na ekranu
	
	
	require_once 'functions/sanitize.php';
	
	$sessionConfig = Config::get('session');
	$session_name = $sessionConfig['session']['session_name'];
	$cookie_name = $sessionConfig['remember']['cookie_name'];
	
	if (!Session::exists($session_name) && Cookie::exists($cookie_name)) {
		
		$cookieHash = Cookie::get($cookie_name);
		$dbHash = DB::getInstance()->get('*','sessions',['hash','=',$cookieHash]);
		if ($dbHash->getCount()) {
			$userId = $dbHash->getFirst()->user_id;
			$user = new User($userId);
			$user->login();
			}		
		}
	

	
?>




