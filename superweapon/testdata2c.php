<?php
require_once 'includes/dbConfig.php';

if(isset($_POST['sub']) && isset($_POST['feeder']) && isset($_POST['catRadio']) && isset($_POST['startDate']) && isset($_POST['endDate'])) {
  $catRadio = $_POST['catRadio'];
  $substation = $_POST['sub'];
  $feeder = $_POST['feeder'];
  $startDate = $_POST['startDate'];
  $endDate = $_POST['endDate'];

  $sql = "SELECT substation, feeder, subload, submvar, subvab, subvac, subvca, pf, time, date FROM data WHERE substation = '$substation' AND feeder = '$feeder' AND DATE BETWEEN '$startDate'AND '$endDate'";

  $data = array();

  $result = mysqli_query($db, $sql);
  while($row = mysqli_fetch_array($result))
  {
    $data[] = $row;
  }

  echo json_encode($data);

}
?>
