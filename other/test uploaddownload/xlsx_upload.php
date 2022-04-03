<?php 

include "dbconnect.php";
if(isset($_POST["submit"])){
	$allowedExts = array("pdf");
	$temp = explode(".", $_FILES["pdf_file"]["name"]);
	$extension = end($temp);
	$upload_pdf=$_FILES["pdf_file"]["name"];
	move_uploaded_file($_FILES["pdf_file"]["tmp_name"],"file_upload/images/uploads/pdf/" . $_FILES["pdf_file"]["name"]);
	
	$sql=mysqli_query($con,"INSERT INTO `upload_pdf_file`(`pdf_file`)VALUES('".$upload_pdf."')");
	// $sql = mysqli_query($con,"INSERT INTO upload_pdf_file(pdf_file) VALUES('$upload_pdf')");
	if($sql){
		echo "File Successful uploaded";
	} else {
		echo "File Submit Error!!";
	} 
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>pdf_upload test</title>
</head>
<body>

<form method="post" role="form" enctype="multipart/form-data"> 
	<input type="file" name="pdf_file" id="pdf_file" accept="application/pdf" />
	<h4>Choose File</h4>
	<button id="send" type="submit" name="submit" class="btn btn-success">Submit</button>
	<!-- <input type="submit" name="submit"> -->
</form>

</body>
</html>
