<?php

	class DB {
		
		private static $instance = null;
		private $config;
		private $conn;
		private $query;
		private $error = false;
		private $results;
		private $count = 0;
		// Constructor
		private function __construct() {
			$this->config = Config::get('database');
			
			$driver = $this->config['driver'];
			$db_name = $this->config[$driver]['db'];
			$host = $this->config[$driver]['host'];
			$user = $this->config[$driver]['user'];
			$pass = $this->config[$driver]['pass'];
			$charset = $this->config[$driver]['charset'];
			$dsn = $driver . ':dbname=' . $db_name . ';host=' . $host . ';charset=' . $charset;

			try {
				$this->conn = new PDO($dsn,$user,$pass);
				}
			catch(PDOException $e) {
				die($e->getMessage());
				}	
			
			}
		// Singleton pattern	
		public static function getInstance() {
			if (!self::$instance) {
				self::$instance = new self();
				}
			return self::$instance;	
			}	
			
		private function query ($sql, $params = array()) {
			$this->error = false;
			if ($this->query = $this->conn->prepare($sql)) {
				if(!empty($params)) {
					/*for ($i=1;$i <= count($params);$i++) {
						$this->query->bindValue($i,$params[$i-1]);
						}*/
					$counter = 1;	
					foreach ($params as $key => $param) {
						$this->query->bindValue($counter, $param);
						$counter++;
						}	
					}
				if ($this->query->execute()) {	
					$this->result = $this->query->fetchAll(Config::get('database')['fetch']);
					$this->count = $this->query->rowCount();
					}
				else {
					$this->error = true;
					}	
				}
				return $this;
			}
			
		private function action($action,$table,$where = array()) {
			if (count ($where) === 3) {
				$operators = array('=','<','>','<=','>=');
				$field = $where[0];
				$operator = $where[1];
				$value = $where[2];
				if (in_array($operator,$operators)) {
					$sql = "$action FROM $table WHERE $field $operator ?";
					if (!$this->query($sql,array($value))->getError()) {
						return $this;
						}
					}
				}
			else {
				$sql = "$action FROM $table";
				if  (!$this->query($sql)->getError()) {
					return $this;
					}
				}	
			return false;
			}
		
		public function get($columns,$table,$where = array()) {
			return $this->action("SELECT $columns",$table,$where);
			/*if (count ($where) === 3) {
				$operators = array('=','<','>','<=','>=');
				$field = $where[0];
				$operator = $where[1];
				$value = $where[2];
				if (in_array($operator,$operators)) {
					$sql = "SELECT $columns FROM $table WHERE $field $operator ?";
					if (!$this->query($sql,array($value))->getError()) {
						return $this;
						}
					}
				}
			else {
				$sql = "SELECT $columns FROM $table";
				if  (!$this->query($sql)->getError()) {
					return $this;
					}
				}	
			return false;	*/
			}
		
		public function find($id,$table) {
			return $this->action("SELECT *",$table,['id','=',$id]);
			}	
		
		public function delete($table,$where = array()) {
			return $this->action("DELETE",$table,$where);
			}
		
		public function insert($table,$fields) {
			$keys = implode(',',array_keys($fields));
			$field_num = count($fields);
			$values = '';
			$x = 1;
			foreach ($fields as $key => $field) {
				$values .= '?';
				if ($x < $field_num) {
					$values .= ',';
					}
				$x++;	
				}
			$sql = "INSERT INTO $table ($keys) VALUES ($values);";
			if (!$this->query($sql,$fields)->getError()) {
				return $this;
				}
			return false;	
			}
		
		public function update($table,$id,$fields) {
			
			}	
		
		public function getConnection() {
			return $this->conn;
			}
		
		public function getError() {
			return $this->error;
			}
		
		public function getResults() {
			return $this->results;
			}
		
		public function getCount() {
			return $this->count;
			}	
		}
	//Zadaća update funkciju funkcija action sa više uvjeta
	
?>