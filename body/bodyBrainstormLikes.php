<?php
session_start();   
/**
 * 
 * Body Widget for displaying Brainsorm voting resolts
 * TODO: Cleanup the code and separate HTML from PHP tags
 * 
 */ 
$user = $_SESSION['user'];
$pass = $_SESSION['pass'];
$userID = $_SESSION['userID'];


isset($_GET['a']) ? $start = $_GET['a'] : $start = 0;
isset($_GET['b']) ? $rows = $_GET['b'] : $rows = 20;
isset($_GET['lang']) ? $lang = $_GET['lang'] : $lang = 'russian';

isset($_GET['act']) ? $act = $_GET['act'] : $act = NULL; 
 
 

if ($user == NULL) {
	header( 'Location: index.php?flag=expire' ) ;
}
 


$id = 0;

if ($lang == 'english') 		{ $lang = 'english'; 	}
elseif ($lang == 'ukrainian') 	{ $lang = 'ukrainian'; 	}
else 							{ $lang = 'russian' ; 	} 

include_once '../CONST.php';
include_once '../dictionary.php';
include_once '../classes/classVotingSetup.php';
include_once '../classes/classMySQL.php';


$mysqlQuery = new MysqlQuery($db_host, $db_user, $db_pass, $db_name);

  
	
?>
<script type='text/javascript'>

$(document).ready(function(){
    $(':radio').change(function(){
  	var ID = $(this).attr('id');   //idRadio_4_234 ;
  	var arr = ID.split("_");
	var SID = $(this).attr('name').replace(/[^0-9]/g, ''); 
  	var PID = arr[2]; 
  	var UID = $('hide').attr('id');
  	var VOTE = $(this).val();
  	var divVote = '#punch'+SID;
        $.post("./app/setBrainstormVote.php", { uid: UID, pid: PID, vote: VOTE} );
        var URL = './app/getBrainstormVotes.php?uid='+UID+'&pid='+PID+'&vote='+VOTE;
        $(divVote).slideUp(1000);
        /*
        $(divVote).fadeOut(1000, function(){
            $(this).load(URL, function(){  
                $(this).fadeIn(1000);
            });
        });
        */
    });
});
function loadBar(URL, ID) {
	$(ID).load(URL);
}	

</script> 	

<?	
echo "<hide id='$userID'></hide>";


$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
} 

$countQuery = "
        SELECT COUNT(Setup.id) AS SetNum 
        FROM Setup, (SELECT Punchline.id, Punchline.sid, Punchline.line, Punchline.uid FROM Punchline WHERE Punchline.uid != '$userID') AS punch
                LEFT JOIN (SELECT BrainstormVote.pid FROM BrainstormVote, Punchline WHERE BrainstormVote.uid='$userID' AND BrainstormVote.pid=Punchline.id ) AS vote ON punch.id=vote.pid
        WHERE vote.pid IS NULL AND Setup.id=punch.sid
        ORDER BY punch.sid;    
";
$setNum = $mysqli->query($countQuery)->fetch_object()->SetNum; 

$brStNum = (int) ($setNum / $rows ) ;

if ($brStNum > $rows) $brStNum == $rows;   // this can be removed to show more then 10 brainstrorms



echo "<br><hr class='hrM'>";
echo "<center>";
for ($i = 0; $i < $brStNum; $i ++) {
	if ($i == $start / $rows AND $act != 'all')
		echo "[ ". ($i+1) . " ] ";
	else
		echo "[ <a href='javascript:void(0)' onclick=\"javascript:$('#mainBody').load('./body/bodyBrainstormLikes.php?a=" . ($i * $rows) . "&b=$rows&lang=$lang')\" id='StormLinks' >". ($i+1) . "</a> ] ";
}
if ($act == 'all') {
	echo "[ $Words[54] ] ";
	$limit = "";
} else {
	echo "[ <a href='javascript:void(0)' onclick=\"javascript:$('#mainBody').load('./body/bodyBrainstormLikes.php?b=$rows&act=all&lang=$lang')\" id='StormLinks' >$Words[54]</a> ] ";
	$limit = "LIMIT $start, $rows" ;
}
echo "</center>";


echo "<hr class='hrM'>";

$query = "
        SELECT Setup.id AS sid, Setup.line AS sline, punch.id AS pid, punch.line AS pline 
        FROM Setup, (SELECT Punchline.id, Punchline.sid, Punchline.line, Punchline.uid FROM Punchline WHERE Punchline.uid != '$userID') AS punch
                LEFT JOIN (SELECT BrainstormVote.pid FROM BrainstormVote, Punchline WHERE BrainstormVote.uid='$userID' AND BrainstormVote.pid=Punchline.id ) AS vote ON punch.id=vote.pid
        WHERE vote.pid IS NULL AND Setup.id=punch.sid
        ORDER BY punch.sid
        $limit;    
