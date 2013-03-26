<?php
session_start(); 
/**
 * Body widget for displaying a list of completed
 * show scenarios from 2004 until 2008
 * Allows users to user to check the specific show script
 */   
$user = $_SESSION['user'];
$pass = $_SESSION['pass'];
$userID = $_SESSION['userID'];
$privileges = $_SESSION['privileges'];


function tream($script){
	$repSigns = array(	'\'', 		'"', 		')',		'(',		',',		'$', 		"\n",		"%0D%0A");
	$subSigns = array(	'&#39;',	'&#34;',	'&#41;',	'&#40;', 	'&#44;',	'&#36;',	'<br>',		'<br>'	);
	
	return substr(stripslashes(str_replace($repSigns, $subSigns, $script)), 0, 300);
}


if ($user == NULL) {
	header( 'Location: index.php?flag=expire' ) ;
}

if (basename(getcwd()) == 'body') { 
	$lang = $_GET['lang'];

	if ($lang == 'english') 		{ $lang = 'english'; 	}
	elseif ($lang == 'ukrainian') 	{ $lang = 'ukrainian'; 	}
	else 							{ $lang = 'russian' ; 	} 

	include_once '../CONST.php';
	include_once '../dictionary.php';
	include_once '../classes/classSetup.php';
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

$query = "SELECT `Games`.`id`, `Games`.`game`, `Games`.`team`, `Games`.`date`, `Games`.`script` FROM `Games` ORDER BY `Games`.`id`;  ";
$num = 0; 

if ($result = $mysqli->query($query)) { 
    while ($obj = $result->fetch_object()) {
    	
		
		
    	$material[$num++] = array (	'id' => $obj->id,
    								'game' => $obj->game,
    								'team' => $obj->team,
    								'date' => $obj->date,
    								'script' => tream($obj->script));
	} $result->close();
} 
$mysqli->close();

?>
<script language="JavaScript">
	$('.classMat').mouseover(function () {
		$(this).css({'color':'maroon'});
	});
	$('.classMat').mouseout(function () {
		$(this).css({'color':'black'});
	});	
	
	$('.classMat').click(function () {
		var id = $(this).attr('id').replace(/[^0-9]/g, '');
		var URL = './body/bodyGame.php?id=' + $(this).attr('id').replace(/[^0-9]/g, '');
//		alert (URL);
		$('#mainBody').load(URL);
	});
</script>

	
<? for ($i=0; $i < $num; $i++) { ?>
<div class='wcBox'>
	<table class='tableWcBox'>
		<tr>
			<td colspan='2'><b><? echo $material[$i]['game']; ?></b></td>
		</tr>
		<tr>
			<td><? echo $material[$i]['team']; ?></td>
			<td><i><? echo $material[$i]['date']; ?></i></td>
		</tr>
		<tr>
			<td colspan='2' class='tdAr'>
				<div class='classMat' id='mat<? echo $material[$i]['id'] ;?>'>
					<? echo $material[$i]['script']; ?>...
				</div>
			</td>
		</tr>
	</table>	
</div>

<? } ?>

<br><br>











 