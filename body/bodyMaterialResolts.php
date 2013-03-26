<?
/**
 * Obsolete file.
 * Is used as an example
 */
include_once '../CONST.php';

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

 

$query = "	   SELECT Archive.id, Archive.text,  Archive.type, COUNT(MaterialVote.vote) as votes , AVG(MaterialVote.vote) as avg "
			. "FROM Archive INNER JOIN MaterialVote ON Archive.id=MaterialVote.mid "
			. "GROUP BY Archive.id "
			. "ORDER BY avg DESC"; 
$num = $id = 0;

if ($result = $mysqli->query($query)) {
    while ($obj = $result->fetch_object()) {$num++; $id++;
		echo "<hr noshade color=#000080><table width=500>";
		echo "<tr><td width=50 valign=top>$num</td><td>" . newLine($obj->text) . "</td></tr>";
		echo "<tr><td></td><td>TYPE: <b>" . $obj->type . "</b> AVG: <b>" . round($obj->avg, 2). "</b> Votes: " . $obj->votes . "</td></tr>";
		echo "</table> ";
	}
	$result->close();
} 

$mysqli->close();




?>