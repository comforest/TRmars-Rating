$(document).ready(function(){
	$('#record').submit(function () {


		try{

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
			var credit = $("input[name='credit"+i+"']").val();

			if(nick.replace(" ", "").length == 0) break;
			if(score < 20){
				alert("정확한 점수를 입력하세요");
				return false;				
			}
			if(company == "-선택-"){
				alert("사용한 기업을 선택해 주세요");
				return false;				
			}
			arr[nick] = {"score" : score, "company" : company, "credit" : credit};
		}

		if(Object.keys(arr).length < 2){
			alert("플레이어 수가 부족합니다.")
			return false;
		}

		}catch(e){
			console.log(e);
		}



		$("input[type='submit']").prop('disabled', true);
		$("input[type='submit']").val("처리중");
		
		$.ajax({
			url:"AddRecord.php",
			type:"post",
			data:{type:type, round:round, data:arr},
			success:function(data){
				$("input[type='submit']").prop('disabled', false);
				$("input[type='submit']").val("등록");

				if(data["success"] == false){
					alert(data["msg"]);
				}else{
					location.href="/";
				}
			},
			error: function (request, status, error) {
				console.log('code: '+request.status+"\n"+'message: '+request.responseText+"\n"+'error: '+error);
			}
		});


		return false;
	});
})

function radio(group, index){
	$(".radio-group-" + group + ".active").removeClass("active");
	$(".radio-group-" + group + ":nth-child(" + index + ")").addClass("active");
}


