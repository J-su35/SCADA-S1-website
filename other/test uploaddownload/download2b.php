<?php

$conn = mysqli_connect("localhost", "root", "123456");
$db = mysqli_select_db($conn, "download");

$res = mysqli_query($conn, "SELECT * FROM table");
$row = mysqli_fetch_array($res);
echo "<table>";
echo "<tr>";
echo "<td>"; echo $row["name"]; echo "</td>";
echo "<td>"; ?><a href="<?php echo $row["path"]; ?>">download</a> <?php echo "</td>";

echo "</tr>";
echo "</table>";

 ?>
