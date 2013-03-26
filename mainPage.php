<?php
session_start();    
/**
 * Main file that holds oll of the information on the page
 * The page is devided into the different numbe of blocks/widgets
 * Blocks are loaded and updates via jQuery/ajax calls
 * All main contetns is loaded into div#mainBody from ./body folder
 * Widgets on the menu panel are loaded speparatelly from ./menu folder
 *
 */

$user = $_SESSION['user'];
$pass = $_SESSION['pass'];
$userID = $_SESSION['userID'];
$privileges = $_SESSION['privileges'];

/**
 * Outputting the page generation time
 * Is used only on development environment.
 * Should be removed upon the deployment
 */

if ($userID != "_741ebb6f") {
	$mtime = microtime(); 
	$mtime = explode(" ",$mtime); 
	$mtime = $mtime[1] + $mtime[0]; 
	$starttime = $mtime;
}

isset($_GET['lang']) ? 	$lang = $_GET['lang'] : $lang = $_SESSION['lang'];

if      ($lang == 'english') 	{   $lang = 'english'     ;   }
elseif  ($lang == 'ukrainian') 	{   $lang = 'ukrainian'   ;   }
else 				{   $lang = 'russian'     ;   } 


include_once './CONST.php';
include_once './dictionary.php';	

isset($_SESSION['url']) ? $savedURL = $_SESSION['url'] : $savedURL = './body/bodyBrainstorm.php?lang=' . $lang; 
isset($_GET['a']) ? $start = $_GET['a'] : $start = 0;
isset($_GET['b']) ? $rows = $_GET['b'] : $rows = 10;

		

if ($user == NULL) {
	header( 'Location: index.php?flag=expire' ) ;
}
	

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
   	exit();
} $result = $mysqli->query("UPDATE `ComedyDB`.`Users` SET `time` = '" . time() .  "' WHERE `Users`.`uid` = '$userID' ;");	
$mysqli->close();
	

	
?>
<html>
	<head>
		<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />	
		<meta name="viewpoint" content="width=device-width, initial-scale=1.0"/>
		<script type="text/javascript" src="./scripts/jquery-1.9.0.min.js"></script>
		<link rel="stylesheet" href="./scripts/main.css" type="text/css" media="screen" charset="utf-8"/>
		<script type='text/javascript' src="./scripts/comedy.js"></script> 	

		
		<script type='text/javascript'> 
		 	$(window).bind("load", function() {
		 		$('#topBody').load("./app/appMessage.php?lang=<?= $lang?>");
		 		$('#mainBody').html("<img src='./images/ajax-loader2.gif'>");
		 		$('#mainBody').load('<? echo $savedURL; ?>');
	 			$('#OnlineUsersTable').load('./menu/menuOnline.php?lang=<?=$lang ?>');
		 		

			});
			
			$("#jokesHref").live('click', function(){
				$('mainBody').load('./body/bodyJokes.php');
			});
		</script>
		
		
		
		<title><?= $Words[14] ?></title>
		
													
	</head>

	<body class='blue'>		 
		<div id="container">
			<div id="header">
				<h1><?= $Words[14] ?></h1>
			</div>
			<div id="content">
				<h2>
					<?= $Words[13] . " " . ucfirst($user) . " (" . $privileges . ")"  ?>
					<select id='lang'>
						<option><?= $Words[85] ?></option>						
						<option value="english"><?= $Words[86] ?></option>
						<option value="russian"><?= $Words[87] ?></option>
						<option value="ukrainian"><?= $Words[88] ?></option>
					</select>
				</h2>
				
				<?= $Words[23] ?>
				
				<!-- Main body part -->	
				<div id="mainBody">Loading...</div>

				<!-- Right Panel -->					
				<div id='materialPanel'>
					<div id='idMenuLog'></div> 
					<div id='idOnlineLink' class='classStatLink' lang='<?= $lang?>'><? echo $Words[65]; ?> </div><div id='OnlineUsersTable'></div> 
	        		<?php include_once './menu/menuNavigation.php'; ?>
	        		<?php include_once './menu/menuAction.php'; ?>	        						
	        		<?php if ($privileges == 'admin') include_once './menu/menuAdmin.php'; ?>
					<div id='idTailsLink' class='classStatLink'><? echo $Words[56]; ?></div><div id='TailsTable'></div> 	        						
	        		<?php include_once './menu/menuStats.php'; ?>
	        	</div>
				

	
				<div id="footer">&copy; <? echo $Words[24] ?><br>
					<? 
						/**
						 *  Outputting the page generation time
						 * Is used only on development environment.
						 * Should be removed upon the deployment
						 */
						if ($userID != "_741ebb6f") {   
						   $mtime = microtime(); 
						   $mtime = explode(" ",$mtime); 
						   $mtime = $mtime[1] + $mtime[0]; 
						   $endtime = $mtime; 
						   $totaltime = ($endtime - $starttime); 
						   echo "This page was created in ".$totaltime." seconds";
						}	
					?> 
				</div>
			</div>
		</div>
	</body>
</html>



