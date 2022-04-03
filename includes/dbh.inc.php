<?php

$servername = "localhost";
$dBUsername = "root";
$dBPassword = "123456";
$dBName = "login";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
  die("Connection failed: ".mysqli_connect_error());
}
