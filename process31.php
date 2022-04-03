<?php

$mysqli = new mysqli('localhost', 'root', '123456', 'login') or die(mysqli_error($mysqli));

$id = 0;
$update = false;
$numberintEd = '';
$numberfloatEd = '';

// Add data section
if (isset($_POST['save'])){
  $number = $_POST['numberint'];
  $float = $_POST['numberfloat'];

  $mysqli->query("INSERT INTO 	equip_problemstest(numberint, numberfloat) VALUES('$number', '$float')") or die($mysqli->error);

  $_SESSION['message'] = "Record has been saved";
  $_SESSION['msg_type'] = "success";

  // header("location: testcss.php");
  header("Refresh: 3; testcss.php");
  exit();
}
// Add data section end

// Delete data section
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $mysqli->query("DELETE FROM equip_problemstest WHERE id=$id") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted";
  $_SESSION['msg_type'] = "danger";

  header("location: testcss.php");
  exit();
}
// Delete data section end

// Edit data Section
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $update = true;
  $result = $mysqli->query("SELECT * FROM equip_problemstest WHERE id=$id") or die($mysqli->error());
  // if (count($result)==1){   //Original version
  if ($result == TRUE){
    $row = $result->fetch_array();
    $numberintEd = $row['numberint'];
    $numberfloatEd = $row['numberfloat'];
  }
}
// Edit data section end

// Update data section
if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $date = $_POST['numberint'];
  $equipcode = $_POST['numberfloat'];

  $mysqli->query("UPDATE equip_problemstest SET numberint='$number', numberfloat='$float' WHERE id=$id") or die($mysqli->error());
  $_SESSION['message'] = "Record has been updated";
  $_SESSION['msg_type'] = "warning";
  header("location: testcss.php");
  exit();
}
// Update data section end

?>
