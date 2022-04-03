<?php
$conn = mysqli_connect("localhost", "root", "123456", "testing");
$sql = "SELECT * FROM tbl_tweet ORDER BY tweet_id DESC";

$res = mysqli_query($conn, $sql);

if (mysqli_num_rows($res) > 0)
{
	while($row = mysqli_fetch_array($res))
	{
		echo '<p>'.$row["tweet"].'</p>';
	}
}
?>