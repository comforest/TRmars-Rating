<html>
<head>
	<meta charset="utf-8">
	<title>VoDKa</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

	<link rel="stylesheet" href="/css/main.css">
	<script type="text/javascript" src="gamelist.js"></script>
</head>
<body>
	<?php
		include $_SERVER["DOCUMENT_ROOT"]."/php/nav.php";
	?>
	<script> $("#menu li:nth-child(4)").addClass("active"); </script>

	<section id="main">

		<?php
		if(isset($_GET["gameid"])){
		?>

		<label style="float:right" > <input id="viewNick" type="checkbox"> 닉네임으로 보기</label>
		<table class="table table-striped">
			<thead>
				<th class="col-sm-1">날짜</th>
				<th class="col-sm-2">플레이어 1</th>
				<th class="col-sm-2">플레이어 2</th>
				<th class="col-sm-2">플레이어 3</th>
				<th class="col-sm-2">플레이어 4</th>
				<th class="col-sm-2">플레이어 5</th>
			</thead>
			<tbody>
			<?php
				include_once $_SERVER["DOCUMENT_ROOT"]."/php/mysqli.inc";
				

				$gameInfo = $_GET["gameid"]; 
				$datearr = [];
				$query = "SELECT id, date from game_history where game_id = $gameInfo";
				if($result = $mysqli->query($query)){
					while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
						$datearr[$row["id"]] = $row["date"];
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
							echo "<td>$datearr[$gameID]</td>";
						}

						echo "
						<td>
						<span class='name'>$row[name]</span>
						<span class='nick'>$row[nick]</span>
						($row[prevRating])
						<br>
						$row[company]
						<br>
						$row[score] / $row[rank]등
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
		<?php
		}else{
			include_once $_SERVER["DOCUMENT_ROOT"]."/php/chooseGame.php";
		}
		?>
	</section>

</body>
</html>