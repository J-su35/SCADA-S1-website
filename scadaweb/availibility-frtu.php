<?php
	$page = "ข้อมูลรายงานความพร้อมใช้งานระบบสื่อสารของชุด FRTU";
	include_once 'header7s.php';
 ?>

    <p><br/></p>
      <div class="container">
        <table class="table table-bordered">
          <tbody id="myTable">
            <?php
              include "config.php";
              $stmt = $db->prepare("SELECT * FROM avai_frtu");
              $stmt->execute();
              while ($row = $stmt->fetch()) {
            ?>
              <tr>

								<td class="text-center"><a href="<?php echo $row['url']; ?>"><?php echo $row['title'] ?></a></td>

								<td class="text-center"> <img src=" <?php echo 'img_frtu/'.$row['img']; ?> " height="100px" width="100px"> </td>
                <?php if ($_SESSION['username'] == "scadaadmin" || $_SESSION['username'] == "commuadmin"): ?>
                  <td class="text-center">
                    <a href="availibility-frtu.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">ลบ</a>
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
			    $mysqli->query("DELETE FROM avai_frtu WHERE id=$id") or die($mysqli->error());

			    echo '<div class="alert alert-success">Record deleted successfully</div>';

			    header("location: availibility-frtu.php");
			  }
			?>

<?php
  require "footer.php";
?>
