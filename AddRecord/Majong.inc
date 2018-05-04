<script type="text/javascript">
$(document).ready(function(){
	for(var i = 1; i <= 4; ++i){
		$("input[name='score"+i+"']").change(calcTotalScore());
	}
	calcTotalScore();
});

function read(){
	var arr = {};
	for(var i = 1; i <= 4; ++ i){
		var nick = $("input[name='name"+i+"']").val();
		var score = parseInt($("input[name='score"+i+"']").val(), 10);
		if(isNaN(score)){
			score = 0;
		}
		
		if(nick.replace(" ", "").length == 0){
			alert("플레이어 수가 부족합니다");
			return false;
		}
		arr[nick] = {"score" : score, "turn" : i, "rank" : 1};
	}

	var score = $("#total_score").html();
	console.log(score);
	if(score == "1200"){
		for(var k in arr){
			arr[k]["score"] += -300;
		}
	}else if(score != "0"){
		alert("점수가 올바르지 않습니다.");
		return false;
	}


	getRank(arr, function(a, b){
		if(a["score"] < b["score"] || (a["score"] == b["score"] && a["turn"] > b["turn"])){
			return -1;
		}
		return 1;
	});

	uma = [200, 100, -100, -200];
	for(var k in arr){
		arr[k]["score"] += uma[arr[k]["rank"] - 1];
	}
	return {url: "addRecord_Accumulate.php", param : {"game":"Majong", "data":arr}};
}

function calcTotalScore(){
	var score = 0;
	for(var i = 1; i <= 4; ++i){
		var s = parseInt($("input[name='score"+i+"']").val());
		if(!isNaN(s)){
			score += s;
		}
	}
	$("#total_score").html(score);
}
</script>

<form id="record">
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
					점수(단위 : 100)
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$turnName = ["東", "南", "西", "北"];
			for($i = 1; $i <= 4; ++$i){
				echo "
				<tr>
				<td class='text-center'>
					".$turnName[$i-1]."
				</td>
				<td>
					<input type = 'text' class='form-control' name='name$i'>
				</td>
				<td>
					<input type = 'number' class='form-control' name='score$i' onchange='calcTotalScore()'>
				</td>
				</tr>
				";
			}
			?>
			<tr>
				<td></td>
				<td column="1">
					총 점수
				</td>
				<td id="total_score">
					
				</td>
			</tr>
		</tbody>
	</table>
	<input type="submit" class='form-control' value="등록">
	<br>
	<p class="text-center">총합이 1200 또는 0이 되면 됩니다.</p>
</form>
