<?php
session_start();    

/**
 * Main login file.
 * Using to login and validate user.
 * Using PHP code for form validation
 * 
 */

isset($_SESSION['user']) ? $user = $_SESSION['user'] : $user = NULL;
isset($_SESSION['userID'])  ? $userID = $_SESSION['userID'] : $userID = NULL;
isset($_SESSION['pass']) ? $pass = $_SESSION['pass'] : $pass = NULL;
isset($_SESSION['privileges']) ? $privileges = $_SESSION['privileges'] : $privileges = NULL;

 

isset($_GET['flag']) ? $flag = $_GET['flag'] : $flag = NULL;
isset($_GET['id']) ? $regFlag = $_GET['id'] : $regFlag = NULL;

include_once './CONST.php';


isset($_REQUEST['lang']) ? $lang = $_REQUEST['lang'] : $lang = 'russian';
isset($_REQUEST['nick']) ? $user = $_REQUEST['nick'] : $user = NULL;
isset($_REQUEST['pass']) ? $pass = $_REQUEST['pass'] : $pass = NULL;
	
$user = htmlentities($user); 
$pass = htmlentities($pass);



?>

<html>
	<head>
		
	 
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<script type="text/javascript" src="./scripts/jquery-1.9.0.min.js"></script>
		<link rel="stylesheet" href="./scripts/main.css" type="text/css" media="screen" charset="utf-8" />
		<script type='text/javascript' src="./scripts/comedy.js"></script> 	
	
	
		<script type='text/javascript'> 
		 	//$(window).bind("load", function() {
		 	//	$('#boxIndex123').load('login.php');
			//});
			
		</script>
		<title>SF Comedy Club</title>
	
		<?php
	

		
if (strlen($user) > 0 && strlen($pass) > 0) {
	
	//////////////////////////// DATA BASE OPERATIONS START //////////////////////////////////
	$mysqli =  new mysqli($db_host, $db_user, $db_pass, $db_name);
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
    	exit();
	}
		
	$obj = $mysqli->query("SELECT Security.uid, Security.password, Users.privileges FROM Security, Users WHERE Security.uid=Users.uid AND Users.name='$user';")->fetch_object();
	$userID = $obj->uid;  
	$password = $obj->password;
	$privileges = $obj->privileges;
		

		
	//////////////////////////// DATA BASE OPERATIONS END ////////////////////////////////////
			
	if (base64_decode ($password) == $pass AND $privileges != 'waiting') {
			// create cookies
			// If the validation is successful, the session starts.
			//  

		$_SESSION['pass'] = $pass;
		$_SESSION['userID'] = $userID;	
		$_SESSION['user'] = $user;
		$_SESSION['privileges'] = $privileges;
		$_SESSION['timeout'] = time();
 
		$result = $mysqli->query("UPDATE `ComedyDB`.`Users` SET `time` = '" . time() .  "' WHERE `Users`.`uid` = '$userID' ;");
 
 		$result = $mysqli->query("INSERT INTO `ComedyDB`.`Log` (`uid`, `action`, `ip`, `system`, `timestamp`) " 
 						. " VALUES ('$userID', '70', '" . $_SERVER['REMOTE_ADDR'] . "', '" . $_SERVER['HTTP_USER_AGENT'] 
 						. "', '" . date('Y-m-d H:i:s') . "'); ");
 

		echo "<script language='Javascript'>";
			echo "window.location = 'mainPage.php?lang=" . $lang . "';";
		echo "</script>";
							
	} elseif ($privileges == 'pending') {
		// The user hasn't been activated yet. 
		$errorMessage = "Your account has not been activated yet <br>";
	} else {
		//refresh the page if user do not match password
						
		echo "<script language='Javascript'>";
			echo "window.location = 'index.php?id=error';";
		echo "</script>";
		$errorMessage = $errorMessage . "Your password doesn't match <br>"; 
	}  	$mysqli->close();
}	 

	
if ($flag == 'expire') 
	$errorMessage = "Your session is expired. Please relogin" ;
else 
	$errorMessage = NULL;
			
?>
	
	
	
	</head>
	<body class='blue'>
		<div id='boxReg'>
			<div id='boxIndex123'> 
		
				<font size=2 color=maroon><br><?= $errorMessage ?><br><br>
				<form method='post' action='index.php'>
					<table border=0 class='logintable'>
						<tr>
							<td align=right><font face=verdana size=2 color=000050>Login:</td> 
							<td><input type='text' id='nick' name='nick' size=10 class='textfield'></td>
						</tr>
						<tr>
							<td align=right><font size=2 color=000050>Password:</td>
							<td><input type='password' id='pass' name='pass' size=10 class='textfield'></td>
						</tr>
						<tr>
							<td align=right><font size=2 color=000050>Language:</td>
							<td>
								<select id='lang' name='lang'>
									<option value="english">English</option>
									<option value="russian">Russian</option>
									<option value="ukrainian">Ukrainian</option>																		
								</select>
							</td>
						</tr>
						<tr>
							<td></td>
							<td><input type=submit value='Push!' class='buttons'></td>
						</tr>
					</table>
				</form>		
		
			</div>
			
			<div id='reg'><a href='indexRegister.php'>:: Registration ::</a></div>

			<br>

			<div width=100% align=right class='copyright'><font size=1 color=000080>Pavel Anisimov &copy 2007-12</font></div>

		</div>

	</body>
</html>
