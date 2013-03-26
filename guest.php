<?php
session_start();    

/**
 * Mock file, sort of backdoor access to a webpage.
 * Used to access a development environment page.
 * Should neve be deployed.
 */
 
include_once './CONST.php';
$user = 'guest';
$pass = 'qwerty';
$lang = 'english';

	//////////////////////////// DATA BASE OPERATIONS START //////////////////////////////////
	$mysqli =  new mysqli($db_host, $db_user, $db_pass, $db_name);
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
    	exit();
	}
		
	$obj = $mysqli->query("SELECT Security.uid, Security.password, Users.privileges FROM Security, Users WHERE Security.uid=Users.uid AND Users.name='$user';")->fetch_object();
	$userID = $obj->uid;  
	$password = $obj->password;
	$privileges = $obj->privileges;
		

 
		
	//////////////////////////// DATA BASE OPERATIONS END ////////////////////////////////////
			
 
			//create cookies

		$_SESSION['pass'] = $pass;
		$_SESSION['userID'] = $userID;	
		$_SESSION['user'] = $user;
		$_SESSION['privileges'] = $privileges;
		$_SESSION['timeout'] = time();
		
						
 		// Updating a login time
		$result = $mysqli->query("UPDATE `ComedyDB`.`Users` SET `time` = '" . time() .  "' WHERE `Users`.`uid` = '$userID' ;");
 		
		// creating a log record with user's IP and user's browser type
 		$result = $mysqli->query("INSERT INTO `ComedyDB`.`Log` (`uid`, `action`, `ip`, `system`, `timestamp`) " 
 						. "VALUES ('$userID', '70', '" . $_SERVER['REMOTE_ADDR'] . "', '" . $_SERVER['HTTP_USER_AGENT'] 
 						. "', '" . date('Y-m-d H:i:s') . "'); ");

		echo  "<script language='Javascript'>" 
			. "window.location = 'mainPage.php?lang=" . $lang . "';"
			. "</script>";
							
?>