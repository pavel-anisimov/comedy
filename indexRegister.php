<?php 
session_start();    

/**
 * Main registration form. Implements classes MySQL, Regiser and Mail for 
 * sending an email to a new member
 */

isset($_GET['flag']) ? $flag = $_GET['flag'] : $flag = NULL;
include_once './CONST.php';
include_once './classes/classMySQL.php';
include_once './classes/classRegister.php';
include_once './classes/classMail.php';
?>
		
<html>
	<head>	
		<script type="text/javascript" src="./scripts/jquery-1.9.0.min.js"></script>
		<link rel="stylesheet" href="./scripts/main.css" type="text/css" media="screen" charset="utf-8"/>
		<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
		<script type='text/javascript' src="./scripts/comedy.js"></script> 	
	</head>
<body class='blue'>
<div id='boxReg'>
	<?php
	
		$regObj = new register($_GET['regEmail'], $_GET['regPass1'], $_GET['regPass2'], $_GET['regName'], $_GET['regNick'], $_GET['regPriv'], $_GET['flag']);
		
		$mysqlQuery = new MysqlQuery($db_host, $db_user, $db_pass, $db_name);
		$SendMail = new classMail($db_host, $db_user, $db_pass, $db_name);

		if ($regObj->getOkay()) {
		
			$userQuery =  $regObj->userQuery(); 
			$mysqlQuery->execute($userQuery); 
			
			
			$securityQuery = $regObj->securityQuery();
			$mysqlQuery->execute($securityQuery); 
			
			echo "<br>" . $regObj->getUid() . "</b><br>" ; 
			
			$mysqlQuery->single("INSERT INTO `ComedyDB`.`Log` (`uid`, `action`, `ip`, `system`, `timestamp`) VALUES ('" . $regObj->getUid() . "', '73', '" . $_SERVER['REMOTE_ADDR'] . "', '" . $_SERVER['HTTP_USER_AGENT'] . "', '" . date('Y-m-d H:i:s') . "'); ");  
			
				
			$headerMessage = $regObj->getNick . " <" . $regObj->getEmail() . ">";  echo $headerMessage . "<br>";
 
	//		function sendToAll ($from, $subject, $message)
			$emailMessage = $regObj->getEmail() . " is awaiting confirmation for registration. \n Please login to http://comedy.pavel.ws to authorize a new comedy club resident."; 	
			$SendMail->sendToAdmin($headerMessage, "New User for Comedy Club", $emailMessage);
				
	 
				
			echo "Thank you for registring. You will be receiving confirmation via email soon.<br>\n";
			echo "<script type='text/javascript'> "
				. "setTimeout(function() { "
				. "window.location = 'index.php'; "
				. "}, 3000); "
				. "</script> ";	
			
		} else {
			 $regFlag = $regObj->getFlag();
		}

	?>
	

	<div id='boxIndex123'> 

		<form id='regForm' accept-charset='UTF-8'>
				 
		<br><? if ($flag == 'yes') echo $regObj->getErrorMessage(); ?> <br><br>
					
		<table border=0 class='login'>
			<tr>
				<td align=right><font face=verdana size=2 color=000050>Login:</td> 
				<td><input type='text' id='user' name='regName' size=10 value='<?php echo $regObj->getName(); ?>' class='textfield'></td>
			</tr>
			<tr>
				<td align=right><font face=verdana size=2 color=000050>Email:</td>
				<td><input type='text' id='user' name='regEmail' size=10 value='<?php echo $regObj->getEmail(); ?>' class='textfield'></td>
			</tr>
			<tr>
				<td align=right><font size=2 color=000050>Password:</td>
				<td><input type='password' id='pass' name='regPass1' size=10 value='<?php echo $regObj->getPass1(); ?>' class='textfield'></td>
			</tr>
			<tr>
				<td align=right><font size=2 color=000050>Password (repeat):</td>
				<td><input type='password' id='pass' name='regPass2' size=10 value='<?php echo $regObj->getPass2(); ?>' class='textfield'></td>
			</tr>

			<tr>
				<td align=right><font face=verdana size=2 color=000050>Display Name:</td> 
				<td><input type='text' id='user' name='regNick' size=10 value='<?php echo $regObj->getNick(); ?>' class='textfield'></td>
			</tr>
			<tr>
				<td></td>
				<td><input type=submit value='Push!' class='buttons' ></td>
			</tr>
		</table>
			
		
		<input type='hidden' name='regPriv' value='pending'>
		<input type='hidden' name='flag' value='yes'>	
		
		</form><br>
		
		
	</div>


	<div id='reg'><a href='index.php'>:: Login ::</a></div>

	<br>

	<div width=100% align=right class='copyright'><font size=0 color=000080>Pavel Anisimov &copy 2007-13</font></div>

</div>

</body></html>