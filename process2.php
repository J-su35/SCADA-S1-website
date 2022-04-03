<?php

session_start();

$mysqli = new mysqli('localhost', 'root', '123456', 'login') or die(mysqli_error($mysqli));

$id = 0;
$update = false;
$name = '';
$location = '';

// Add data section
if (isset($_POST['save'])){
  $name = $_POST['name'];
  $location = $_POST['location'];

  $mysqli->query("INSERT INTO noti_equip(name, location) VALUES('$name', '$location')") or die($mysqli->error);

  $_SESSION['message'] = "Record has been saved";
  $_SESSION['msg_type'] = "success";

  header("location: notifyequip2.php");
}
// Add data section end

// Delete data section
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $mysqli->query("DELETE FROM noti_equip WHERE id=$id") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted";
  $_SESSION['msg_type'] = "danger";

  header("location: notifyequip2.php");
}
// Delete data section end

// Edit data Section
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $update = true;
  $result = $mysqli->query("SELECT * FROM noti_equip WHERE id=$id") or die($mysqli->error());
  // if (count($result)==1){   //Original version
  if ($result == TRUE){
    $row = $result->fetch_array();
    $name = $row['name'];
    $location = $row['location'];
  }
}
// Edit data section end

// Update data section
if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $location = $_POST['location'];

  $mysqli->query("UPDATE noti_equip SET name='$name', location='$location' WHERE id=$id") or die($mysqli->error());
  $_SESSION['message'] = "Record has been updated";
  $_SESSION['msg_type'] = "warning";
  header("location: notifyequip2.php");
}
// Update data section end
 ?>
