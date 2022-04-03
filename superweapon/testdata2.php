<?php
require_once 'includes/dbConfig.php';
//fetch.php

// if(isset($_POST['catRadio']) && isset($_POST['sub']) && isset($_POST['feeder']) && isset($_POST['startDate']) && isset($_POST['endDate']))
// {
if(isset($_POST['id']))
  {
 // $connect = mysqli_connect("localhost", "root", "", "testing");
 $sql = "SELECT substation, feeder, subload, time, date FROM data WHERE substation = 'RBB' AND feeder = '01VB01' AND DATE '2021-01-01' GROUP BY substation";
 $result = mysqli_query($db, $sql);
 while($row = mysqli_fetch_array($result))
 {
  $data["substation"] = $row["substation"];
  // $data[] = $row;
 }

 echo json_encode($data);
}
?>
