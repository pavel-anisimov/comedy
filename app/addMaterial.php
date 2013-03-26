<?php
session_start();
/**
 * Widget for adding a a material (joke, song, sketch etc)
 * into the database
 */

$user = $_SESSION['user'];
$userID = $_SESSION['userID'];
$pass = $_SESSION['pass'];

isset($_GET['lang']) ? $lang = $_GET['lang'] : $lang = 'russian';
$userID=='741ebb6f' ? $checkBox = '<label for="voteMaterial">Votable</label><input id="voteMaterial" type="checkbox" name="voteMaterial">' : $checkBox = ' '; 

include_once '../CONST.php';
include_once '../dictionary.php';
include_once '../classes/classMySQL.php';
?>

<script type='text/javascript' src='./scripts/ajaxform.js'></script> 	

<form id='addMaterial' action='./app/set.Material.php?lang=<?=$lang?>' method='post'>
 	<fieldset id='addMaterial'>  <legend align=right><?=$Words[47]?></legend>

		<input type='hidden' name='m32' id='m32' value='<?=$Words[32]?>'>
		<input type='hidden' name='m51' id='m51' value='<?=$Words[51]?>'>
		<input type='hidden' name='m52' id='m52' value='<?=$Words[52]?>'>
		<input type='hidden' name='m53' id='m53' value='<?=$Words[53]?>'>
		<input type='hidden' name='m53' id='m53' value='<?=$Words[53]?>'>		
						 		
		<input type='hidden' name='uid' id='uid' value='<?=$userID?>'>
		<input type='hidden' name='lang' id='lang' value='<?=$lang?>'>
		<textarea name='linematerial'  id='linematerial' class='submitTextarea' autofocus></textarea>
		<?=$Words[50] ?>
		<select name='type' form='addMaterial' id='type' class='selectType'>
			<option value='NULL'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
			<option value='joke'><?=$Words[1]?></option>
			<option value='sketch' ><?=$Words[3]?></option>
			<option value='idea'><?=$Words[5]?></option>
			<option value='song'><?=$Words[7]?></option>
			<option value='black'><?=$Words[34]?></option>
		</select>
		<?= $checkBox ?>
		<input type='submit' value='OK' class='submit'>
	</fieldset>
</form><div id='mError'></div>
