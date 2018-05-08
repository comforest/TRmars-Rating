<script type="text/javascript">
function read(){
	var arr = {};
	for(var i = 1; i <= 4; ++ i){
		var nick = $("input[name='name"+i+"']").val();
		var score = $("input[name='score"+i+"']").val();
		var tie = $("input[name='tie"+i+"']").val();

		if(nick.replace(" ", "").length == 0){
			if(i <= 2){
				alert("플레이어 수가 부족합니다");
				return false;
			}
			break;
		}
		if(score == 0){
			alert("점수를 입력하세요");
			return false;				
		}
		arr[nick] = {"score" : score, "turn" : i, "tie" : tie, "rank" : 1};
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

	return {url: "addRecord_Rating.php", param : {"game":<?php echo "\"$_GET[game]\"" ?>, "data":arr}};
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
					점수
				</th>
				<th class = "col-sm-2 text-center">
					공동 순위 처리<br>(높은 점수 = 높은 등수)
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			for($i = 1; $i <= 4; ++$i){
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
					<input type = 'number' class='form-control' name='tie$i'>
				</td>
				</tr>
				";
			}
			?>
		</tbody>
	</table>
	<input type="submit" class='form-control' value="등록">
</form>
