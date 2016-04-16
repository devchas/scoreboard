<?php

require_once 'db.inc.php';
require 'record.func.php';
$connect = mysqli_connect(HOST, DB_USER, DB_PASS) or die('Could not connect to server' . mysqli_error());
mysqli_select_db($connect, DB_NAME);

//post game to gamelog table and update results in user table
if (isset($_GET['game_list'], $_GET['player1'], $_GET['player2'], $_GET['player3'], $_GET['player4'])) {	
	$game = $_GET['game_list'];
	$winner1 = $_GET['player1'];
	$winner2 = $_GET['player2'];
	$loser1 = $_GET['player3'];
	$loser2 = $_GET['player4'];

	$winnerteam = $winner1 . ' & ' . $winner2;
	$winnersvar = $winner2 . ' & ' . $winner1;
	$loserteam = $loser1 . ' & ' . $loser2;
	$losersvar = $loser2 . ' & ' . $loser1;
	
	$insert = mysqli_query($connect, "INSERT INTO gamelog (game, winner1, winner2, loser1, loser2, winnerteam, winnersvar, loserteam, losersvar) VALUES ('$game', '$winner1', '$winner2', '$loser1', '$loser2', '$winnerteam', '$winnersvar', '$loserteam', '$losersvar')");
	if ($insert) {
		updatescores ();
		$open = header("Location: http://fibroboard.com");	
	}
	
	$teams = mysqli_query($connect, "SELECT * FROM teams");

	$winstatus = 0;
	
	//checks if winning team exists in database as entered or as reversed
	while ($team_row = mysqli_fetch_array($teams)) {				
		if ($winnerteam == $team_row['TeamName'] OR $winnersvar == $team_row['TeamName']) {
			//if team already exists, determines which team name is in the system; sets $winnerset to "reg" or "var" depending on how entered
			$winstatus++;
			if ($winnerteam == $team_row['TeamName']) {
				$winnerset = "reg";
			} else {
				$winnerset = "var";
			}
		} 
	}
	//if the team doesn't exist, enters new team
	if ($winstatus == 0) {
		$insert = "INSERT INTO teams (TeamName) VALUES ('$winnerteam')";
		$newteam = mysqli_query($connect, $insert);
	}
	
	$teams2 = mysqli_query($connect, "SELECT * FROM teams");	
	
	$losestatus = 0;
	
	//checks if losing team exists in database as entered or as reversed
	while ($team_row = mysqli_fetch_array($teams2)) {				
		if ($loserteam == $team_row['TeamName'] OR $losersvar == $team_row['TeamName']) {
			//if team already exists, determines which team name is in the system; sets $loserset to "reg" or "var" depending on how entered
			$losestatus++;
			if ($loserteam == $team_row['TeamName']) {
				$loserset = "reg";
			} else {
				$loserset = "var";
			} 
		}
	}
	//if the team doesn't exist, enters new team and adds 1 win for that game
	if ($losestatus == 0) {
		$insert = "INSERT INTO teams (TeamName) VALUES ('$loserteam')";
		$newteam = mysqli_query($connect, $insert);
	}

}


	
mysqli_close($connect);

?>