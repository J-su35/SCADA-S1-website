<?php

$mysqli = new mysqli('sql113.epizy.com', 'epiz_24636187', 'uONrYWxJLD', 'epiz_24636187_login') or die(mysqli_error($mysqli));

$id = 0;
$update = false;
$dateEd = '';
$equipcodeEd = '';
$locationEd = '';
$detailEd = '';
$actionEd = '';
$action_dateEd = '';

// Add data section
if (isset($_POST['save'])){
  $date = $_POST['noti_date'];
  $equipcode = $_POST['equipcode'];
  $location = $_POST['location'];
  $detail = $_POST['detail'];
  $action = $_POST['action'];
  $action_date = $_POST['action_date'];

  $mysqli->query("INSERT INTO equip_problems1(date, equip_code, location, detail, action, action_date) VALUES('$date', '$equipcode', '$location', '$detail', '$action', '$action_date')") or die($mysqli->error);

  $_SESSION['message'] = "Record has been saved";
  $_SESSION['msg_type'] = "success";

  header("location: bad_equip.php");
}
// Add data section end

// Delete data section
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $mysqli->query("DELETE FROM equip_problems1 WHERE id=$id") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted";
  $_SESSION['msg_type'] = "danger";

  header("location: bad_equip.php");
}
// Delete data section end

// Edit data Section
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $update = true;
  $result = $mysqli->query("SELECT * FROM equip_problems1 WHERE id=$id") or die($mysqli->error());
  // if (count($result)==1){   //Original version
  if ($result == TRUE){
    $row = $result->fetch_array();
    $dateEd = $row['date'];
    $equipcodeEd = $row['equip_code'];
    $locationEd = $row['location'];
    $detailEd = $row['detail'];
    $actionEd = $row['action'];
    $action_date = $row['action_date'];
  }
}
// Edit data section end

// Update data section
if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $date = $_POST['noti_date'];
  $equipcode = $_POST['equipcode'];
  $location = $_POST['location'];
  $detail = $_POST['detail'];
  $action = $_POST['action'];
  $action_date = $_POST['action_date'];

  $mysqli->query("UPDATE equip_problems1 SET date='$date', equip_code='$equipcode', location='$location', detail='$detail', action='$action', action_date='$action_date' WHERE id=$id") or die($mysqli->error());
  $_SESSION['message'] = "Record has been updated";
  $_SESSION['msg_type'] = "warning";
  header("location: bad_equip.php");
}
// Update data section end

?>
