<?php
/**
 * Admin panel.
 * Only visible to the admin users.
 * Contains only admin data, like view other users, 
 * add users, authorise users etc.
 * TODO: Substitute a table with List
 * 
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

	$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
	if (mysqli_connect_errno()) {
    	printf("Connect failed: %s\n", mysqli_connect_error());
    	exit();
	} $usersQ = "SELECT COUNT(*) AS UsersNum FROM Users WHERE Users.privileges='pending';";
	$result = $mysqli->query($usersQ);
	$obj = $result->fetch_object();
	$newUsers = $obj->UsersNum; 
	
	if ($newUsers > 0) {
		$linkUsers =  $Words[27] . " <span id='newUsers'>($newUsers $Words[28])</span><script type='text/javascript'>$('#adminLinksTable').show();</script> ";				  
	} else {
		$linkUsers =  $Words[27] . " <span id='noNewUsers'>($newUsers $Words[28])</span>";
	}
	$mysqli->close();
?>


<div id='idAdminLinks' class='classStatLink'><? echo $Words[40]; ?></div>

<div id='adminLinksTable' class='LinksTable'>
	<table class='linkTable'>
		<? echo "
		<tr class='StatTR2'><td class='singleTD'><a href='javascript:void(0)' onclick=\"javascript:openWin1('./app/appNewUsers.php?lang=$lang')\">$linkUsers </a></td></tr>
		";  ?>		

		<tr class='StatTR0'><td class='singleTD'><a href="javascript:void(0)" onclick="javascript:$('#mainBody').load('./body/bodyUsers.php?lang=<? echo $lang; ?>')"><? echo $Words[42] ?></a></td></tr>
		<tr class='StatTR1'><td class='singleTD'><a href='javascript:void(0)' onclick="javascript:$('#mainBody').load('./body/bodyLog.php?lang=<? echo $lang; ?>')"><? echo $Words[43]; ?></a></td></tr>		
		<tr class='StatTR1'><td class='singleTD'><a href='javascript:void(0)' onclick="javascript:$('#mainBody').load('./body/bodyResolts.php?lang=<? echo $lang; ?>')"><? echo "Voting Resolts"; ?></a></td></tr>
		<tr class='StatTR1'><td class='singleTD'><a href='javascript:void(0)' onclick="javascript:$('#mainBody').load('./body/bodyMaterialResolts.php?lang=<? echo $lang; ?>')"><? echo "Material Resolts"; ?></a></td></tr>				
		<? if ($userID == '741ebb6f') { echo "
		<tr class='StatTR0'><td class='singleTD'><a href='javascript:void(0)' onclick=\"javascript:openWin1('./app/addDictionary.php?lang=$lang')\">$Words[41] </a></td></tr>
		"; } ?>	
	</table>
</div>	

