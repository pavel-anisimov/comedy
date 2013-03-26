
<script type='text/javascript' src='./scripts/comedy.js'></script> 
<script src='./scripts/ajaxform.js'></script> 
<script type='text/javascript' src='./scripts/jquery-1.9.0.min.js'></script>
<? 
 

$lang = $_GET['lang'];

 

if ($lang == 'russian') {
} elseif ($lang == 'ukrainian' ){
} elseif ($lang == NULL) {
	$lang == 'english';
} else {
	$lang == 'english';
}

include '../CONST.php';
include '../dictionary.php';
include '../classes/classMySQL.php';
 
 

?>

<form id='getVotesResults'   method='POST'>
<input type='text' name='from' size=8 value='' placeholder='From Day' class='inputRes' id='idFrom'>
<input type='text' name='to' size=8 value='' placeholder='To Day' class='inputRes' id='idTo'>
<input type='text' name='min' size=3 value='' placeholder='Min' class='inputRes' id='idMin'>
<input type='text' name='max' size=3 value='' placeholder='Max' class='inputRes' id='idMax'>
<input type='submit' value='OK' id='submit'>
</form>	<span id='errorVote'></span>

<div id='votesBody'></div>
 