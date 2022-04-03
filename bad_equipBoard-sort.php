<<?php
include 'includes/dbh.inc.php';

$output = '';
$order = $_POST["order"];
if($order == 'desc')
{
  $order = 'asc';
} else {
  $order ='desc';
}
$query = "SELECT * FROM broken_equipment ORDER BY ".$_POST["column_name"]." ".$_POST["order"]."";
$result = mysqli_query($conn, $query);
$output .='
<table class="table table-sm">
  <thead>
    <tr>
      <th><a class="column_sort" id="jobid" data-order="'.$order.'" href="#">หมายเลขงาน</a></th>
      <th><a  class="column_sort" id="equip_type" data-order="'.$order.'" href="#">ประเภทอุปกรณ์</a></th>
      <th><a  class="column_sort" id="eqip_name" data-order="'.$order.'" href="#">อุปกรณ์</a></th>
      <th><a class="column_sort" id="date" data-order="'.$order.'" href="#">วันที่แจ้ง</a></th>
      <th><a  class="column_sort" id="detail" data-order="'.$order.'" href="#">อาการชำรุด</a></th>
      <th><a  class="column_sort" id="status" data-order="'.$order.'" href="#">สถานะ</a></th>
      <th><a  class="column_sort" id="priority" data-order="'.$order.'" href="#">ความสำคัญ</a></th>
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
  </table>';
  echo $output;
?>
