<?php
session_start();

$conn = mysqli_connect("localhost", "root", "123456");
// $conn = mysqli_connect("sql113.epizy.com", "epiz_24636187", "uONrYWxJLD");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$db = mysqli_select_db($conn, 'login');
// $db = mysqli_select_db($conn, 'epiz_24636187_login');

if(isset($_POST['submit'])){
  $user = $_POST['username'];
  $pass = $_POST['password'];

  // $result = mysqli_query($conn, "SELECT * FROM userslogin WHERE user_uid = '$user' AND user_pwd = '$pass'")
  $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$user' AND password = '$pass'")
   or die('Failed to query database'.mysqli_error());
  $row = mysqli_fetch_array($result);
    if ( $row['username'] == $user && $row['password'] == $pass ) {
      echo "login successful";
      $_SESSION['username'] = $user;
      header("location:index.php");
    } else {
      echo "login failed";
      header('location:login.html');
    }
  }
?>
