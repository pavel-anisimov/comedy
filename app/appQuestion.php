<?php
session_start();
/**
 * Widget-form for submitting a joke setup
 * 
 */
$user = $_SESSION['user'];
$userID = $_SESSION['userID'];
$pass = $_SESSION['pass'];

isset($_GET['lang']) ? $lang = $_GET['lang'] : $lang = 'russian';

include_once '../CONST.php';
include_once '../dictionary.php';
include_once '../classes/classMySQL.php';
?>
 
<script type='text/javascript' src='./scripts/ajaxform.js'></script> 	

<form id='addQuestion' action='./app/set.Setup.php?lang=<?=$lang?>' method='post'>
	<fieldset id='addQuestion'>  <legend align=right><?=$Words[31]?></legend>	
		<input type='hidden' name='m32' id='m32' value='<?=$Words[32]?>'>
		<input type='hidden' name='m51' id='m51' value='<?=$Words[51]?>'>			
		<input type='hidden' name='lang' id='lang' value='<?=$lang?>'>	
		<input type='hidden' name='uid' id='uid' value='<?=$userID?>'>
		<textarea name='line' id='line' class='submitTextarea' autofocus></textarea>
		<input type='submit' value='OK' class='submit'>
	</fieldset>
</form><div id='mError'></div>

