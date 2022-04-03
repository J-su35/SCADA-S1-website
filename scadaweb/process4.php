<?php

session_start();

$mysqli = new mysqli('localhost', 'root', '123456', 'login') or die(mysqli_error($mysqli));

$id = 0;
$update = false;
$time = '';
$date = '';
$sub = '';

// Add data section
if (isset($_POST['save'])){
  $time = $_POST['time'];
  $date = $_POST['date'];
  $sub = $_POST['sub'];

  $mysqli->query("INSERT INTO commu_down(timedown, notidate, sub) VALUES('$time', '$date', '$sub')") or die($mysqli->error);

  $_SESSION['message'] = "Record has been saved";
  $_SESSION['msg_type'] = "success";

  header("location: subdown.php");
}

// Delete data section
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $mysqli->query("DELETE FROM commu_down WHERE id=$id") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted";
  $_SESSION['msg_type'] = "danger";

  header("location: subdown.php");
}
// Delete data section end

// Edit data Section
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $update = true;
  $result = $mysqli->query("SELECT * FROM commu_down WHERE id=$id") or die($mysqli->error());
  // if (count($result)==1){   //Original version
  if ($result == TRUE){
    $row = $result->fetch_array();
    $time = $row['timedown'];
    $date = $row['notidate'];
    $sub = $row['sub'];
  }
}
// Edit data section end

// Update data section
if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $time = $_POST['time'];
  $date = $_POST['date'];
  $sub = $_POST['sub'];

  $mysqli->query("UPDATE commu_down SET timedown='$time', notidate='$date', sub='$sub' WHERE id=$id") or die($mysqli->error());
  $_SESSION['message'] = "Record has been updated";
  $_SESSION['msg_type'] = "warning";
  header("location: subdown.php");
}
// Update data section end

 ?>
