<?php
session_start();    
/**
 * adding a query into database to store in a database for record keeping
 */
$pass = $_SESSION['pass'];
$query = $_GET['query'];
$flag = $_GET['exec'];
$lang = $_GET['lang'];


include '../CONST.php';
include '../classMySQL.php';


$mysqlQuery = new MysqlQuery($db_host, $db_user, $db_pass, $db_name);

$mysqlQuery->verify();

if (strlen($query) > 5) {
	$mysqlQuery->execute($query);
	echo "Query: " . $query . "<br>";
}


?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<form method='get' action='addQuery.php?exec=TRUE'>
			<textarea rows=10 cols=80 name='query'><?= $query ?></textarea><br>
			<input type='submit' value='Push!' class='buttons'>
		</form>
		
	</body>
</html>