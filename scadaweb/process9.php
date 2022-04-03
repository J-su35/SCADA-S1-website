<?php

$mysqli = new mysqli('sql113.epizy.com', 'epiz_24636187', 'uONrYWxJLD', 'epiz_24636187_login') or die(mysqli_error($mysqli));

$id = 0;

$monthEd = '';
$yearEd = '';
$substationEd = '';
$read_timeEd = '';
$read_dateEd = '';

$F1_current_ExunitEd = '';
$F1_current_ImunitEd = '';
$F1_last_ExunitEd = '';
$F1_last_ImunitEd = '';
$F1_differentEd = '';
$F1_summationEd = '';

$F2_current_ExunitEd = '';
$F2_current_ImunitEd = '';
$F2_last_ExunitEd = '';
$F2_last_ImunitEd = '';
$F2_differentEd = '';
$F2_summationEd = '';

$F3_current_ExunitEd = '';
$F3_current_ImunitEd = '';
$F3_last_ExunitEd = '';
$F3_last_ImunitEd = '';
$F3_differentEd = '';
$F3_summationEd = '';

$F4_current_ExunitEd = '';
$F4_current_ImunitEd = '';
$F4_last_ExunitEd = '';
$F4_last_ImunitEd = '';
$F4_differentEd = '';
$F4_summationEd = '';

$F5_current_ExunitEd = '';
$F5_current_ImunitEd = '';
$F5_last_ExunitEd = '';
$F5_last_ImunitEd = '';
$F5_differentEd = '';
$F5_summationEd = '';

$loadtransfer_incomingEd = '';
$loadtransfer_feederEd = '';
$sumIncoming_energyEd = '';
$sumFeeder_energyEd = '';
$remarkEd = '';
$operator_nameEd = '';

$legend0 = '';
$legend1 = '';
$legend2 = '';
$legend3 = '';
$legend4 = '';


// Edit data Section
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];

  $result = $mysqli->query("SELECT * FROM subkhw WHERE id=$id") or die($mysqli->error());
  // if (count($result)==1){   //Original version
  if ($result == TRUE){
    $row = $result->fetch_array();

    $monthEd = $row['month'];
    $yearEd = $row['year'];
    $substationEd = $row['subName'];
    $read_timeEd = $row['timeRead'];
    $read_dateEd = $row['dateRead'];

    $F1_current_ExunitEd = $row['nowExF1'];
    $F1_current_ImunitEd = $row['nowImF1'];
    $F1_last_ExunitEd = $row['lastExF1'];
    $F1_last_ImunitEd = $row['lastImF1'];
    $F1_differentEd = $row['diffF1'];
    $F1_summationEd = $row['resultUnitF1'];

    $F1_current_ExunitEd = $row['nowExF2'];
    $F1_current_ImunitEd = $row['nowImF2'];
    $F1_last_ExunitEd = $row['lastExF2'];
    $F1_last_ImunitEd = $row['lastImF2'];
    $F1_differentEd = $row['diffF2'];
    $F1_summationEd = $row['resultUnitF2'];

    $F1_current_ExunitEd = $row['nowExF3'];
    $F1_current_ImunitEd = $row['nowImF3'];
    $F1_last_ExunitEd = $row['lastExF3'];
    $F1_last_ImunitEd = $row['lastImF3'];
    $F1_differentEd = $row['diffF3'];
    $F1_summationEd = $row['resultUnitF3'];

    $F1_current_ExunitEd = $row['nowExF4'];
    $F1_current_ImunitEd = $row['nowImF4'];
    $F1_last_ExunitEd = $row['lastExF4'];
    $F1_last_ImunitEd = $row['lastImF4'];
    $F1_differentEd = $row['diffF4'];
    $F1_summationEd = $row['resultUnitF4'];

    $F1_current_ExunitEd = $row['nowExF5'];
    $F1_current_ImunitEd = $row['nowImF5'];
    $F1_last_ExunitEd = $row['lastExF5'];
    $F1_last_ImunitEd = $row['lastImF5'];
    $F1_differentEd = $row['diffF5'];
    $F1_summationEd = $row['resultUnitF5'];

    $loadtransfer_incomingEd = $row['transferIn'];
    $loadtransfer_feederEd = $row['transferF'];
    $sumIncoming_energyEd = $row['totalUnitIn'];
    $sumFeeder_energyEd = $row['totalUnitF'];
    $remarkEd = $row['remark'];
    $operator_nameEd = $row['author'];
  }

  $legend0 = 'XPU1YB-01';
  $legend1 = 'XPU1BR-01';
  $legend2 = 'XPU2BR-01';
  $legend3 = 'XPU3BR-01';
  $legend4 = 'XPU4BR-01';
}
// Edit data section end

?>
