<?php
session_start();    

/**
 * Widget for displaying who is online at current moment
 * Checks users activities for last 10 minutes
 * TODO: Replace table tags with list
 */
$userID = $_SESSION['userID'];
isset($_GET['lang']) ? 	$lang = $_GET['lang'] : $lang = 'russian';

if (basename(getcwd()) == 'menu') {
	

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
	
	$usersOnline = "SELECT `Users`.`uid` , `Users`.`nick` , `Users`.`time` AS timeout
					FROM `Users`
					WHERE `Users`.`time` > " . (time() - 600) . "
					ORDER BY `Users`.`time` DESC;";
		 
$count = 0 ;
echo "<table class='onlineTable'><tr><th class='statsTH'>$Words[66]</th><th  class='statsTH' id='statTH'>$Words[67]</th></tr>";
if ($result = $mysqli->query($usersOnline)) { 

    while ($obj = $result->fetch_object()) { $count ++;
   		echo "<tr class='StatTR" . ($count % 2). "'>";
        echo "<td class='onlineTDLeft'>$obj->nick</td>"; 
		
		if ( (int) ((time() - $obj->timeout) / 60) < 1 )
			$minsAgo = $Words[68] ;
		else $minsAgo = (int) ((time() - $obj->timeout) / 60) . " mins ago";
		
        echo "<td class='onlineTDRight' >" . $minsAgo . "</td>"; 
   		echo "</tr>";
    } $result->close(); 
} 

echo "</table>";		
		

?>

