<?php

if (isset($_POST['login-submit'])) {
  require 'dbh.inc.php';

  $mailuid = $_POST['mailuid'];
  $mailuid = $_POST['pwd'];

  if (empty($mailuil) || empty($password)) {
    header("Location: ../index.phperror=emptyfields");
    exit();
  }
  else {
    $sql ="SELECT * FROM users WHERE uidUsers=? OR emailUsers=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepapre($stmt, $sql)) {
      header("Location: ../index.php?error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($row = mysqli_fetch_assoc($result)) {
        $pwdCheck = password_verify($password, $row['pwdUsers']);
        if ($pwdCheck == false) {
          header("Location: ../index.php?error=wrongpwd");
          exit();
        }
        else if($pwdCheck == true) {
          session_start();
          $_SESSION['userId'] = $row['idUsers'];
          $_SESSION['userUid'] = $row['uidUsers'];

          header("Location: ../index.php?login=success");
          exit();
        }
      }
      else {
        header("Location: ../index.php?error=nouser");
      }
    }
  }
}
else {
  header("Location: ../index.php");
  exit();
}
?>
