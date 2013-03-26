<?php

class classPunchline {
	private $p_id;
	private $p_pid;
	private $p_sid;
	private $p_line;
	private $p_uid;
	private $P_nick;
	private $p_time;

/*
	function __construct (){
		$this->d_id= NULL;
		$this->p_id= NULL;		
		$this->d_line = "NULL";
		$this->d_time = NULL;
		$this->d_author= NULL;
		$this->d_likes = NULL;   $f++, $q_pid, $q_sid, $q_line, $q_uid, $q_nick, $q_time
	}  */
	
	function __construct ($id, $pid, $sid, $line, $uid, $nick, $time) {

		$this->p_id= $id;
		$this->p_pid= $pid;		
		$this->p_sid= $pid;		
		$this->p_line = $line;
		$this->p_uid = $uid;		
		$this->p_time = $time;
		$this->p_nick= $nick;


	}
	
	function show () {
		echo "<dd>" . $this->p_id . ". ";	
		echo $this->p_line . " ";
		echo "<i>(" . $this->p_nick . ")</i>\n";
	} 
	
	
	function setId($d_id) {
		$this->d_id = $d_id;
	}
	function getId() {
		return $this->d_id;
	}
	function setUid($d_uid) {
		$this->d_uid = $d_uid;
	}
	function getUid() {
		return $this->d_uid;
	}
		
	
	function setLine($d_line) {
		$this->d_line = $d_line;
	}
	function getLine() {
		return $this->d_line;
	}
	
	function setTime($d_time) {
		$this->d_time = $d_time;
	}
	function getTime() {
		return $this->d_time;
	}
	
	function setNick($d_nick) {
		$this->d_nick = $d_nick;
	}
	function getNick() {
		return $this->d_nick;
	}

	function setSid($d_sid) {
		$this->d_sid = $d_sid;
	}
	function getSid() {
		return $this->d_sid;
	} 
					
				
}

?>