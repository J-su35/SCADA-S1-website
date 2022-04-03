<?php
 // to get values passe from form in login.php file
 $username = "";

if(isset($_POST['username'])){
    $username = $_POST['username'];
}
 $password = "";
if(isset($_POST['username'])){
    $password = $_POST['password'];
 }

 $con = mysqli_connect("localhost", "root", "123456", "login");
 // to prevent mysql injection
 $username = stripcslashes($username);
 $password = stripcslashes($password);
 $username = mysqli_real_escape_string($con, $username);
 $password = mysqli_real_escape_string($con, $password);

 //connect to the server select database
 // mysqli_connect("localhost", "root", "");
 // mysqli_select_db("login");

 // Query the database for user
 $result = mysqli_query($con, "select * from users where username = '$username' and password = '$password'")
  or die('Failed to query database'.mysqli_error());
 $row = mysqli_fetch_array($result);
 if ( $row['username'] == $username && $row['password'] == $password ) {
  echo "login success! Welcome".$row['username'];
 } else {
     echo "Failed to login!";
}

?>
