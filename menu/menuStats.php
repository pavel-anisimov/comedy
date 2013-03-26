<?php
/**
 * Statistics Widget Displays statistics for submitted punchlines and setups 
 * by users. Should booost the morality of writers
 * TODO: Relace table tags with list or divs 
 */


if (basename(getcwd()) == 'menu') { 
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

	
	
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}



echo "<div id='idPunchStatLink' class='classStatLink'>$Words[39]</div>";

// Punchline Stats Starts
$statPunchQuery = "
		SELECT Users.nick AS Name, count(Punchline.id) AS Punchlines 
		FROM Users
		INNER JOIN Punchline ON Users.uid=Punchline.uid 
		WHERE Users.privileges = 'author' OR Users.privileges='admin'
		GROUP BY Users.nick
		ORDER BY Punchlines DESC, Name;
";
$count = 1;

echo "<div id='PunchStatTable'><table class='statTable'><tr><th class='statsTH'>$Words[36]</th><th  class='statsTH' id='statTH'>$Words[10]</th></tr>";
if ($result = $mysqli->query($statPunchQuery)) { 

    while ($obj = $result->fetch_object()) { $count ++;
   		echo "<tr class='StatTR" . ($count % 2). "'>"
        . "<td class='statTDLeft'>$obj->Name</td>"
        . "<td class='statTDRight' >$obj->Punchlines</td>"
   		. "</tr>";
    } $result->close();
} 
echo "</table></div>";			
// Punchline Stats End



echo "<div id='idSetupStatLink' class='classStatLink'>$Words[38]</div>";

 
// Setup Stats Starts
$statPunchQuery = "
		SELECT Users.nick AS Name, count(Setup.id) AS Setups 
		FROM Users
		INNER JOIN Setup ON Users.uid=Setup.uid 
		WHERE Users.privileges = 'author' OR Users.privileges='admin'
		GROUP BY Users.nick
		ORDER BY Setups DESC, Name;
";
$count = 1;

echo "<div id='SetupStatTable'><table class='statTable'><tr><th class='statsTH'>$Words[36]</th><th  class='statsTH' id='statTH'>$Words[37]</th></tr>";
if ($result = $mysqli->query($statPunchQuery)) { 

    while ($obj = $result->fetch_object()) { $count ++;
   		echo "<tr id='StatTR" . ($count % 2). "'>"
        . "<td class='statTDLeft'>$obj->Name</td>"
        . "<td class='statTDRight'>$obj->Setups</td>" 
   		. "</tr>";
    } $result->close();
} 
echo "</table></div>";			
// Setup Stats End



$mysqli->close();
?>