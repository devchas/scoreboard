<?php
require_once 'db.inc.php';
$connect = mysqli_connect(HOST, DB_USER, DB_PASS) or die('Could not connect to server' . mysqli_error());
mysqli_select_db($connect, DB_NAME);

$BPrank = mysqli_query($connect, "SELECT * FROM users WHERE (BPwins > '0' OR BPlosses > '0') ORDER by BPwins DESC, BPlosses");

function BPrankings ($BPrank) {
	
	print "<div class=\"scoreboard\"><h2>Beer Pong Leaderboard</h2>";
	
	//Start a table with column headers
	print "\n<table border='1'>\n<tr>\n" .
			"\n\t<col width='50'>" .
			"\n\t<col width='120'>" .
			"\n\t<col width='20'>" .
			"\n\t<col width='20'>" .
			"\n\t<th>Rank</th>" .
			"\n\t<th>Bro</th>" .
			"\n\t<th align=\"center\">Wins</th>" .
			"\n\t<th align=\"center\">Losses</th>" .
			"\n</tr>";
		
		$i = 1;
		
		//...and print out each of the attributes in that row as a separate TD (Table Data item)
		while ($BProw = mysqli_fetch_array($BPrank)) {
				print "\n<tr>" .
						"\n\t<td align=\"center\">$i</td>" .
						"\n\t<td>{$BProw['UserName']}</td>" .
						"\n\t<td align=\"center\">{$BProw['BPwins']}</td>" .
						"\n\t<td align=\"center\">{$BProw['BPlosses']}</td>" .
						"\n</tr>";
				$i++;	
		}
	//finish the table
	print "\n</table>\n</div>";
}

$KJrank = mysqli_query($connect, "SELECT * FROM users WHERE (KJwins > '0' OR KJlosses > '0') ORDER by KJwins DESC, KJlosses");

function KJrankings ($KJrank) {
	
	print "<div class=\"scoreboard\"><h2>KAN JAM Leaderboard</h2>";
	
	//Start a table with column headers
	print "\n<table border='1'>\n<tr>\n" .
			"\n\t<col width='50'>" .
			"\n\t<col width='120'>" .
			"\n\t<col width='20'>" .
			"\n\t<col width='20'>" .
			"\n\t<th>Rank</th>" .
			"\n\t<th>Bro</th>" .
			"\n\t<th align=\"center\">Wins</th>" .
			"\n\t<th align=\"center\">Losses</th>" .
			"\n</tr>";
		
		//start a table row
		print "\n<tr>";
		
		$i = 1;
		
		//...and print out each of the attributes in that row as a separate TD (Table Data item)
		while ($KJrow = mysqli_fetch_array($KJrank)) {
				print "\n<tr>" .
						"\n\t<td align=\"center\">$i</td>" .
						"\n\t<td>{$KJrow['UserName']}</td>" .
						"\n\t<td align=\"center\">{$KJrow['KJwins']}</td>" .
						"\n\t<td align=\"center\">{$KJrow['KJlosses']}</td>" .
						"\n</tr>";
				$i++;	
		}
	//finish the table
	print "\n</table>\n</div>";
}

$SBrank = mysqli_query($connect, "SELECT * FROM users WHERE (SBwins > '0' OR SBlosses > '0') ORDER by SBwins DESC, SBlosses");

function SBrankings ($SBrank) {
	
	print "<div class=\"scoreboard\"><h2>Spikeball Leaderboard</h2>";
	
	//Start a table with column headers
	print "\n<table border='1'>\n<tr>\n" .
			"\n\t<col width='50'>" .
			"\n\t<col width='120'>" .
			"\n\t<col width='20'>" .
			"\n\t<col width='20'>" .
			"\n\t<th>Rank</th>" .
			"\n\t<th>Bro</th>" .
			"\n\t<th align=\"center\">Wins</th>" .
			"\n\t<th align=\"center\">Losses</th>" .
			"\n</tr>";
		
		$i = 1;
		
		//...and print out each of the attributes in that row as a separate TD (Table Data item)
		while ($SBrow = mysqli_fetch_array($SBrank)) {
				print "\n<tr>" . 
						"\n\t<td align=\"center\">$i</td>" .
						"\n\t<td>{$SBrow['UserName']}</td>" .
						"\n\t<td align=\"center\">{$SBrow['SBwins']}</td>" .
						"\n\t<td align=\"center\">{$SBrow['SBlosses']}</td>" .
						"\n</tr>";
				$i++;	
		}
	//finish the table
	print "\n</table>\n</div>";
}

