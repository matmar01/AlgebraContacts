<?php
	
	class Token {
		/*
		public static function generate() {
			$token = md5(uniqid(rand()));
			$_SESSION['token'] = $token;
			$_SESSION['token_time'] = time();
			return $token;
			}
		public static function controlToken() {
			if (isset($_SESSION['token_time']) && isset($_SESSION['token'])) {
				$token_time = time() - $_SESSION['token_time'];
				if (($_POST['token'] == $_SESSION['token']) && ($token_time < 120)) {
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
		*/
		
		private static $token_name;
		
		private function __construct() {
			
			self::$token_name = Config::get('session')['session']['token_name'];
			
			}
		// factory pattern 
		public static function factory() {
			return new self;//isto kao i return new Token();
			}
		
		public static function generate() {
			Session::put(self::$token_name,md5(uniqid()));
			return Session::get(self::$token_name);
			}
		
		public function check($token) {
			if (Session::exists(self::$token_name) && $token === Session::get(self::$token_name)) {
				return true;
				}
			return false;	
			}
			
		}
	

?>