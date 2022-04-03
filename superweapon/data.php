<?php

header('Content-Type: application/json');

require_once 'includes/dbh.inc.php';

$sqlsrvQuery = "SELECT substation, feeder, subload, time, date FROM LOAD_2021 WHERE substation = 'RNB' AND feeder = '02VB01' AND DATE = '2021-02-20'";

$data = array();

$stmt = sqlsrv_query($conn, $sqlQuery);
if($stmt === false) {
    die (print_r(sqlsrv_errors(),true()));
}

while($row = sqlsrv_fetch_Array($stmt)) {
    $data[] = $row;
}

sqlsrv_close($conn);

echo json_encode($data);

 ?>
