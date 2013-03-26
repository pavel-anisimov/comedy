<?php
session_start();    
/**
 * Body widget for displaying a signle show
 * scenario selected by the user
 */   
 
$user = $_SESSION['user'];
$pass = $_SESSION['pass'];
$userID = $_SESSION['userID'];
$privileges = $_SESSION['privileges'];


isset($_GET['id']) ? $id = $_GET['id'] : die ('ERROR: Material ID is not set');

function tream($script){
	$repSigns = array(	'\'', 		'"', 		')',		'(',		',',		'$', 		"\n",		"%0D%0A");
	$subSigns = array(	'&#39;',	'&#34;',	'&#41;',	'&#40;', 	'&#44;',	'&#36;',	'<br>',		'<br>'	);
	return stripslashes(str_replace($repSigns, $subSigns, $script));
}


if ($user == NULL) {
	header( 'Location: index.php?flag=expire' ) ;
}

if (basename(getcwd()) == 'body') { 
	isset($_GET['lang']) ? $lang = $_GET['lang'] : $lang = 'russian';

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

$material = array();

$mysqli =  new mysqli($db_host, $db_user, $db_pass, $db_name);
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}

$query = "SELECT `id`, `game`, `team`, `date`, `script`, `uid`, `timestamp` FROM `Games` WHERE `id`='$id';  ";


if ($result = $mysqli->query($query)) { 
    while ($obj = $result->fetch_object()) {
    	
		
		
    	$material = array (	'id' => $obj->id,
    								'game' => $obj->game,
    								'team' => $obj->team,
    								'date' => $obj->date,
    								'script' => tream($obj->script),
    								'timestamp' => $obj->timestamp );
	} $result->close();
} 
$mysqli->close();

?>


	<table class='tableWcBox'>
		<tr>
			<td colspan='2'><b><? echo $material['game']; ?></b></td>
		</tr>
		<tr>
			<td><? echo $material['team']; ?></td>
			<td><i><? echo $material['date']; ?></i></td>
		</tr>
		<tr>
			<td colspan='2' class='tdAr'><br><? echo $material['script']; ?>...</td>
		</tr>
	</table>	

<br><br>











 