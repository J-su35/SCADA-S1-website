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
      echo '<form method="post" enctype="multipart/form-data">
          <div class="mb-3">
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


          <div class="custom-file mb-3">
            <input type="file" name="xlsx_file" class="custom-file-input" id="customFile">
            <label class="custom-file-label" for="customFile">Choose file</label>
          </div>

          <div class="row justify-content-center mb-3">
            <input type="submit" name="submit" value="Upload" class="btn btn-primary">
          </div>
    </form>';
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

<script>
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>

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

      $allowedExts = array("xlsx", "xls");
      $temp = explode(".", $_FILES["xlsx_file"]["name"]);
      $extension = end($temp);
      $title = $_POST["title"]."-62";
      $pname = $_FILES["xlsx_file"]["name"];

      // $tname = $_FILES["xlsx_file"]["tmp_name"];
      // $uploads_dir = 'load01/';
      // move_uploaded_file($tname, $uploads_dir. '/'.$pname);

      // move_uploaded_file($_FILES["xlsx_file"]["tmp_name"],"load01/" . $_FILES["xlsx_file"]["name"]);

      if (move_uploaded_file($_FILES["xlsx_file"]["tmp_name"],"load01/" . $_FILES["xlsx_file"]["name"])) {

        $sql = mysqli_query($conn,"INSERT INTO load01(title, filename) VALUES('$title', '$pname')");

        if ($sql) {
            echo '<div class="alert alert-success">New file uploaded successfully</div>';

            // header("location: upload01.php");
            // exit();

        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

      } else {
        echo '<div class="alert alert-danger"><strong>Error! </strong>File was not uploaded</div>';

        header("location: upload01.php");
        exit();
      }


  }
    ?>
  </div>

    <!--- Footer -->
    <?php
    require "footer.php";
    ?>
