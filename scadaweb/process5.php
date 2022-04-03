<?php

session_start();

$mysqli = new mysqli('localhost', 'root', '123456', 'login') or die(mysqli_error($mysqli));

// $id = 0;

// Add data section
if (isset($_POST['save'])){
  $brPEA = $_POST['Author'];
  $equipcode = $_POST['Equipment'];
  $outageTime = $_POST['OutageTime'];

  $mysqli->query("INSERT INTO sfsd(Br_name, equip_code, outageTime) VALUES('$brPEA', '$equipcode', '$outageTime')") or die($mysqli->error);

  // $_SESSION['message'] = "Record has been saved";
  // $_SESSION['msg_type'] = "success";

  header("location: sfsd.php");
}
// Add data section end

// Delete data section
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $mysqli->query("DELETE FROM sfsd WHERE id=$id") or die($mysqli->error());

  $_SESSION['message'] = "เหตุการณ์ถูกลบเรียบร้อย";
  $_SESSION['msg_type'] = "danger";

  header("location: sfsd.php");
}
// Delete data section end


?>
