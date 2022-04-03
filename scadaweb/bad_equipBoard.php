<?php
  $page = "สถานะอุปกรณ์ชำรุด";
  include_once 'header7s.php';
  require_once 'process3d.php';
  require_once 'process3d2.php';

  include 'includes/dbh.inc.php';

  $limit = 10;

  $pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;
  $start = ($pageNumber - 1) * $limit;

  $result = $conn->query("SELECT * FROM broken_equipment LIMIT $start, $limit") or die($conn->error);

  $records = $result->fetch_all(MYSQLI_ASSOC);

  $result1 = $conn->query("SELECT count(id) AS id FROM broken_equipment");
  $recordCount = $result1->fetch_all(MYSQLI_ASSOC);

  $total = $recordCount[0]['id'];
  $pages = ceil($total / $limit);

  $prevPage = $pageNumber - 1;
  $nextPage = $pageNumber + 1;
?>



    <!-- Session message section -->
    <?php
     if (isset($_GET['notify']) && $_GET['notify'] == "statusUpdated") {
       echo '<p class="alert alert-success">อัตเดตสถานะเรียบร้อย!</p>';
     } elseif (isset($_GET['notify']) && $_GET['notify'] == "deleted") {
       echo '<p class="alert alert-danger">รายการถูกลบ!</p>';
     } elseif (isset($_GET['notify']) && $_GET['notify'] == "updated") {
       echo '<p class="alert alert-info">แก้ไขข้อมูลเรียบร้อย!</p>';
     }
   ?>

    <!-- Session message section end -->

    <div class="container">
      <div class="row justify-content-center table-responsive">
        <!-- Table section -->
        <table class="table table-sm">
          <thead>
            <tr>
              <th>หมายเลขงาน</th>
              <th>ประเภทอุปกรณ์</th>
              <th>อุปกรณ์</th>
              <th>วันที่แจ้ง</th>
              <th>อาการชำรุด</th>
              <th>สถานะ</th>
              <th>ความสำคัญ</th>
              <th colspan="1"></th>
              <th colspan="2"></th>
            </tr>
          </thead>
            <tbody id="myTable">
              <?php foreach($records as $row) : ?>
                <tr>
                  <td><?php echo $row['JId']; ?></td>
                  <td><?php echo $row['catgories']; ?></td>
                  <td><?php echo $row['equip_code']; ?></td>
                  <td><?php echo $row['date']; ?></td>
                  <td><?php echo $row['detail']; ?></td>
                  <td><?php echo $row['status']; ?></td>
                  <td><?php echo $row['priority']; ?></td>
            <?php if($_SESSION['username']=='scadaadmin' || $_SESSION['username']=='madadmin'): ?>
                <td>
                    <a href="changestatus.php?edit=<?php echo $row['id']; ?>" class="btn btn-primary">อัพเดตสถานะ</a>
                </td>
            <?php endif; ?>
            <?php if($_SESSION['username']=='scadaadmin' || $_SESSION['username']=='scadas1'): ?>
                <td>
                    <a href="bad_equip.php?edit=<?php echo $row['id']; ?>" class="btn btn-warning">แก้ไข</a>
                    <a href="process3d.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">ลบ</a>
                </td>
            <?php endif; ?>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
          <!-- Table section End -->

          <!-- <div id="table"></div> -->

          <div class="container">
            <ul class="pagination justify-content-center">
              <li class="page-item"><a class="page-link" href="bad_equipBoard.php?page=<?= $prevPage; ?>">Previous</a></li>
              <?php for($i = 1; $i<= $pages; $i++) : ?>
                <li class="page-item"><a class="page-link" href="bad_equipBoard.php?page=<?= $i; ?>"><?= $i; ?></a></li>
              <?php endfor; ?>
              <li class="page-item"><a class="page-link" href="bad_equipBoard.php?page=<?= $nextPage; ?>">Next</a></li>
            </ul>
         </div>

      </div>
    </div>

<?php
  require "footer.php";
?>
