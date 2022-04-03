<?php
  $page = "ดาวน์โหลด ผังไฟเบอร์ออฟติค";
  include_once 'header3.php';
?>

    <p><br/></p>
      <div class="container">
        <table class="table table-bordered">
          <tbody>
            <?php
              include "config.php";
              $stmt = $db->prepare("SELECT * FROM fibrediagram");
              $stmt->execute();
              while ($row = $stmt->fetch()) {
            ?>
              <tr>
                <td><?php echo $row['title'] ?></td>
                <td class="text-center"><a href="download-04.php?id=<?php echo $row['id'] ?>" class="btn btn-primary">Download</a></td>

                <?php if($_SESSION['username']=='adminS1' || $_SESSION['username']=='commuadmin'): ?>
                  <td class="text-center">
                    <a href="fibredownload.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">ลบ</a>
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
        $mysqli = new mysqli('localhost', 'root', '123456', 'login') or die(mysqli_error($mysqli));

        if (isset($_GET['delete'])) {
          $id = $_GET['delete'];
          $mysqli->query("DELETE FROM fibrediagram WHERE id=$id") or die($mysqli->error());

          echo '<div class="alert alert-success">Record deleted successfully</div>';

          header("location: fibredownload.php");
        }
      ?>

      <div class="container">
        <p><a href="ftp://172.26.1.1/%23060-%E1%BC%B9%A1%E2%A4%C3%A7%A2%E8%D2%C2%E0%A4%E0%BA%D4%C5%E3%C2%E1%A1%E9%C7%B9%D3%E1%CA%A7/02%20%A2%E9%CD%C1%D9%C5%CA%D3%A4%D1%AD%E1%BC%B9%A1/01%20%A2%E9%CD%C1%D9%C5%C3%D0%C2%D0%CA%D2%C2%E0%A4%E0%BA%D4%C5/">FTP : ผังไฟเบอร์ออฟติค</a></p>
      </div>

      <!--- Footer -->
  <?php
    require "footer.php";
  ?>
