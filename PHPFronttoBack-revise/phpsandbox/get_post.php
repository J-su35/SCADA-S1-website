<?php
	//GET methos ส่งข้อมูลไป server จะเห็นข้อมูลการส่งที่ช่อง address
	if(isset($_GET['name'])) {
		// print_r($_GET);
		$name = htmlentities($_GET['name']); //htmlentities ฟังก์ชันป้องกันการใส่ <script> ใน input ป้องกันผู้ไม่หวังดีทำลายเว็ป
		// echo $name;
	}
	//POST methos ส่งข้อมูลไป server จะไม่เห็นข้อมูลการส่งที่ช่อง address
	// if(isset($_POST['name'])) {
	// 	print_r($_POST);
	// 	$name = htmlentities($_GET['name']); //htmlentities ฟังก์ชันป้องกันการใส่ <script> ใน input ป้องกันผู้ไม่หวังดีทำลายเว็ป
	// 	echo $name;
	// }

	// if(isset($_REQUEST['name'])) {
	// 	print_r($_REQUEST);
	// 	$name = htmlentities($_GET['name']); //htmlentities ฟังก์ชันป้องกันการใส่ <script> ใน input ป้องกันผู้ไม่หวังดีทำลายเว็ป
	// 	echo $name;
	// }

	// echo $_SERVER['QUERY_STRING'];
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>My Website</title>
</head>
<body>
	<form method="GET" action="get_post.php">
		<div>
			<label>Name</label>
			<input type="text" name="name">
		</div>

		<div>
			<label>Email</label>
			<input type="text" name="email">
		</div>

		<input type="submit" value="Submit">
	</form>

	<ul>
		<li>
			<a href="get_post.php?name=Brad">Brad</a>
		</li>
		<li>
			<a href="get_post.php?name=Steve">Steve</a>
		</li>
	</ul>
	<?php echo "{$name}'s Profile"; ?>
</body>
</html>