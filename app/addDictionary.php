<?php
session_start();

/**
 * Widget for adding new words into the dictionarry
 */
$user = $_SESSION['user'];
$pass = $_SESSION['pass'];


$eng = isset($_POST['english']) ? $_POST['english'] : "english";
$rus = isset($_POST['russian']) ? $_POST['russian'] : "russian";
$ukr = isset($_POST['ukrainian']) ? $_POST['ukrainian'] : "ukrainian";
 
$lang = $_GET['lang'];


include '../CONST.php';
include '../classes/classMySQL.php';

$mysqlQuery = new MysqlQuery(DB_HOST, DB_USER, DB_PASS, DB_NAME);


$time = date("Y-m-d H:i:s");

 
$dictionaryQuery = "INSERT INTO `Dictionary` (`english`, `russian`, `ukrainian`) VALUES ('$eng', '$rus', '$ukr');";

$mysqlQuery->execute("UPDATE `ComedyDB`.`Users` SET `time` = '" . time() .  "' WHERE `Users`.`uid` = '$userID' ;"); 

if (strlen($eng) > 2) {
	$mysqlQuery->execute($dictionaryQuery); 
	echo "Thank you";
}
 
?>

	<html>
		
		<head>
			<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
		</head>
		<body class='blue'>


			<form action='addDictionary.php' method='post'>\n
	 
	
				English: <input type='text' name='english' size=40 value=''><br>\n
				Russian: <input type='text' name='russian' size=40 value=''><br>\n
				Ukrainian: <input type='text' name='ukrainian' size=40 value=''><br>\n
				<input type='submit' value='OK'>\n
			</form>
			
		</body>
	</html>


 