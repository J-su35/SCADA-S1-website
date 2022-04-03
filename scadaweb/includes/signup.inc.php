<?php

if (isset($_POST['submit'])) {
  include_once 'dbh.inc.php';

  $first = htmlentities($_POST['first']);
  $first = mysqli_real_escape_string($conn, $_POST['first']);
  $last = htmlentities($_POST['last']);
  $last = mysqli_real_escape_string($conn, $_POST['last']);
  $email = htmlentities($_POST['email']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $uid = htmlentities($_POST['uid']);
  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $affi = htmlentities($_POST['affi']);
  $affi = mysqli_real_escape_string($conn, $_POST['affi']);
  $pwd = htmlentities($_POST['pwd']);
  $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
  $pwdRepeat = htmlentities($_POST['pwd-repeat']);

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
          //----------Add new-------------------------------------------------
          if(empty($_POST['g-captcha-response']))
          {
            $captcha_error = 'Captcha is required';
          }
          else {
            $secret_key = '6LemYs4ZAAAAADwKv4qY8lcL3ReBRC_MQFAESFPt';
            $respose = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' .$secret_key. '&response=' .$_POST['g-rechatcha-respose']);

            $respose_data = json_decode($response);

            if(!$respose_data->success)
            {
              $captcha_error = 'Captcha verification failed';
            }
          }

          if($captcha_error == '')
          {
            $data = array(
              'success' => true
            );
          } else {
            $data = array(
              'captcha_error' => $captcha_error
            );
          }
          echo json_encode($data);
          //-----------------------------------------------------------
          //Hashing the PASSWORD
          $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
          //Insert the user into the database
          $stmt = $conn->prepare("INSERT INTO userslogin (user_first, user_last, user_email, user_uid, user_affi, user_pwd) VALUES ('$first', '$last', '$email', '$uid', '$affi', '$hashedPwd');");
          $stmt->bind_param("ssssss", $first, $last, $email, $uid, $affi, $hashedPwd);
          $stmt -> execute();

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
