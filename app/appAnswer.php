<?php
/**
 * Widget for outputing joke punchlines submitted by users
 */

isset($_GET['u']) ? $uid = $_GET['u'] : die('ERROR: User id has not been defined');
isset($_GET['p']) ? $pid = $_GET['p'] : die('ERROR: Punchline number is not set up');
isset($_GET['lang']) ? $lang = $_GET['lang'] : $lang = 'russian';

include_once '../CONST.php';
include_once '../dictionary.php';
include_once '../classes/classMySQL.php';

?>
<script type='text/javascript' src='./scripts/comedy.js'></script> 
<script type='text/javascript' src='./scripts/ajaxform.js'></script> 
<script type='text/javascript' src='./scripts/jquery-1.9.0.min.js'></script>
<? 
 
if ($lang == 'russian') {
} elseif ($lang == 'ukrainian' ){
} elseif ($lang == NULL) {
	$lang == 'english';
} else {
	$lang == 'english';
}
?>

 

<form id='myForm<?=$pid?>' class='ajaxform' method='POST' action='./app/setPunchline.php'>
		<input type='hidden' name='uid' value='$uid' id='uid<?=$pid?>'> 
		<input type='hidden' name='pid' value='$pid' id='pid<?=$pid?>'>
		<input type='text' name='line' size=40 value='' placeholder='<?=$Words[29]?>' class='inputAns' id='line<?=$pid?>'>
		<input type='submit' value='OK' id='submit'>
</form>	<span id='error<?=$pid?>'></span>


 