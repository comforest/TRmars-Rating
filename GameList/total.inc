<table class="table table-striped">
	<thead>
		<th class="col-sm-2">날짜</th>
		<th class="col-sm-2">플레이어 1</th>
		<th class="col-sm-2">플레이어 2</th>
		<th class="col-sm-2">플레이어 3</th>
		<th class="col-sm-2">플레이어 4</th>
		<th class="col-sm-2">플레이어 5</th>
	</thead>
	<tbody>
	<?php
		include_once $_SERVER["DOCUMENT_ROOT"]."/php/mysqli.inc";
		

		$query = "SELECT id, date, name from game_history inner join game_info on game = eng_name";
		if($result = $mysqli->query($query)){
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$datearr[$row["id"]]["date"] = $row["date"];
				$datearr[$row["id"]]["game"] = $row["name"];
			}
		}
		

		$query = "SELECT g.game_id, u.name, u.nick, g.rank, g.score, g.prevRating, g.company from game_detail g Inner join user u on u.id = g.user_id order by game_id desc, turn asc";
		if($result = $mysqli->query($query)){
			$gameID = -1;
			$index = 0;
			echo"<tr>";
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				if($gameID != $row["game_id"]){
					if(!isset($datearr[$row["game_id"]])){
						continue;
					}

					if($gameID != -1){ //prev row의 남은 칸 채우기
						while($index++ < 6){
							echo "<td></td>";
						}
						echo "</tr><tr>";
					}
					$index = 0;
					$gameID = $row["game_id"];
					echo "<td>".$datearr[$gameID]["date"]."<br>".$datearr[$gameID]["game"]."</td>";
				}

				echo "
				<td>
				<span class='name'>$row[name]</span>
				<span class='nick'>$row[nick]</span>
				(".round($row[prevRating], 2).")
				<br>
				$row[company]
				<br>
				$row[score]점 / $row[rank]등
				</td>
				";
				++$index;
			}

			while($index++ < 6){
				echo "<td></td>";
			}
			echo "</tr>";
		}
	?>
	</tbody>
</table>