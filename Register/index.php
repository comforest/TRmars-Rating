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
	<script type="text/javascript" src="register.js"></script>
</head>
<body>
	<?php
		include $_SERVER["DOCUMENT_ROOT"]."/php/nav.php";
	?>
	<script> $("#menu li:nth-child(3)").addClass("active"); </script>
	


	<section id="main">
		<form onsubmit="addUser(); return false;">
			<div id="namediv">
				<label>이름</label>
				<input type="text" class="form-control" name="name">
				<span id="nameHelp" class="help-block"></span>
			</div>
			<br>
			<div id="nickdiv">
				<label>닉네임</label>
				<input type="text" class="form-control" name="nickname">
				<span id="nickHelp" class="help-block"></span>
			</div>
			<br>
			<input type="submit" class="form-control">
		</form>
	</section>
</body>
</html>