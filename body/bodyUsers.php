<?php
session_start();    
/**
 * Widget for displaying users
 * Accessable by admin
 * TODO: implement ISSET methods
 */
$user = $_SESSION['user'];
$pass = $_SESSION['pass'];
$userID = $_SESSION['userID'];
$privileges = $_SESSION['privileges'];

$start = $_GET['a'];
$rows = $_GET['b'];



if (basename(getcwd()) == 'body') { 
	$lang = $_GET['lang'];

	if ($lang == 'english') 		{ $lang = 'english'; 	}
	elseif ($lang == 'ukrainian') 	{ $lang = 'ukrainian'; 	}
	else 							{ $lang = 'russian' ; 	} 

	include '../CONST.php';
	include '../dictionary.php';
	include '../classes/classSetup.php';

	echo "
		<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
		<script type='text/javascript' src='../scripts/jquery-1.9.0.min.js'></script>
		<link rel='stylesheet' href='../scripts/main.css' type='text/css' media='screen' charset='utf-8' />
		<script type='text/javascript' src='../scripts/comedy.js'></script> 	
	"; 
}

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$result = $mysqli->query("UPDATE `ComedyDB`.`Users` SET `time` = '" . time() .  "' WHERE `Users`.`uid` = '$userID' ;");	


$User_query = 	"SELECT Users.id, Users.uid, Users.name, Users.nick, Users.cell, Users.email, Users.privileges, Security.password
					FROM Users, Security
					WHERE Security.uid = Users.uid
					ORDER BY Users.id  
					";	

if ($userResult = $mysqli->query($User_query)) { 

    while ($obj = $userResult->fetch_object()) {
    	
  		$passwd = '';
    	for ($i=0; $i<strlen($obj->password); $i++) $passwd = $passwd . "*";	
           	 
		$idUserDiv = 'userDiv' . $obj->id;
 		echo "<a href='#' onclick=\"javascript:divClicked('#" . $idUserDiv . "')\" class='usersLinks'>$obj->id. $obj->name</a>     <Br>";     
 		echo "<div id='$idUserDiv' class='UsersClass'>";
		echo "<table>
			<tr class='StatTR2'><td class='editUsersLeft'>Login:</td><td class='editUsersRight'>$obj->name</td></tr>
			<tr class='StatTR0'><td class='editUsersLeft'>Display Name:</td><td  class='editUsersRight'>$obj->nick</td></tr>
			<tr class='StatTR1'><td class='editUsersLeft'>email:</td><td class='editUsersRight'>$obj->email</td></tr>
			<tr class='StatTR0'><td class='editUsersLeft'>Cell phone:</td><td class='editUsersRight'>$obj->cell</td></tr>
			<tr class='StatTR1'><td class='editUsersLeft'>Privileges:</td><td class='editUsersRight'>$obj->privileges</td></tr>
			<tr class='StatTR0'><td class='editUsersLeft'>Password:</td><td class='editUsersRight'>$passwd</td></tr>
			</table>
			";
		echo "</div>";
		
		
				
    } $userResult->close();
} 
$mysqli->close();






?> 
