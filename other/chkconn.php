<?php

// $conn = mysqli_connect("localhost", "root", "123456", "login");
$conn = mysqli_connect("127.0.0.1", "root", "123456");

if($conn) {
  echo "connection successful";
} else {
  echo "Failed to connect";
}

$db = mysqli_select_db($conn, 'login');
if(isset($_POST['submit'])){
  $user = $_POST['username'];
  $pass = $_POST['password'];
  echo "success!";

$result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$user' AND password = '$pass'")
 or die('Failed to query database'.mysqli_error());
$row = mysqli_fetch_array($result);
if ( $row['username'] == $user && $row['password'] == $pass ) {
 echo "login success! Welcome".$row['username'];
} else {
    echo "Failed to login!";
}
}
?>
