<?php

$mysqli = new mysqli('localhost', 'root', '123456', 'login') or die(mysqli_error($mysqli));

$id = 0;
$update = false;
$dateEd = '';
$catEd = '';
$equipcodeEd = '';
$locationEd = '';
$detailEd = '';
$priorityEd = '';
$cusNameEd = '';

// Add data section
if (isset($_POST['save'])){
  $date = $_POST['noti_date'];
  $cat = $_POST['catgories'];
  $equipcode = $_POST['equipcode'];
  $location = $_POST['location'];
  $detail = $_POST['detail'];
  $priority = $_POST['priority'];
  $cusName = $_POST['customerName'];
  $defaultStatus = "รอตรวจสอบ";

  $dateNow = date("Y-m-d");

  $sqlCheck = "SELECT * FROM broken_Equipment WHERE date = '$dateNow'";

  $result = mysqli_query($mysqli, $sqlCheck);
  $resultCheck = mysqli_num_rows($result);
    if ($resultCheck < 10) {
      $IdJob = "0" . $resultCheck . date("d") . date("m") . date("Y");
    } else {
      $IdJob = $resultCheck . date("d") . date("m") . date("Y");
    }


  // mysqli_query($mysqli, 'set character set utf8');
  $mysqli->query("INSERT INTO broken_Equipment(JId, date, catgories, equip_code, location, detail, priority, status, customer) VALUES('$IdJob', '$date', '$cat', '$equipcode', '$location', '$detail', '$priority', '$defaultStatus', '$cusName')") or die($mysqli->error);

  // header("location: bad_equipv.2.php");

  header("Location: ../bad_equipv.2.php?notify=successful");
  exit();
}
// Add data section end

// Delete data section
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $mysqli->query("DELETE FROM broken_Equipment WHERE id=$id") or die($mysqli->error());

  $_SESSION['message'] = "รายการถูกลบ";
  $_SESSION['msg_type'] = "danger";

  header("location: bad_equipBorad.php");
}
// Delete data section end

// Edit data Section
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $update = true;
  $result = $mysqli->query("SELECT * FROM broken_Equipment WHERE id=$id") or die($mysqli->error());
  // if (count($result)==1){   //Original version
  if ($result == TRUE){
    $row = $result->fetch_array();
    $dateEd = $row['date'];
    // $catEd = $_POST['catgories'];
    $equipcodeEd = $row['equip_code'];
    $locationEd = $row['location'];
    $detailEd = $row['detail'];
    // $priorityEd = $row['priority'];
    $cusNameEd = $row['customer'];
  }
}
// Edit data section end

// Update data section
if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $date = $_POST['noti_date'];
  $cat = $_POST['catgories'];
  $equipcode = $_POST['equipcode'];
  $location = $_POST['location'];
  $detail = $_POST['detail'];
  $priority = $_POST['priority'];
  $cusName = $_POST['customerName'];


  $mysqli->query("UPDATE broken_Equipment SET date='$date', catgories='$cat', equip_code='$equipcode', location='$location', detail='$detail', priority='$priority', customer='$cusName' WHERE id=$id") or die($mysqli->error());
  // $mysqli->query("UPDATE broken_Equipment SET date='$date', equip_code='$equipcode', location='$location', detail='$detail', customer='$cusName' WHERE id=$id") or die($mysqli->error());
  // $mysqli->query("UPDATE broken_Equipment SET date='$date' WHERE id=$id") or die($mysqli->error());
  $_SESSION['message'] = "Record has been updated";
  $_SESSION['msg_type'] = "warning";
  // header("location: bad_equipv.2.php");
  header("location: bad_equipBorad.php");
  // exit();

  // header("Location: ../bad_equipBorad?update=successful");
  // exit();
}
// Update data section end
// --------------------------------------------------------------------------



?>
