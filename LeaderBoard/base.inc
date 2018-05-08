
<table class="table table-striped table-hover">
<thead>
	<tr>
		<th>순위</th>
		<th>이름</th>
		<th>닉네임</th>
		<th>게임수</th>
		<th>점수</th>
	</tr>
</thead>
<tbody>

	<?php

	include_once $_SERVER["DOCUMENT_ROOT"]."/php/mysqli.inc";
	$query = "SELECT u.name, u.nick, r.rating, count(d.game_id) as gameAmount from game_detail d Inner join game_history h on h.id = d.game_id and h.date > '$date' and h.game = '$game' Inner Join rating r on r.game = h.game and r.user_id = d.user_id Right join user u on u.id = d.user_id group by u.id, r.rating order by r.rating desc, gameAmount desc, name desc";

	if($result = $mysqli->query($query)){
		$rank = 1;
		$index = 1;
		$prevRating = 0;

		$notRegister = "";
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			if($prevRating != $row["rating"]){
				$rank = $index;
			}

			if($row["gameAmount"] > 0){
				echo "
					<tr>
						<td>$rank</td>
						<td>$row[name]</td>
						<td>$row[nick]</td>
						<td>$row[gameAmount]</td>
						<td>".round($row["rating"], 2)."</td>
					</tr>
				";

				++ $index;
				$prevRating = $row["rating"];
			}else{
				$notRegister .= "
					<tr>
						<td>-</td>
						<td>$row[name]</td>
						<td>$row[nick]</td>
						<td>$row[gameAmount]</td>
						<td>게임 기록 X</td>
					</tr>
				";
			}
		}//while

		echo $notRegister;
	}
	?>
	</tbody>
</table>
