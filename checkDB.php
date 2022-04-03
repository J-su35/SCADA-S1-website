<?php
include 'includes/dbh.inc.php';

$dateNow = date("Y-m-d");
// echo $dateNow . "<br>";

$sqlCheck = "SELECT * FROM broken_Equipment WHERE date = '$dateNow'";
$result = mysqli_query($conn, $sqlCheck);
$resultCheck = mysqli_num_rows($result);
$resultplus = $resultCheck+1;
// echo $resultCheck;
echo $resultplus;
// if ($resultCheck < 10) {
//   $jobID = "0" .$resultCheck. date("d") . date("m") . date("Y");
//   echo $jobID;
// } elseif ($resultCheck > 9 && < 100 ) {
//     $jobID = $resultCheck . date("d") . date("m") . date("Y");
//     echo $jobID;
// } else {
//     echo "JobID Error!";
// }

?>
