<?php
	$page = "อัพโหลดไฟล์สรุปข้อมูลปัญหาไฟเบอร์ออฟติค";
	include_once 'header.php';
 ?>


 <?php
 if ($_SESSION['username'] == "scadaadmin" || $_SESSION['username']=="commuadmin") {
   echo '
	<div class="container my-5">
		<div class="row">
			<div class="col-md-8">
		    <form method="post" enctype="multipart/form-data">
					<div class="form-group">
			      <label>ชื่อไฟล์ : </label>
			      <input type="text" name="title" class="form-control">
					</div>
					<div class="form-group mb-3">
			      <label>Upload file : </label>
			      <input type="file" name="pdf_file" accept="application/pdf" /><br>
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
    $localhost = "sql113.epizy.com";
    $dbusername = "epiz_24636187";
    $dbpassword = "uONrYWxJLD";
    $dbname = "epiz_24636187_login";

    $conn = mysqli_connect($localhost, $dbusername, $dbpassword, $dbname);

    if (isset($_POST["submit"])) {
      $allowedExts = array("pdf");
      $temp = explode(".", $_FILES["pdf_file"]["name"]);
      $extension = end($temp);
      $title = $_POST["title"];
      $pname = $_FILES["pdf_file"]["name"];

      if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"],"bad fiber/" . $_FILES["pdf_file"]["name"])) {
        $sql = mysqli_query($conn,"INSERT INTO sum_badfiber(title, filename) VALUES('$title', '$pname')");

        if ($sql) {
            echo '<div class="alert alert-success">
										New record created successfully.
									</div>';
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

      } else {
        echo '<div class="alert alert-danger">
								File was not uploaded.
							</div>';
      }
    }
    ?>


    <!--- Footer -->
<?php
  require "footer.php";
?>
