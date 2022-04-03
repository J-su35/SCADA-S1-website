<?php
	$page = "แผนกจัดการงานสถานีฯ 1";
	include_once 'header.php';
 ?>


<div id="download" class="container-fluid padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4">แผนกจัดการงานสถานีฯ 1</h1>
		</div>
		<hr>
	</div>
</div>

<!--- Cards -->
<div class="container-fluid padding">
	<div class="row padding">

		<div class="col-md-4">
			<div class="card">
				<img class="card-img-top" src="img/substation.png">
				<div class="card-body">
					<h4 class="card-title">เพิ่ม/แก้ไข ข้อมูลสถานีไฟฟ้า</h4>
					<!-- ยังไม่ได้ใช้ -->
					<!-- <p class="card-text">John is an Internet entrepreneur with almost 20 years of experience.</p> -->
					<a href="allsubs1.php" class="btn btn-outline-secondary">คลิก</a>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="card">
				<img class="card-img-top" src="img/singleline.png">
				<div class="card-body">
					<h4 class="card-title">ลงข้อมูลการอ่านมาตรวัดไฟฟ้าประจำเดือน</h4>
					<!-- ยังไม่ได้ใช้ -->
					<!-- <p class="card-text">Mary is a designer with almost 10 years of digital design experience</p> -->
					<a href="substationkhw.php" class="btn btn-outline-secondary">คลิก</a>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="card">
				<img class="card-img-top" src="img/usermanuals.png">
				<div class="card-body">
					<h4 class="card-title">ดูข้อมูลหน่วยมาตรวัดไฟฟ้าประจำเดือน</h4>
					<!-- ยังไม่ได้ใช้ -->
					<!-- <p class="card-text">Phil is a developer with over 5 years on web delvelopment experience</p> -->
					<a href="substationkhw.php" class="btn btn-outline-secondary">คลิก</a>
				</div>
			</div>
		</div>

	</div>
</div>

<!--- Footer -->
<?php
require "footer.php";
?>
