<?php
	if(isset($_POST['submit'])){
		$username = htmlentities($_POST['username']);

		setcookie('username', $username, time()+3600);
		// 1 hour

		header('Lovation: page2.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>PHP Cookies</title>
</head>
<body>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<input type="text" name="username" placeholder="Enter Username">
		<br>
		<input type="submit" name="submit" value="Submit">
	</form>
</body>
</html>