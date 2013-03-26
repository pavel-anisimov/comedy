<?php

class UserSecurity {

	private $uid;
	private $login;
	private $password;
	private $cpriptpass; 

	private $query; 
	private $db_host; 
	private $db_user;
	private $db_pass; 
	private $db_name;
	
	function __construct ($db_host, $db_user, $db_pass, $db_name) {
		$this->db_host = $db_host;
		$this->db_user= $db_user;
		$this->db_pass = $db_pass; 
		$this->db_name = $db_name;
		$query = '';
	}
	
	function verify($user, $pass) {


		
		$mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
		if ($mysqli->connect_errno) {
    		printf("Connect failed: %s\n", $mysqli->connect_error);
    		exit();
		} 
		

		$DBpass = $mysqli->query("SELECT Security.password FROM Users, Security WHERE Users.uid=Security.uid AND Users.name='$user'")->fetch_object()->password;
		$mysqli->close();

		if ($DBpass == $pass)
			return TRUE;
		else 
			return FALSE;
	}
	

	
	
}




?>