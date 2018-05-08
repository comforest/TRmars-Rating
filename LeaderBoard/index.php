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
		<?php
		if(isset($_GET["game"])) {
			$date = "2018-3-1";
			$game = $_GET["game"];
	
			include $_GET["game"].".inc";
		}else{
			include_once $_SERVER["DOCUMENT_ROOT"]."/php/chooseGame.php";
		}
		?>
	</section>

</body>
</html>
