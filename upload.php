<?php

require_once 'db.inc.php';
$connect = mysqli_connect(HOST, DB_USER, DB_PASS) or die('Could not connect to server' . mysqli_error());
mysqli_select_db($connect, DB_NAME);

if (isset($_POST['gameID'])) {	
	global $connect;
	$id = $_POST['gameID'];
} else {
	echo 'No ID found<br>';
}

//properties of the uploaded file
$name = mysqli_real_escape_string ($connect, $_FILES["myfile"]["name"]);
$type = $_FILES["myfile"]["type"];
$size = $_FILES["myfile"]["size"];
$temp = $_FILES["myfile"]["tmp_name"];
$error = $_FILES["myfile"]["error"];

$name = rand(0, 20000) . $name;

if ($error > 0) {
	die("Error uploading file! Code " . $error);
} else {
	if ($type == "image/png" || $type == "image/png" || $type == "image/jpeg" || $type == "gif") {
		move_uploaded_file($temp, "images/".$name);
		$insert = mysqli_query($connect, "INSERT INTO images (gamelog, name) VALUES ('$id', '$name')");
		if ($insert) {
			$open = header("Location: http://fibroboard.com");
		}
	} else {
		die("Invalid file type");
	}
}




?>