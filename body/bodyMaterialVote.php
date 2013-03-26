<?php
session_start();    
/**
 * Body widget for displaying Vote resolts for all material
 * TODO: Cleanup the code (separate PHP from HTML)
 * 
 */
$user = $_SESSION['user'];
$pass = $_SESSION['pass'];
$userID = $_SESSION['userID'];;


isset($_GET['lang']) ? $lang = $_GET['lang'] : $lang = 'russian';

 

if ($lang == 'english') 		{ $lang = 'english'; 	}
elseif ($lang == 'ukrainian') 	{ $lang = 'ukrainian'; 	}
else 							{ $lang = 'russian' ; 	} 

include_once '../CONST.php';
include_once '../dictionary.php';
include_once '../classes/classSetup.php';

	if (basename(getcwd()) == 'body') { 
	echo "
		<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
		<script type='text/javascript' src='../scripts/jquery-1.9.0.min.js'></script>
		<link rel='stylesheet' href='../scripts/main.css' type='text/css' media='screen' charset='utf-8' />
		<script type='text/javascript' src='../scripts/comedy.js'></script> 	
	"; }
	 
?>

<script type='text/javascript'>

$(document).ready(function(){
    $(':radio').change(function(){
  	var ID = $(this).attr('id');   //idRadio_4_234 ;
	var arr = ID.split("_");
//var SID = $(this).attr('name').replace(/[^0-9]/g, ''); 
  	var MID = arr[2]; 
  	var UID = $('hide').attr('id');
  	var VOTE = $(this).val();
  	var divVote = '#BoxMaterial' + MID;
  	
 
  	
  	
        $.post("./app/setMaterialVote.php", { uid: UID, mid: MID, vote: VOTE} );
   //     var URL = './app/getBrainstormVotes.php?uid='+UID+'&pid='+PID+'&vote='+VOTE;
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
</script> 
<?php
echo "<hide id='$userID'></hide>";
//////////////////////////// DATA BASE OPERATIONS START //////////////////////////////////  

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
   	exit();
} $result = $mysqli->query("UPDATE `ComedyDB`.`Users` SET `time` = '" . time() .  "' WHERE `Users`.`uid` = '$userID' ;");	
$mysqli->close();


$con = mysql_connect($db_host, $db_user, $db_pass);




if (!$con) {
	die('Could not connect: ' . mysql_error());
} 
mysql_select_db($db_name);

//echo $userID ."<br>";
$User_query = "SELECT Users.uid, Users.name, Users.nick, Users.privileges FROM Users WHERE uid=$userID;";


//$User_result = mysql_query($User_query);
//list($userId, $userName, $userNick, $userPriveleges) = mysql_fetch_row($User_result);


list($SetupsNumber) = mysql_fetch_row(mysql_query('SELECT COUNT(*) FROM Setup;'));

$archiveQuery = 	"
			SELECT `Archive`.`id`, `Archive`.`text`, `Archive`.`type`, `Archive`.`timestamp`
			FROM `Archive`
			LEFT JOIN ( 
					SELECT `Archive`.`id`, `Archive`.`text`
			        FROM `Archive`, `MaterialVote`
			        WHERE `Archive`.`id`=`MaterialVote`.`mid` AND `MaterialVote`.`uid`='$userID') AS `TEMP` 
						ON `TEMP`.`id`=`Archive`.`id`
			WHERE `Archive`.`vote`='1' AND `TEMP`.`id` IS NULL
			ORDER BY `Archive`.`type`, `Archive`.`timestamp`  ;
			";
 
		
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$num = 0;
if ($result = $mysqli->query($archiveQuery)) { 

    while ($obj = $result->fetch_object()) {$num++;

		switch ($obj->type) {
		    case 'joke':
		        $typeOut = $Words[1];
		        break;
		    case 'sketch':
		        $typeOut = $Words[3];
		        break;
		    case 'idea':
		        $typeOut = $Words[5];
		        break;
		    case 'song':
		        $typeOut = $Words[7];
		        break;		
		    case 'black':
		        $typeOut = $Words[35];
		        break;
		}



		 
   
   		echo "<div id='BoxMaterial" .  $obj->id . "' class='boxM'>";
        echo "<b>$typeOut #$num. </b><br>" . $obj->text; 
		
        echo "                <div id='divMaterialVote" . $obj->id . "' class='divMaterialVoteForm'> \n";
        echo "                  <form name='formMaterial" . $obj->id . "'>                       				                 \n ";
        echo "                     <input type='radio' name='like$num' id='idRadio_1_$obj->id' value='1' class='classRadio'> \n ";	 
        echo "                        <label for='idRadio_1_$obj->id'>+ 1</label>                                            \n ";					
        echo "                     <input type='radio' name='like$num' id='idRadio_2_$obj->id' value='2' class='classRadio'> \n ";
        echo "                        <label for='idRadio_2_$obj->id'>+ 2</label>                                            \n ";
        echo "                     <input type='radio' name='like$num' id='idRadio_3_$obj->id' value='3' class='classRadio'> \n ";
        echo "                        <label for='idRadio_3_$obj->id'>+ 3</label>                                            \n ";
        echo "                     <input type='radio' name='like$num' id='idRadio_4_$obj->id' value='4' class='classRadio'> \n ";
        echo "                        <label for='idRadio_4_$obj->id'>+ 4</label>                                            \n ";
        echo "                     <input type='radio' name='like$num' id='idRadio_5_$obj->id' value='5' class='classRadio'> \n ";
        echo "                        <label for='idRadio_5_$obj->id'>+ 5</label> \n ";
        echo "                  </form>  \n ";
        echo "               </div> \n "; 
        		
		echo "</div>";
    } $result->close();
}

/* close connection */
$mysqli->close();
				
 


mysql_close($con);  
	
	echo "<br><Br>"

//////////////////////////// DATA BASE OPERATIONS END ////////////////////////////////////


?>
