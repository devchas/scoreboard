<?php

require_once 'db.inc.php';
$connect = mysqli_connect(HOST, DB_USER, DB_PASS) or die('Could not connect to server' . mysqli_error());
mysqli_select_db($connect, DB_NAME);

//post records to team table
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

}

$wintype = array(
	"Beer Pong" => "BPwins",
	"KAN JAM" => "KJwins",
	"Spikeball" => "SBwins",
);

$losstype = array(
	"Beer Pong" => "BPlosses",
	"KAN JAM" => "KJlosses",
	"Spikeball" => "SBlosses",
);

$gamelist = array();
$gameref = mysqli_query($connect, "SELECT * FROM games");
while($gamerow = mysqli_fetch_array($gameref)) {
	$gamelist[] = $gamerow['GAME'];
}

//this function updates the scoreboard for specified players
function scoreupd () {
	//total each player's record in individual games
	global $gamelist, $connect, $winner1, $winner2, $loser1, $loser2, $wintype, $losstype, $winnerteam, $winnersvar, $loserteam, $losersvar;
	foreach ($gamelist as $i) {
		$userref = mysqli_query($connect, "SELECT * FROM users");
		while($userrow = mysqli_fetch_array($userref)) {
			//totals win count for each UserName
			$wincountA = mysqli_query($connect, "SELECT * FROM gamelog WHERE (game='$i' AND winner1='$userrow[UserName]')");
			$wincountB = mysqli_query($connect, "SELECT * FROM gamelog WHERE (game='$i' AND winner2='$userrow[UserName]')");
			$wincount = mysqli_num_rows($wincountA) + mysqli_num_rows($wincountB);
			//totals loss count for each UserName
			$losscountA = mysqli_query($connect, "SELECT * FROM gamelog WHERE (game='$i' AND loser1='$userrow[UserName]')");
			$losscountB = mysqli_query($connect, "SELECT * FROM gamelog WHERE (game='$i' AND loser2='$userrow[UserName]')");
			$losscount = mysqli_num_rows($losscountA) + mysqli_num_rows($losscountB);
			//updates all user records based on the game log
			$postgame = mysqli_query($connect, "UPDATE users SET $wintype[$i]=$wincount, $losstype[$i]=$losscount WHERE UserName='$userrow[UserName]'");
		}
	}

	//total each player's record in for total games
	$userref = mysqli_query($connect, "SELECT * FROM users");
	while($userrow = mysqli_fetch_array($userref)) {
		//totals win count for each UserName
		$totwinsA = mysqli_query($connect, "SELECT * FROM gamelog WHERE winner1='$userrow[UserName]'");
		$totwinsB = mysqli_query($connect, "SELECT * FROM gamelog WHERE winner2='$userrow[UserName]'");
		$totwins = mysqli_num_rows($totwinsA) + mysqli_num_rows($totwinsB);
		//totals loss count for each UserName
		$totlossesA = mysqli_query($connect, "SELECT * FROM gamelog WHERE loser1='$userrow[UserName]'");
		$totlossesB = mysqli_query($connect, "SELECT * FROM gamelog WHERE loser2='$userrow[UserName]'");
		$totlosses = mysqli_num_rows($totlossesA) + mysqli_num_rows($totlossesB);
		//updates all user records based on the game log
		$post = mysqli_query($connect, "UPDATE users SET totwins=$totwins, totlosses=$totlosses WHERE UserName='$userrow[UserName]'");
	}
}


//Posts teams wins to teams DB
function teamscoreupd () {
	//total and posts each team's record in each game
	global $gamelist, $connect, $winner1, $winner2, $loser1, $loser2, $wintype, $losstype, $winnerteam, $winnersvar, $loserteam, $losersvar;
		foreach ($gamelist as $i) {
		$teamref = mysqli_query($connect, "SELECT * FROM teams");
		while($teamrow = mysqli_fetch_array($teamref)) {
			//totals win count for each TeamName
			$wincountA = mysqli_query($connect, "SELECT * FROM gamelog WHERE (game='$i' AND winnerteam='$teamrow[TeamName]')");
			$wincountB = mysqli_query($connect, "SELECT * FROM gamelog WHERE (game='$i' AND winnersvar='$teamrow[TeamName]')");
			$wincount = mysqli_num_rows($wincountA) + mysqli_num_rows($wincountB);
			//totals loss count for each TeamName
			$losscountA = mysqli_query($connect, "SELECT * FROM gamelog WHERE (game='$i' AND loserteam='$teamrow[TeamName]')");
			$losscountB = mysqli_query($connect, "SELECT * FROM gamelog WHERE (game='$i' AND losersvar='$teamrow[TeamName]')");
			$losscount = mysqli_num_rows($losscountA) + mysqli_num_rows($losscountB);
			//updates all user records based on the game log
			$postgame = mysqli_query($connect, "UPDATE teams SET $wintype[$i]=$wincount, $losstype[$i]=$losscount WHERE TeamName='$teamrow[TeamName]'");
		}
	}
	
	//total and posts each team's record in aggregate
	$teamref = mysqli_query($connect, "SELECT * FROM teams");
	while($teamrow = mysqli_fetch_array($teamref)) {
		//totals win count for each TeamName
		$totwinsA = mysqli_query($connect, "SELECT * FROM gamelog WHERE winnerteam='$teamrow[TeamName]'");
		$totwinsB = mysqli_query($connect, "SELECT * FROM gamelog WHERE winnersvar='$teamrow[TeamName]'");
		$totwins = mysqli_num_rows($totwinsA) + mysqli_num_rows($totwinsB);
		//totals loss count for each TeamName
		$totlossesA = mysqli_query($connect, "SELECT * FROM gamelog WHERE loserteam='$teamrow[TeamName]'");
		$totlossesB = mysqli_query($connect, "SELECT * FROM gamelog WHERE losersvar='$teamrow[TeamName]'");
		$totlosses = mysqli_num_rows($totlossesA) + mysqli_num_rows($totlossesB);
		//updates all user records based on the game log
		$post = mysqli_query($connect, "UPDATE teams SET totwins=$totwins, totlosses=$totlosses WHERE TeamName='$teamrow[TeamName]'");
	}
}

//This function updates the team names in the gamelog DB
function teamnames () {
	global $gamelist, $connect, $winner1, $winner2, $loser1, $loser2, $wintype, $losstype, $winnerteam, $winnersvar, $loserteam, $losersvar;	
	$select = mysqli_query($connect, "SELECT * FROM gamelog");

	$teams = array();
			$teamref = mysqli_query($connect, "SELECT * FROM gamelog");
			while($teamrow = mysqli_fetch_array($teamref)) {
				$teams[] = $teamrow['ID'];
			}

	while ($gamerow = mysqli_fetch_array($select)) {
		foreach ($teams as $i) {
			if ($i == $gamerow['ID']) {
				$winner1 = $gamerow['winner1'];
				$winner2 = $gamerow['winner2'];
				$loser1 = $gamerow['loser1'];
				$loser2 = $gamerow['loser2'];
				$winnerteam = $winner1 . ' & ' . $winner2;
				$winnersvar = $winner2 . ' & ' . $winner1;
				$loserteam = $loser1 . ' & ' . $loser2;
				$losersvar = $loser2 . ' & ' . $loser1;
				$insert = mysqli_query($connect, "UPDATE gamelog SET winnerteam='$winnerteam', winnersvar='$winnersvar', loserteam='$loserteam', losersvar='$losersvar' WHERE ID='$i'");

			}
		}		
	}
}

function updatescores () {
	teamnames() ;
	teamscoreupd ();
	scoreupd ();
}


?>