<?php
  $page = "รายงานการอ่านมาตรวัดไฟฟ้าประจำเดือน";
  include_once 'header3.php';
?>

<p><br/></p>
  <div class="container">
    <table class="table table-bordered">
      <tbody>
        <?php
          include "config.php";
          $stmt = $db->prepare("SELECT * FROM substationkhw");
          $stmt->execute();
          while ($row = $stmt->fetch()) {
        ?>
          <tr>
            <td><?php echo $row['title'] ?></td>
            <td><?php echo $row['month'] ?></td>
            <td><?php echo $row['subName'] ?></td>
            <td class="text-center"><a href="download-07.php?id=<?php echo $row['id'] ?>" class="btn btn-primary">Download</a></td>

            <?php if($_SESSION['username']=='scadaadmin'): ?>
              <td class="text-center">
                <a href="sub_kwhunit.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">ลบ</a>
              </td>
            <?php endif; ?>
          </tr>
          <?php
          }
         ?>
      </tbody>
    </table>
  </div>

  <?php
    $mysqli = new mysqli('sql113.epizy.com', 'epiz_24636187', 'uONrYWxJLD', 'epiz_24636187_login') or die(mysqli_error($mysqli));

    if (isset($_GET['delete'])) {
      $id = $_GET['delete'];
      $mysqli->query("DELETE FROM substationkhw WHERE id=$id") or die($mysqli->error());

      echo '<div class="alert alert-success">Record deleted successfully</div>';

      header("location: sub_kwhunit.php");
    }
  ?>

  <div class="container">
    <p><a href="ftp://172.26.1.1/%23049-%E1%BC%B9%A1%A4%C7%BA%A4%D8%C1%A1%D2%C3%A8%E8%D2%C2%E4%BF/%C3%D2%C2%A7%D2%B9%BB%C3%D0%A8%D3%E0%B4%D7%CD%B9%CA%B6%D2%B9%D5%CF/">FTP : หน่วยซื้อไฟฟ้า กฟผ.</a></p>
  </div>

<?php
  require "footer.php";
?>
