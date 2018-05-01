<!-- 테라포밍 마스 기록 추가 HTML -->
<script type="text/javascript">

function read(){
	var type = $(".radio-group-0.active").text();
	var round = $(".radio-group-1.active").text();

	if(type == ""){
		alert("플레이한 게임 맵을 선택해 주세요");
		return false;
	}
	if(round == ""){
		alert("진행한 라운드 수를 선택해 주세요");
		return false;
	}

	var arr = {};
	
	for(var i = 1; i <= 5; ++ i){
		var nick = $("input[name='name"+i+"']").val();
		var score = $("input[name='score"+i+"']").val();
		var company = $("select[name='company"+i+"']").val();
		var tie = $("input[name='tie"+i+"']").val();

		if(nick.replace(" ", "").length == 0) break;
		if(score < 20){
			alert("정확한 점수를 입력하세요");
			return false;				
		}
		if(company == "-선택-"){
			alert("사용한 기업을 선택해 주세요");
			return false;				
		}
		arr[nick] = {"score" : score, "company" : company, "tie" : tie, "turn" : i, "rank" : 1};
	}

	getRank(arr, function(a, b){
		if(a["score"] < b["score"] || (a["score"] == b["score"] && a["tie"] < b["tie"])){
			return -1;
		}
		return 1;
	});

	for(var k  in arr){
		delete arr[k]["tie"];
	}
	
	return {url: "addRecord_Rating.php", param : {"gameid":1, "type":type, "round":round, "data":arr}};
}

function radio(group, index){
	$(".radio-group-" + group + ".active").removeClass("active");
	$(".radio-group-" + group + ":nth-child(" + index + ")").addClass("active");
}
</script>

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
					<button type="button" class="btn btn-default radio-group-0" onclick="radio(0, 3)">초록</button>
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
				<th class = "col-sm-1 text-center">
					순서
				</th>
				<th class = "col-sm-3 text-center">
					닉네임
				</th>
				<th class = "col-sm-2 text-center">
					점수
				</th>
				<th class = "col-sm-4 text-center">
					사용 기업
				</th>
				<th class = "col-sm-2 text-center">
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
					<input type = 'number' class='form-control' name='tie$i'>
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
