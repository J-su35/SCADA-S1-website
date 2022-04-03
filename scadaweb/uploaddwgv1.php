<?php
$page = "อัพโหลดผังการจ่ายไฟ";
  include_once 'header.php';
?>

<?php
if ($_SESSION['username'] == "scadaadmin" || $_SESSION['username'] =="scadas1") {
  echo '
  <div class="container my-3">
    <form method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label>ชื่อไฟล์ : </label>
        <input type="text" name="title" class="form-control">
      </div>
      <div class="form-group">
        <label>แรงดัน : </label><br>
        <input type="radio" name="voltage" value="115" class="form-check-input"> 115 kV<br>
        <input type="radio" name="voltage" value="2233" class="form-check-input"> 22, 33 kV
      </div>
      <div class="form-group">
        <label>ประเภทไฟล์ : </label><br>
        <input type="radio" name="filetype" value="AutoCAD_2007" class="form-check-input"> AutoCAD 2007<br>
        <input type="radio" name="filetype" value="AutoCAD_2013" class="form-check-input"> AutoCAD 2013<br>
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
    $localhost = "sql113.epizy.com";
    $dbusername = "epiz_24636187";
    $dbpassword = "uONrYWxJLD";
    $dbname = "epiz_24636187_login";



    $conn = mysqli_connect($localhost, $dbusername, $dbpassword, $dbname);
    mysqli_query($conn, 'set character set utf8');

    if (isset($_POST["submit"])) {
      $allowedExts = array("pdf", "dwg");
      $temp = explode(".", $_FILES["dwg_file"]["name"]);
      $extension = end($temp);
      $pname = $_FILES["dwg_file"]["name"];

      $voltage = $_POST['voltage'];
      $filetype = $_POST['filetype'];

      if (isset($voltage) && isset($voltage) == "115") {
        if ($filetype == "AutoCAD_2007") {
          $title = $_POST["title"];
          if (move_uploaded_file($_FILES["dwg_file"]["tmp_name"],"sigleline/" . $_FILES["dwg_file"]["name"])) {
            $sql = mysqli_query($conn,"INSERT INTO sigleline(title, filename, voltage, filetype) VALUES('$title', '$pname', '$voltage', '$filetype')");

            if ($sql) {
              echo '<div class="alert alert-success">New file uploaded successfully</div>';

              header("Refresh: 3; uploaddwg.php");
              exit();
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
          } else {
            echo '<div class="alert alert-danger"><strong>Error! </strong>File was not uploaded</div>';

            header("Refresh: 3; uploaddwg.php");
            exit();
          }

        } elseif ($filetype == "AutoCAD_2013") { {
          $title = $_POST["title"];

          if (move_uploaded_file($_FILES["dwg_file"]["tmp_name"],"sigleline/" . $_FILES["dwg_file"]["name"])) {
            $sql = mysqli_query($conn,"INSERT INTO sigleline(title, filename, voltage, filetype) VALUES('$title', '$pname', '$voltage', '$filetype')");

            if ($sql) {
              echo '<div class="alert alert-success">New file uploaded successfully</div>';

              header("Refresh: 3; uploaddwg.php");
              exit();
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
          } else {
            echo '<div class="alert alert-danger"><strong>Error! </strong>File was not uploaded</div>';

            header("Refresh: 3; uploaddwg.php");
            exit();
          }



        } else {
          $title = $_POST["title"];
          // if (move_uploaded_file($_FILES["dwg_file"]["tmp_name"],"sigleline/115kV/pdf/" . $_FILES["dwg_file"]["name"])) {
          if (move_uploaded_file($_FILES["dwg_file"]["tmp_name"],"sigleline/" . $_FILES["dwg_file"]["name"])) {
            $sql = mysqli_query($conn,"INSERT INTO sigleline(title, filename, voltage, filetype) VALUES('$title', '$pname', '$voltage', '$filetype')");

            if ($sql) {
              echo '<div class="alert alert-success">New file uploaded successfully</div>';

              header("Refresh: 3; uploaddwg.php");
              exit();
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
          } else {
            echo '<div class="alert alert-danger"><strong>Error! </strong>File was not uploaded</div>';

            header("Refresh: 3; uploaddwg.php");
            exit();
          }


        }

      } else {
        if (isset($filetype) && isset($filletype) == "AutoCAD_2007") {
          $title = $_POST["title"];
          // if (move_uploaded_file($_FILES["dwg_file"]["tmp_name"],"sigleline/22-33kV/2007/" . $_FILES["dwg_file"]["name"])) {
          if (move_uploaded_file($_FILES["dwg_file"]["tmp_name"],"sigleline/" . $_FILES["dwg_file"]["name"])) {
            $sql = mysqli_query($conn,"INSERT INTO sigleline(title, filename, voltage, filetype) VALUES('$title', '$pname', '$voltage', '$filetype')");

            if ($sql) {
              echo '<div class="alert alert-success">New file uploaded successfully</div>';

              header("Refresh: 3; uploaddwg.php");
              exit();
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
          } else {
            echo '<div class="alert alert-danger"><strong>Error! </strong>File was not uploaded</div>';

            header("Refresh: 3; uploaddwg.php");
            exit();
          }


        } elseif (isset($filetype) && isset($filetype) == "AutoCAD_2013") {
          $title = $_POST["title"];
          // if (move_uploaded_file($_FILES["dwg_file"]["tmp_name"],"sigleline/22-33kV/2013/" . $_FILES["dwg_file"]["name"])) {
          if (move_uploaded_file($_FILES["dwg_file"]["tmp_name"],"sigleline/" . $_FILES["dwg_file"]["name"])) {
            $sql = mysqli_query($conn,"INSERT INTO sigleline(title, filename, voltage, filetype) VALUES('$title', '$pname', '$voltage', '$filetype')");

            if ($sql) {
              echo '<div class="alert alert-success">New file uploaded successfully</div>';

              header("Refresh: 3; uploaddwg.php");
              exit();
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
          } else {
            echo '<div class="alert alert-danger"><strong>Error! </strong>File was not uploaded</div>';

            header("Refresh: 3; uploaddwg.php");
            exit();
          }


        } else {
          $title = $_POST["title"];
          // if (move_uploaded_file($_FILES["dwg_file"]["tmp_name"],"sigleline/22-33kV/pdf/" . $_FILES["dwg_file"]["name"])) {
          if (move_uploaded_file($_FILES["dwg_file"]["tmp_name"],"sigleline/" . $_FILES["dwg_file"]["name"])) {
            $sql = mysqli_query($conn,"INSERT INTO sigleline(title, filename, voltage, filetype) VALUES('$title', '$pname', '$voltage', '$filetype')");

            if ($sql) {
              echo '<div class="alert alert-success">New file uploaded successfully</div>';

              header("Refresh: 3; uploaddwg.php");
              exit();
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
          } else {
            echo '<div class="alert alert-danger"><strong>Error! </strong>File was not uploaded</div>';

            header("Refresh: 3; uploaddwg.php");
            exit();
          }
        }
      }
    }
    ?>

    <!--- Footer -->
<?php
  require "footer.php";
?>
