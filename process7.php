<?php

$mysqli = new mysqli('localhost', 'root', '123456', 'login') or die(mysqli_error($mysqli));

$id = 0;
$update = false;

$dateEd = '';
$locationEd = '';
$equipmentEd = '';
$causesEd = '';
$detailEd = '';
$datefinishedEd = '';
$otherEd = '';

// Add data section
if (isset($_POST['save'])){
  $date = $_POST['date'];
  $location = $_POST['location'];
  $equipment = $_POST['equipment'];
  $causes = $_POST['causes'];
  $detail = $_POST['detail'];
  $datefinished = $_POST['datefinished'];
  $other = $_POST['other'];

  $mysqli->query("INSERT INTO bad_sdh(date, location, equipment, causes, detail, dateend, other) VALUES('$date', '$location', '$equipment', '$causes', '$detail', '$datefinished', '$other')") or die($mysqli->error);

  $_SESSION['message'] = "Record has been saved";
  $_SESSION['msg_type'] = "success";

  header("location: bad_SDH.php");
}
// Add data section end

// Delete data section
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $mysqli->query("DELETE FROM bad_sdh WHERE id=$id") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted";
  $_SESSION['msg_type'] = "danger";

  header("location: bad_sdh.php");
}
// Delete data section end

// Edit data Section
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $update = true;
  $result = $mysqli->query("SELECT * FROM bad_sdh WHERE id=$id") or die($mysqli->error());
  // if (count($result)==1){   //Original version
  if ($result == TRUE){
    $row = $result->fetch_array();
    $dateEd = $row['date'];
    $locationEd = $row['location'];
    $equipmentEd = $row['equipment'];
    $causesEd = $row['causes'];
    $detailEd = $row['detail'];
    $datefinishedEd = $row['datefinished'];
    $otherEd = $row['other'];
  }
}
// Edit data section end

// Update data section
if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $dateEd = $_POST['date'];
  $locationEd = $_POST['location'];
  $equipmentEd = $_POST['equipment'];
  $causesEd = $_POST['causes'];
  $detailEd = $_POST['detail'];
  $datefinishedEd = $_POST['datefinished'];
  $otherEd = $_POST['other'];

  $mysqli->query("UPDATE bad_sdh SET date='$date', location='$location', equipment='$equipment', causes='$causes', detail='$detail', dateend='$datefinished', other='$other' WHERE id=$id") or die($mysqli->error());
  $_SESSION['message'] = "Record has been updated";
  $_SESSION['msg_type'] = "warning";
  header("location: bad_SDH.php");
}
// Update data section end

?>
