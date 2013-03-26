<?php

class MysqlQuery {
	private $query;
	private $query1;
	private $query2;
	private $db_host; 
	private $db_user;
	private $db_pass; 
	private $db_name;
	private $sqlFile;
	
	function __construct ($db_host, $db_user, $db_pass, $db_name) {
		$this->db_host = $db_host;
		$this->db_user= $db_user;
		$this->db_pass = $db_pass; 
		$this->db_name = $db_name;
		if (basename(getcwd()) == 'comedytest') 
			$this->sqlFile = './scripts/comedy.mysql';
		else 
			$this->sqlFile = '../scripts/comedy.mysql';
		$query = '';
	}
	
	function verify() {
		echo "DB HOST $this->db_host created <br>
			DB USER $this->db_user created <br>
			DB PASS $this->db_pass created <br>
			DB NAME $this->db_name selected <br>";

		
		$mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
		if ($mysqli->connect_errno) {
    		printf("Connect failed: %s\n", $mysqli->connect_error);
    		exit();
		} $mysqli->close();
		
			
			
	}
	
	function execute($query) {
		$this->query = $query;
		$mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
		//echo "Mysqli class has been created <br>";

		if ($mysqli->connect_errno) {
    		printf("Connect failed: %s\n", $mysqli->connect_error);
    		exit();
		}
		
		
		
		if ($result = $mysqli->query($query)) {
 
			//echo "Query: " . $query . "<br>Successfully executed.";
			
 			//echo "$sqlFile is about to be open<br>";
			$fh = fopen($this->sqlFile, 'a') ;
			//echo "SQL file $sqlFile has been opened <br>";
			fwrite($fh, $query . "\n\n");
			//echo $this->query . " has been written into the file " . $this->sqlFile . " <br>";
			fclose($fh);
			
			//echo "exiting method<br>";
			
			
	
		} else {
			//echo "Query: " . $query . "<br>Failed.";
			return FALSE;
		}
		
	
		$mysqli->close();		
		return TRUE;
	}
	
	function single($query) {
		
		//echo "This is the query - " . $query . "<br>";
		$this->query = $query;
		$mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);

		if ($mysqli->connect_errno) {
    		printf("Connect failed: %s\n", $mysqli->connect_error);
    		exit();
		}
		
		if ($result = $mysqli->query($query)) {
			//echo "Return Ture<br>";
			$mysqli->close();		
			return TRUE;	
		} else {

			//echo "Return False<br>";
			$mysqli->close();		
			return FALSE;
		}
	}	
	
	function select ($query)  {
		$this->query = $query;
		$mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
		echo "Mysqli class has been created <br>";

		if ($mysqli->connect_errno) {
    		printf("Connect failed: %s\n", $mysqli->connect_error);
    		exit();
		}		
		$mysqli->close();		
		echo "test 111";
		return TRUE;
		
	}
	
	
}




?>