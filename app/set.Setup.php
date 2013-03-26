<?php
session_start();
/**
 * widget for setting a joke setup
 * is called form AJAX method and is not displayed
 * 
 */
$user = $_SESSION['user'];
$userID = $_SESSION['userID'];
$pass = $_SESSION['pass'];

include_once '../CONST.php';
include_once '../dictionary.php';
include_once '../classes/classMySQL.php';

isset($_GET['lang']) ? $lang = $_GET['lang'] : $lang = 'russian';
isset($_POST['uid']) ? $uid = $_POST['uid'] : $uid = $userID; 
isset($_POST['line']) ? $line = $_POST['line'] : $line = NULL;

$time = date("Y-m-d H:i:s");

$repSigns = array(	'\'', 		'"', 		')',		'(',		',',		'$');
$subSigns = array(	'&#39;',	'&#34;',	'&#41;',	'&#40;', 	'&#44;',	'&#36;');
$line = str_replace($repSigns, $subSigns, $line); 


$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
   	exit();
} 

 
$num = $mysqli->query('SELECT COUNT(*) AS Num FROM `Brainstorm` WHERE sid != 0;')->fetch_object()->Num + 1;


$updateTime = "UPDATE `ComedyDB`.`Users` SET `time` = '" . time() .  "' WHERE `Users`.`uid` = '$userID' ;";
$questionQuery1 = "INSERT INTO `Setup` (`line`, `uid`, `timestamp`) VALUES ('$line', '$uid', '$time');";
$questionQuery2 = "INSERT INTO `ComedyDB`.`Log` (`uid`, `action`, `ip`, `timestamp`) VALUES ('$uid', '71', '" . $_SERVER['REMOTE_ADDR'] . "', '" . date('Y-m-d H:i:s') . "');" ;


$result = $mysqli->query($updateTime);
$result = $mysqli->query($questionQuery1);
$result = $mysqli->query($questionQuery2);


$mysqli->close();


?>


 