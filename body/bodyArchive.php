<?php
session_start();    
/**
 * 
 * Body Widget for displaying jokes archive
 * 
 */
 
$user = $_SESSION['user'];
$pass = $_SESSION['pass'];
$userID = $_SESSION['userID'];;


isset($_GET['lang']) ? $lang = $_GET['lang'] : $lang = 'russian';
isset($_GET['type']) ? $type = $_GET['type'] : die ('ERROR: Type of the materian has not been defined');
isset($_GET['period']) ? $period = $_GET['period'] : die ('ERROR: Time period has not been defined');
 

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
	 

//////////////////////////// DATA BASE OPERATIONS START //////////////////////////////////  

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
   	exit();
} $result = $mysqli->query("UPDATE `ComedyDB`.`Users` SET `time` = '" . time() .  "' WHERE `Users`.`uid` = '$userID' ;");	
$mysqli->close();


$con = mysql_connect($db_host, $db_user, $db_pass);




if (!$con) {
	die('Could not connect: ' . mysql_error());
} 
mysql_select_db($db_name);

//echo $userID ."<br>";
$User_query = "SELECT Users.uid, Users.name, Users.nick, Users.privileges FROM Users WHERE uid=$userID;";


//$User_result = mysql_query($User_query);
//list($userId, $userName, $userNick, $userPriveleges) = mysql_fetch_row($User_result);

 

echo "<br><hr class='hrM'><center>
[ <a href='javascript:void(0)' onclick=\"javascript:$('#mainBody').load('./body/bodyArchive.php?lang=$lang&type=$type&period=week')\">$Words[59]</a> ] 
[ <a href='javascript:void(0)' onclick=\"javascript:$('#mainBody').load('./body/bodyArchive.php?lang=$lang&type=$type&period=month')\">$Words[60]</a> ] 
[ <a href='javascript:void(0)' onclick=\"javascript:$('#mainBody').load('./body/bodyArchive.php?lang=$lang&type=$type&period=year')\">$Words[61]</a> ] 
[ <a href='javascript:void(0)' onclick=\"javascript:$('#mainBody').load('./body/bodyArchive.php?lang=$lang&type=$type')\">$Words[54]</a> ] 
<hr class='hrM'></center>";


switch ($period) {
    case "week":
        $dateString = "AND `Archive`.`timestamp` > '" . date('Y-m-d H:i:s', strtotime('-1 week')) . "'";
        break;
    case "month":
        $dateString = "AND `Archive`.`timestamp` > '" . date('Y-m-d H:i:s', strtotime('-1 month')) . "'";
        break;
    case "year":
        $dateString = "AND `Archive`.`timestamp` > '" . date('Y-m-d H:i:s', strtotime('-6 months')) . "'";
        break;
	default: 
		$dateString = "";
}


list($SetupsNumber) = mysql_fetch_row(mysql_query('SELECT COUNT(*) FROM Setup;'));

$archiveQuery = 	"
				SELECT `Archive`.`text`, `Archive`.`type`, `Users`.`nick`, `Archive`.`mainAuthor` ,`Archive`.`timestamp` 
				FROM `ComedyDB`.`Archive`, `ComedyDB`.`Users`
				WHERE `Users`.`uid`=`Archive`.`uid` AND `Archive`.`type`='$type' " . $dateString . " 
				ORDER BY `Archive`.`timestamp` DESC;
			";
 
		
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$num = 0;
if ($result = $mysqli->query($archiveQuery)) { 

    while ($obj = $result->fetch_object()) {$num++;

		switch ($obj->type) {
		    case 'joke':
		        $typeOut = $Words[1];
		        break;
		    case 'sketch':
		        $typeOut = $Words[3];
		        break;
		    case 'idea':
		        $typeOut = $Words[5];
		        break;
		    case 'song':
		        $typeOut = $Words[7];
		        break;		
		    case 'black':
		        $typeOut = $Words[35];
		        break;
		}


		if ($obj->mainAuthor != 'none')  $mainAuthor = " ($Words[64] $obj->mainAuthor)";	
		else $mainAuthor= "";
   
   		echo "<div id='BoxM$num' class='boxM'>";
        echo "<b>$typeOut #$num. </b><br>" . newLine($obj->text); 
        echo "<div class=AuthorM>$Words[62]: " . $obj->nick . " " . $mainAuthor . " $Words[63]: <i>" . date ('Y-m-d' , strtotime ($obj->timestamp))  . "</i> </div>"; 
		echo "</div>";
    } $result->close();
}

/* close connection */
$mysqli->close();
				
 


mysql_close($con);  
	
echo "<br><br>"


?>
