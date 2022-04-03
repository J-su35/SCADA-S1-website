<?php

$mysqli = new mysqli('sql113.epizy.com', 'epiz_24636187', 'uONrYWxJLD', 'epiz_24636187_login') or die(mysqli_error($mysqli));

$id = 0;
$update = false;

$jobnumEd = '';
$routeEd = '';
$equipmentEd = '';
$clientEd = '';
$dateopenEd = '';
$timeopenEd = '';
$datecloseEd = '';
$timecloseEd = '';
$causesEd = '';
$detailEd = '';
$locationEd = '';
$repairingEd = '';

// Add data section
if (isset($_POST['save'])){
  $jobnum = $_POST['jobnum'];
  $route = $_POST['route'];
  $equipment = $_POST['equipment'];
  $client = $_POST['client'];
  $dateopen = $_POST['dateopen'];
  $timeopen = $_POST['timeopen'];
  $dateclose = $_POST['dateclose'];
  $timeclose = $_POST['timeclose'];
  $causes = $_POST['causes'];
  $detail = $_POST['detail'];
  $location = $_POST['location'];
  $repairing = $_POST['repairing'];

  $mysqli->query("INSERT INTO bad_fiber(jobnum, route, equipment, client, dateopen, timeopen, dateclose, timeclose, causes, detail, location, repairing) VALUES('$jobnum', '$route', '$equipment', '$client', '$dateopen', '$timeopen', '$dateclose', '$timeclose', '$causes', '$detail', '$location', '$repairing')") or die($mysqli->error);

  $_SESSION['message'] = "Record has been saved";
  $_SESSION['msg_type'] = "success";

  header("location: bad_fiber.php");
}
// Add data section end

// Delete data section
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $mysqli->query("DELETE FROM bad_fiber WHERE id=$id") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted";
  $_SESSION['msg_type'] = "danger";

  header("location: bad_fiber.php");
}
// Delete data section end

// Edit data Section
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $update = true;
  $result = $mysqli->query("SELECT * FROM bad_fiber WHERE id=$id") or die($mysqli->error());
  // if (count($result)==1){   //Original version
  if ($result == TRUE){
    $row = $result->fetch_array();
    $jobnumEd = $row['jobnum'];
    $routeEd = $row['route'];
    $equipmentEd = $row['equipment'];
    $clientEd = $row['client'];
    $dateopenEd = $row['dateopen'];
    $timeopenEd = $row['timeopen'];
    $datecloseEd = $row['dateclose'];
    $timecloseEd = $row['timeclose'];
    $causesEd = $row['causes'];
    $detailEd = $row['detail'];
    $locationEd = $row['location'];
    $repairingEd = $row['repairing'];
  }
}
// Edit data section end

// Update data section
if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $jobnum = $row['jobnum'];
  $route = $row['route'];
  $equipment = $row['equipment'];
  $client = $row['client'];
  $dateopen = $row['dateopen'];
  $timeopen = $row['timeopen'];
  $dateclose = $row['dateclose'];
  $timeclose = $row['timeclose'];
  $causes = $row['causes'];
  $detail = $row['detail'];
  $location = $row['location'];
  $repairing = $row['repairing'];

  $mysqli->query("UPDATE bad_fiber SET jobnum='$jobnum', route='$route', equipment='$equipment', client='$client', dateopen='$dateopen', timeopen='$timeopen', dateclose='$dateclose', timeclose='$timeclose', causes='$causes', detail='$detail', location='$location', repairing='$repairing' WHERE id=$id") or die($mysqli->error());
  $_SESSION['message'] = "Record has been updated";
  $_SESSION['msg_type'] = "warning";
  header("location: bad_fiber.php");
}
// Update data section end

?>
