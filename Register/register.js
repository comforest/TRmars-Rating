function addUser(){
	var nameDiv = $("#namediv");
	var nickDiv = $("#nickdiv");

	nameDiv.removeClass("has-error");
	$("#nameHelp").text("");
	nickDiv.removeClass("has-error");
	$("#nickHelp").text("");

	var name = $("input[name='name']").val();
	var nick = $("input[name='nickname']").val();

	var ch = true;
	if(name.length == 0){
		nameDiv.addClass("has-error");
		$("#nameHelp").text("이름을 입력해주세요");
		ch = false;
	}else if(name.length >= 10){
		nameDiv.addClass("has-error");
		$("#nameHelp").text("이름이 너무 깁니다.");		
		ch = false;
	}

	if(nick.length == 0){
		nickDiv.addClass("has-error");
		$("#nickHelp").text("닉네임을 입력해주세요");
		ch = false;
	}else if(name.length >= 10){
		nickDiv.addClass("has-error");
		$("#nickHelp").text("닉네임이 너무 깁니다.");
		ch = false;
	}

	if(ch == false){
		return;
	}

	$.ajax({
		url:"AddUser.php",
		type:"post",
		data:{name:name, nickname:nick},
		success:function(data){
			if(data == false){
				nickDiv.addClass("has-error");
				$("#nickHelp").text("닉네임이 이미 존재합니다.");
			}else{
				window.location.href = "/";
			}
		}
	});
}