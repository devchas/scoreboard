<?php

require_once "HTML/Template/IT.php";
require_once 'db.inc.php';

//the following three functions create game log elements given different parameters

//creates a list of all game logs (every game played)
function allgamelog() {
	$connect = mysqli_connect(HOST, DB_USER, DB_PASS) or die('Could not connect to server' . mysqli_error());
	mysqli_select_db($connect, DB_NAME);

	if (!($result = @ mysqli_query($connect, "SELECT * FROM gamelog ORDER by ID DESC"))) {
		showerror();
	}

	$template = new HTML_Template_IT;

	$template->loadTemplatefile("logtemp.tpl", true, true);

	while ($row = mysqli_fetch_array($result)) {

		$template->setCurrentBlock("GAMELOG");
	
		$template->setVariable("GAME", $row["game"]);
		$template->setVariable("WINNER1", $row["winnerteam"]);
		$template->setVariable("LOSER1", $row["loserteam"]);
		$template->setVariable("ID", $row["ID"]);
		
		if (!($commentsTable = @ mysqli_query($connect, "SELECT * FROM comments WHERE gamelog='$row[ID]' ORDER by ID"))) {
			showerror();
		}
		
		while ($comment = mysqli_fetch_array($commentsTable)) {
			
			$template->setCurrentBlock("COMMENTS");
		
			$template->setVariable("NAME", $comment["name"]);
			$template->setVariable("COMMENT", $comment["comment"]);
			$template->parseCurrentBlock();
		}
		$template->setCurrentBlock("GAMELOG");
		$template->parseCurrentBlock();
	}

	$template->show();
}

//creates a list of all game logs for a specified type of game (Beer Pong, KAN JAM, Spikeball)
function gamelog($game) {
	$connect = mysqli_connect(HOST, DB_USER, DB_PASS) or die('Could not connect to server' . mysqli_error());
	mysqli_select_db($connect, DB_NAME);

	if (!($result = @ mysqli_query($connect, "SELECT * FROM gamelog ORDER by ID DESC"))) {
		showerror();
	}

	$template = new HTML_Template_IT;

	$template->loadTemplatefile("logtemp.tpl", true, true);

	while ($row = mysqli_fetch_array($result)) {
		if ($row['game'] == $game) {

			$template->setCurrentBlock("GAMELOG");
		
			$template->setVariable("GAME", $row["game"]);
			$template->setVariable("WINNER1", $row["winnerteam"]);
			$template->setVariable("LOSER1", $row["loserteam"]);
			$template->setVariable("ID", $row["ID"]);
		
			if (!($commentsTable = @ mysqli_query($connect, "SELECT * FROM comments WHERE gamelog='$row[ID]' ORDER by ID"))) {
				showerror();
			}
			
			while ($comment = mysqli_fetch_array($commentsTable)) {
				
				$template->setCurrentBlock("COMMENTS");
			
				$template->setVariable("NAME", $comment["name"]);
				$template->setVariable("COMMENT", $comment["comment"]);
				$template->parseCurrentBlock();
			}
			
			if (!($imagesTable = @ mysqli_query($connect, "SELECT * FROM images WHERE gamelog='$row[ID]' ORDER by ID"))) {
				showerror();
			}
			
			while ($image = mysqli_fetch_array($imagesTable)) {
				
				$template->setCurrentBlock("IMAGES");
			
				$template->setVariable("IMAGE", $image["name"]);
				$template->parseCurrentBlock();
			}
			
			$template->setCurrentBlock("GAMELOG");
			$template->parseCurrentBlock();
		}
	}
	$template->show();
}

