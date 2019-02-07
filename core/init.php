<?php
	
	error_reporting(E_ALL);
	ini_set('display_errors',1);
	ini_set('display_startup_errors',TRUE);
	//ispisuju sve greske na ekranu
	
	session_start();
	//session_regenerate_id();
	//stvara novi id na reload
	
	spl_autoload_register(function($class){
		require_once 'classes/' . $class . '.php';
		});//sam require sve fajlove .php u
			//folder classes 
	
	require_once 'functions/sanitize.php';

?>