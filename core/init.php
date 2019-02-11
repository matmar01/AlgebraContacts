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

?>