//creates a list of all game logs for a specified game id
function idgamelog($id) {
	$connect = mysqli_connect(HOST, DB_USER, DB_PASS) or die('Could not connect to server' . mysqli_error());
	mysqli_select_db($connect, DB_NAME);

	if (!($result = @ mysqli_query($connect, "SELECT * FROM gamelog ORDER by ID DESC"))) {
		showerror();
	}

	$template = new HTML_Template_IT;

	$template->loadTemplatefile("logtemp.tpl", true, true);

	while ($row = mysqli_fetch_array($result)) {
		if ($row['ID'] == $id) {

			$template->setCurrentBlock("GAMELOG");
		
			$template->setVariable("GAME", $row["game"]);
			$template->setVariable("WINNER1", $row["winner1"]);
			$template->setVariable("WINNER1", $row["winnerteam"]);
			$template->setVariable("LOSER1", $row["loserteam"]);
			$template->setVariable("ID", $row["ID"]);
		
			if (!($commentsTable = @ mysqli_query($connect, "SELECT * FROM comments WHERE gamelog='$row[ID]' ORDER by ID"))) {
				showerror();
			}
			
			while ($comment = mysqli_fetch_array($commentsTable)) {
				
				$template->setCurrentBlock("COMMENTS");
			
				$template->setVariable("NAME", $comment["name"]);
				$template->setVariable("COMMENT", $comment["comment"]);
				$template->parseCurrentBlock();
			}
			if (!($imagesTable = @ mysqli_query($connect, "SELECT * FROM images WHERE gamelog='$row[ID]' ORDER by ID"))) {
				showerror();
			}
			
			while ($image = mysqli_fetch_array($imagesTable)) {
				
				$template->setCurrentBlock("IMAGES");
			
				$template->setVariable("IMAGE", $image["name"]);
				$template->parseCurrentBlock();
			}

			$template->setCurrentBlock("GAMELOG");
			$template->parseCurrentBlock();
		}
	}
	$template->show();
}

//the following two functions create leaderboards for individuals and teams

//creates a leaderboard of individuals by game or total ($type)
function leaderboard($type) {
	$connect = mysqli_connect(HOST, DB_USER, DB_PASS) or die('Could not connect to server' . mysqli_error());
	mysqli_select_db($connect, DB_NAME);
	
	$wintype = array(
		"Beer Pong" => "BPwins",
		"KAN JAM" => "KJwins",
		"Spikeball" => "SBwins",
		"Total" => "totwins",
	);

	$losstype = array(
		"Beer Pong" => "BPlosses",
		"KAN JAM" => "KJlosses",
		"Spikeball" => "SBlosses",
		"Total" => "totlosses",
	);

	$rank = 1;
	
	if (!($result = @ mysqli_query($connect, "SELECT * FROM users WHERE ($wintype[$type] > '0' OR $losstype[$type] > '0') ORDER by $wintype[$type] DESC, $losstype[$type]"))) {
		showerror();
	}

	$template = new HTML_Template_IT;

	$template->loadTemplatefile("leaderstemp.tpl", true, true);

	while ($row = mysqli_fetch_array($result)) {

			$template->setCurrentBlock("LEADERS");
		
			$template->setVariable("GAME", $type);
			$template->setVariable("RANK", $rank);
			$template->setVariable("NAME", $row["UserName"]);
			$template->setVariable("WINS", $row[$wintype[$type]]);
			$template->setVariable("LOSSES", $row[$losstype[$type]]);
		
			$template->parseCurrentBlock();
			$rank++;
	}

	$template->show();
}

//creates a leaderboard of teams by game or total ($type)
function teamboard($type) {
	$connect = mysqli_connect(HOST, DB_USER, DB_PASS) or die('Could not connect to server' . mysqli_error());
	mysqli_select_db($connect, DB_NAME);
	
	$wintype = array(
		"Beer Pong" => "BPwins",
		"KAN JAM" => "KJwins",
		"Spikeball" => "SBwins",
		"Total" => "totwins",
	);

	$losstype = array(
		"Beer Pong" => "BPlosses",
		"KAN JAM" => "KJlosses",
		"Spikeball" => "SBlosses",
		"Total" => "totlosses",
	);

	$rank = 1;
	
	if (!($result = @ mysqli_query($connect, "SELECT * FROM teams WHERE ($wintype[$type] > '0' OR $losstype[$type] > '0') ORDER by $wintype[$type] DESC, $losstype[$type]"))) {
		showerror();
	}

	$template = new HTML_Template_IT;

	$template->loadTemplatefile("teamlead.tpl", true, true);

	while ($row = mysqli_fetch_array($result)) {

			$template->setCurrentBlock("TEAMS");
		
			$template->setVariable("GAME", $type);
			$template->setVariable("RANK", $rank);
			$template->setVariable("TEAM", $row["TeamName"]);
			$template->setVariable("WINS", $row[$wintype[$type]]);
			$template->setVariable("LOSSES", $row[$losstype[$type]]);
		
			$template->parseCurrentBlock();
			$rank++;
	}

	$template->show();
}

?>