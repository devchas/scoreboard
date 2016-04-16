<?php

require_once 'db.inc.php';
require 'record.func.php';
$connect = mysqli_connect(HOST, DB_USER, DB_PASS) or die('Could not connect to server' . mysqli_error());
mysqli_select_db($connect, DB_NAME);

//deletes a game from the gamelog
if (isset ($_GET['delete'])) {
	$id = $_GET['delete'];

	$delete = mysqli_query($connect, "DELETE FROM gamelog WHERE ID='$id'");

	if ($delete) {
		updatescores ();
		$open = header("Location: http://fibroboard.com");
	} else {
		echo 'Did not delete';
	}
} else {
	echo 'Did not set ID';
}

mysqli_close($connect);

?>