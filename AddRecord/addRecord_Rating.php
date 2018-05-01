<?php
header("Content-Type:application/json;charset=utf-8");

$data = $_POST["data"];
$game = $_POST["gameid"];

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
$query="INSERT INTO game_history(date,game_id $q1) values(now(),$game $q2)";
$mysqli->query($query);
$gameID = $mysqli->insert_id;

foreach($data as $k=>$v){
	$q1 = "";
	$q2 = "";
	if(isset($v["company"])){
		$q1 = ",company";
		$q2 = ",'$v[company]'";
	}
	$query = "INSERT INTO game_detail(game_id, user_id, turn, score, rank, prevRating $q1) values($gameID, $v[id], $v[turn], $v[score], $v[rank], $v[rating] $q2);";
	$mysqli->query($query);

	$query = "UPDATE rating set rating = rating + ".delta($k)." where user_id = $v[id] and game_id = $game;";
	$mysqli->query($query);
}

$result = array("success"=>true);
echo json_encode($result);




function delta($i){
	global $data;
	$n = count($data);
	return 32.0 * (($n-$data[$i]['rank'])/($n-1.0) - expected($i));
}

function expected($i){
	global $data;
	$sum = 0.0;
	$n = count($data);
	foreach($data as $k => $v){
		if($i == $k) continue;
		$sum += winProbability($data[$i]["rating"],$v["rating"]);
	}
	return $sum/($n-1);
}

// winProbability
// data -	r1 : 자기 rating
//			r2 : 상대 rating
function winProbability($r1, $r2){
	$n = 1.0/(1+(pow(10,($r2 - $r1)/400)));
	return $n;
}

?>
