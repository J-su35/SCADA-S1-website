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
  /* background-color: #D3D3D3; */
  /* padding-top: 10px; */
  padding-bottom: 30px;
  width: 100%;
}
</style>

<div class="article-container">
<?php
  include 'includes/dbh.inc.php';
  $output='';

  if(isset($_POST['submit'])) {
    // $pst = $_POST['search'];
    // $str = $conn-> real_escape_string($_POST['search']);
    // $str = preg_replace("#[^0-9a-z]#i","",$str);
    $str = mysqli_real_escape_string($conn, $_POST['search']);
    $str = preg_replace("#[^0-9a-z]#i","",$str);


    // $sth = $conn->prepare("SELECT * FROM userslogin WHERE user_uid LIKE '%$str'") or die("could not search!");
    // $sth = $conn->prepare("SELECT * FROM userslogin WHERE user_uid LIKE '%$str'");
    // $sth->setFetchMode(PDO:: FETCH_OBJ);
    // $sth->execute();


    // mysqli_query($conn, 'set names utf8');
    // $sth = mysqli_query($conn, "SELECT * FROM sitemap WHERE title LIKE '%$str%'");
    // $sth = $conn->query("SELECT * FROM sitemap WHERE title LIKE '%$str%'");

    $sql = "SELECT * FROM sitemap WHERE title LIKE '%$str%'";
    mysqli_query($conn, 'set names utf8');
    $sth = mysqli_query($conn, $sql);

    $count = mysqli_num_rows($sth);

    // $sth->execute();
    if($count == 0) {
      // $output = 'ไม่พบผลลัพธ์ที่ต้องการค้นหา!';
      echo "พบผลลัพธ์ที่ตรงกันจำนวน ".$count." ผลลัพธ์<br><br>";
      echo "ไม่พบผลลัพธ์ที่ต้องการค้นหา!";
    } else {
      echo "พบผลลัพธ์ที่ตรงกันจำนวน ".$count." ผลลัพธ์<br><br>";

      while($row = mysqli_fetch_array($sth)) {
        // $name = $row['user_uid'];
        //
        // $output .= '<div>'.$name.'</div>';

        echo "<a href=".$row['link']."><div class='article-box'><h5>".$row['title']."</h5></a>
              <p>".$row['link']."</p></div>";
      }
    }
  }


  // print("$output");

 ?>
</div>

<?php
  require "footer.php";
?>
