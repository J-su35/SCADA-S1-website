<?php
	$page = "SCADA S1";
	include_once 'header.php';

	// print_r($_SESSION['username']);
	// print_r($_SESSION['group']);
?>


<!--- Image Slider -->
<div id="slides" class="carousel slide" data-ride="carousel">
	<ul class="carousel-indicators">
		<li data-target="#slides" data-slide-to="0" class="active"></li>
		<li data-target="#slides" data-slide-to="1"></li>
		<li data-target="#slides" data-slide-to="2"></li>
		<li data-target="#slides" data-slide-to="3"></li>
		<li data-target="#slides" data-slide-to="4"></li>
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
			<img src="img/background_4.png">
		</div>
		<div class="carousel-item">
			<img src="img/background_5.png">
		</div>
		<div class="carousel-item">
			<img src="img/background4.png">
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
					<h4 class="card-title">ผังการจ่ายไฟฟ้า</h4>
					<!-- ยังไม่ได้ใช้ -->
					<!-- <p class="card-text">Mary is a designer with almost 10 years of digital design experience</p> -->
					<a href="slddownload.php" class="btn btn-outline-secondary">คลิก</a>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="card">
				<img class="card-img-top" src="img/fibre optic.png">
				<div class="card-body">
					<h4 class="card-title">ผังไฟเบอร์ออฟติค</h4>
					<!-- ยังไม่ได้ใช้ -->
					<!-- <p class="card-text">Phil is a developer with over 5 years on web delvelopment experience</p> -->
					<a href="fibredownload.php" class="btn btn-outline-secondary">คลิก</a>
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

		<div class="col-md-4">
			<div class="card">
				<img class="card-img-top" src="img/bad_equip.png">
				<div class="card-body">
					<h4 class="card-title">ข้อมูลการชำรุดของอุปกรณ์ไฟฟ้าในระบบ</h4>
					<!-- ยังไม่ได้ใช้ -->
					<!-- <p class="card-text">Phil is a developer with over 5 years on web delvelopment experience</p> -->
					<a href="bad_equipBorad.php" class="btn btn-outline-secondary">คลิก</a>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="card">
				<img class="card-img-top" src="img/commu.png">
				<div class="card-body">
					<h4 class="card-title">ข้อมูลการชำรุดของระบบสื่อสาร</h4>
					<!-- ยังไม่ได้ใช้ -->
					<!-- <p class="card-text">Phil is a developer with over 5 years on web delvelopment experience</p> -->
					<a href="noticommu2.php" class="btn btn-outline-secondary">คลิก</a>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="card">
				<img class="card-img-top" src="img/paytm-electricity.png">
				<div class="card-body">
					<h4 class="card-title">รายงานการอ่านมาตรวัดไฟฟ้าประจำเดือน</h4>
					<!-- ยังไม่ได้ใช้ -->
					<!-- <p class="card-text">Phil is a developer with over 5 years on web delvelopment experience</p> -->
					<a href="sub_kwhunit.php" class="btn btn-outline-secondary">คลิก</a>
				</div>
			</div>
		</div>

	</div>
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
			<a href="upload01.php"><i class="fas fa-chart-area"></i></a>
			<h4><a style="text-decoration: none; color:black;" href="upload01.php">โหลด 01</a></h4>
			<!-- <p><a href="upload01.php">อัพโหลดไฟล์ โหลด 01</a></p> -->
		</div>
		<div class="col-xs-12 col-sm-6 col-md-4">
			<!-- <i class="fas fa-code"></i> -->
			<a href="uploaddwg.php"><i class="fas fa-file-upload"></i><a/>
			<h4><a style="text-decoration: none; color:black;" href="uploaddwg.php">ผังการจ่ายไฟฟ้า</a></h4>
			<!-- <p><a href="uploaddwg.php">อัพโหลดผังการจ่ายไฟฟ้า</a></p> -->
		</div>
		<div class="col-xs-12 col-sm-6 col-md-4">
			<!-- <i class="fas fa-code"></i> -->
			<a href="uploadfibre.php"><i class="fas fa-arrow-circle-up"></i></a>
			<h4><a style="text-decoration: none; color:black;" href="uploadfibre.php">ผังไฟเบอร์ออฟติค</a></h4>
			<!-- <p><a href="uploadfibre.php">อัพโหลดผังไฟเบอร์ออฟติค</a></p> -->
		</div>
		<div class="col-xs-12 col-sm-6 col-md-4">
			<!-- <i class="fas fa-code"></i> -->
			<a href="uploadusrman.php"><i class="fas fa-arrow-circle-up"></i></a>
			<h4><a style="text-decoration: none; color:black;" href="uploadusrman.php">คู่มือปฏิบัติงาน</a></h4>

			<!-- <p><a href="uploadusrman.php">อัพโหลดคู่มือ</a></p> -->
		</div>
		<div class="col-xs-12 col-sm-6 col-md-4">
			<!-- <i class="fas fa-bold"></i> -->
			<a href="bad_equipv.2.php"><i class="fas fa-tools"></i></a>
			<h4><a style="text-decoration: none; color:black;" href="bad_equipv.2.php">แจ้งอุปกรณ์ในระบบชำรุด</a></h4>
			<!-- <p><a href="bad_equip.php">แจ้งอุปกรณ์ในระบบชำรุด</a></p> -->
			<!-- <p><a href="notiequipindex.php">แจ้งอุปกรณ์ในระบบชำรุด</a></p> -->
		</div>
		<div class="col-sm-12 col-md-4">
			<!-- <i class="fab fa-css3"></i> -->
			<a href="noticommu.php"><i class="fas fa-broadcast-tower"></i></a>
			<h4><a style="text-decoration: none; color:black;" href="noticommu.php">แจ้งปัญหาระบบสื่อสาร DOWN</a></h4>
			<!-- <p><a href="noticommu.php">แจ้งปัญหาระบบสื่อสาร DOWN</a></p> -->
		</div>
		<div class="col-sm-12 col-md-4">
			<!-- <i class="fab fa-css3"></i> -->
			<a href="substation_index.php"><i class="fas fa-file-invoice"></i></a>
			<!-- <i class="fas fa-broadcast-tower"></i> -->
			<h4><a style="text-decoration: none; color:black;" href="substation_index.php">ข้อมูลหน่วยซื้อไฟ กฟผ.</a></h4>
			<!-- <p><a href="substationkhw.php">ลงข้อมูลหน่วยซื้อไฟ กฟผ.</a></p> -->
		</div>
	</div>
	<hr class="my-4">
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










<!--- Check out my course on Udemy! -->
<!-- <div class="udemy-course" style="position: fixed; bottom: 0; right: 0; margin-bottom: -5px; z-index: 100;">
	<a href="http://bit.ly/advanced-bootstrap-course" target="_blank" style="z-index: 999!important; cursor: pointer!important;"><img src="https://www.w3newbie.com/wp-content/uploads/nuno-udemy-banner.png" style="max-width: 100%; min-width: 100%;"></a>
</div> -->
