<?php
session_start();
/**
 * Setter to submit a punchline to a database.
 * Is called with an ajax method without getting displaid
 */
$userID = $_SESSION['userID'];

include_once '../CONST.php';

isset($_POST['uid']) ? $uid = $_POST['uid'] : $uid = $userID;
isset($_POST['pid']) ? $pid = $_POST['pid'] : die('Punchline number is not set up');
isset($_POST['line']) ? $line = $_POST['line'] : die('ERROR: Punchline has not been defined.');

 
$repSigns = array(	'\'', 		'"', 		')',		'(',		',',		'$');
$subSigns = array(	'&#39;',	'&#34;',	'&#41;',	'&#40;', 	'&#44;',	'&#36;');
$line = str_replace($repSigns, $subSigns, $line);

$time = date("Y-m-d H:i:s");



$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$result = $mysqli->query("UPDATE `ComedyDB`.`Users` SET `time` = '" . time() .  "' WHERE `Users`.`uid` = '$userID' ;");

$questionAnswer1 = "INSERT INTO `Punchline` (`sid`, `line`, `uid`, `timestamp`) VALUES ('$pid', '$line', '$uid', '$time');";
$questionAnswer2 = "INSERT INTO `ComedyDB`.`Log` (`uid`, `action`, `opt`, `ip`, `timestamp`) VALUES ('$uid', '72', '# $pid', '" . $_SERVER['REMOTE_ADDR'] . "', '" . date('Y-m-d H:i:s') . "');" ;

 
$result = $mysqli->query($questionAnswer1);
$result = $mysqli->query($questionAnswer2);



$result->close();
$mysqli->close();



?>


 