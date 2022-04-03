<?php
//db details for test2.php
$servername = "localhost";
$dBUsername = "root";
$dBPassword = "123456";
$dBName = "ods_db";

//Connect and select the database
$db = new mysqli($servername, $dBUsername, $dBPassword, $dBName);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
