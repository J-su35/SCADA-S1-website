<?php

$mysqli = new mysqli('localhost', 'root', '123456', 'login') or die(mysqli_error($mysqli));

$id = 0;
$date_endEd = '';
$ma_nameEd = '';

// Edit data Section
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $result = $mysqli->query("SELECT * FROM broken_Equipment WHERE id=$id") or die($mysqli->error());
  // if (count($result)==1){   //Original version
  if ($result == TRUE){
    $row = $result->fetch_array();
    $date_endEd = $row['date_end'];

    $cusNameEd = $row['ma_name'];
  }
}
// Edit data section end

// Update data section
if (isset($_POST['updateStatus'])) {
  $id = $_POST['id'];
  $date_end = $_POST['date_end'];
  $status = $_POST['status'];
  $ma_name = $_POST['ma_name'];

  $mysqli->query("UPDATE broken_Equipment SET date_end='$date_end', status='$status', ma_name='$ma_name' WHERE id=$id") or die($mysqli->error());

  $_SESSION['message'] = "Record has been updated";
  $_SESSION['msg_type'] = "warning";
  // header("location: bad_equipv.2.php");

  header("Location: ../bad_equipBorad.php?notify=update completed");
  exit();

  // header("Location: ../bad_equipBorad?update=successful");
  // exit();
}
// Update data section end
// --------------------------------------------------------------------------



?>
