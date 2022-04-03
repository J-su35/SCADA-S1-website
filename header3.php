<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $page;?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<!-- <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script> -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
	<link href="style.css" rel="stylesheet">

	<script src="js/jquery-3.4.0.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link href="css/bootstrap.min.css" rel="stylesheet"/>
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
				echo '<ul class="navbar-nav ml-auto">
					<li class="nav-item active">
						<a class="nav-link" href="index.php">หน้าหลัก</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="signup.php">สร้างบัญชีใช้งาน</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="http://122.155.190.111/">แผนงานขอดับไฟ P6</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#upload">ลงข้อมูล</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#download">ดาวน์โหลด</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="login.php">เข้าสู่ระบบ</a>
					</li>
				</ul>';

				// header("Location:login.php");

			}
			 ?>

		</div>
	</div>
</nav>
</header>
