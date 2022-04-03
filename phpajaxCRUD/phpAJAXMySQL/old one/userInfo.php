<?php
include_once('db.php');

$name = $_POST['name'];
$age = $_POST['age'];

$sql = "INSERT INTO user (name, age) VALUES ('$name', '$age')";

if (mysqli_query($conn, $sql)) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
?>
