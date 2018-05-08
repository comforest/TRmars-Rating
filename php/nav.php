<nav class="navbar navbar-inverse navbar-static-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>                        
			</button>
			<span class="navbar-brand">Rating System</span>
		</div>
		<ul id="menu" class="nav navbar-nav">
			<?php
				$param = "";
				if(isset($_GET["game"])){
					$param = "game=$_GET[game]";
				}

				if(strlen($param) != 0){
					$param = "?".$param;
				}
			
			echo"
			<li><a href='/$param'>Main</a></li>
			<li><a href='/AddRecord$param'>Add Record</a></li>
			<li><a href='/Register$param'>Register</a></li>
			<li><a href='/GameList$param'>Game List</a></li>
			<li><a href='/GameData$param'>Game Data</a></li>
			"
			?>
		</ul>

		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">게임 선택 <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<?php
						include_once $_SERVER["DOCUMENT_ROOT"]."/php/mysqli.inc";
						$result = $mysqli->query("SELECT name, eng_name FROM game_info;");
						if($result){
							while($row = $result->fetch_array(MYSQLI_ASSOC)){
								$url = $_SERVER["REQUEST_URI"];
								$url = substr($url, 0, strpos($url, '?'));
								print "<li><a href='$url?game=$row[eng_name]'> $row[name] </a></li>";
							}
						}
					?>
				</ul>
			</li>
		</ul>
      
	</div><!-- /.container-fluid -->

</nav>