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
	<script type="text/javascript" src="AddRecord.js"></script>
</head>
<body>
	<?php
		include $_SERVER["DOCUMENT_ROOT"]."/php/nav.php";
	?>
	<script> $("#menu li:nth-child(2)").addClass("active"); </script>
	


	<section id="main">
		<form id="record">
			<table>
				<tr>
					<td width="100px">
						<label>사용한 맵</label>
					</td>
					<td>
						<div class="btn-group" role="group">
							<button type="button" class="btn btn-default radio-group-0" onclick="radio(0, 1)">주황</button>
							<button type="button" class="btn btn-default radio-group-0" onclick="radio(0, 2)">파랑</button>
							<button type="button" class="btn btn-default radio-group-0" onclick="radio(0, 3)">빨강</button>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<label>게임 라운드</label>
					</td>
					<td>
						<div class="btn-group" role="group">
							<button type="button" class="btn btn-default radio-group-1" onclick="radio(1, 1)">7</button>
							<button type="button" class="btn btn-default radio-group-1" onclick="radio(1, 2)">8</button>
							<button type="button" class="btn btn-default radio-group-1" onclick="radio(1, 3)">9</button>
							<button type="button" class="btn btn-default radio-group-1" onclick="radio(1, 4)">10</button>
							<button type="button" class="btn btn-default radio-group-1" onclick="radio(1, 5)">11</button>
							<button type="button" class="btn btn-default radio-group-1" onclick="radio(1, 6)">12</button>
							<button type="button" class="btn btn-default radio-group-1" onclick="radio(1, 7)">13</button>
						</div>
					</td>
				</tr>
			</table>
			<br>
			<table class="table">
				<thead>
					<tr>
						<th class = "col-sm-1">
							순서
						</th>
						<th class = "col-sm-3">
							닉네임
						</th>
						<th class = "col-sm-2">
							점수
						</th>
						<th class = "col-sm-4">
							사용 기업
						</th>
						<th class = "col-sm-2">
							남은 크레딧<br>(동점 시 기입)
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
					for($i = 1; $i <= 5; ++$i){
						echo "
						<tr>
						<td class='text-center'>
							$i
						</td>
						<td>
							<input type = 'text' class='form-control' name='name$i'>
						</td>
						<td>
							<input type = 'number' class='form-control' name='score$i'>
						</td>
						<td>
							<select class='form-control' name='company$i'>
								<option>-선택-</option>
								<option>UNMI</option>
								<option>마이닝 길드</option>
								<option>새턴 시스템</option>
								<option>시네마틱스</option>
								<option>에코라인</option>
								<option>인벤트릭스</option>
								<option>크레디코</option>
								<option>타르시스</option>
								<option>테렉터</option>
								<option>토르게이트</option>
								<option>포볼로그</option>
								<option>헬리온</option>
							</select>
						</td>
						<td>
							<input type = 'number' class='form-control' name='credit$i'>
						</td>
						</tr>
						";
					}
					?>
					<tr>
					</tr>
				</tbody>
			</table>
			<input type="submit" class='form-control' value="등록">
		</form>
	</section>
</body>
</html>