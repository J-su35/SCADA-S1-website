<?php

$conn = mysqli_connect('localhost', 'root', '123456', 'testing');

	// Check connection
	if (!$conn) {
	  die("Connection failed: " . mysqli_connect_error());
	}

// echo $_POST["tweet"];  //debug

$tweet = $_POST['tweet'];

$sql = "INSERT INTO tbl_tweet (tweet) VALUES ('$tweet')";
mysqli_query($conn, $sql)

?>