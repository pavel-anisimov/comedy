<?php
/**
 * A language select file.
 * Accesses a data base and loads languages into an array to accessed throu out the pages
 * NOTE: Using an outdated mysql_connect(). Should be replaed by MySQLi class
 * Access to a DB is sql injection protected.
 * 
 */

isset($_GET['lang']) ? $lang = $_GET['lang'] : $lang = 'russian';

if ($lang != 'english' AND $lang != 'ukrainian')
	$lang = 'russian';

 

$Words = array();

$con = mysql_connect(DB_HOST, DB_USER, DB_PASS);
if (!$con) {
	die('Could not connect: ' . mysql_error());
} 
mysql_select_db($db_name);


$word_query = "SELECT Dictionary.wid AS id, Dictionary." . $lang . " AS word FROM Dictionary;";

 

$result = mysql_query($word_query);


while($row = mysql_fetch_object($result)){
	$Words[$row->id] = $row->word; 	
};

mysql_close($con);  


?>
