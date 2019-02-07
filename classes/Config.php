<?php

	class Config {
		
		private function __construct() {}
		private function __clone() {}
		
		public static function get($path = NULL) {
			if ($path) {
				$items = require_once 'config/' . $path . '.php';
				return $items;
				}
			else {
				return FALSE;
				}	
			}
		
		}

?>