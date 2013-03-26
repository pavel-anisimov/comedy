<?php

class classMail {
	
	private $db_host; 
	private $db_user;
	private $db_pass; 
	private $db_name;
	private $fromMail;
	private $toMail;
	private $head;
	private $message;
	private $subject;
	
	function __construct ($db_host, $db_user, $db_pass, $db_name) {
		$this->db_host = $db_host;
		$this->db_user= $db_user;
		$this->db_pass = $db_pass; 
		$this->db_name = $db_name;
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




	function sendToAdmin ($from, $subject, $message) {
		$this->fromMail = $from;
		$this->toMail = '';
		$this->subject = $subject;
		$this->message = $message;
		$this->head = "From: " . $from;
		
		
		
		$adminSql = "
					SELECT `Users`.`email`
		    		FROM `Users`
		    		WHERE `Users`.`privileges` = 'admin' ";
		
//		echo "$adminSql <br>";
		$mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);	
		if ($result = $mysqli->query($adminSql)) {

			$obj = $result->fetch_object();
    		$this->toMail = $obj->email; 	 
    		while ($obj = $result->fetch_object()) { 
 				$this->toMail .= "," . $obj->email;
			} $result->close();
		} $mysqli->close();
//		echo "FROM: ". $this->fromMail . "<br> TO: " . $this->toMail . "<br>SUBJECT: " . $this->subject . "<br>MESSAGE: " . $this->message . "<br>";
		mail($this->toMail, $this->subject, $this->message, $this->head);

	}
	
	
	
	
	
	
	
	
	
	
	
	
	function sendToAll ($from, $subject, $message) {
		$this->fromMail = $from;
		$this->toMail = $to;
		$this->subject = $subject;
		$this->message = $message;
		$this->head = "From: " . $from;
		
		$toAllSql = "SELECT `Users`.`email`\n"
		    . "FROM `Users`\n" ;
			
			
		$mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);	
		if ($result = $mysqli->query($toAllSql)) {

			$obj = $result->fetch_object();
    		$this->toMail = $email; 	 
    		while ($obj = $result->fetch_object()) { 
 				$this->toMail .= "," . $email;
			} $result->close();
		} $mysqli->close();
		//echo "FROM: ". $this->fromMail . "<br> TO: " . $this->toMail . "<br>SUBJECT: " . $this->subject. "<br>MESSAGE: " . $this->message . "<br>";
		mail($this->toMail, $this->subject, $this->message, $this->fromMail);	
		
	}

	
	
	
	function sendToSingle ($to, $from, $subject, $message) {
		
		
		$this->fromMail = $from;
		$this->toMail = $to;
		$this->subject = $subject;
		$this->message = $message;
		$this->head = "From: " . $from;
		
		//echo "FROM: ". $this->fromMail . "<br> TO: " . $this->toMail . "<br>SUBJECT: " . $this->subject . "<br>MESSAGE: " . $this->message . "<br>";
		mail($this->toMail, $this->subject, $this->message, $this->head);
		
		
	}	
	
}



//$to = "anisimov@hotmail.com, 'pavel.n.anisimov@gmail.com, ");

//mail($to, "test", "This is the test of sendint messages to multiple users <Br> line 2 \n line 3", "From: p.anisimoc@comcast.net");

?>