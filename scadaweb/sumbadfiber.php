<?php
	$page = "สรุปข้อมูลปัญหาไฟฟเบอร์ออฟติค";
	include_once 'header3.php';
 ?>

    <p><br/></p>
      <div class="container">
        <table class="table table-bordered">
          <tbody>
            <?php
              include "config.php";
              $stmt = $db->prepare("SELECT * FROM sum_badfiber");
              $stmt->execute();
              while ($row = $stmt->fetch()) {
            ?>
              <tr>
                <td><?php echo $row['title'] ?></td>
                <td class="text-center"><a href="download-05.php?id=<?php echo $row['id'] ?>" class="btn btn-primary">Download</a></td>

								<?php if($_SESSION['username']=='scadaadmin' || $_SESSION['username']=="commuadmin"): ?>
                  <td class="text-center">
                    <a href="sumbadfiber.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">ลบ</a>
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
			    $mysqli->query("DELETE FROM sum_badfiber WHERE id=$id") or die($mysqli->error());

			    echo '<div class="alert alert-success">Record deleted successfully</div>';

			    header("location: sumbadfiber.php");
			  }
			?>

<?php
  require "footer.php";
?>
