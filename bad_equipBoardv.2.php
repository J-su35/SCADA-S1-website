<?php
  $page = "สถานะอุปกรณ์ชำรุด";
  include_once 'header7s.php';
  require_once 'process3d.php';
  require_once 'process3d2.php';

  include 'includes/dbh.inc.php';

  $limit = 10;

  $pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;
  $start = ($pageNumber - 1) * $limit;

  // $result = $conn->query("SELECT * FROM broken_equipment LIMIT $start, $limit") or die($conn->error);
  $result = $conn->query("SELECT * FROM broken_equipment ORDER BY date DESC LIMIT $start, $limit") or die($conn->error);

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
      <div class="row justify-content-center table-responsive" id="equip_table">
        <!-- Table section -->
        <table class="table table-sm">
          <thead>
            <tr>
              <th><a class="column_sort" id="jobid" data-order="desc" href="#">หมายเลขงาน</a></th>
              <th><a  class="column_sort" id="equip_type" data-order="desc" href="#">ประเภทอุปกรณ์</a></th>
              <th><a  class="column_sort" id="eqip_name" data-order="desc" href="#">อุปกรณ์</a></th>
              <th><a class="column_sort" id="date" data-order="desc" href="#">วันที่แจ้ง</a></th>
              <th><a  class="column_sort" id="detail" data-order="desc" href="#">อาการชำรุด</a></th>
              <th><a  class="column_sort" id="status" data-order="desc" href="#">สถานะ</a></th>
              <th><a  class="column_sort" id="priority" data-order="desc" href="#">ความสำคัญ</a></th>
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

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
  $(document).on('click', '.column_sort', function(){
    var column_name = $(this).attr("jobid");
    var order = $(this).data("order");
    var arrow = '';
    // glyphicon glyphicon-triangle-top
    // glyphicon glyphicon-triangle-bottom
    if(orer == 'desc'){
      arrow = '&nbsp;<span class="glyphicon glyphicon-triangle-bottom"></span>';
    } else {
      arrow = '&nbsp;<span class="glyphicon glyphicon-triangle-top"></span>';
    }
    $.ajax({
      url:"bad_equipBoard-sort.php",
      method:"POST",
      data:{column_name:column_name, order:order},
      success:function(data){
        $('#equip_table').html(data);
        $('#'+column_name+'').append(arrow);
      }
    })
  });
});
</script>
