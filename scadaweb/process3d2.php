<?php

$mysqli = new mysqli('sql113.epizy.com', 'epiz_24636187', 'uONrYWxJLD', 'epiz_24636187_login') or die(mysqli_error($mysqli));

$id = 0;
$date_endEd = '';
$ma_nameEd = '';

// Edit data Section
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $result = $mysqli->query("SELECT * FROM broken_equipment WHERE id=$id") or die($mysqli->error());

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

  $mysqli->query("UPDATE broken_equipment SET date_end='$date_end', status='$status', ma_name='$ma_name' WHERE id=$id") or die($mysqli->error());

  header("Location: ../bad_equipBoard.php?notify=statusUpdated");
  exit();
}
// Update data section end
// --------------------------------------------------------------------------



?>