$totrank = mysqli_query($connect, "SELECT * FROM users WHERE (totwins > '0' OR totlosses > '0') ORDER by totwins DESC, totlosses");

function totrankings ($totrank) {
	
	print "<div class=\"scoreboard\"><h2>Total Leaderboard</h2>";
	
	//Start a table with column headers
	print "\n<table border='1'>\n<tr>\n" .
			"\n\t<col width='50'>" .
			"\n\t<col width='120'>" .
			"\n\t<col width='20'>" .
			"\n\t<col width='20'>" .
			"\n\t<th>Rank</th>" .
			"\n\t<th>Bro</th>" .
			"\n\t<th align=\"center\">Wins</th>" .
			"\n\t<th align=\"center\">Losses</th>" .
			"\n</tr>";
		
		$i = 1;
		
		//...and print out each of the attributes in that row as a separate TD (Table Data item)
		while ($totrow = mysqli_fetch_array($totrank)) {
				print "\n<tr>" . 
						"\n\t<td align=\"center\">$i</td>" .
						"\n\t<td>{$totrow['UserName']}</td>" .
						"\n\t<td align=\"center\">{$totrow['totwins']}</td>" .
						"\n\t<td align=\"center\">{$totrow['totlosses']}</td>" .
						"\n</tr>";
				$i++;	
		}
	//finish the table
	print "\n</table>\n</div>";
}

$players = mysqli_query($connect, "SELECT * FROM users ORDER BY UserName");

function players ($players) {
	while($player_row = mysqli_fetch_array($players)) {
		echo '<option value ="' . $player_row['UserName'] . '">' . $player_row['UserName'] . '</option>';
	}
}

$TeamBPrank = mysqli_query($connect, "SELECT * FROM teams WHERE (BPwins > '0' OR BPlosses > '0') ORDER by BPwins DESC, BPlosses");

function TeamBPrankings ($TeamBPrank) {
	
	print "<div class=\"scoreboard\"><h2>Beer Pong Leaderboard</h2>";
	
	//Start a table with column headers
	print "\n<table border='1'>\n<tr>\n" .
			"\n\t<col width='50'>" .
			"\n\t<col width='180'>" .
			"\n\t<col width='20'>" .
			"\n\t<col width='20'>" .
			"\n\t<th>Rank</th>" .
			"\n\t<th>Team</th>" .
			"\n\t<th align=\"center\">Wins</th>" .
			"\n\t<th align=\"center\">Losses</th>" .
			"\n</tr>";
		
		$i = 1;
		
		//...and print out each of the attributes in that row as a separate TD (Table Data item)
		while ($BProw = mysqli_fetch_array($TeamBPrank)) {
				print "\n<tr>" .
						"\n\t<td align=\"center\">$i</td>" .
						"\n\t<td>{$BProw['TeamName']}</td>" .
						"\n\t<td align=\"center\">{$BProw['BPwins']}</td>" .
						"\n\t<td align=\"center\">{$BProw['BPlosses']}</td>" .
						"\n</tr>";
				$i++;	
		}
	//finish the table
	print "\n</table>\n</div>";
}

$TeamKJrank = mysqli_query($connect, "SELECT * FROM teams WHERE (KJwins > '0' OR KJlosses > '0') ORDER by KJwins DESC, KJlosses");

