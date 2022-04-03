<?php

$mysqli = new mysqli('sql113.epizy.com', 'epiz_24636187', 'uONrYWxJLD', 'epiz_24636187_login') or die(mysqli_error($mysqli));

$id = 0;
$update = false;

$equipNameEd = '';
$locationEd = '';
$date1Ed = '';
$name1Ed = '';
$causeEd = '';
$divisionEd = '';
$date2Ed = '';
$detailEd = '';
$name2Ed = '';

// Add data section
if (isset($_POST['save'])){
  $equipName = $_POST['equipName'];
  $location = $_POST['location'];
  $date1 = $_POST['date1'];
  $name1 = $_POST['name1'];
  $cause = $_POST['cause'];
  $division = $_POST['division'];
  $date2 = $_POST['date2'];
  $detail = $_POST['detail'];
  $name2 = $_POST['name2'];

  $mysqli->query("INSERT INTO master_frtu(equipName, location, date1, name1, cause, division, date2, detail, name2) VALUES('$equipName', '$location', '$date1', '$name1', '$cause', '$division', '$date2', '$detail', '$name2')") or die($mysqli->error);

  $_SESSION['message'] = "Record has been saved";
  $_SESSION['msg_type'] = "success";

  header("location: bad_fiber.php");
}
// Add data section end

// Delete data section
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $mysqli->query("DELETE FROM master_frtu WHERE id=$id") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted";
  $_SESSION['msg_type'] = "danger";

  header("location: bad_fiber.php");
}
// Delete data section end

// Edit data Section
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $update = true;
  $result = $mysqli->query("SELECT * FROM master_frtu WHERE id=$id") or die($mysqli->error());
  // if (count($result)==1){   //Original version
  if ($result == TRUE){
    $row = $result->fetch_array();
    $equipNameEd = $row['equipName'];
    $locationEd = $row['location'];
    $date1Ed = $row['date1'];
    $name1Ed = $row['name1'];
    $causeEd = $row['cause'];
    $divisionEd = $row['division'];
    $date2Ed = $row['date2'];
    $detailEd = $row['detail'];
    $name2Ed = $row['name2'];
  }
}
// Edit data section end

// Update data section
if (isset($_POST['update'])) {
  $id = $_POST['id'];

  $equipNameEd = $_POST['equipName'];
  $locationEd = $_POST['location'];
  $date1Ed = $_POST['date1'];
  $name1Ed = $_POST['name1'];
  $causeEd = $_POST['cause'];
  $divisionEd = $_POST['division'];
  $date2Ed = $_POST['date2'];
  $detailEd = $_POST['detail'];
  $name2Ed = $_POST['name2'];

  $mysqli->query("UPDATE master_frtu SET equipName='$equipName', location='$location', date1='$date1', name1='$name1', cause='$cause', division='$division', date2='$data2', detail=$detail, name2=$name2 WHERE id=$id") or die($mysqli->error());
  $_SESSION['message'] = "Record has been updated";
  $_SESSION['msg_type'] = "warning";
  header("location: bad_fiber.php");
}
// Update data section end

?>
