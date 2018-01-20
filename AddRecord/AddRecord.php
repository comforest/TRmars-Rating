<?php
	header("Content-Type:application/json;charset=utf-8");

	include_once $_SERVER["DOCUMENT_ROOT"]."/php/mysqli.inc";

	$type = $_POST["type"];
	$round = $_POST["round"];
	$data = $_POST["data"];

	$rank = $data;
	uasort($rank, 'cmp');


	$rankIndex = 0;
	$realIndex = 1;
	$prevValue;
	foreach($rank as $nick => $value){
		if($rankIndex == 0){
			$rankIndex = 1;
		}else if(!($prevValue["score"] == $value["score"] && $prevValue["credit"] == $value["credit"])){
			$rankIndex = $realIndex;
		}

		$data[$nick]["rank"] = $rankIndex;
		++$realIndex;
		$prevValue = $value;
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
				$str .= $value["nick"];
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

	$query="INSERT INTO gameHistory(date,gameType,round$columns) values(now(), '$type', $round$values)";
	$mysqli->query($query);
	

	$result = array("success"=>true, "msg" => $query);


	foreach($data as $k => $v){
		$query = "UPDATE user set rating = $v[rating] + ".delta($k)." where id = $v[id]";
		$mysqli->query($query);
	}

	echo json_encode($result,JSON_UNESCAPED_UNICODE);




	function delta($i){
		global $data;
		$n = count($data);
		return 100.0 * (($n-$data[$i]['rank'])/($n-1) - expected($i));
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
		$n = 1.0/(1+(pow(10,($r2 - $r1)/500)));
		return $n;
	}

	function cmp($a, $b){
		if($b["score"] == $a["score"]){
			return $a["credit"] > $b["credit"] ? -1 : 1;
		}
		return $a["score"] > $b["score"] ? -1 : 1;
	}
?>