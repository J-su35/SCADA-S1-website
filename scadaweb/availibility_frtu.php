<?php
  $page = "รายงานความพร้อมใช้งานระบบสื่อสารของชุด FRTU";
  include_once 'header.php';
?>

<div class="container mt-3">
  <div class="text-center mb-5">
    <h2>รายงานความพร้อมใช้งานระบบสื่อสารของชุด FRTU</h2>
  </div>

<?php
if ($_SESSION['username'] == "scadaadmin" || $_SESSION['username'] == "commuadmin") {
      echo '
      <div class="container my-5">
        <form method="post" enctype="multipart/form-data">
    			<div class="form-group">
    	      <label>รายงาน : </label>
    	      <input type="text" name="title" class="form-control">
    			</div>
          <div class="form-group">
    	      <label>Download link </label>
    	      <input type="url" name="url" class="form-control">
    			</div>
    			<div class="form-group mt-5">
    	      <label>Upload QR code : </label>
    	      <input type="file" name="img"><br>
    	      <input type="submit" name="submit" value="Upload" class="btn btn-primary">
    			</div>
        </form>
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

    $localhost = "sql113.epizy.com";
    $dbusername = "epiz_24636187";
    $dbpassword = "uONrYWxJLD";
    $dbname = "epiz_24636187_login";

    $conn = mysqli_connect($localhost, $dbusername, $dbpassword, $dbname);

    if (isset($_POST["submit"])) {

      if (empty($_POST["title"])) {
        $nameErr = "กรุณาใส่ชื่อเรื่อง";
      }

      // $dir_target = "img_frtu/".$img;

        $title = $_POST["title"];
        $url = $_POST["url"];
        $img = $_FILES['img']['name'];

        $dir_target = "img_frtu/".$img;

        $imgError = $files['error'];
        $imgError = $files['tmp_name'];

        $imgExt = explode('.', $img);
        $imgCheck = strtolower(end($imgExt));

        $imgType = array('png','jpg','jpeg','bmp','gif');

        if (move_uploaded_file($_FILES["img"]["tmp_name"], $dir_target)) {

          $sql = mysqli_query($conn,"INSERT INTO avai_frtu(title, url, img) VALUES('$title', '$url', '$img')");

          if ($sql) {
              echo '<div class="alert alert-success">Uploaded successfully</div>';

              header("location: availibility_frtu.php?uploadsuccess");

          } else {
              echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }

        } else {
          echo '<div class="alert alert-danger"><strong>Error! </strong>File was not uploaded</div>';

          header("Refresh: 3; availibility_frtu.php");
          exit;
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
