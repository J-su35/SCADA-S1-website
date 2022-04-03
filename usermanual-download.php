<?php
	$page = "ดาวน์โหลดคู่มือปฏิบัติงาน";
	include_once 'header7s.php';
 ?>

    <p><br/></p>
      <div class="container">
        <table class="table table-bordered">
          <tbody id="myTable">
            <?php
              include "config.php";
              $stmt = $db->prepare("SELECT * FROM usermanual");
              $stmt->execute();
              while ($row = $stmt->fetch()) {
            ?>
              <tr>
                <td><?php echo $row['title'] ?></td>
								<td><?php echo $row['categories'] ?></td>
                <td class="text-center"><a href="download-02.php?id=<?php echo $row['id'] ?>" class="btn btn-primary">Download</a></td>

								<?php if($_SESSION['username']=='adminS1'): ?>
                  <td class="text-center">
                    <a href="usermanual-download.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">ลบ</a>
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
			    $mysqli->query("DELETE FROM usermanual WHERE id=$id") or die($mysqli->error());

			    echo '<div class="alert alert-success">Record deleted successfully</div>';

			    header("location: usermanual-download.php");
			  }
			?>

<?php
  require "footer.php";
?>
