<?php session_start() ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>VoDKa</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

	<link rel="stylesheet" href="/css/main.css">
</head>
<body>
	<?php
		include $_SERVER["DOCUMENT_ROOT"]."/php/nav.php";
	?>
	<script> $("#menu li:nth-child(1)").addClass("active"); </script>
	


	<section id="main">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>순위</th>
					<th>이름</th>
					<th>닉네임</th>
					<th>게임수</th>
					<th>레이팅</th>
				</tr>
			</thead>
			<tbody>
				<?php
				include_once $_SERVER["DOCUMENT_ROOT"]."/php/mysqli.inc";


				$date = "2018-3-1";
				$query = "SELECT u.name, u.nick, u.rating, count(d.game_id) as gameAmount from game_detail d INNer join game_history h on h.id = d.game_id and h.date > '$date'Right JOIN user u on u.id = d.user_id group by u.id order by rating desc, gameAmount desc, name desc;";
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
									<td>$row[rating]</td>
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
	</section>
</body>
</html>
