<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/php/mysqli.inc";
$query = "SELECT name, eng_name from game_info";
if($result = $mysqli->query($query)){
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		echo "<a href='$_SERVER[REQUEST_URI]?game=$row[eng_name]'> $row[name] </a><br>";
	}
}
?>