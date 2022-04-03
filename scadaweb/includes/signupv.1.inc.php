<?php

if (isset($_POST['submit'])) {
  include_once 'dbh.inc.php';

  $first = mysqli_real_escape_string($conn, $_POST['first']);
  $last = mysqli_real_escape_string($conn, $_POST['last']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $affi = mysqli_real_escape_string($conn, $_POST['affi']);
  $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
  $pwdRepeat = $_POST['pwd-repeat'];

  //Error handlers
  //Check for empty fields
  if (empty($first) || empty($last) || empty($email) || empty($uid) || empty($affi) || empty($pwd) || empty($pwdRepeat)) {
    header("Location: ../signup.php?error=emptyfields");
    exit();
  } else {
  //Check if inpupt characters are valid
  // if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last)) {
  if (!preg_match("/[กขคง]/", $first) || !preg_match("/[กขคง]/", $last)) {
    header("Location: ../signup.php?error=invalidfirstlastname");
    exit();
  } else {
    //Check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      header("Location: ../signup.php?error=invalidmail");
      exit();
    } elseif (strpos($email, "@pea.co.th") < 1) {
        header("Location: ../signup.php?error=invalidmail");
        exit();
    } else {
      $sql = "SELECT * FROM userslogin WHERE user_uid='$uid'";
      $result = mysqli_query($conn, $sql);
      $resultCheck = mysqli_num_rows($result);

      if ($resultCheck > 0) {
        header("Location: ../signup.php?error=usertaken");
        exit();
      } else {
        if ($pwd !== $pwdRepeat) {
          header("Location: ../signup.php?error=passwordcheck&uid=".$uid."&mail=".$email);
          exit();
        } else {
          //Hashing the PASSWORD
          $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
          //Insert the user into the database
          $sql = "INSERT INTO userslogin (user_first, user_last, user_email, user_uid, user_affi, user_pwd) VALUES ('$first', '$last', '$email', '$uid', '$affi', '$hashedPwd');";

          mysqli_query($conn, $sql);
          header("Location: ../signup.php?signup=success");
          exit();
        }
      }
    }
  }
  }
} else {
  header("Location: ../signup.php");
  exit();
}
