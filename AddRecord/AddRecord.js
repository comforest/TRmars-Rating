$(document).ready(function(){
	$('#record').submit(function () {

		try{
		var data = read();
		if(data == false) return false;
		if(Object.keys(data["param"]["data"]).length < 2){
			alert("플레이어 수가 부족합니다.")
			return false;
		}

		$("input[type='submit']").prop('disabled', true);
		$("input[type='submit']").val("처리중");

		$.ajax({
			url: data["url"],
			type:"post",
			data: data["param"],
			success:function(result){
				$("input[type='submit']").prop('disabled', false);
				$("input[type='submit']").val("등록");

				if(result["success"] == false){
					alert(result["msg"]);
				}else{
					location.href="/?gameid="+data["param"]["gameid"];
				}
			},
			error: function (request, status, error) {
				console.log('code: '+request.status+"\n"+'message: '+request.responseText+"\n"+'error: '+error);
			}
		});

		}catch(e){
			console.log(e.lineNumber + " " +e.message);
		}
			
		return false;

	});
});

function getRank(arr, comp){
	for(var k in arr){
		for(var i in arr){
			if(k == i) continue;
			if(comp(arr[k], arr[i]) == -1){
				arr[k]["rank"] += 1;
			}
		}
	}
}