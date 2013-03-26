<?php
/**
 * widget for adding a full scenarios into the database 
 * 
 */
include '../CONST.php';
include '../classes/classMySQL.php';

// substitute speial carracters with HTML codes
function tream($script){
	$repSigns = array(	'\'', 		'"', 		')',		'(',		',',		'$', 	);
	$subSigns = array(	'&#39;',	'&#34;',	'&#41;',	'&#40;', 	'&#44;',	'&#36;',	);
	return stripslashes(str_replace($repSigns, $subSigns, $script));
}


 
$flag = $_POST['flag'];
$uid = '741ebb6f';
$timestamp = date("Y-m-d H:i:s"); 
$team = tream($_POST['team']);
$game = tream($_POST['game']);
$date = $_POST['date'];
$script = tream($_POST['script']);


$mysqli =  new mysqli($db_host, $db_user, $db_pass, $db_name);
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}

$query = "INSERT INTO `$db_name`.`Games` (`game`, `team`, `date`, `script`, `uid`, `timestamp`) VALUES ('$game', '$team', '$date', '$script', '$uid', '$timestamp');";
 
 
if ($flag == 'yes') {
//	$mysqlQuery->execute($archiveQuery);  
 
echo "<center>$game, $team <br>	$date</center>
<pre>$script</pre>";

$result = $mysqli->query($query);
//$mysqlQuery->single("INSERT INTO `ComedyDB`.`Log` (`uid`, `action`, `ip`, `timestamp`) VALUES ('$userID', '$opt', '" . $_SERVER['REMOTE_ADDR'] . "', '" . date('Y-m-d H:i:s') . "'); ");  
			
 	echo "thank you!!!";
	//$text = "";
}	
$mysqli->close();

?>

<html> 
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<script type="text/javascript" src="../scripts/jquery-1.9.0.min.js"></script>
		<link rel="stylesheet" href="../scripts/main.css" type="text/css" media="screen" charset="utf-8" />
		<script type='text/javascript' src="../scripts/comedy.js"></script> 	
	</head>

	<body  class='blue'>
		<div class='boxAddM'>
			<form id='addQuestion' action='./addGame.php' method='post'>
			 		<fieldset id='addMaterial'>  <legend align=right>Add Material</legend>
					<input type='hidden' name='flag' value='yes'>
					GAME: <input type='text' name='game' value='<?=$game?>'><br>
					TEAM: <input type='text' name='team' value='<?=$team?>'><br>
					DATE: <input type='text' name='date' value='<?=$date?>'><br>	
			 		SCRIPT:<br>
			 		<textarea name='script' rows=40 cols=100><?=$script?></textarea>	
					<input type='hidden' name='uid' value='<?=$uid?>'>
					<input type='submit' value='OK'>
					</fieldset>
			</form>
		</div>
	</body>
</html>

 