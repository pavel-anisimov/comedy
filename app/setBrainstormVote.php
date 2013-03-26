<?php
/**
 * Setter widget to submit a vote for a joke punchline
 * Is not displayed and is called from ajax method
 * TODO: implement ISSET method to undeclared variales
 * Due to similarity with setMaterialVote.php should be 
 * created as a class or abstract class
 * 
 */
 
$uid = $_POST['uid'];
$pid = $_POST['pid'];
$vote = $_POST['vote'];
 
 
if (basename(getcwd()) == 'app' OR basename(getcwd()) == 'body')
	include '../CONST.php';
else 
	include './CONST.php';


$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

//$result = $mysqli->query("UPDATE `ComedyDB`.`Users` SET `time` = '" . time() .  "' WHERE `Users`.`uid` = '$userID' ;");	

$msg = "INSERT INTO `ComedyDB`.`BrainstormVote` (`pid`, `vote`, `uid`, `timestamp`) VALUES ('$pid', '$vote', '$uid', '" . date('Y-m-d H:i:s') . "'); ";
echo $msg;
$result = $mysqli->query($msg);

$result->close();
$mysqli.close();

?>
 