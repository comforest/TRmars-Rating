<?php
header("Content-Type:application/json;charset=utf-8");

include_once $_SERVER["DOCUMENT_ROOT"]."/php/mysqli.inc";

$type = $_POST["type"];
$round = $_POST["round"];
$data = $_POST["data"];

$rank = $data;
uasort($rank, 'cmp');


$rankarr = [];
$start = 1;
$amount = 0;
$prevValue = array("score"=>PHP_INT_MIN, "credit"=>PHP_INT_MIN);
$index = 0;
foreach($rank as $nick => $value){
	if(!($prevValue["score"] == $value["score"] && $prevValue["credit"] == $value["credit"])){
		$amount /= $index - $start;
		for($i = $start; $i < $index; ++$i){
			$rankarr[$i] = $amount;
		}
		$amount = 0;
		$start = $index;
	}
	++$index;

	$data[$nick]["realrank"] = $start + 1;
	$prevValue = $value;
	$amount += $index;
}
$amount /= $index - $start;
for($i = $start; $i < $index; ++$i){
	$rankarr[$i] = $amount;
}

$index = 0;
foreach($rank as $nick => $value){
	$data[$nick]["rank"] = $rankarr[$index];
	++$index;
}

$str = "";
$ch = false;

$index = 1;
$gameID = 1;
$defaultRating = 500;
foreach($data as $key=>$value){
	$query = "SELECT u.id, r.rating from user u Left Join rating r on u.id = r.user_id and r.game_id = $gameID WHERE nick = '$key'";
	if($result = $mysqli->query($query)){
		if($result->num_rows == 0){
			if($ch) $str .= ", ";
			$str .= $key;
			$ch = true;
		}else{
			$row = $result->fetch_array(MYSQLI_NUM);
			$data[$key]["id"] = $row[0];
			if($row[1] == null){
				$data[$key]["rating"] = $defaultRating;
				$mysqli->query("INSERT INTO rating(user_id, game_id, rating) values($row[0], $gameID, $defaultRating)");
			}else{
				$data[$key]["rating"] = $row[1];
			}
			++$index;
		}
	}
}
if($ch){
	$result = array("success"=>false, "msg" => $str."은 존재하지 않는 닉네임 입니다.");
	echo json_encode($result);
	return;
}

$query="INSERT INTO game_history(date,gameType,round,game_id) values(now(), '$type', $round, $gameID)";
$mysqli->query($query);
$gameID = $mysqli->insert_id;

$result = array("success"=>true);
$index = 1;
foreach($data as $k=>$v){
	$query = "INSERT INTO game_detail(game_id, user_id, turn, score, rank, prevRating, company)".
			"values($gameID, $v[id], $index, $v[score], $v[realrank], $v[rating], '$v[company]');";
	$mysqli->query($query);

	$query = "UPDATE rating set rating = ".($v["rating"] + delta($k))." where user_id = $v[id] and game_id = $gameID;";		
	$mysqli->query($query);
	
	++$index;
	
}

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

function cmp($a, $b){
	if($b["score"] == $a["score"]){
		return $a["credit"] > $b["credit"] ? -1 : 1;
	}
	return $a["score"] > $b["score"] ? -1 : 1;
}
?>
