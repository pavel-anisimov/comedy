<?php
session_start();    
/**
 * Widget for submiitting a new users.
 * Only admins can access this widget.
 * TODO: impelent isset function. 
 * TODO: Cleanup the code to separate html from php tags
 */
$user = $_SESSION['user'];
$userID = $_SESSION['userID'];
$pass = $_SESSION['pass'];


$regUid = $_GET['regUid'];
$regStatus = $_GET['regStatus'];


$lang = $_GET['lang'];



include '../classes/classPunchline.php'; 
include '../classes/classMySQL.php'; 
include '../classes/classMail.php'; 
include '../CONST.php'; 

$SendMail = new classMail($db_host, $db_user, $db_pass, $db_name);

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
   	exit();
} $result = $mysqli->query("UPDATE `ComedyDB`.`Users` SET `time` = '" . time() .  "' WHERE `Users`.`uid` = '$userID' ;");	
$mysqli->close();

echo "
	<html> <head>
	<script type='text/javascript' src='../scripts/jquery-1.9.0.min.js'></script>
	<link rel='stylesheet' href='../scripts/main.css' type='text/css' media='screen' charset='utf-8'/>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<link rel='stylesheet' href='../scriptsjquery-ui-1.9.2.custom.css' type='text/css' media='screen'' charset='utf-8'/>
	<script type='text/javascript' src='../scripts/comedy.js'></script> 	
	<script type='text/javascript' src='../scripts/jquery-ui-1.9.2.custom.min.js'></script> 
	
	</head></body class='blue'>
	";
	

if ($regStatus != NULL AND $regStatus != 'pending') {
	
	$mysqlQuery = new MysqlQuery($db_host, $db_user, $db_pass, $db_name);
	$updateQuery = "UPDATE `$db_name`.Users SET `Users`.`privileges`='$regStatus' WHERE `Users`.`uid`='$regUid';";
	//echo "$updateQuery <br>";
	$mysqlQuery->execute($updateQuery);
	
	$mysqlQuery->single("INSERT INTO `ComedyDB`.`Log` (`uid`, `action`,  `opt`, `ip`, `timestamp`) VALUES ('$regUid', '81', '$user' , '" . $_SERVER['REMOTE_ADDR'] . "', '" . date('Y-m-d H:i:s') . "'); ");  
	
	
	echo "<div class='boxQ'>Thank you. User $regUser has been activated as $regStatus</div><br>";
	
	
	//	function sendToSingle ($to, $from, $subject, $message);
	



	$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	} 

	$obj = $mysqli->query("SELECT Users.email, Security.password, Users.name FROM Users, Security WHERE Users.uid = Security.uid AND Users.uid = '$regUid' ;")->fetch_object();

	$emailMessage = "This is automatically generated message. DO NOT REPLY TO IT. \n\n";
	$emailMessage .= "Congratulations! You have been registered as a member of SF Comedy Club with the status of \"" . $regStatus . "\".\n";
	$emailMessage .= "Login: " . $obj->name . "\n";
	$emailMessage .= "Password: " . base64_decode($obj->password) . "\n";	
	$emailMessage .= "Website: http://comedy.pavel.ws \n\n"; 	
	$emailSubject = "SF Comedy Club‏ Registration" ;
	
	$SendMail->sendToSingle($obj->email, "SF Comedy Club <valentin.tsay@gmail.com>", $emailSubject, $emailMessage); 
	

	//$obj->close();
	$mysqli->close();
		
}
	$con = mysql_connect($db_host, $db_user, $db_pass);
	if (!$con) {
		die('Could not connect: ' . mysql_error());
	} 
	mysql_select_db($db_name);

	$result = mysql_query("
					SELECT Users.uid AS userID, Users.name AS login, Users.nick AS nickname, Users.email, Users.privileges, Security.password
					FROM Users, Security 
					WHERE Users.uid=Security.uid AND Users.privileges='pending';");
	
	$a = 0;
	
	

while($requests = mysql_fetch_object($result)){
	//$threatsArray[] = $threats;
	$a++;

	
	echo "
		<div class='boxQ'>
			<form method='get' action='appNewUsers.php?lang=$lang'>
				<table>
					<tr><td align=right>Login:</td><td>$requests->login</td></tr>
					<tr><td align=right>Display Name:</td><td>$requests->nickname</td></tr>  
					<tr><td align=right>eMail:</td><td>$requests->email</td></tr>		
					<tr><td align=right>Status:</td><td>
						<select name='regStatus'>
 							<option value='admin'>admin</option>
							<option value='author'>author</option>
							<option value='member' selected='selected'>member</option>
						</select><input type=submit value='Aprove!'>
						<input type='hidden' name='regUid' value='$requests->userID'>  	
					</td></tr>
				</table>
			</form>
		</div><br>
	";		

}
		
	mysql_close($con); 


?>
</body></html>









