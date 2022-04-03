<?php
	$page = "อัพโหลดคู่มือการปฏิบัติงาน";
	include_once 'header.php';
 ?>

 <?php

 if ($_SESSION['username'] == "adminS1" || $_SESSION['username']=="commuadmin" || $_SESSION['username']=="madadmin") {
   echo '
	<div class="container my-5">
    <form method="post" enctype="multipart/form-data">
			<div class="form-group">
	      <label>ชื่อเรื่อง : </label>
	      <input type="text" name="title" class="form-control">
			</div>
			<div class="mb-3">
        <label for="categories">ประเภท : </label>
				<input list="options" name="categories" class="form-control" required>
        <datalist id="options">
          <option value="SF6">SF6</option>
          <option value="Recloser">Recloser</option>
          <option value="AVR">AVR</option>
          <option value="SCADA">SCADA</option>
          <option value="Loadbreak 115 kV">Loadbreak 115 kV</option>
        </datalist>
      </div>
			<div class="form-group mt-5">
	      <label>Upload file : </label>
	      <input type="file" name="pdf_file" accept="application/pdf" /><br>
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
      $allowedExts = array("pdf");
      $temp = explode(".", $_FILES["pdf_file"]["name"]);
      $extension = end($temp);
      $title = $_POST["title"];
      $pname = $_FILES["pdf_file"]["name"];
			$categories = $_POST["categories"];

      if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"],"user_manual/" . $_FILES["pdf_file"]["name"])) {
        $sql = mysqli_query($conn,"INSERT INTO usermanual(title, filename, categories) VALUES('$title', '$pname', '$categories')");

        if ($sql) {
					echo '<p class="alert alert-success">File was uploaded successful!</p>';
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

      } else {
        echo "File was not uploaded";
      }
    }
    ?>


    <!--- Footer -->
<?php
  require "footer.php";
?>
