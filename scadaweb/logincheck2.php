<?php
session_start();

if (isset($_POST['submit'])) {
  include 'includes/dbh.inc.php';

  $user = mysqli_real_escape_string($conn, $_POST['username']);
  $pass = mysqli_real_escape_string($conn, $_POST['password']);

  //Error handlers
  if (empty($user) || empty($pass)) {
      header("Location: ../login.php?error=empty");
      exit();
  } else {
    $sqlCheck = "SELECT * FROM userslogin WHERE user_uid = '$user'";
    $result = mysqli_query($conn, $sqlCheck);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck < 1) {
      header("Location: ../login.php?error=userinvalid");
      exit();
    } else {
      if ($row = mysqli_fetch_assoc($result)) {
        //De-hashing
        $hashedPwdCheck = password_verify($pass, $row['user_pwd']);
        if ($hashedPwdCheck == false) {
          header("Location: ../login.php?error=wrongpassword");
          exit();
        } elseif ($hashedPwdCheck == true) {
          $_SESSION['username'] = $user;

          $sql = "SELECT * FROM userslogin INNER JOIN groups ON userslogin.group_id = groups.id WHERE user_uid = '$user'";
          $result2 = mysqli_query($conn, $sql);
          $row2 = mysqli_fetch_assoc($result2);
          $_SESSION['group'] = $row2['groupname'];

          header("Location: ../index.php?login=success");
          exit();
        }
      }
    }
  }
} else {
  header("Location: ../index.php?login=error");
  exit();
}
?>
