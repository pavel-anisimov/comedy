<?php
/**
 * Widget for outputting joke punchlines for selected joke setup
 */

isset($_GET['lang']) ? $lang = $_GET['lang'] : $lang = 'russian';
isset($_GET['p']) ? $podacha = $_GET['p'] : die('Setup is not defined');
isset($_GET['u']) ? $userID = $_GET['u'] : die('Username is not defined');

include_once '../CONST.php'; 
include_once '../classes/classMySQL.php';

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$result = $mysqli->query("UPDATE `ComedyDB`.`Users` SET `time` = '" . time() .  "' WHERE `Users`.`uid` = '$userID' ;");	

 
$PunchQuery = "	SELECT Punchline.id, Punchline.sid, Punchline.line, Punchline.uid, Users.nick
				FROM Setup, Punchline, Users
				WHERE Punchline.uid = Users.uid AND Punchline.sid = $podacha AND Punchline.sid = Setup.id;
				"; 
 
$num = 'a';
if ($result = $mysqli->query($PunchQuery)) { 

    while ($obj = $result->fetch_object()) { 
		
 		echo "<div id='ans" . $obj->id  . "' class='punchline'>";

		echo $num . ". " . $obj->line;
		// . " <i>(". $obj->nick . ")</i>";
		//$line = $Dobivki[$numPunch]->getLine();
		
		//if ($user == $Punchlines[$numPunch]->getUid()) {
		//	$hrefEdit = "javascript:$('#ans$d_id').load('appEdit.php?did=$d_id')";
			

		//	echo "[<a href=# onclick=\"$hrefEdit\">edit</a>]";
		//} 
		echo "</div>";
		$num++;
		
    } $result->close();
} else echo "No punchlines has been submited yet" ;

$mysqli->close();

?>