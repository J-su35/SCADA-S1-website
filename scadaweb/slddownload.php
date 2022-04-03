<?php
  $page = "ดาวน์โหลดผังการจ่ายไฟ";
  include_once 'header7s.php';
?>

    <p><br/></p>
      <div class="container">
        <table class="table table-bordered">
          <tbody id="myTable">
            <?php
              include "config.php";
              $stmt = $db->prepare("SELECT * FROM sigleline");
              $stmt->execute();
              while ($row = $stmt->fetch()) {
            ?>
              <tr>
                <td><?php echo $row['title'] ?></td>
                <td><?php echo $row['voltage'] ?></td>
                <td><?php echo $row['filetype'] ?></td>
                <td class="text-center"><a href="download-03.php?id=<?php echo $row['id'] ?>" class="btn btn-primary">Download</a></td>

                <?php if($_SESSION['username']=='scadaadmin' || $_SESSION['username'] =="scadas1"): ?>
                  <td class="text-center">
                    <a href="slddownload.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">ลบ</a>
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
          $mysqli->query("DELETE FROM sigleline WHERE id=$id") or die($mysqli->error());

          echo '<div class="alert alert-success">Record deleted successfully</div>';

          header("location: slddownload.php");
        }
      ?>

      <div class="container">
        <p><a href="ftp://172.26.1.1/%23049-%E1%BC%B9%A1%A4%C7%BA%A4%D8%C1%A1%D2%C3%A8%E8%D2%C2%E4%BF/05_%C3%D2%C2%A7%D2%B9/02_%E1%BC%B9%BC%D1%A7%A1%D2%C3%A8%E8%D2%C2%E4%BF%20%A1%BF%B5.1/">FTP : ผังการจ่ายไฟฟ้า</a></p>
      </div>


      <!--- Footer -->
  <?php
    require "footer.php";
  ?>
