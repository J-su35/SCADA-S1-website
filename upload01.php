<?php
  $page = "อัพโหลดโหลด 01";
  include_once 'header.php';
?>

<div class="container mt-3">
  <div class="text-center mb-5">
    <h2>อัพโหลดข้อมูล โหลด01</h2>
  </div>

<?php
if ($_SESSION['username'] == "adminS1") {
  // echo $_SESSION['username'];
      echo '
      <div class="container mt-3">
        <div class="row">
          <div class="col-md-6">
            <form method="post" enctype="multipart/form-data">
              <label for="monthName">เดือน : </label>
              <select name="title" class="custom-select" id="monthName" required>
                <option value=""></option>
                <option value="มกราคม">มกราคม</option>
                <option value="กุมภาพันธ์">กุมภาพันธ์</option>
                <option value="มีนาคม">มีนาคม</option>
                <option value="เมษายน">เมษายน</option>
                <option value="พฤษภาคม">พฤษภาคม</option>
                <option value="มิถุนายน">มิถุนายน</option>
                <option value="กรกฎาคม">กรกฎาคม</option>
                <option value="สิงหาคม">สิงหาคม</option>
                <option value="กันยายน">กันยายน</option>
                <option value="ตุลาคม">ตุลาคม</option>
                <option value="พฤศจิกายน">พฤศจิกายน</option>
                <option value="ธันวาคม">ธันวาคม</option>
              </select>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>ประเภทไฟล์</label><br>
              <input type="radio" name="filetype" value="xlsx" class="form-check-input"> xlsx, xls<br>
              <input type="radio" name="filetype" value="PDF" class="form-check-input"> PDF
            </div>

              <div class="form-group">
                <label>Upload file : </label>
                <input type="file" name="xlsx_file">
              </div>

              <div class="row justify-content-center mb-3">
                <input type="submit" name="submit" value="Upload" class="btn btn-primary">
              </div>
            </form>
          </div>
        </div>
      </div>';
} else {
    echo '
    <div class="alert alert-danger">
      <strong>Failed </strong> with not authorized.
    </div>

    <div class="row justify-content-center mb-3">
      <a href="index.php" class="btn btn-info">กลับ</a>
    </div>';
  }

?>

    <?php

    $localhost = "localhost";
    $dbusername = "root";
    $dbpassword = "123456";
    $dbname = "login";

    // $localhost = "sql113.epizy.com";
    // $dbusername = "epiz_24636187";
    // $dbpassword = "uONrYWxJLD";
    // $dbname = "epiz_24636187_login";

    $conn = mysqli_connect($localhost, $dbusername, $dbpassword, $dbname);

    if (isset($_POST["submit"])) {

      if (empty($_POST["title"])) {
        $nameErr = "กรุณาเลือกเดือน";
      }

      $allowedExts = array("xlsx", "xls", "pdf");
      $temp = explode(".", $_FILES["xlsx_file"]["name"]);
      $extension = end($temp);
      $pname = $_FILES["xlsx_file"]["name"];

      $filetype = $_POST['filetype'];

      if (isset($filetype) && $filetype == "xlsx") {
        $title = $_POST["title"]."-xls";

        if (move_uploaded_file($_FILES["xlsx_file"]["tmp_name"],"load01/" . $_FILES["xlsx_file"]["name"])) {

          $sql = mysqli_query($conn,"INSERT INTO load01(title, filename) VALUES('$title', '$pname')");

          if ($sql) {
              echo '<div class="alert alert-success">New file uploaded successfully</div>';

              header("Refresh: 3; upload01.php");
              exit();

          } else {
              echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }

        } else {
          echo '<div class="alert alert-danger"><strong>Error! </strong>File was not uploaded</div>';

          header("Refresh: 3; upload01.php");
          exit();
        }
      } elseif (isset($filetype) && $filetype == "PDF") {
          $title = $_POST["title"]."-PDF";

          if (move_uploaded_file($_FILES["xlsx_file"]["tmp_name"],"load01/" . $_FILES["xlsx_file"]["name"])) {

            $sql = mysqli_query($conn,"INSERT INTO load01(title, filename) VALUES('$title', '$pname')");

            if ($sql) {
                echo '<div class="alert alert-success">New file uploaded successfully</div>';

                header("location: upload01.php");
                exit();

            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }

          } else {
            echo '<div class="alert alert-danger"><strong>Error! </strong>File was not uploaded</div>';

            header("Refresh: 3; upload01.php");
            exit();
          }
      }



      // $tname = $_FILES["xlsx_file"]["tmp_name"];
      // $uploads_dir = 'load01/';
      // move_uploaded_file($tname, $uploads_dir. '/'.$pname);

      // move_uploaded_file($_FILES["xlsx_file"]["tmp_name"],"load01/" . $_FILES["xlsx_file"]["name"]);




  }
    ?>
  </div>

    <!--- Footer -->
    <?php
    require "footer.php";
    ?>