";
//$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
//if (mysqli_connect_errno()) {
//    printf("Connect failed: %s\n", mysqli_connect_error());
//    exit();
//}

$jCount = -1;
$previous = 0;
$curent = 0;
$Jokes = array();
if ($result = $mysqli->query($query) ) {
    while ($obj = $result->fetch_object()) {
//$obj->sid   $obj->sline   $obj->pid   $obj->pline";
        $curent = $obj->sid;
        if ($curent != $previous) {
            $previous = $curent;
            $jCount++;
            $Jokes[$jCount] = new VotingSetup();
        }
       $Jokes[$jCount]->add( $obj->sid, $obj->sline, $obj->pid, $obj->pline );
    } 
    $result->close();
} $mysqli->close();

for ($i  = 0; $i < ($jCount + 1); $i++) {
    $num = 'a'; 
    
    echo "\n<div id='idSetPunch" . $Jokes[$i]->getId() . "' class='classSetPunch'>\n";
    echo "   <table width=100%> \n";
    echo "      <tr valign=top> \n";
    echo "         <td width=25>" . $Jokes[$i]->getId() . "</td> \n";
    echo "         <td>" . $Jokes[$i]->getLine() . "</td> \n ";
    echo "      </tr> \n";
    echo "      <tr> \n";
    echo "         <td></td> \n";
    echo "         <td>\n" ;

    for ($m = 0; $m < $Jokes[$i]->getCount(); $m++) {
		$tempPunch = $Jokes[$i]->getSinglePunchline($m);
        $pid = $tempPunch['id'];

        echo "            <div id='punch" . $pid .  "' class=vb> \n";
        echo "               <div id='k' class=fd> \n";
        echo "                  " . $num++ . ". " . $tempPunch['line'] . " \n";;
        echo "               </div> \n";
        echo "               <div id='divVote$pid' class='divVoteForm'> \n";
        echo "                  <form name='formSetup" . $Jokes[$i]->getId() . "'>                                       \n ";
        echo "                     <input type='radio' name='like$pid' id='idRadio_1_$pid' value='1' class='classRadio'> \n ";	 
        echo "                        <label for='idRadio_1_$pid'>+ 1</label>                                            \n ";					
        echo "                     <input type='radio' name='like$pid' id='idRadio_2_$pid' value='2' class='classRadio'> \n ";
        echo "                        <label for='idRadio_2_$pid'>+ 2</label>                                            \n ";
        echo "                     <input type='radio' name='like$pid' id='idRadio_3_$pid' value='3' class='classRadio'> \n ";
        echo "                        <label for='idRadio_3_$pid'>+ 3</label>                                            \n ";
        echo "                     <input type='radio' name='like$pid' id='idRadio_4_$pid' value='4' class='classRadio'> \n ";
        echo "                        <label for='idRadio_4_$pid'>+ 4</label>                                            \n ";
        echo "                     <input type='radio' name='like$pid' id='idRadio_5_$pid' value='5' class='classRadio'> \n ";
        echo "                        <label for='idRadio_5_$pid'>+ 5</label> \n ";
        echo "                  </form>  \n ";
        echo "               </div> \n ";
        echo "            </div> \n";
    }
        echo "         </td> \n";
        echo "      </tr> \n";
        echo "   </table> \n";
        echo "</div> \n";     
}




echo "<br>\n<br>\n";


$previous = $start - $rows;
if ($previous < 0) $previous = 0;

$next = $start+$rows;
if ($next > $setNum - $rows) $next = $setNum - $rows;


?>
<hr class='hrM'>
<table width=400><tr><td aligh=left>

<a href='javascript:void(0)' onclick="javascript:$('#mainBody').load('./body/bodyBrainstormLikes.php?a=<? echo $previous;?>&b=<?=$rows?>&lang=<? echo $lang;?>')"> <? echo $Words[17]; ?></a>						</td><td aligh=right>
<a href='javascript:void(0)' onclick="javascript:$('#mainBody').load('./body/bodyBrainstormLikes.php?a=<? echo $next;?>&b=<?=$rows?>&lang=<? echo $lang;?>')">  <? echo $Words[18]; ?></a>									</td></tr></table>
<hr class='hrM'><br><br>
   