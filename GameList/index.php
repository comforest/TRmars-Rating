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

		<label style="float:right" > <input id="viewNick" type="checkbox">닉네임으로 보기</label>
		<?php
		if(isset($_GET["game"])){
			echo '<a href= "/GameList" style="float:right;margin-right:10px;"> <label>전체 보기 </label></a>';
			require "$_GET[game].inc";
		}else{
			require "total.inc";
		}
		?>
	</section>

</body>
</html>