<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SCADA S1</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<!-- <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script> -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
	<link href="style.css" rel="stylesheet">
</head>
<body>

<!-- Navigation  -->  <!--start 7.21 -->
<nav class="navbar navbar-expand-md navbar-light bg-light stricky-top">
	<div class="container-fluid">
		<a class="navbar-brand" href="index.php"><img src="img/scada-logo.png"></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarResponsive">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item active">
					<a class="nav-link" href="index.php">หน้าหลัก</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="https://www.google.co.th/">แผนงานขอดับไฟ P6</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#upload">ลงข้อมูล</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href='#download'>ดาวน์โหลด</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="logout.php">ออกจากระบบ</a>
				</li>
			</ul>
	</div>
</nav>

<!--- Image Slider -->
<div id="slides" class="carousel slide" data-ride="carousel">
	<ul class="carousel-indicators">
		<li data-target="#slides" data-slide-to="0" class="active"></li>
		<li data-target="#slides" data-slide-to="1"></li>
		<li data-target="#slides" data-slide-to="2"></li>
	</ul>
	<div class="carousel-inner">
		<div class="carousel-item active">
			<img src="img/background11.png" alt="src www.travelfortoday.com">
			<div class="carousel-caption">
				<h1 class="display-2">SCADA S1</h1>
				<h3>ศูนย์ควบคุมการจ่ายไฟฟ้า เขต 1 (ภาคใต้) จ.เพชรบุรี</h3>
				<!-- <button type="button" class="btn btn-outline-light btn-lg">VIEW DEMO
				</button>
				<button type="button" class="btn btn-primary btn-lg">Get Started
				</button> -->
			</div>
		</div>
		<div class="carousel-item">
			<img src="img/background3.png">
		</div>
		<div class="carousel-item">
			<img src="img/green office logo.png">
		</div>
	</div>
</div>

<!--- Jumbotron -->  <!-- ปิดไว้ ไม่ได้ใช้ -->
<!-- <div class="container-fluid">
	<div class="row jumbotron">
		<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
			<p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nec lorem ut velit cursus dictum vel sit amet turpis.
			</p>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2">
			<a href="#"><button type="button" class="btn btn-outline-secondary btn-lg">Click</button></a>
		</div>
	</div>
</div> -->

<!--- Welcome Section -->
<div id="upload" class="container-fluid padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4">ลงข้อมูล</h1>
		</div>
		<hr>
		<!-- เอาออก ไม่ได้ใช้ -->
		<!-- <div class="col-12">
			<p class="lead">Aenean condimentum nisl ligula, ut commodo nisi laoreet et. Vestibulum ultricies scelerisque velit. Sed facilisis urna dolor, non fringilla ipsum tincidunt non. Pellentesque efficitur viverra diam non mattis. Cras varius felis nisi, eu dignissim orci blandit a.</p>
		</div> -->
	</div>
</div>

<!--- Three Column Section -->
<div class="container-fluid padding">
	<div class="row text-center padding">
		<div class="col-xs-12 col-sm-6 col-md-4">
			<!-- <i class="fas fa-code"></i> -->
			<i class="fas fa-chart-area"></i>
			<h3>โหลด 01</h3>
			<p><a href="upload01.php">อัพโหลดไฟล์ โหลด 01</a></p>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-4">
			<!-- <i class="fas fa-bold"></i> -->
			<i class="fas fa-tools"></i>
			<h3>แจ้งอุปกรณ์ชำรุด</h3>
			<p><a href="bad_equip.php">แจ้งอุปกรณ์ในระบบชำรุด</a></p>
		</div>
		<div class="col-sm-12 col-md-4">
			<!-- <i class="fab fa-css3"></i> -->
			<i class="fas fa-broadcast-tower"></i>
			<h3>แจ้งปัญหาระบบสื่อสาร</h3>
			<p><a href="subdown.php">แจ้งปัญหาระบบสื่อสาร DOWN</a></p>
		</div>
	</div>
	<hr class="my-4">
</div>

<!--- Two Column Section -->  <!-- ปิดไว้ ไม่ได้ใช้ -->
<!-- <div class="container-fluid padding">
	<div class="row padding">
		<div class="col-lg-6">
			<h2>Cras congue dictum lacus.</h2>
			<p>tincidunt mi. Vestibulum ornare porttitor neque sed gravida. Suspendisse rutrum dui non vestibulum vestibulum. Sed pretium mattis sem.</p>
			<p>Cras congue dictum lacus, a lobortis metus convallis at. Ut tincidunt sed turpis vitae vulputate. Sed ultrices augue vitae felis congue facilisis. Nunc pharetra luctus risus ac facilisis. Nulla vulputate eleifend nibh, sed mattis nulla faucibus ut. Fusce quis magna hendrerit, faucibus odio et,</p>
			<p>Quisque tincidunt molestie odio. Nulla at facilisis magna. Nullam posuere a erat nec dapibus. Sed ac ex congue purus molestie faucibus.</p>
			<br>
			<a href="#" class="btn btn-primary">คลิก</a>
		</div>
			<div class="col-lg-6">
				<img src="img/desk.png" class="img-fluid">
			</div>
		</div>
