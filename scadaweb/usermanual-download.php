<?php
	$page = "ดาวน์โหลดคู่มือปฏิบัติงาน";
	include_once 'header7s.php';
	include 'includes/dbh.inc.php';

	$limit = 10;
	$pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;
  $start = ($pageNumber - 1) * $limit;

  $result = $conn->query("SELECT * FROM usermanual LIMIT $start, $limit") or die($conn->error);

  $records = $result->fetch_all(MYSQLI_ASSOC);

	$result1 = $conn->query("SELECT count(id) AS id FROM usermanual");
  $recordCount = $result1->fetch_all(MYSQLI_ASSOC);

  $total = $recordCount[0]['id'];
  $pages = ceil($total / $limit);

  $prevPage = $pageNumber - 1;
  $nextPage = $pageNumber + 1;

 ?>

    <p><br/></p>
      <div class="container">
        <table class="table table-bordered">
          <tbody id="myTable">
            <?php foreach($records as $row) : ?>
              <tr>
                <td><?php echo $row['title'] ?></td>
								<td><?php echo $row['categories'] ?></td>
								<td class="text-center"><a href="download-02.php?id=<?php echo $row['id'] ?>" class="btn btn-primary">Download</a></td>

								<?php if($_SESSION['username']=='scadaadmin'): ?>
                  <td class="text-center">
                    <a href="usermanual-download.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">ลบ</a>
                  </td>
                <?php endif; ?>
							</tr>
              <?php endforeach; ?>
          </tbody>
        </table>

				<div class="container">
					<ul class="pagination justify-content-center">
						<li class="page-item"><a class="page-link" href="usermanual-download.php?page=<?= $prevPage; ?>">Previous</a></li>
						<?php for($i = 1; $i<= $pages; $i++) : ?>
							<li class="page-item"><a class="page-link" href="usermanual-download.php?page=<?= $i; ?>"><?= $i; ?></a></li>
						<?php endfor; ?>
						<li class="page-item"><a class="page-link" href="usermanual-download.php?page=<?= $nextPage; ?>">Next</a></li>
					</ul>
				</div>

      </div>

			<?php
			  $mysqli = new mysqli('sql113.epizy.com', 'epiz_24636187', 'uONrYWxJLD', 'epiz_24636187_login') or die(mysqli_error($mysqli));

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
