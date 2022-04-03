<?php
  $page = "ผลลัพธ์การค้นหา";
  include 'header.php';
 ?>

<style>
.article-container {
  width: 900px;
  padding: 30px;
}

.article-box {
  padding-bottom: 30px;
  width: 100%;
}
</style>

<div class="article-container">
<?php
  include 'includes/dbh.inc.php';
  $output='';

  if(isset($_POST['submit'])) {
    $str = $conn-> real_escape_string($_POST['search']);
    $str = preg_replace("#[^0-9a-z]#i","",$str);

    mysqli_query($conn, 'set names utf8');
    $sth = mysqli_query($conn, "SELECT * FROM sitemap WHERE title LIKE '%$str%'");


    $count = mysqli_num_rows($sth);

    if($count == 0) {
      echo "พบผลลัพธ์ที่ตรงกันจำนวน ".$count." ผลลัพธ์<br><br>";
      echo "ไม่พบผลลัพธ์ที่ต้องการค้นหา!";
    } else {
      echo "พบผลลัพธ์ที่ตรงกันจำนวน ".$count." ผลลัพธ์<br><br>";

      while($row = mysqli_fetch_array($sth)) {

        echo "<a href=".$row['link']."><div class='article-box'><h5>".$row['title']."</h5></a>
              <p>".$row['link']."</p></div>";
      }
    }
  }

 ?>
</div>

<?php
  require "footer.php";
?>