</div> -->

<hr class="my-4">
<!--- Fixed background -->
<figure>
	<div class="fixed-wrap">
		<div id="fixed">
		</div>
	</div>
</figure>

<!--- Emoji Section --> <!---เอาออก-- >
<!-- <button class="fun" data-toggle="collapse" data-target="#emoji">Click for fun</button>
<div id="emoji" class="collapse">
	<div class="container-fluid padding">
		<div class="row text-center">
			<div class="col-sm-6 col-md-3">
				<img class="gif" src="img/gif/panda.gif">
			</div>
			<div class="col-sm-6 col-md-3">
				<img class="gif" src="img/gif/poo.gif">
			</div>
			<div class="col-sm-6 col-md-3">
				<img class="gif" src="img/gif/unicorn.gif">
			</div>
			<div class="col-sm-6 col-md-3">
				<img class="gif" src="img/gif/chicken.gif">
			</div>
		</div>
	</div>
</div> -->
<!--- Meet the team -->

<div id="download" class="container-fluid padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4">ดาวน์โหลด</h1>
		</div>
		<hr>
	</div>
</div>

<!--- Cards -->
<div class="container-fluid padding">
	<div class="row padding">
		<div class="col-md-4">
			<div class="card">
				<img class="card-img-top" src="img/load-curves.png">
				<div class="card-body">
					<h4 class="card-title">โหลด 01</h4>
					<!-- ยังไม่ได้ใช้ -->
					<!-- <p class="card-text">John is an Internet entrepreneur with almost 20 years of experience.</p> -->
					<a href="download01.php" class="btn btn-outline-secondary">คลิก</a>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="card">
				<img class="card-img-top" src="img/singleline.png">
				<div class="card-body">
					<h4 class="card-title">ผังการจ่ายไฟ</h4>
					<!-- ยังไม่ได้ใช้ -->
					<!-- <p class="card-text">Mary is a designer with almost 10 years of digital design experience</p> -->
					<a href="slddownload.php" class="btn btn-outline-secondary">คลิก</a>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="card">
				<img class="card-img-top" src="img/usermanuals.png">
				<div class="card-body">
					<h4 class="card-title">คู่มือปฏิบัติงาน</h4>
					<!-- ยังไม่ได้ใช้ -->
					<!-- <p class="card-text">Phil is a developer with over 5 years on web delvelopment experience</p> -->
					<a href="usermanual-download.php" class="btn btn-outline-secondary">คลิก</a>
				</div>
			</div>
		</div>
	</div>
</div>

<!--- Two Column Section --> <!-- ปิดไว้ ไม่ได้ใช้ -->
<!-- <div class="container-fluid padding">
	<div class="row padding">
		<div class="col-lg-6">
			<h2>Lorem ipsum dolor sit amet,</h2>
			<p>Maecenas sed libero quis augue auctor egestas. Suspendisse rhoncus nisl eu arcu tempus efficitur. Sed feugiat nulla felis, eu fermentum odio euismod nec. Nam faucibus convallis vulputate.</p>
			<p>Fusce ac turpis quis tortor vehicula auctor et eu ex. Nullam sit amet enim et est fermentum luctus id vitae odio. Integer pharetra euismod dolor, at dignissim magna laoreet id. Aliquam volutpat augue hendrerit purus egestas, ac euismod tortor viverra. Maecenas id lacus sed elit facilisis ornare.</p>
			<br>
		</div>

			<div class="col-lg-6">
				<img src="img/bootstrap2.png" class="img-fluid">
			</div>
		</div>
		<hr class="my-4">
</div> -->

<!--- Connect -->
<div class="container-fluid padding">
	<div class="row text-center padding">
		<div class="col-12">
			<h2>Connect</h2>
		</div>
		<div class="col-12 social padding">
			<a href="http://www.facebook.com/Provincial.Electricity.Authority"><i class="fab fa-facebook"></i></a>
			<a href="http://www.twitter.com/pea_thailand"><i class="fab fa-twitter"></i></a>
			<!-- <a href="#"><i class="fab fa-google-plus-g"></i></a> --> <!-- เอาออก -->
			<a href="https://www.instagram.com/peathailand"><i class="fab fa-instagram"></i></a>
			<a href="https://www.youtube.com/user/PEAchannelThailand"><i class="fab fa-youtube"></i></a>
		</div>
	</div>
</div>

<!--- Footer -->
<?php
require "footer.php";
?>



</body>
</html>









<!--- Check out my course on Udemy! -->
<!-- <div class="udemy-course" style="position: fixed; bottom: 0; right: 0; margin-bottom: -5px; z-index: 100;">
	<a href="http://bit.ly/advanced-bootstrap-course" target="_blank" style="z-index: 999!important; cursor: pointer!important;"><img src="https://www.w3newbie.com/wp-content/uploads/nuno-udemy-banner.png" style="max-width: 100%; min-width: 100%;"></a>
</div> -->
