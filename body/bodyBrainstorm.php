<?php
session_start();    
$user = $_SESSION['user'];
$pass = $_SESSION['pass'];
$userID = $_SESSION['userID'];
$privileges = $_SESSION['privileges'];

if(isset($_GET['a']))	$start = $_GET['a'];
else 					$start = 0;

if(isset($_GET['b']))	$rows = $_GET['b'];
else 					$rows = 10;

if(isset($_GET['act']))		$act = $_GET['act'];
else 						$act = 'false';
 
 
if ($user == NULL) {
	header( 'Location: index.php?flag=expire' ) ;
}

if (basename(getcwd()) == 'body') { 
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
 

?>

<script>
$(function(){ 
  	var UID = $('hide').attr('uid');	
  	var LANG = $('hide').attr('lang');	
  	
	$(".appPunchline").click(function () {
		var ID = $(this).attr('id'); 
		var PID = $(this).attr('id').replace(/[^0-9]/g, ''); 	
		var TARGET = '#questionView' + PID;	
		var URL = './app/appPunchline.php?u=' + UID + '&p=' + PID;

		$(TARGET).load(URL, function(){
			$(this).slideToggle(1000);
		});		
	});
	
	$(".addPunchline").click(function () {
		var ID = $(this).attr('id'); 
		var PID = $(this).attr('id').replace(/[^0-9]/g, ''); 	
		var TARGET = '#addPunch' + PID;	
		var URL = './app/appAnswer.php?u=' + UID + '&p=' + PID + '&lang=' + LANG;
		//./app/appAnswer.php?u=$userID&p=$obj->id&lang=$lang
                 
                 
                 $('div[id ^= addPunch]').slideUp(1000, function(){
                     $(this).html('');
                 });
 //                $('div[id ^= addPunch]').html('');
//                $('div[id ^= addPunch]').html('close!', function() {
//                   $(this).hide(1000);
//                });
                
		$(TARGET).load(URL, function(){
			$(this).slideToggle(1000, function() {
				$(':text').focus();
			});
		});		
	});
});

//./app/appPunchline.php?u=$userID&p=$obj->id&lang=$lang
</script>	


<?php
echo "<hide uid='$userID' lang='$lang'></hide>";

//////////////////////////// DATA BASE OPERATIONS START //////////////////////////////////  


$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$result = $mysqli->query("UPDATE `ComedyDB`.`Users` SET `time` = '" . time() .  "' WHERE `Users`.`uid` = '$userID' ;");	

$SetupsNumber = $mysqli->query('SELECT COUNT(*) AS Num FROM Setup;')->fetch_object()->Num;

$brStNum = (int) ($SetupsNumber / 10 ) + 1;

if(!(isset($_GET['a'])))
	$start = $SetupsNumber - $SetupsNumber % 10;

	
echo "<br><hr class='hrM'>";
echo "<center>";
for ($i = 0; $i < $brStNum; $i ++) {
	if ($i == $start / 10 AND $rows != $SetupsNumber AND $act != "all")
		echo "[ ". ($i+1) . " ] ";
	else
		echo "[ <a href='javascript:void(0)' onclick=\"javascript:$('#mainBody').load('./body/bodyBrainstorm.php?a=" . ($i*10) . "&b=$rows&lang=$lang')\" id='StormLinks" . ($i+1) . "' >". ($i+1) . "</a> ] ";
}
if ($act == 'all') {
	echo "[ $Words[54] ] ";
	$limit = "";
} else {
	echo "[ <a href='javascript:void(0)' onclick=\"javascript:$('#mainBody').load('./body/bodyBrainstorm.php?b=$rows&act=all&lang=$lang')\" id='StormLinks" . ($i+1) . "' >$Words[54]</a> ] ";
	$limit = "LIMIT $start, $rows" ;
}
echo "</center>";

echo "<hr class='hrM'>";

if ($start / 10 == 12 OR $start / 10 == 13)
	echo "В последнее время в клубах становятся популярными креативные коктели с разными эффектами. 
	Попробуйте описать следующие коктейли (как можно смешнее). 
	Если насоберём 8-10 коктейлей, то можно как бриз-монолог пускать.<br> ";

$Setup_query = 	"SELECT Setup.id, Setup.line, Users.nick, Users.uid, Setup.timestamp
					FROM Setup, Users 
					WHERE Setup.uid = Users.uid
					ORDER BY Setup.id  " .
					$limit . ";
					";	

			

$n = $start;

if ($result = $mysqli->query($Setup_query)) { 

    while ($obj = $result->fetch_object()) { 

        //echo "$obj->id - $obj->line - $obj->nick - $obj->uid - $obj->timestamp <br>"; 
            
		echo "<br>$obj->id. ";
		echo "$obj->line... <br>\n";
			
		$User_count_query = 	"
						SELECT COUNT(*) AS userNum
						FROM $db_name.Punchline 
						WHERE Punchline.sid=$obj->id AND Punchline.uid='$userID' ;
						";					
	
						
		$Total_count_query = 	"
						SELECT COUNT(*) AS totalNum
						FROM $db_name.Punchline 
						WHERE Punchline.sid=$obj->id;
						";	 			
		
		$userCountResult = $mysqli->query($User_count_query);
		$UserSovpadenia = $userCountResult->fetch_object()->userNum;
		
		$totalCountResult = $mysqli->query($Total_count_query);
		$TotalSovpadenia = $totalCountResult->fetch_object()->totalNum;
				
		echo "[ <span class='addPunchline' id='StormAnswer$obj->id'>$Words[15]</span> - "; 
			
		echo " <span class='appPunchline' id='StormLinks$obj->id'>$Words[21] $TotalSovpadenia $Words[22]</span>\n ";
		if ($UserSovpadenia == 0)
		echo "<span id='missing$obj->id'> - <span id='missingAnswer'>$Words[20]</span></span>";
		echo "]\n";
		echo "<div id='addPunch$obj->id' class='addPunch'></div>\n\n";		
		echo "<div id='questionView$obj->id' class='questionView'><br><br></div><br>\n\n";		
	

    } $result->close();
} 
$mysqli->close();

	
echo "<br>\n<br>\n";

$previous = $start-$rows;
if ($previous < 0) $previous = 0;

$next = $start+$rows;
if ($next > $SetupsNumber) $next = $start;


?>
 





<hr class='hrM'>
<table width=400><tr><td aligh=left>

<a href='javascript:void(0)' onclick="javascript:$('#mainBody').load('./body/bodyBrainstorm.php?a=<?=$previous?>&b=<?=$rows?>&lang=<?=$lang?>')"> <? echo $Words[17]." ".$rows; ?></a>						</td><td aligh=right>
<a href='javascript:void(0)' onclick="javascript:$('#mainBody').load('./body/bodyBrainstorm.php?a=<?=$next?>&b=<?=$rows?>&lang=<?=$lang?>')">  <? echo $Words[18] ." ". $rows; ?></a>									</td></tr></table>
<hr class='hrM'><br><br>

 
