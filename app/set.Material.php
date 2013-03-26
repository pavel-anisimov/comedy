<?php
session_start();
/**
 * Method for setting material (joke, song, sketch etc)
 * and adding it to a database
 * Is called from Ajax method and is not displayed
 */
$userID = $_SESSION['userID'];

include_once '../CONST.php';

 

isset($_POST['uid']) ? $uid = $_POST['uid'] : $uid = $userID;
isset($_POST['type']) ? $type = $_POST['type'] : die('ERROR: Material type has not been defined');
isset($_POST['linematerial']) ? $linematerial = $_POST['linematerial'] : die('ERROR: Punchline has not been defined.');
isset($_POST['voteMaterial']) ? $vote = TRUE : $vote = FALSE;

echo $vote . "<BR>";
 
$repSigns = array(	'\'', 		'"', 		')',		'(',		',',		'$');
$subSigns = array(	'&#39;',	'&#34;',	'&#41;',	'&#40;', 	'&#44;',	'&#36;');
$linematerial = str_replace($repSigns, $subSigns, $linematerial);

$time = date("Y-m-d H:i:s");

switch ($type) {
	case 'joke':	$act = 76;	break;
	case 'song':	$act = 78;	break;
	case 'idea':	$act = 79;	break;
	case 'sketch':	$act = 77;	break;
	case 'black':	$act = 80;	break;
	default: 	$type = 'joke'; 
				$act = 76;		break;
}


$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$updateTime = "UPDATE `Users` SET `time` = '" . time() .  "' WHERE `Users`.`uid` = '$uid' ;";

$vote == TRUE ? $vote == 1 : $vote == 0 ;
				
$questionAnswer1 = "INSERT INTO `Archive` (`text`, `type`, `vote`, `uid`, `mainAuthor`, `timestamp`) VALUES ('$linematerial', '$type', '$vote', '$uid', 'none', '$time')"  ;
$questionAnswer2 = "INSERT INTO `ComedyDB`.`Log` (`uid`, `action`, `ip`, `timestamp`) VALUES ('$uid', '$act', '" . $_SERVER['REMOTE_ADDR'] . "', '" . date('Y-m-d H:i:s') . "');" ;


$result = $mysqli->query($updateTime);
$result = $mysqli->query($questionAnswer1);
$result = $mysqli->query($questionAnswer2);


$mysqli->close();

?>


 