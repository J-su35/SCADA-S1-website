<?php

$servername = "sql113.epizy.com";
$dBUsername = "epiz_24636187";
$dBPassword = "uONrYWxJLD";
$dBName = "epiz_24636187_login";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
  die("Connection failed: ".mysqli_connect_error());
}
