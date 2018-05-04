<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>                        
			</button>
			<span class="navbar-brand">Vodka</span>
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
	</div><!-- /.container-fluid -->
</nav>
