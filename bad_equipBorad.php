<?php
  $page = "สถานะอุปกรณ์ชำรุด";
  include_once 'header7s.php';
  require_once 'process3d.php';
  require_once 'process3d2.php';

  include 'includes/dbh.inc.php';

  // print_r($_POST["limit-records"]);
  // print_r($_POST);
  $limit = 10;
  // $limit = $_POST["limit-records"];
  // $limit = isset($_POST["limit-records"]) ? $_POST["limit-records"] : 100;
  $pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;
  $start = ($pageNumber - 1) * $limit;

  $result = $conn->query("SELECT * FROM broken_Equipment LIMIT $start, $limit") or die($conn->error);

  // $result = $conn->query("SELECT * FROM customers LIMIT $start, $limit");
  $records = $result->fetch_all(MYSQLI_ASSOC);

  $result1 = $conn->query("SELECT count(id) AS id FROM broken_Equipment");
  $recordCount = $result1->fetch_all(MYSQLI_ASSOC);

  $total = $recordCount[0]['id'];
  $pages = ceil($total / $limit);
  // print_r($_POST["limit-records"]);

  $prevPage = $pageNumber - 1;
  $nextPage = $pageNumber + 1;

?>



    <!-- Session message section -->
    <?php if (isset($_SESSION["message"])): ?>
      <div class="alert alert-<?=$_SESSION["msg_type"]?>">
        <?php
          echo $_SESSION["message"];
          unset($_SESSION["message"]);
         ?>
      </div>
    <?php endif ?>
    <!-- Session message section end -->

    <div class="container">

    <!-- debug part -->
    <?php
      // $mysqli = new mysqli('localhost', 'root', '123456', 'login') or die(mysqli_error($mysqli));
      // $result = $mysqli->query("SELECT * FROM broken_Equipment") or die($mysqli->error);
      // $result = $conn->query("SELECT * FROM broken_Equipment") or die($conn->error);

      // pre_r($result);
      // pre_r($result->fetch_assoc());
    ?>



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
            <?php if($_SESSION['username']=='adminS1' || $_SESSION['username']=='commuadmin'): ?>
                <td>
                    <a href="changestatus.php?edit=<?php echo $row['id']; ?>" class="btn btn-primary">อัพเดตสถานะ</a>
                </td>
            <?php endif; ?>
            <?php if($_SESSION['username']=='adminS1'): ?>
                <td>
                    <a href="bad_equipv.2.php?edit=<?php echo $row['id']; ?>" class="btn btn-warning">แก้ไข</a>
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
              <li class="page-item"><a class="page-link" href="bad_equipBorad.php?page=<?= $prevPage; ?>">Previous</a></li>
              <?php for($i = 1; $i<= $pages; $i++) : ?>
                <li class="page-item"><a class="page-link" href="bad_equipBorad.php?page=<?= $i; ?>"><?= $i; ?></a></li>
              <?php endfor; ?>
              <li class="page-item"><a class="page-link" href="bad_equipBorad.php?page=<?= $nextPage; ?>">Next</a></li>
            </ul>
        </div>
      </div>
    </div>

    <script type="text/javascript">
      // $(document).ready(function(){
      //   $("#limit-records").change(function(){
      //     $('form').submit();
      //   })
      // })
    </script>

<?php
  require "footer.php";
?>
