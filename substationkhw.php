<?php
  $page = "ลงข้อมูลมาตรวัดไฟฟ้าประจำเดือน";
  include_once 'header.php';
?>

<?php
if ($_SESSION['username'] == "adminS1" || $_SESSION['group'] == "substation") {
  echo '
  <div class="container my-5">
    <form method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label>ชื่อไฟล์ : </label>
        <input type="text" name="title" class="form-control">
      </div>
      <div class="mb-3">
        <label for="monthName">เดือน : </label>
        <select name="month" class="custom-select" id="monthName" required>
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
      <div class="form-group">
          <label for="subName">สฟฟ.</label>
          <select name="subName" id="subName" class="form-control" required>
            <option value=""></option>
            <option value="จอมบึง">จอมบึง</option>
            <option value="ชะอำ 1">ชะอำ 1</option>
            <option value="ชะอำ 2">ชะอำ 2</option>
            <option value="ชะอำ 3">ชะอำ 3</option>
            <option value="ปากท่อ">ปากท่อ</option>
            <option value="โพธาราม">โพธาราม</option>
            <option value="ราชบุรี 2 ลานไก">ราชบุรี 2 ลานไก</option>
            <option value="ราชบุรี 2">ราชบุรี 2</option>
            <option value="ราชบุรี 3 (ชั่วคราว)">ราชบุรี 3 (ชั่วคราว)</option>
            <option value="ราชบุรี 3 (ถาวร)">ราชบุรี 3 (ถาวร)</option>
            <option value="หัวหิน 2">หัวหิน 2</option>
            <option value="หัวหิน 3">หัวหิน 3</option>
            <option value="หัวหิน 4">หัวหิน 4</option>
            <option value="ดำเนินสะดวก">ดำเนินสะดวก</option>
            <option value="สวนผึ้ง">สวนผึ้ง</option>
          </select>
        </div>

      <div class="form-group mt-5">
        <label>Upload file : </label>
        <input type="file" name="xlsx_file">
        <input type="submit" name="submit" value="Upload" class="btn btn-primary">
      </div>
    </form>
  </div>';
} else {
  echo '
  <div class="container-fluid my-3">
    <div class="alert alert-danger">
      <strong>Failed </strong> with not authorized.
    </div>

    <div class="row justify-content-center mb-3">
      <a href="index.php" class="btn btn-info">กลับ</a>
    </div>
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
      $allowedExts = array("xlsx", "xls");
      $temp = explode(".", $_FILES["xlsx_file"]["name"]);
      $extension = end($temp);
      $pname = $_FILES["xlsx_file"]["name"];

      // $tname = $_FILES["xlsx_file"]["tmp_name"];
      // $uploads_dir = 'load01/';
      // move_uploaded_file($tname, $uploads_dir. '/'.$pname);

      // move_uploaded_file($_FILES["xlsx_file"]["tmp_name"],"load01/" . $_FILES["xlsx_file"]["name"]);

      $title = $_POST["title"];
      $month = $_POST["month"];
      $subName = $_POST["subName"];

        // if (move_uploaded_file($_FILES["dwg_file"]["tmp_name"],"fibre/2007/" . $_FILES["dwg_file"]["name"])) {
        if (move_uploaded_file($_FILES["xlsx_file"]["tmp_name"],"substation-kwh/" . $_FILES["xlsx_file"]["name"])) {
          $sql = mysqli_query($conn,"INSERT INTO substationkhw(title, filename, month, subName) VALUES('$title', '$pname', '$month', '$subName')");

          if ($sql) {
            echo '<div class="alert alert-success">New file uploaded successfully</div>';

            header("Refresh: 3; substationkhw.php");
            exit();

          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
        } else {
          echo '<div class="alert alert-danger"><strong>Error! </strong>File was not uploaded</div>';

          header("Refresh: 3; substationkhw.php");
          exit();
        }
    }
    ?>

    <!--- Footer -->
<?php
  require "footer.php";
?>
