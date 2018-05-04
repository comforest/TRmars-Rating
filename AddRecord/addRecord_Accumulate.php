<?php
header("Content-Type:application/json;charset=utf-8");

$data = $_POST["data"];
$game = $_POST["game"];

require "checkNick.php";

$q1 = "";
$q2 = "";
if(isset($_POST["type"])){
	$q1 .= ",gameType";
	$q2 .= ",'$_POST[type]'";
}
if(isset($_POST["round"])){
	$q1 .= ",round";
	$q2 .= ",".$_POST["round"];
}

include_once $_SERVER["DOCUMENT_ROOT"]."/php/mysqli.inc";
$query="INSERT INTO game_history(date,game $q1) values(now(), '$game' $q2)";
$mysqli->query($query);
$gameID = $mysqli->insert_id;

foreach($data as $k=>$v){
	$q1 = "";
	$q2 = "";
	if(isset($v["company"])){
		$q1 = ",company";
		$q2 = ",'$v[company]'";
	}
	$query = "INSERT INTO game_detail(game_id, user_id, turn, score, rank $q1) values($gameID, $v[id], $v[turn], $v[score], $v[rank] $q2);";
	$mysqli->query($query);

	$query = "UPDATE rating set rating = rating + $v[score] where user_id = $v[id] and game = '$game';";
	$mysqli->query($query);
}

$result = array("success"=>true);
echo json_encode($result);
?>
