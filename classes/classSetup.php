<?php
class classSetups {
	private $p_id;
	private $p_line;
	private $p_time;
	private $p_author;
	private $p_likes;



	function __construct ($id, $line, $author, $uid, $time) {
		$this->p_id= $id;
		$this->p_line = $line;
		$this->p_time = $time;
		$this->p_author= $author;
		$this->p_uid = $uid;
	}
	
	function show () {
		echo "<br>$this->p_id. ";
		echo "$this->p_line... <br>\n";
	}
	

	function setId($p_id) {
		$this->p_id = $p_id;
	}
	function getId() {
		return $this->p_id;
	}
	
	function setLine($p_line) {
		$this->p_line = $p_line;
	}
	function getLine() {
		return $this->p_line;
	}
	
	function setTime($p_time) {
		$this->p_time = $p_time;
	}
	function getTime() {
		return $this->p_time;
	}
	
	function setAuthor($p_author) {
		$this->p_author = $p_author;
	}
	function getAuthor() {
		return $this->p_author;
	}

	function setUid($p_uid) {
		$this->p_uid = $p_uid;
	}
	function getUid() {
		return $this->p_uid;
	} 
					
				
}
?>