<?php
  $page = "อัพโหลดผังไฟเบอร์ออฟติค";
  include_once 'header.php';
?>

<?php
if ($_SESSION['username'] == "adminS1") {
  echo '
  <div class="container my-5">
    <form method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label>ชื่อไฟล์ : </label>
        <input type="text" name="title" class="form-control">
      </div>
      <div class="form-group">
        <label>ประเภทไฟล์</label><br>
        <input type="radio" name="filetype" value="AutoCAD" class="form-check-input"> AutoCAD<br>
        <input type="radio" name="filetype" value="PDF" class="form-check-input"> PDF
      </div>
      <div class="form-group">
        <label>Upload file : </label>
        <input type="file" name="dwg_file">
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
      $allowedExts = array("pdf", "dwg");
      $temp = explode(".", $_FILES["dwg_file"]["name"]);
      $extension = end($temp);
      $pname = $_FILES["dwg_file"]["name"];

      // $tname = $_FILES["xlsx_file"]["tmp_name"];
      // $uploads_dir = 'load01/';
      // move_uploaded_file($tname, $uploads_dir. '/'.$pname);

      // move_uploaded_file($_FILES["xlsx_file"]["tmp_name"],"load01/" . $_FILES["xlsx_file"]["name"]);

      $filetype = $_POST['filetype'];

      if (isset($filetype) && $filetype == "AutoCAD") {

        $title = $_POST["title"]."-DWG";
        // if (move_uploaded_file($_FILES["dwg_file"]["tmp_name"],"fibre/2007/" . $_FILES["dwg_file"]["name"])) {
        if (move_uploaded_file($_FILES["dwg_file"]["tmp_name"],"fibre/" . $_FILES["dwg_file"]["name"])) {
          $sql = mysqli_query($conn,"INSERT INTO fibrediagram(title, filename) VALUES('$title', '$pname')");

          if ($sql) {
            echo '<div class="alert alert-success">New file uploaded successfully</div>';

            header("Refresh: 3; uploadfibre.php");
            exit();

          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
        } else {
          echo '<div class="alert alert-danger"><strong>Error! </strong>File was not uploaded</div>';

          header("Refresh: 3; uploadfibre.php");
          exit();

        }
      } elseif (isset($filetype) && $filetype == "PDF") {

        $title = $_POST["title"]."-PDF";
        // if (move_uploaded_file($_FILES["dwg_file"]["tmp_name"],"fibre/pdf/" . $_FILES["dwg_file"]["name"])) {
        if (move_uploaded_file($_FILES["dwg_file"]["tmp_name"],"fibre/" . $_FILES["dwg_file"]["name"])) {
          $sql = mysqli_query($conn,"INSERT INTO fibrediagram(title, filename) VALUES('$title', '$pname')");

          if ($sql) {
            echo '<div class="alert alert-success">New file uploaded successfully</div>';

            header("Refresh: 3; uploadfibre.php");
            exit();

          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
        } else {
            echo '<div class="alert alert-danger"><strong>Error! </strong>File was not uploaded</div>';

            header("Refresh: 3; uploadfibre.php");
            exit();
        }
      }
    }
    ?>

    <!--- Footer -->
<?php
  require "footer.php";
?>
