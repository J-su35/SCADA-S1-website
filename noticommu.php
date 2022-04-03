<?php
	$page = "แจ้งปัญหาระบบสื่อสาร";
	include_once 'header.php';
 ?>


<div id="download" class="container-fluid padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4">แจ้งปัญหาระบบสื่อสาร</h1>
		</div>
		<hr>
	</div>
</div>

<!--- Cards -->
<div class="container-fluid padding">
	<div class="row padding">

		<div class="col-md-3">
			<div class="card">
				<img class="card-img-top" src="img/fixfiber.png">
				<div class="card-body">
					<h4 class="card-title">สรุปข้อมูลปัญหาระบบไฟเบอร์ออฟติค</h4><br>
					<!-- ยังไม่ได้ใช้ -->
					<!-- <p class="card-text">John is an Internet entrepreneur with almost 20 years of experience.</p> -->
					<a href="uploadbadfiber.php" class="btn btn-outline-secondary">คลิก</a>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="card">
				<img class="card-img-top" src="img/radio_tower.png">
				<div class="card-body">
					<h4 class="card-title">ระบบสื่อสาร SCADA(Master&Remote)</h4>
					<!-- ยังไม่ได้ใช้ -->
					<!-- <p class="card-text">John is an Internet entrepreneur with almost 20 years of experience.</p> -->
					<a href="bad_fiber.php" class="btn btn-outline-secondary">คลิก</a>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="card">
				<img class="card-img-top" src="img/gauge-rediness.png">
				<div class="card-body">
					<h4 class="card-title">ความพร้อมใช้งานระบบสื่อสารของชุด FRTU</h4>
					<!-- ยังไม่ได้ใช้ -->
					<!-- <p class="card-text">John is an Internet entrepreneur with almost 20 years of experience.</p> -->
					<a href="availibility_frtu.php" class="btn btn-outline-secondary">คลิก</a>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="card">
				<img class="card-img-top" src="img/sdh-content2.png">
				<div class="card-body">
					<h4 class="card-title">SDH<br><br></h4>
					<!-- ยังไม่ได้ใช้ -->
					<!-- <p class="card-text">Mary is a designer with almost 10 years of digital design experience</p> -->
					<a href="bad_SDH.php" class="btn btn-outline-secondary">คลิก</a>
				</div>
			</div>
		</div>

	</div>
</div>

<!--- Footer -->
<?php
require "footer.php";
?>
