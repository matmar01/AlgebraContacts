<?php

	//csrf -> informiraj se o tome
	//CSRF token
	
	class Token {
		
		public static function setToken() {
			$token = md5(uniqid(rand()));
			$_SESSION['token'] = $token;
			$_SESSION['token_time'] = time();
			return $token;
			}
		
		public static function controlToken() {
			if (isset($_SESSION['token_time']) && isset($_SESSION['token'])) {
				$token_time = time() - $_SESSION['token_time'];
				if (($_POST['token'] == $_SESSION['token']) AND ($token_time < 120)) {
					return true;
					}
				}	
			return false;	
			}
		
		public static function deleteToken() {
			if (isset($_SESSION['token_time']) && isset($_SESSION['token'])) {
				unset($_SESSION['token']);
				unset($_SESSION['token_time']);
				return true;
				}
			return false;	
			}
			
		}
	

?>