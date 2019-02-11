<?php

	class Config {
		
		private function __construct() {}
		private function __clone() {}
		
		public static function get($path = NULL) {
			if ($path) {
				$items = require 'config/' . $path . '.php';
				return $items;
				}
			else {
				return FALSE;
				}	
			}
		
		}

?>