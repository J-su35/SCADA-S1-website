<?php
//Create Connection
// $conn = mysqli_connect('localhost', 'root', '123456', 'testing');
// อีกวิธีที่ชาวบ้านไม่ค่อยทำกัน
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

//Check connection
if(mysqli_connect_error()){
	//Connection Failed
	echo 'Failed to connect to MySQL'. mysqli_connect_error();
}

?>