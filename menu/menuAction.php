<?php

/**
 * Action menu widget
 * Is used to call widgets to submit a data into the database
 * TODO: Substitute a table with List 
 */
if (basename(getcwd()) == 'menu') { 
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

?>


<div id='idActLinks' class='classStatLink'><? echo $Words[45]; ?></div>

<div id='ActLinksTable' class='ActNavLinksTable'>
	<table class='linkTable'>
		<tr class='StatTR2'><td class='singleTD'><a href="javascript:void(0)" id="idAddMaterial" uid='<? echo $userID;?>' lang='<? echo $lang;?>'><? echo $Words[47]; ?></a></td></tr>
		<tr class='StatTR0'><td class='singleTD'><a href="javascript:void(0)" id="idAddQuestion" uid='<? echo $userID;?>' lang='<? echo $lang;?>'><? echo $Words[48]; ?></a></td></tr>
		<tr class='StatTR1'><td class='singleTD'><a href="javascript:void(0)" onclick="javascript:$('#mainBody').load('./body/bodyMaterialVote.php?lang=<?= $lang; ?>')"><? echo $Words[49]; ?></a></td></tr>
        <tr class='StatTR1'><td class='singleTD'><a href='javascript:void(0)' onclick="javascript:$('#mainBody').load('./body/bodyMaterialResolts.php?lang=<? echo $lang; ?>')"><? echo "Material Resolts"; ?></a></td></tr>    	
		<tr class='StatTR0'><td class='singleTD'><a href="javascript:void(0)" onclick="javascript:$('#mainBody').load('./body/bodyBrainstormLikes.php?lang=<?= $lang; ?>')"><? echo $Words[46]; ?></a></td></tr>
	</table>
</div>	



 
