<?php
session_start();    
/**
 * Body Widget for displaying a log of all users actions
 */
$user = $_SESSION['user'];
$pass = $_SESSION['pass'];
$userID = $_SESSION['userID'];;


isset($_GET['lang']) ? $lang = $_GET['lang'] : $lang = 'russian';
isset($_GET['limit']) ? $limit = "" : $limit = "LIMIT 0 , 20";

if ($lang == 'english') 		{ $lang = 'english'; 	}
elseif ($lang == 'ukrainian') 	{ $lang = 'ukrainian'; 	}
else 							{ $lang = 'russian' ; 	} 

include_once '../CONST.php';
include_once '../dictionary.php';
include_once '../classes/classSetup.php';

if (basename(getcwd()) == 'body') { 
	echo "
		<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
		<script type='text/javascript' src='../scripts/jquery-1.9.0.min.js'></script>
		<link rel='stylesheet' href='../scripts/main.css' type='text/css' media='screen' charset='utf-8' />
		<script type='text/javascript' src='../scripts/comedy.js'></script> 	
	"; }
	

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$num = 0;

$logQuery = "
			SELECT  `Log`.`id`, `Users`.`nick`, `Dictionary`.`$lang` AS action, `Log`.`opt`,  `Log`.`ip`,  `Log`.`system`,  `Log`.`timestamp`
			FROM `Log`, `Users`, `Dictionary`
			WHERE `Log`.`action`=`Dictionary`.`wid` AND `Log`.`uid`=`Users`.`uid`
			ORDER BY  `Log`.`timestamp` DESC " . $limit . ";";

echo "<br><hr class='hrM'>\n";
//echo "<table><tr><td width=100><b>$Words[82]:</b></td><td><b>$Words[83]:</b></td></tr></table>\n";				
if ($result = $mysqli->query($logQuery)) { 

    while ($obj = $result->fetch_object()) {$num++;

 		echo "<div class='classLog".($num%2)."'><table class='tableLog'><tr><td width=100>" . date('D, M jS', strtotime($obj->timestamp)). "</td>";
 		echo "<td width = 400>$obj->nick $obj->action $obj->opt</td></td>";
 		echo "<tr><td>" . date('H:iA', strtotime($obj->timestamp)). "</td><td><font color=#C0C0C0>(IP: $obj->ip)</font></td>";
 		echo "</tr></table></div>\n";

 
    } $result->close();
}

echo "<center>
[ <a href='javascript:void(0)' onclick=\"javascript:$('#mainBody').load('./body/bodyLog.php?lang=$lang&limit=none')\">$Words[54]</a> ] 
<hr class='hrM'></center>";


echo " <br><br>";
/* close connection */
$mysqli->close();
				


?>