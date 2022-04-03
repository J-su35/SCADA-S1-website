<!DOCTYPE html>
<html>
<head>
	<title>Download</title>
</head>
<body>
<?php
	$con = mysqli_connect("localhost","root","123456");
	$db = mysqli_select_db($con, "download");
	$sql="SELECT * FROM table";	
	$res = mysqli_query($con, $sql);
	
$row = mysqli_fetch_array($res, MYSQLI_NUM);


?>

<?php
$link = mysqli_connect("localhost", "root", "123456", "download");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$query = "SELECT name FROM table";
$result = mysqli_query($link, $query);

/* numeric array */
// $row = mysqli_fetch_array($result, MYSQLI_NUM);
// printf ("%s (%s)\n", $row[1]);

/* associative array */
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
printf ("%s (%s)\n", $row["first file"]);

/* free result set */
// mysqli_free_result($result);

/* close connection */
mysqli_close($link);
?> 

</body>
</html>