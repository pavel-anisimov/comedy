<?php
session_start();    
/**
 * Menu Log Widget 
 * Is not implementing anything and is not displayed. As of today obsoleete
 */
$user = $_SESSION['user'];
$pass = $_SESSION['pass'];
$userID = $_SESSION['userID'];;

$start = $_GET['a'];
$rows = $_GET['b'];

$lang = $_GET['lang'];  

 



if ($lang == 'english') 		{ $lang = 'english'; 	}
elseif ($lang == 'ukrainian') 	{ $lang = 'ukrainian'; 	}
else 							{ $lang = 'russian' ; 	} 

include '../CONST.php';
include '../dictionary.php';
include '../classes/classSetup.php';

if (basename(getcwd()) == 'menu') { 
echo "
		<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
		<script type='text/javascript' src='../scripts/jquery-1.9.0.min.js'></script>
		<link rel='stylesheet' href='../scripts/main.css' type='text/css' media='screen' charset='utf-8' />
		<script type='text/javascript' src='../scripts/comedy.js'></script> 	
"; }
	
	
	

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$num = 0;

$logQuery = "
			SELECT  `Log`.`id`, `Users`.`nick`, `Dictionary`.`$lang` AS action, `Log`.`opt`,  `Log`.`ip`,  `Log`.`system`,  `Log`.`timestamp`
			FROM `Log`, `Users`, `Dictionary`
			WHERE `Log`.`action`=`Dictionary`.`wid` AND `Log`.`uid`=`Users`.`uid`
			ORDER BY  `Log`.`timestamp` DESC LIMIT 0 , 5;";

echo "<br>$Words[83]\n";
if ($result = $mysqli->query($logQuery)) { 

    while ($obj = $result->fetch_object()) {$num++;
		
		$logMsg = date('H:i', strtotime($obj->timestamp)) . " - $obj->nick $obj->action $obj->opt";
		
		if (strlen($logMsg) > 31) {
			if ($lang == 'english')
				$logMsg = substr($logMsg, 0, 30) . "…";
			else
				$logMsg = substr($logMsg, 0, 66) . "…";
		}
 		echo "<div class='menuLog'>" . $logMsg . "</div>\n";

 
    } $result->close();
}

 
$mysqli->close();
				
 
?>