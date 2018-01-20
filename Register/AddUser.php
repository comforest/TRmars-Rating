<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/php/mysqli.inc";
$name = $_POST["name"];
$nick = $_POST["nickname"];

$query = "SELECT * FROM user WHERE nick = '$nick'";
if($result = $mysqli->query($query)){
	if($result->num_rows > 0){
		print 0;
		exit();
	}
}

$query = "INSERT INTO user(name, nick) values('$name', '$nick')";
$mysqli->query($query);
print $query;
?>