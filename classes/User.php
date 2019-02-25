<?php

	class User {
		
		private $db;
		private $data;
		private $session_name;
		private $cookieName;
		private $cookieDuration;
		private $isLoggedIn = false;
		
		public function __construct($userID = null) {
			
			$config = Config::get('session');
			$this->session_name = $config['session']['session_name'];
			$this->cookieName = $config['remember']['cookie_name'];
			$this->cookieDuration = $config['remember']['cookie_expiery'];
			$this->db = DB::getInstance();
			
			if (!$userID) {
				if (Session::exists($this->session_name)) {
					$user = Session::get($this->session_name);
					if ($this->find($user)) {
						$this->isLoggedIn = true;
						}	
					}
				}
			else {
				$this->find($userID);
				}	
			}
		
		public function create ($fields = array()) {
			if (!$this->db->insert('users',$fields)) {
				throw new Exception("There was a problem creating an account");
				}
			}
		
		public function find($userId = null) {
			if ($userId) {
				$field = (is_numeric($userId)) ? 'id' : 'username';
				$data = $this->db->get('*','users',[$field,'=',$userId]);
				if ($data->getCount()) {
					$this->data = $data->getFirst();
					return true;
					}
				}
			return false;	
			}
		
		public function login($username = null,$password = null,$remember = null) {
			/*if (isset($username) && isset($password)) {
				$data = $this->db->get('password','users',['username','=',$username])->getResults();
				$hashed = '';
				foreach ($data as $keys => $values) {
					foreach ($values as $key => $value) {
						if ($key == 'password') {
							$hashed = $value;
							}
						}
					}
				if (!($hashed === $password)) {
					throw new Exception("Username and password don't match!");
					}	
				}*/
			if (!$username && !$password && $this->exists()) {	
				Session::put($this->session_name,$this->data()->id);
				return true;
				}
			else {	
				$user = $this->find($username);	
				if ($user) {
					if ($this->data()->password === Hash::make($password,$this->data()->salt)) {
						Session::put($this->session_name,$this->data()->id);
						if ($remember) {
							$hash = Hash::unique();
							$hashCheck = $this->db->get('hash','sessions',['user_id','=',$this->data()->id]);
							if (!$hashCheck->getCount()) {
								$this->db->insert('sessions',[
								'hash' => $hash,
								'user_id' => $this->data()->id]);
								}
							else {
								$hash = $hashCheck->getFirst()->hash;
								}
							Cookie::put($this->cookieName,$hash,$this->cookieDuration);
							}
						return true;
						}	
					}
				}	
			return false;				
			}	
		
		public function logout() {
			$this->db->delete('sessions',['user_id','=',$this->data()->id]);
			Session::delete($this->session_name);
			Cookie::delete($this->cookieName);
			session_destroy();
			}
		
		public function data() {
			return $this->data;
			}
		
		public function check() {
			return $this->isLoggedIn;
			}
			
		public function exists() {			
			return (!empty($this->data)) ? true : false;
			}	
		
		}

?>