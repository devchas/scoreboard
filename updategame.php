<?php

require_once 'db.inc.php';
require 'record.func.php';
$connect = mysqli_connect(HOST, DB_USER, DB_PASS) or die('Could not connect to server' . mysqli_error());
mysqli_select_db($connect, DB_NAME);

//updates a game record and automatically updates the scoreboard
if (isset ($_GET['ID'])) {
	$id = $_GET['ID'];

	if (isset($_GET['game_list'], $_GET['player1'], $_GET['player2'], $_GET['player3'], $_GET['player4'])) {
		$game = $_GET['game_list'];
		$winner1 = $_GET['player1'];
		$winner2 = $_GET['player2'];
		$loser1 = $_GET['player3'];
		$loser2 = $_GET['player4'];
		
		$update = mysqli_query($connect, "UPDATE gamelog 
			SET game = '$game', 
				winner1 = '$winner1',
				winner2 = '$winner2',
				loser1 = '$loser1',
				loser2 = '$loser2'
			WHERE ID = '$id'");
	}

	if ($update) {
		updatescores ();
		$open = header("Location: http://fibroboard.com/edit.php?edit=$id");
	}	
}


?>