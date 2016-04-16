<?php

require_once 'db.inc.php';
$connect = mysqli_connect(HOST, DB_USER, DB_PASS) or die('Could not connect to server' . mysqli_error());
mysqli_select_db($connect, DB_NAME);

if (isset($_GET['name'], $_GET['comment'], $_GET['gameID'])) {	
	global $connect;
	$name = mysqli_real_escape_string($connect, $_GET['name']);
	$comment = mysqli_real_escape_string($connect, $_GET['comment']);
	$id = $_GET['gameID'];
	
	$insert = mysqli_query($connect, "INSERT INTO comments (gamelog, name, comment) VALUES ('$id', '$name', '$comment')");
	if ($insert) {
		$open = header("Location: http://fibroboard.com");
	} else {
		echo 'Set, not posted';
	}
} else {
	echo 'Not set';
}
	
?>