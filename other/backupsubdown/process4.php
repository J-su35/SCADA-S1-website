<?php

$mysqli = new mysqli('localhost', 'root', '123456', 'login') or die(mysqli_error($mysqli));

// Add data section
if (isset($_POST['save'])){
  $time = $_POST['time'];
  $date = $_POST['date'];
  $sub = $_POST['sub'];

  $mysqli->query("INSERT INTO commu_down(timedown, notidate, sub) VALUES('$time', '$date', '$sub')") or die($mysqli->error);

}

 ?>
