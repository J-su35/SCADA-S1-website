<?php

$mysqli = new mysqli('localhost', 'root', '123456', 'login') or die(mysqli_error($mysqli));

// Add data section
if (isset($_POST['save'])){
  $date = $_POST['noti_date'];
  $equipcode = $_POST['equipcode'];
  $location = $_POST['location'];
  $detail = $_POST['detail'];

  $mysqli->query("INSERT INTO equip_problems(date, equip_code, location, detail) VALUES('$date', '$equipcode', '$location', '$detail')") or die($mysqli->error);

}

 ?>
