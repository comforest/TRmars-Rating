$(document).ready(function(){
	$("#viewNick").change(switchNameNick);
	switchNameNick();
});


function switchNameNick(){
	var ch = $("#viewNick").is(":checked");
	if(ch){
		viewNick();
	}else{
		viewName();
	}
}

function viewName(){
	$(".name").show();
	$(".nick").hide();
}

function viewNick(){
	$(".nick").show();
	$(".name").hide();
}