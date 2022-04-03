<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $page;?></title>

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
	<link href="style.css" rel="stylesheet">

	<script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>

<header>
<!-- Navigation  -->  <!--start 7.21 -->
<nav class="navbar navbar-expand-md navbar-light bg-light stricky-top">
	<div class="container-fluid">
		<a class="navbar-brand" href="index.php"><img src="img/scada-logo.png"></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarResponsive">
			<?php
			if (isset($_SESSION['username'])) {
				echo '<ul class="navbar-nav ml-auto">
					<li class="nav-item active">
						<a class="nav-link" href="index.php">หน้าหลัก</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="http://122.155.190.111/">แผนงานขอดับไฟ P6</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="logout.php">ออกจากระบบ</a>
					</li>
				</ul>';
			} else {
				header("Location:login.php");

			}
			 ?>

		</div>
	</div>
</nav>
</header>