function TeamKJrankings ($TeamKJrank) {
	
	print "<div class=\"scoreboard\"><h2>KAN JAM Leaderboard</h2>";
	
	//Start a table with column headers
	print "\n<table border='1'>\n<tr>\n" .
			"\n\t<col width='50'>" .
			"\n\t<col width='180'>" .
			"\n\t<col width='20'>" .
			"\n\t<col width='20'>" .
			"\n\t<th>Rank</th>" .
			"\n\t<th>Team</th>" .
			"\n\t<th align=\"center\">Wins</th>" .
			"\n\t<th align=\"center\">Losses</th>" .
			"\n</tr>";
		
		//start a table row
		print "\n<tr>";
		
		$i = 1;
		
		//...and print out each of the attributes in that row as a separate TD (Table Data item)
		while ($KJrow = mysqli_fetch_array($TeamKJrank)) {
				print "\n<tr>" .
						"\n\t<td align=\"center\">$i</td>" .
						"\n\t<td>{$KJrow['TeamName']}</td>" .
						"\n\t<td align=\"center\">{$KJrow['KJwins']}</td>" .
						"\n\t<td align=\"center\">{$KJrow['KJlosses']}</td>" .
						"\n</tr>";
				$i++;	
		}
	//finish the table
	print "\n</table>\n</div>";
}

$TeamSBrank = mysqli_query($connect, "SELECT * FROM teams WHERE (SBwins > '0' OR SBlosses > '0') ORDER by SBwins DESC, SBlosses");

function TeamSBrankings ($TeamSBrank) {
	
	print "<div class=\"scoreboard\"><h2>Spikeball Leaderboard</h2>";
	
	//Start a table with column headers
	print "\n<table border='1'>\n<tr>\n" .
			"\n\t<col width='50'>" .
			"\n\t<col width='180'>" .
			"\n\t<col width='20'>" .
			"\n\t<col width='20'>" .
			"\n\t<th>Rank</th>" .
			"\n\t<th>Team</th>" .
			"\n\t<th align=\"center\">Wins</th>" .
			"\n\t<th align=\"center\">Losses</th>" .
			"\n</tr>";
		
		$i = 1;
		
		//...and print out each of the attributes in that row as a separate TD (Table Data item)
		while ($SBrow = mysqli_fetch_array($TeamSBrank)) {
				print "\n<tr>" . 
						"\n\t<td align=\"center\">$i</td>" .
						"\n\t<td>{$SBrow['TeamName']}</td>" .
						"\n\t<td align=\"center\">{$SBrow['SBwins']}</td>" .
						"\n\t<td align=\"center\">{$SBrow['SBlosses']}</td>" .
						"\n</tr>";
				$i++;	
		}
	//finish the table
	print "\n</table>\n</div>";
}

$Teamtotrank = mysqli_query($connect, "SELECT * FROM teams WHERE (totwins > '0' OR totlosses > '0') ORDER by totwins DESC, totlosses");

function Teamtotrankings ($Teamtotrank) {
	
	print "<div class=\"scoreboard\"><h2>Total Leaderboard</h2>";
	
	//Start a table with column headers
	print "\n<table border='1'>\n<tr>\n" .
			"\n\t<col width='50'>" .
			"\n\t<col width='180'>" .
			"\n\t<col width='20'>" .
			"\n\t<col width='20'>" .
			"\n\t<th>Rank</th>" .
			"\n\t<th>Team</th>" .
			"\n\t<th align=\"center\">Wins</th>" .
			"\n\t<th align=\"center\">Losses</th>" .
			"\n</tr>";
		
		$i = 1;
		
		//...and print out each of the attributes in that row as a separate TD (Table Data item)
		while ($totrow = mysqli_fetch_array($Teamtotrank)) {
				print "\n<tr>" .
						"\n\t<td align=\"center\">$i</td>" .
						"\n\t<td>{$totrow['TeamName']}</td>" .
						"\n\t<td align=\"center\">{$totrow['totwins']}</td>" .
						"\n\t<td align=\"center\">{$totrow['totlosses']}</td>" .
						"\n</tr>";
				$i++;	
		}
	//finish the table
	print "\n</table>\n</div>";
}

?>