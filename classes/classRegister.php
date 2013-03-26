<?php
class register {
	private $regUid;
	private $regEmail;
	private $regPass1;
	private $regPass2;
	private $regName;
	private $regNick;
	private $regPriv;	
	private $regTime;	
	private $okay;
	private $regFlag;
	private $errorMessage;
	
	function __construct ($regEmail, $regPass1, $regPass2, $regName, $regNick, $regPriv, $flag) {
		$digit = (date(U) % date (Y));	
		$toHash = $regName . $digit .  $regEmail;
		$this->regUid = hash(crc32b, $toHash);
		$this->regEmail = $regEmail;
		$this->regPass1 = $regPass1;
		$this->regPass2 = $regPass2;
		$this->regName = $regName;
		$this->regNick = $regNick;
		$this->regPriv = 'pending';
		$this->regTime = date ("Y-m-d H:i:s");
		$this->regFlag = $flag;
		$this->isOkey();
	}
	
	function getErrorMessage () {	return $this->errorMessage;	} 
	function getEmail () 		{	return $this->regEmail;		} 
	function getName () 		{	return $this->regName;		} 
	function getNick () 		{	return $this->regNick;		} 
	function getPass1 () 		{	return $this->regPass1;		} 
	function getPass2 () 		{	return $this->regPass2;		} 	
	function getUid () 			{	return $this->regUid;		} 		
	function getFlag () 		{	return $this->regFlag;		} 	
	function getOkay () 		{	return $this->okay;			} 
					
				
				
	function isOkey(){
		$err = FALSE;
		
		if (strlen($this->regUid) != 8) { 
			$err = TRUE;
			$this->errorMessage = " Script error #4. Please inform web administrator<br>";
		}
		if (strpbrk($this->regEmail,"@.") == false) { 
			$err = TRUE;
			$this->errorMessage .= " Your email is incorrect.<br>";
		}	
		if (strlen($this->regEmail) < 10) { 
			$err = TRUE;
			$this->errorMessage .= " Your email is suspeciously short.<br>";
		}				
		if (strlen($this->regName) < 4) { 
			$err = TRUE;
			$this->errorMessage .= " Your login should be at least 4 characters long.<br>";
		}
		if (strlen($this->regPass1) != strlen($this->regPass2)) { 
			$err = TRUE;
			$this->errorMessage .= " Your password doesn't match.<br>";
		}	
		if (strlen($this->regPass1) < 6 OR strlen($this->regPass2) < 6) { 
			$err = TRUE;
			$this->errorMessage .= " Your password should be at least 6 characters long.<br>";
		}		
		if ( $this->regPass1 != $this->regPass2) { 
			$err = TRUE;
			$this->errorMessage .= " Your password doesn't match.<br>";
		}	
		if (strlen($this->regNick) < 4) { 
			$err = TRUE;
			$this->errorMessage .= " Your nickname should be at least 4 characters long.<br>";
		}	
	
		
		if ($this->regPriv != "pending") { 
			$err = TRUE;
			$this->errorMessage .= " Script error #5. Please inform web administrator.<br>";
		}
		if ($err == FALSE) {
			$this->okay = TRUE;
		}
		else 
			$this->okay = FALSE;
	}
	function userQuery(){
		return "INSERT INTO `ComedyDB`.`Users` (`uid`, `name`, `nick`, `email`, `timestamp`) VALUES ('$this->regUid', '$this->regName', '$this->regNick', '$this->regEmail', '$this->regTime');";
	}
	
	function securityQuery() {
		$encriptedPass =  base64_encode($this->regPass1);
		return "INSERT INTO `ComedyDB`.`Security` (`uid`, `password`, `timestamp`) VALUES ('$this->regUid', '$encriptedPass', '$this->regTime');";
	}
}
?>