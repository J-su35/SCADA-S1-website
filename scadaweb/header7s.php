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

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

	<script src="js/searchBox.js"></script>
</head>
<body>

<header>
<!-- Navigation  -->  <!--start 7.21 -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark stricky-top">
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
					<li class="nav-item dropdown">
			      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
			        ลงข้อมูล
			      </a>
			      <div class="dropdown-menu">
			        <a class="dropdown-item" href="upload01.php">อัพโหลดไฟล์ โหลด 01</a>
			        <a class="dropdown-item" href="uploaddwg.php">อัพโหลดผังการจ่ายไฟ</a>
			        <a class="dropdown-item" href="uploadfibre.php">อัพโหลดผังไฟเบอร์ออฟติค</a>
							<a class="dropdown-item" href="uploadusrman.php">อัพโหลดคู่มือ</a>
			        <a class="dropdown-item" href="bad_equip.php">แจ้งอุปกรณ์ในระบบชำรุด</a>
			        <a class="dropdown-item" href="noticommu.php">แจ้งปัญหาระบบสื่อสาร</a>
							<a class="dropdown-item" href="substationkhw.php">ลงข้อมูลหน่วยซื้อไฟ กฟผ.</a>
			      </div>
			    </li>
					<li class="nav-item dropdown">
			      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
			        ดาวน์โหลด
			      </a>
			      <div class="dropdown-menu">
			        <a class="dropdown-item" href="download01.php">โหลด 01</a>
			        <a class="dropdown-item" href="slddownload.php">ผังการจ่ายไฟ</a>
			        <a class="dropdown-item" href="usermanual-download.php">คู่มือปฏิบัติงาน</a>
							<a class="dropdown-item" href="sub_kwhunit.php">รายงานการอ่านมาตรวัดไฟฟ้าประจำเดือน</a>
			        <a class="dropdown-item" href="fibredownload.php">ผังไฟเบอร์ออฟติค</a>
			      </div>
			    </li>
					<li class="nav-item active">
						<a class="nav-link" href="logout.php">ออกจากระบบ</a>
					</li>
				</ul>

				<form class="form-inline">
					<input class="form-control mr-sm-2" id="myInput" type="text" placeholder="Search" aria-label="Search">
				</form>';
			} else {
				header("Location:login.php");
			}
			 ?>

		</div>
	</div>
</nav>
</header>
