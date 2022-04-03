<?php

if (isset($_POST['submit'])) {
  include_once 'dbh.inc.php';

  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
  $pwdRepeat = $_POST['pwd-repeat'];

  //Error handlers
  //Check for empty fields
  if (empty($username) || empty($pwd) || empty($pwdRepeat)) {
    header("Location: ../signup0.php?signup=empty");
    exit();
  } elseif (!preg_match("/^[a-zA-Z]*$/", $username)) {
    header("Location: ../signup0.php?signup=invalid");
    exit();
  } elseif ($pwd !== $pwdRepeat) {
    header("Location: ../signup0.php?error=passwordcheck&uid");
    exit();
  }
    //Hashing the PASSWORD
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    //Insert the user into the database
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPwd');";

    mysqli_query($conn, $sql);
    header("Location: ../signup0.php?signup=success");
    exit();


} else {
  header("Location: ../signup0.php");
  exit();
}
