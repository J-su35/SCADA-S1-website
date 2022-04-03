<?php
	session_start();

	// $_SESSION['name'] = 'Jonh Doe';

	print_r($_SESSION);

	$name = isset($_SESSIOIN['name']) ? $_SESSION['name'] : 'Guest';
	$email = isset($_SESSIOIN['email']) ? $_SESSION['email'] : 'Not subscribed';
	$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>PHP Sesssions Page3</title>
</head>
<body>
	<h1>Hello <?php echo $name; ?></h1>
	<a href="page3.php">Unset session Go to page4</a>
</body>
</html>