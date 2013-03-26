<?php
/**
 * File holding constants. 
 * It is in the process of refactoring into a class
 * It holds most of the constants, like DB access data, timezone etc.
 */
final class Constants {
    const DB_HOST = 'localhost';
    const DB_USER = 'ComedyDB';
    const DB_PASS = 'SFComedy2013';
    const DB_NAME = 'ComedyDB';
    const DB_BASE = 'comedy';

}

date_default_timezone_set ('America/Los_Angeles');

 

$host = $_SERVER['HTTP_HOST']; 
$db_host = 'localhost';
$db_user = 'ComedyDB';
$db_pass = 'SFComedy2013!';
$db_name = 'ComedyDB';

define ("DB_HOST", 'localhost');
define ("DB_USER", 'ComedyDB');
define ("DB_PASS", 'SFComedy2013!');
define ("DB_NAME", 'ComedyDB');
define ("BASE", 'comedy');
define ("HOST", $_SERVER['HTTP_HOST']);

$base = 'comedytest';


$os = "Android";
$user_sys = $_SERVER['HTTP_USER_AGENT']; 

$phpSelf = $_SERVER['PHP_SELF'];

if (strpos($phpSelf, "action"))
	$dir = "../";
else 
	$dir = "./";



?>
