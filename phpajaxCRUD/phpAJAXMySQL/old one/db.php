<?php 
	$conn = mysqli_connect('localhost', 'root', '123456', 'testing');

	// Check connection
	if (!$conn) {
	  die("Connection failed: " . mysqli_connect_error());
	}
 ?>