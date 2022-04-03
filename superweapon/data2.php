<?php


header('Content-Type: application/json');

require_once 'includes/dbConfig.php';

// extract($_POST);

if(isset($_POST['catRadio']) && isset($_POST['sub']) && isset($_POST['feeder']) && isset($_POST['startDate']) && isset($_POST['endDate'])) {

  $catRadio = $_POST['catRadio'];
  $subName = $_POST['sub'];
  $feeder = $_POST['feeder'];
  $startDate = $_POST['startDate'];
  $endDate = $_POST['endDate'];

  // $sql = "SELECT substation, feeder, $catRadio, time, date FROM data WHERE substation = $subName AND feeder = $feeder AND DATE BETWEEN $startDate AND $endDate";
  $sql = "SELECT substation, feeder, subload, time, date FROM data WHERE substation = 'RBB' AND feeder = '01VB01' AND DATE '2021-01-01'";
  $result = mysqli_query($db, $sql);

  $data = array();

  while ($row = mysqli_fetch_array($result)) {
      // $data[] = $row;
      $data[] = $row["substation"];
  }
//   $result = sqlsrv_query( $conn, $sqlQuery, $data);
//   if( $result === false ) {
//        die( print_r( sqlsrv_errors(), true));
//   }

//   foreach ($result as $row) {
//       $data[] = $row;
//   }

//   sqlsrv_close($conn);

//   echo json_encode($data);

//-----------------------------------------------------------------



// foreach ($result as $row) {
//   $data[] = $row;
// }

mysqli_close($db);

echo json_encode($data);
}

?>
