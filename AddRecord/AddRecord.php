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

	$columns = "";
	$values = "";
	$str = "";
	$ch = false;

	$index = 1;
	foreach($data as $key=>$value){
		$query = "SELECT id,rating from user WHERE nick = '$key'";
		if($result = $mysqli->query($query)){
			if($result->num_rows == 0){
				if($ch) $str .= ", ";
				$str .= $key;
				$ch = true;
			}else{
				$row = $result->fetch_array(MYSQLI_NUM);
				$data[$key]["id"] = $row[0];
				$data[$key]["rating"] = $row[1];
				$columns .= ",user$index,score$index,rating$index,company$index,rank$index";
				$values .= ",$row[0],$value[score],$row[1],'$value[company]',$value[rank]";
				++$index;
			}
		}
	}
	if($ch){
		$result = array("success"=>false, "msg" => $str."은 존재하지 않는 닉네임 입니다.");
		echo json_encode($result);
		return;
	}

	$query="INSERT INTO game_history(date,gameType,round) values(now(), '$type', $round)";
	$mysqli->query($query);
	$gameID = $mysqli->insert_id;

	$result = array("success"=>true);
	$index = 1;
	foreach($data as $k=>$v){
		$query = "INSERT INTO game_detail(game_id, user_id, turn, score, rank, prevRating, company)".
				"values($gameID, $v[id], $index, $v[score], $v[realrank], $v[rating], '$v[company]');";
		$mysqli->query($query);

		$query = "UPDATE user set rating = ".($v["rating"] + delta($k))." where id = $v[id];";		
		$mysqli->query($query);
		
		++$index;
		
	}

	echo json_encode($result);




	function delta($i){
		global $data;
		$n = count($data);
		return 32 * (($n-$data[$i]['rank'])/($n-1) - expected($i));
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
