<?php

require_once 'db.inc.php';
require 'elements.php';
$connect = mysqli_connect(HOST, DB_USER, DB_PASS) or die('Could not connect to server' . mysqli_error());
mysqli_select_db($connect, DB_NAME);

?>

<!DOCTYPE html>
<html>
<link type="text/css" rel="stylesheet" href="main.css "/>
<head>
	<title>Bro Board</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script>
	$(document).ready(function(){
		$(".golog").show();
		$(".goscore").hide();
		$(".goenter").hide();
		$(".bplog").show();
		$(".kjlog").hide();
		$(".sblog").hide();
		$(".comms").hide();
		$(".bprank").show();
		$(".kjrank").hide();
		$(".sbrank").hide();
	  $(".beerpong").click(function(){
		$(".bplog").show();
		$(".kjlog").hide();
		$(".sblog").hide();
		$(".bprank").show();
		$(".kjrank").hide();
		$(".sbrank").hide();	
	  });
	  $(".kanjam").click(function(){
		$(".bplog").hide();
		$(".kjlog").show();
		$(".sblog").hide();
		$(".bprank").hide();
		$(".kjrank").show();
		$(".sbrank").hide();
	  });
	  $(".spikeball").click(function(){
		$(".bplog").hide();
		$(".kjlog").hide();
		$(".sblog").show();
		$(".bprank").hide();
		$(".kjrank").hide();
		$(".sbrank").show();
	  });
	  $(".lognav").click(function(){
		$(".golog").show();
		$(".goscore").hide();
		$(".goenter").hide();

	  });
	  $(".scorenav").click(function(){
		$(".golog").hide();
		$(".goscore").show();
		$(".goenter").hide();

	  });
	  $(".enternav").click(function(){
		$(".golog").hide();
		$(".goscore").hide();
		$(".goenter").show();

	  });	  	  
	  $(".commsbutton").click(function(){
		$(".comms").toggle();
		
	  });		  
	});
	</script>
	</head>
<body>
<div id="nav">
	<h1>THE BRO BOARD</h1>
	<button class="lognav">Game Log</button>
	<button class="scorenav">Scoreboard</button>
	<button class="enternav">Enter Game</button>
</div>
<div id="inputs" class="goenter">
<h2>Enter Game Result:</h2>
<form action="recordgame.php" id="game_log" method="get">
<table class="entry">	
	<tr>
	<th>Game</th>
	<th>Winners</th>
	<th>Losers</th>
	<th></th>
	</tr>
	<tr>
	<td>
	<select name="game_list" form="game_log">
		<?php
			$games = mysqli_query($connect, "SELECT * FROM games ORDER BY GAME");
			while($game_row = mysqli_fetch_array($games)) {
				echo '<option value ="' . $game_row['GAME'] . '">' . $game_row['GAME'] . '</option>';
			}
		?>
	</select>
	</td>
	
	<td>
	<select name="player1" form="game_log">		
	<?php
	$players = mysqli_query($connect, "SELECT * FROM users ORDER BY UserName");
	while($player_row = mysqli_fetch_array($players)) {
			echo '<option value ="' . $player_row['UserName'] . '">' . $player_row['UserName'] . '</option>';
	}
	?>
	</select>
	
	<select name="player2" form="game_log">
	<?php
	$players = mysqli_query($connect, "SELECT * FROM users ORDER BY UserName");
	while($player_row = mysqli_fetch_array($players)) {
			echo '<option value ="' . $player_row['UserName'] . '">' . $player_row['UserName'] . '</option>';
	}
	?>
	</select>
	</td>

	<td>
	<select name="player3" form="game_log">
	<?php
	$players = mysqli_query($connect, "SELECT * FROM users ORDER BY UserName");
	while($player_row = mysqli_fetch_array($players)) {
			echo '<option value ="' . $player_row['UserName'] . '">' . $player_row['UserName'] . '</option>';
	}
	?>
	</select>

	<select name="player4" form="game_log">
	<?php
	$players = mysqli_query($connect, "SELECT * FROM users ORDER BY UserName");
	while($player_row = mysqli_fetch_array($players)) {
			echo '<option value ="' . $player_row['UserName'] . '">' . $player_row['UserName'] . '</option>';
	}
	?>
	</select>
	</td>
	</tr>
</table><br>
<input type="submit" class="button">
</form>
</div>
<div id="leaderboard" class="goscore">
	<div id="selectors">
		<button class="beerpong">Beer Pong</button>
		<button class="kanjam">KAN JAM</button>
		<button class="spikeball">Spikeball</button>
	</div>
	<h2>Individual Leaderboard</h2>
	<div class="bprank"><h2 class="title">Beer Pong</h2><?php leaderboard('Beer Pong'); ?><br></div>
	<div class="kjrank"><h2 class="title">KAN JAM</h2><?php leaderboard('KAN JAM'); ?><br></div>
	<div class="sbrank"><h2 class="title">Spikeball</h2><?php leaderboard('Spikeball'); ?><br></div>
	<!-- <b>Total Leaderboard:</b><?php leaderboard('Total'); ?><br> -->
	
	<h2>Team Leaderboard</h2>
	<div class="bprank"><h2 class="title">Beer Pong</h2><?php teamboard('Beer Pong'); ?><br></div>
	<div class="kjrank"><h2 class="title">KAN JAM</h2><?php teamboard('KAN JAM'); ?><br></div>
	<div class="sbrank"><h2 class="title">Spikeball</h2><?php teamboard('Spikeball'); ?><br></div>
	<!-- <b>Total Leaderboard:</b><?php teamboard('Total'); ?><br> -->
	
</div>
<div id="logs" class="golog">
	<div id="selectors">
		<button class="beerpong">Beer Pong</button>
		<button class="kanjam">KAN JAM</button>
		<button class="spikeball">Spikeball</button>
	</div>
	<!-- <div><h2>All Games:</h2><?php allgamelog(); ?></div> -->
	<div class="bplog"><h2 class="title">Beer Pong</h2><?php gamelog('Beer Pong'); ?></div>
	<div class="kjlog"><h2 class="title">KAN JAM</h2><?php gamelog('KAN JAM'); ?></div>
	<div class="sblog"><h2 class="title">Spikeball</h2><?php gamelog('Spikeball'); ?></div>
</div>
<?php mysqli_close($connect) ?>
</body>
</htm