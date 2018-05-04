<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/php/mysqli.inc";

$msg = "";
$ch = false;

foreach($data as $key=>$value){
	$query = "SELECT u.id, r.rating from user u Left Join rating r on u.id = r.user_id and r.game = '$game'	 WHERE nick = '$key';";
	if($result = $mysqli->query($query)){
		if($result->num_rows == 0){
			if($ch) $msg .= ", ";
			$msg .= $key;
			$ch = true;
		}else{
			$row = $result->fetch_array(MYSQLI_NUM);
			$data[$key]["id"] = $row[0];
			if($row[1] == null){
				if(!isset($default_rating)){
					$result = $mysqli->query("SELECT default_rating from game_info where eng_name = '$game'");
					$row1 = $result->fetch_array(MYSQLI_NUM);
					$default_rating = $row1[0];
				}
				$mysqli->query("INSERT INTO rating(user_id, game, rating) values($row[0], '$game', $default_rating);");
				$data[$key]["rating"] = $default_rating;
			}else{
				$data[$key]["rating"] = $row[1];
			}
		}
	}
}
if($ch){
	$result = array("success"=>false, "msg" => $msg."은 존재하지 않는 닉네임 입니다.");
	echo json_encode($result);
	exit;
}

?>
