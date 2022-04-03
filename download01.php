<?php
  $page = "ดาวน์โหลด โหลด01";
  include_once 'header3.php';
?>

    <p><br/></p>
      <div class="container">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>โหลด01 เดือน</th>
              <th></th>
              <?php if($_SESSION['username']=='adminS1'): ?>
                <th colspan="1"></th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php
              include "config.php";
              $stmt = $db->prepare("SELECT * FROM load01");
              $stmt->execute();
              while ($row = $stmt->fetch()) {
            ?>
              <tr>
                <td><?php echo $row['title'] ?></td>
                <td class="text-center"><a href="download-01.php?id=<?php echo $row['id'] ?>" class="btn btn-primary">Download</a></td>

                <?php if($_SESSION['username']=='adminS1'): ?>
                  <td class="text-center">
                    <a href="download01.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">ลบ</a>
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
    $mysqli->query("DELETE FROM load01 WHERE id=$id") or die($mysqli->error());

    echo '<div class="alert alert-success">Record deleted successfully</div>';

    header("location: download01.php");
  }
?>

<div class="container">
  <p><a href="ftp://172.26.1.1/%23049-%E1%BC%B9%A1%A4%C7%BA%A4%D8%C1%A1%D2%C3%A8%E8%D2%C2%E4%BF/05_%C3%D2%C2%A7%D2%B9/05_%20Load-01%20%BB%C3%D0%A8%D3%E0%B4%D7%CD%B9/">FTP : Load01</a></p>
</div>


<?php
  require "footer.php";
?>
