<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link type="text/css" rel="stylesheet" href="main.css" />
	<title>FI Bro Board</title>
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
	  $(".beerpong").click(function(){
		$(".bplog").show();
		$(".kjlog").hide();
		$(".sblog").hide();
	  });
	  $(".kanjam").click(function(){
		$(".bplog").hide();
		$(".kjlog").show();
		$(".sblog").hide();
	  });
	  $(".spikeball").click(function(){
		$(".bplog").hide();
		$(".kjlog").hide();
		$(".sblog").show();
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
<?php

require_once 'db.inc.php';
require 'score.func.php';
include 'elements.php';
$connect = mysqli_connect(HOST, DB_USER, DB_PASS) or die('Could not connect to server' . mysqli_error());
mysqli_select_db($connect, DB_NAME);

if (isset ($_GET['edit'])) {
	$id = $_GET['edit'];
}
?>
<div>
<h1><a href="http://fibroboard.com">THE BRO BOARD</a></h1>
<a href="http://fibroboard.com" class="return">Return Home</a><br>
<p class="exist">Exiting Result:</p>
	<?php idgamelog($id); ?>
</div>

<?php

if (!($result = @ mysqli_query($connect, "SELECT * FROM gamelog WHERE ID='$id'"))) {
	showerror();
}
while ($gamerow = mysqli_fetch_array($result)) {
	$game = $gamerow['game'];
	$winner1 = $gamerow['winner1'];
	$winner2 = $gamerow['winner2'];
	$loser1 = $gamerow['loser1'];
	$loser2 = $gamerow['loser2'];
}

?>
<form action="updategame.php" id="game_log" method="get">
	<input type="hidden" name="ID" value="<?php echo $id ?>">
	<table  class="entry">		
	<tr>
	<th colspan="4">Change to this result:</th>
	<tr/>
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
				echo '<option value ="' . $game_row['GAME'] . '" select="selected">' . $game_row['GAME'] . '</option>';
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
	players ($players);
	?>
	</select>
	</td>

	<td>
	<select name="player3" form="game_log">
	<?php
	$players = mysqli_query($connect, "SELECT * FROM users ORDER BY UserName");
	players ($players);
	?>
	</select>

	<select name="player4" form="game_log">
	<?php
	$players = mysqli_query($connect, "SELECT * FROM users ORDER BY UserName");
	players ($players);
	?>
	</select>
	</td>
	</tr>
	</table><br>	
	<input type="submit" class="button">
</form>
<br><a href="delete.php?delete=<?php echo $id; ?>">Delete Game</a>
</body>
</html>