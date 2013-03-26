<?php
/**
 * Navigation menu widget
 * Is used to call mainbody methods to be displayed in the mainbody div
 * Used to display jokes, songes, sketches etc archives
 * TODO: Substitute a table with List 
 */
 
if (basename(getcwd()) == 'menu') { 
	$lang = $_GET['lang'];

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
//$_SESSION['url']
$urlJoke = "./body/bodyArchive.php?lang=$lang&type=joke&period=month";
$urlSketch = "./body/bodyArchive.php?lang=$lang&type=sketch&period=month";
$urlSong = "./body/bodyArchive.php?lang=$lang&type=song&period=month";
$urlIdea = "./body/bodyArchive.php?lang=$lang&type=idea&period=month";
$urlBlack = "./body/bodyArchive.php?lang=$lang&type=black&period=month";
$urlBrainstorm = "./body/bodyBrainstorm.php?lang=$lang";

?>


<div id='idNavLinks' class='classStatLink'><? echo $Words[44]; ?></div>

<div id='NavLinksTable' class='NavLinksTable'>
	<table class='linkTable'>
		<tr class='StatTR2'><td class='singleTD'><a href="javascript:void(0)" onclick="javascript:$('#mainBody').load('./body/bodyArchive.php?lang=<? echo $lang; ?>&type=joke&period=month')"><? echo $Words[2]; ?></a></td></tr>
		<tr class='StatTR0'><td class='singleTD'><a href="javascript:void(0)" onclick="javascript:$('#mainBody').load('./body/bodyArchive.php?lang=<? echo $lang; ?>&type=sketch&period=month')"><? echo $Words[4]; ?></a></td></tr>
		<tr class='StatTR1'><td class='singleTD'><a href="javascript:void(0)" onclick="javascript:$('#mainBody').load('./body/bodyArchive.php?lang=<? echo $lang; ?>&type=song&period=month')"><? echo $Words[33] ?></a></td></tr>
		<tr class='StatTR0'><td class='singleTD'><a href="javascript:void(0)" onclick="javascript:$('#mainBody').load('./body/bodyArchive.php?lang=<? echo $lang; ?>&type=idea&period=month')"><? echo $Words[6] ?></a></td></tr>
		<tr class='StatTR1'><td class='singleTD'><a href="javascript:void(0)" onclick="javascript:$('#mainBody').load('./body/bodyArchive.php?lang=<? echo $lang; ?>&type=black&period=month')"><? echo $Words[34] ?></a></td></tr>									
		<tr class='StatTR1'><td class='singleTD'><a href="javascript:void(0)" onclick="javascript:$('#mainBody').load('./body/bodyGames.php?lang=<? echo $lang; ?>')">WC KVN Archive</a></td></tr>	
		<tr class='StatTR0'><td class='singleTD'><a href="javascript:void(0)" onclick="javascript:$('#mainBody').load('./body/bodyBrainstorm.php?lang=<? echo $lang; ?>')"><? echo $Words[16]; ?></a></td></tr>
	</table>
</div>	


