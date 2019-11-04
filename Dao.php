<?php
class Dao {
	
	//private $host = 'localhost';
	//private $dbName = 'testdb';
	//private $dbUsername = 'root';
	//private $dbPassword = '';
	
	//mysql://baa858e9ba12f1:7f821f4a@us-cdbr-iron-east-05.cleardb.net/heroku_08770357bfc5d85?reconnect=true
	private $host = 'us-cdbr-iron-east-05.cleardb.net';
	private $dbName = 'heroku_08770357bfc5d85';
	private $dbUsername = 'baa858e9ba12f1';
	private $dbPassword = '7f821f4a';
	
	public function __construct() {
		
	}
	
	public function getConnection() {
		try {
			$connection = new PDO("mysql:host={$this->host};dbname={$this->dbName}", $this->dbUsername, $this->dbPassword);
		}
		catch (Exception $e) {
			echo print_r($e, 1);
		}
		return $connection;
	}
	
	public function isValidLogin($username, $password) {
		$connection = $this->getConnection();
		$queryString = "select * from user where username = :username and password = :password;";
		$q = $connection->prepare($queryString);
		$q->bindParam(":username", $username);
		$q->bindParam(":password", $password);
		$q->execute();
		$results = $q->fetchAll();
		return sizeof($results) > 0;
	}
	
	public function getUserID($username) {
		$connection = $this->getConnection();
		$queryString = "select user_id from user where username = :username";
		$q = $connection->prepare($queryString);
		$q->bindParam(":username", $username);
		$q->execute();
		$results = $q->fetch();
		return $results[0];
	}
	
	public function createUser($username, $password) {
		$connection = $this->getConnection();
		$queryString = "insert into user (username, password) values (:username, :password)";
		$q = $connection->prepare($queryString);
		$q->bindParam(":username", $username);
		$q->bindParam(":password", $password);
		$q->execute();
		return $this->getUserID($username);
	}
	
	public function userExists($username) {
		$connection = $this->getConnection();
		$queryString = "select * from user where username = :username";
		$q = $connection->prepare($queryString);
		$q->bindParam(":username", $username);
		$q->execute();
		$results = $q->fetchAll();
		return sizeof($results) > 0;
	}
	
	public function validLogin($username, $password) {
		$connection = $this->getConnection();
		$queryString = "select * from user where username = :username and password = :password";
		$q = $connection->prepare($queryString);
		$q->bindParam(":username", $username);
		$q->bindParam(":password", $password);
		$q->execute();
		$results = $q->fetchAll();
		return sizeof($results) > 0;
	}
	
	public function saveSettings($user_id, $follow_list) {
		$connection = $this->getConnection();
		
		$queryString = "delete from follow where user_id = :user_id;";
		$q = $connection->prepare($queryString);
		$q->bindParam(":user_id", $user_id);
		$q->execute();
		
		$queryString = "insert into follow (user_id, account_url) values (:user_id, :account)";
		
		foreach ($follow_list as $account) {
			$q = $connection->prepare($queryString);
			$q->bindParam(":user_id", $user_id);
			$q->bindParam(":account", $account);
			$q->execute();
		}
		print_r($q->errorInfo());
	}
	
	public function getFollowList($user_id) {
		$connection = $this->getConnection();
		$queryString = "select account_url from follow where user_id = :user_id;";
		$q = $connection->prepare($queryString);
		$q->bindParam(":user_id", $user_id);
		$q->execute();
		$results = $q->fetchAll();
		$follow_list = [];
		foreach ($results as $account) {
			$follow_list[] = $account[0];
		}
		return $follow_list;
	}
	
	public function printTable($tableName) {
		$connection = $this->getConnection();
		try {
			$q = $connection->query("select * from {$tableName};", PDO::FETCH_ASSOC)->fetchAll();
			echo sizeof($q);
			foreach ($q as $row) {
				print_r($row);
				echo "<br>";
			}
		} catch(Exception $e) {
			echo print_r($e, 1);
			exit;
		}
	}
}
?>