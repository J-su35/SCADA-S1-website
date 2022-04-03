<?php

$mysqli = new mysqli('sql113.epizy.com', 'epiz_24636187', 'uONrYWxJLD', 'epiz_24636187_login') or die(mysqli_error($mysqli));

$id = 0;

// Add data section
if (isset($_POST['save'])){
  $month = $_POST['month'];
  $year = $_POST['yeartxt'];
  $subName = $_POST['substaion'];
  $timeRead = $_POST['read_time'];
  $dateRead = $_POST['read_date'];

  $nowExF1 = $_POST['F1_current_Exunit'];
  $nowImF1 = $_POST['F1_current_Imunit'];
  $lastExF1 = $_POST['F1_last_Exunit'];
  $lastImF1 = $_POST['F1_last_Imunit'];
  $diffF1 = $_POST['F1_different'];
  $resultUnitF1 = $_POST['F1_summation'];

  $nowExF2 = $_POST['F2_current_Exunit'];
  $nowImF2 = $_POST['F2_current_Imunit'];
  $lastExF2 = $_POST['F2_last_Exunit'];
  $lastImF2 = $_POST['F2_last_Imunit'];
  $diffF2 = $_POST['F2_different'];
  $resultUnitF2 = $_POST['F2_summation'];

  $nowExF3 = $_POST['F3_current_Exunit'];
  $nowImF3 = $_POST['F3_current_Imunit'];
  $lastExF3 = $_POST['F3_last_Exunit'];
  $lastImF3 = $_POST['F3_last_Imunit'];
  $diffF3 = $_POST['F3_different'];
  $resultUnitF3 = $_POST['F3_summation'];

  $nowExF4 = $_POST['F4_current_Exunit'];
  $nowImF4 = $_POST['F4_current_Imunit'];
  $lastExF4 = $_POST['F4_last_Exunit'];
  $lastImF4 = $_POST['F4_last_Imunit'];
  $diffF4 = $_POST['F4_different'];
  $resultUnitF4 = $_POST['F4_summation'];

  $nowExF5 = $_POST['F5_current_Exunit'];
  $nowImF5 = $_POST['F5_current_Imunit'];
  $lastExF5 = $_POST['F5_last_Exunit'];
  $lastImF5 = $_POST['5F5_last_Imunit'];
  $diffF5 = $_POST['F5_different'];
  $resultUnitF5 = $_POST['F5_summation'];

  $transferIn = $_POST['loadtransfer_incoming'];
  $tranferF = $_POST['loadtransfer_feeder'];
  $sumIn_En = $_POST['sumIncoming_energy'];
  $sumF_En = $_POST['sumFeeder_energy'];
  $message = $_POST['message'];
  $operatorname = $_POST['operator_name'];

  $mysqli->query("INSERT INTO subkhw(month, year, subName, timeRead, dateRead, nowExF1, nowImF1, lastExF1, lastImF1, diffF1, resultUnitF1, nowExF2, nowImF2, lastExF2, lastImF2, diffF2, resultUnitF2, nowExF3, nowImF3, lastExF3, lastImF3, diffF3, resultUnitF3, nowExF4, nowImF4, lastExF4, lastImF4, diffF4, resultUnitF4, nowExF5, nowImF5, lastExF5, lastImF5, diffF5, resultUnitF5, transferIn, transferF, totalUnitIn, totalUnitF, remark, author) VALUES('$month', '$year', '$subName', '$timeRead', '$dateRead', '$nowExF1', '$nowImF1', '$lastExF1', '$lastImF1', '$diffF1', '$resultUnitF1', '$nowExF2', '$nowImF2', '$lastExF2', '$lastImF2', '$diffF2', '$resultUnitF2', '$nowExF3', '$nowImF3', '$lastExF3', '$lastImF3', '$diffF3', '$resultUnitF3', '$nowExF4', '$nowImF4', '$lastExF4', '$lastImF4', '$diffF4', '$resultUnitF4', '$nowExF5', '$nowImF5', '$lastExF5', '$lastImF5', '$diffF5', '$resultUnitF5', '$transferIn', '$tranferF', '$sumIn_En', '$sumF_En', '$message', '$operatorname')") or die($mysqli->error);

  $_SESSION['message'] = "Record has been saved";
  $_SESSION['msg_type'] = "success";

  header("location: substationkhw.php");
}
// Add data section end

?>
