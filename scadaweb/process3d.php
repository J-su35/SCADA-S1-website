<?php

$mysqli = new mysqli('sql113.epizy.com', 'epiz_24636187', 'uONrYWxJLD', 'epiz_24636187_login') or die(mysqli_error($mysqli));

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

  $sqlCheck = "SELECT * FROM broken_equipment WHERE date = '$dateNow'";

  $result = mysqli_query($mysqli, $sqlCheck);
  $resultCheck = mysqli_num_rows($result);
    if ($resultCheck < 10) {
      $IdJob = "0" . $resultCheck . date("d") . date("m") . date("Y");
    } else {
      $IdJob = $resultCheck . date("d") . date("m") . date("Y");
    }


  // mysqli_query($mysqli, 'set character set utf8');
  $mysqli->query("INSERT INTO broken_equipment(JId, date, catgories, equip_code, location, detail, priority, status, customer) VALUES('$IdJob', '$date', '$cat', '$equipcode', '$location', '$detail', '$priority', '$defaultStatus', '$cusName')") or die($mysqli->error);

  header("Location: ../bad_equip.php?notify=successful");
  exit();
}
// Add data section end

// Delete data section
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $mysqli->query("DELETE FROM broken_equipment WHERE id=$id") or die($mysqli->error());

  header("Location: ../bad_equipBoard.php?notify=deleted");
  exit();
}
// Delete data section end

// Edit data Section
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $update = true;
  $result = $mysqli->query("SELECT * FROM broken_equipment WHERE id=$id") or die($mysqli->error());

  if ($result == TRUE){
    $row = $result->fetch_array();
    $dateEd = $row['date'];
    $equipcodeEd = $row['equip_code'];
    $locationEd = $row['location'];
    $detailEd = $row['detail'];
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


  $mysqli->query("UPDATE broken_equipment SET date='$date', catgories='$cat', equip_code='$equipcode', location='$location', detail='$detail', priority='$priority', customer='$cusName' WHERE id=$id") or die($mysqli->error());

  header("Location: ../bad_equipBoard.php?notify=updated");
  exit();
}
// Update data section end
// --------------------------------------------------------------------------

?>
