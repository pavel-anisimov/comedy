<?php
/**
 * widget for getting a voutig resonts for all joke setups and punchlines
 * TODO: implement isset to all $_GET[var] variables
 */
include '../CONST.php';

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if ($_GET[user])
	$userQ = " AND Users.nick= '" . $_GET[user] . "'";
if ($_GET[min])
	$scoreMin =  " AND TEMP.avg >= " . $_GET[min];
if ($_GET[max])
	$scoreMax =  " AND TEMP.avg < " . $_GET[max];
if ($_GET[from])
	$scoreFrom =  " AND TEMP.time > '" . $_GET[from] . "'";
if ($_GET[to])
	$scoreTo =  " AND TEMP.time < '" . $_GET[to] . "'";

$query = "
			SELECT Setup.line AS setup, TEMP.punchline, Users.nick, TEMP.avg, TEMP.votes, TEMP.time
			FROM ( 
				SELECT 	Punchline.uid AS uid, Punchline.sid AS sid, Punchline.line AS punchline,  
						Punchline.id AS pid, Punchline.timestamp AS time,
						COUNT(BrainstormVote.vote) AS votes, SUM(BrainstormVote.vote) AS sum, AVG(BrainstormVote.vote) AS avg
					FROM Punchline
						INNER JOIN BrainstormVote 
							ON  Punchline.id=BrainstormVote.pid 
			 		WHERE 1
					GROUP BY Punchline.line ) AS TEMP, Users, Setup
			WHERE Users.uid=TEMP.uid AND Setup.id=TEMP.sid AND Setup.id < 101 $user $scoreMin $scoreMax $scoreFrom $scoreTo
			ORDER BY TEMP.avg  DESC;
"; 


if ($result = $mysqli->query($query)) {
    while ($obj = $result->fetch_object()) {$num++; $id++;
		echo "<table width=500>";
		echo "<tr><td width=50>$num</td><td>" . $obj->setup . ".</td></tr>";
		echo "<tr><td>" . "</td><td>" . $obj->punchline . "</td></tr>";
		echo "<tr><td></td><td>AVG: <b>" . round($obj->avg, 2). "</b> Votes: " . $obj->votes . "</td></tr>";
		echo "</table><br>";
	}
	$result->close();
} 

$mysqli->close();
?>