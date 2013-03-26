<?php
/**
 * Widget for getting brainstorm votes
 * Is called from Body and displayed in a body
 */

$uid = $_GET['uid'];
$pid = $_GET['pid'];
 
 

if ($lang == 'english') 		{ $lang = 'english'; 	}
elseif ($lang == 'ukrainian') 	{ $lang = 'ukrainian'; 	}
else 							{ $lang = 'russian' ; 	} 

if (basename(getcwd()) == 'app' OR basename(getcwd()) == 'body')
	include '../CONST.php';
else 
	include './CONST.php';


$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

 

$getQ = "SELECT COUNT(*) AS `votes`, SUM(`BrainstormVote`.`vote`) AS `sum`, AVG(`BrainstormVote`.`vote`) AS `average` FROM `ComedyDB`.`BrainstormVote` WHERE `BrainstormVote`.`pid`='$pid' ;";
 
$voteStat = $mysqli->query($getQ)->fetch_object();
	
	$val = (($voteStat->average) - 1) / 0.04  ;
	if ($voteStat->average >= 4)
		$color = '88cbb4';
	if ($voteStat->average < 4 AND $voteStat->average >=3 )
		$color = 'e7dc31';
	if ($voteStat->average < 3 )
		$color = 'salmon';

		$msg = round ($voteStat->average, 2);	
	if ($voteStat->average == 0)
		$msg = "NULL";	
		
	$val = $val . "%";
?>


<div id='idOutBar'>
	<div id='idInBar' style="background-color:<?= $color ?>; width: <?= $val ?>;"><?= $msg ?></div>
</div>
