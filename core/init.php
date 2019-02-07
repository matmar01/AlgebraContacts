<?php
	
	error_reporting(E_ALL);
	
	session_start();
	//session_regenerate_id();
	//stvara novi id na reload
	
	spl_autoload_register(function($class){
		require_once 'classes/' . $class . '.php';
		});//sam require sve fajlove .php u
			//folder classes 
	
	//$displayErrors = Config::get('app');
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	//ispisuju sve greske na ekranu
	
	
	require_once 'functions/sanitize.php';

?>
