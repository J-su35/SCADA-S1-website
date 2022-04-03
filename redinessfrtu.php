<?php
	$page = "ข้อมูลความพร้อมใช้งานระบบสื่อสาร FRTU";
	include_once 'header3.php';
 ?>

    <p><br/></p>
      <div class="container">
        <table class="table table-bordered">
          <tbody>
            <?php
              include "config.php";
              $stmt = $db->prepare("SELECT * FROM rediness_frtu");
              $stmt->execute();
              while ($row = $stmt->fetch()) {
            ?>
              <tr>
                <td><?php echo $row['title'] ?></td>
                <td class="text-center"><a href="download-06.php?id=<?php echo $row['id'] ?>" class="btn btn-primary">Download</a></td>

								<?php if($_SESSION['username']=='adminS1' || $_SESSION['username']=="commuadmin"): ?>
                  <td class="text-center">
                    <a href="redinessfrtu.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">ลบ</a>
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
			    $mysqli->query("DELETE FROM rediness_frtu WHERE id=$id") or die($mysqli->error());

			    echo '<div class="alert alert-success">Record deleted successfully</div>';

			    header("location: redinessfrtu.php");
			  }
			?>

<?php
  require "footer.php";
?>
