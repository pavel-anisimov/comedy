<?php
/**
 * Widget that shows incompleted 
 * or past due brainstorms
 * 
 * TODO: substitute table tags with list or div
 * elliminate unset values. Throws a warning
 */
if (basename(getcwd()) == 'menu') {
	if (isset($_GET['lang'])) 
	$lang = $_GET['lang'];
	else $lang = 'russian';

	if ($lang == 'english') 		{ $lang = 'english'; 	}
	elseif ($lang == 'ukrainian') 	{ $lang = 'ukrainian'; 	}
	else 							{ $lang = 'russian' ; 	} 

	include_once'../CONST.php';
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
} 	
$brStNumber = (int) ( $mysqli->query('SELECT COUNT(*) AS Num FROM Setup;')->fetch_object()->Num / 10 );

$authorsQ = "SELECT DISTINCT `Users`.`uid`, `Users`.`nick` FROM `Users` WHERE `Users`.`privileges`='admin' OR `Users`.`privileges`='author' ORDER BY `Users`.`nick`;";


$tailsArray = array(); 		

$count = 0 ;

echo "<div id='TailsTable'><table class='statTable'><tr><th class='statsTH'>$Words[36]</th><th  class='statsTH' id='statTH'>$Words[55]</th></tr>\n";

if ($result = $mysqli->query($authorsQ)) { 
    while ($obj = $result->fetch_object()) {

		$tailsArray[$count]->uid = $obj->uid;  
		$tailsArray[$count]->nick = $obj->nick;  
		$count ++;
    } $result->close(); 
} 
 


for ($i = 0; $i < $count; $i++) {
	$punchArray = array(); 	
	$missingTail = TRUE;
	$q = 0;
	$tailsQ = "SELECT DISTINCT `Punchline`.`sid` FROM `Punchline` WHERE `Punchline`.`uid`='" . $tailsArray[$i]->uid . "' ORDER BY `Punchline`.`sid`;";
 
	if ($resultT = $mysqli->query($tailsQ)) {
		
		echo "<tr class='StatTR" . ($i % 2). "'>";
        echo "<td class='statTDLeft'> " . $tailsArray[$i]->nick . "</td>"; 

		echo "<td class='statTDRight'>";
		
		//echo $tailsArray[$i]->uid . " - " . $tailsArray[$i]->nick . "<br>"; 


	    while ($obj = $resultT->fetch_object()) {
 			$punchArray[$q] = $obj->sid;
			$q ++;
    	} $resultT->close(); 
 
  
    	
    	for ($j = 0; $j < $brStNumber; $j++) {
    		$k = 0;	
    		$ansInBrSt = 0;
    		while ($punchArray[$k]) {
    			if ($punchArray[$k] > ($j*10) AND $punchArray[$k] <= ($j+1)*10 ) {
    				 $ansInBrSt ++;
    			}
			
    		$k++; 
			}

  			if ($ansInBrSt < 7) {
	 		
				echo " <a href='javascript:void(0)' onclick=\"javascript:$('#mainBody').load('./body/bodyBrainstorm.php?a=" . ($j*10) . "&lang=$lang')\" id='StormLinks$n' >" . ($j+1) . "</a>";	
				$missingTail = FALSE;
			}
    	} 
		if ($missingTail == TRUE)
			echo $Words[58];
		
 
   		echo "</td></tr>\n";	
    }  
} 
 
echo "<tr ><td colspan='2'><span class='small'>$Words[57]</td></tr></table></div>\n";	 

$mysqli->close();

?>