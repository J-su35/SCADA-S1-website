<?php
  $page = "แจ้งปัญหาอุปกรณ์ในสายส่ง 115 kV";
  include_once 'header7.php';
  require_once 'process3.php';
?>



    <!-- Session message section -->
    <?php if (isset($_SESSION['message'])): ?>
      <div class="alert alert-<?=$_SESSION['msg_type']?>">
        <?php
          echo $_SESSION['message'];
          unset($_SESSION['message']);
         ?>
      </div>
    <?php endif ?>
    <!-- Session message section end -->

    <div class="container">

    <!-- debug part -->
    <?php
      $mysqli = new mysqli('localhost', 'root', '123456', 'login') or die(mysqli_error($mysqli));
      $result = $mysqli->query("SELECT * FROM equip_problems2") or die($mysqli->error);

      // pre_r($result);
      // pre_r($result->fetch_assoc());
    ?>
      <!-- Table section -->
      <div class="row justify-content-center table-responsive">
        <table class="table table-sm">
          <thead>
            <tr>
              <th>วันที่</th>
              <th>อุปกรณ์</th>
              <th>สถานที่</th>
              <th>สาเหตุ/รายละเอียด</th>
              <th>การแก้ไข</th>
              <th>วันที่แก้ไข</th>
              <th colspan="2"></th>
            </tr>
          </thead>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['equip_code']; ?></td>
                <td><?php echo $row['location']; ?></td>
                <td><?php echo $row['detail']; ?></td>
                <td><?php echo $row['action']; ?></td>
                <td><?php echo $row['action_date']; ?></td>
            <?php if($_SESSION['username']=='scadaadmin'): ?>
                <td>
                    <a href="bad_equip2.php?edit=<?php echo $row['id']; ?>" class="btn btn-info">แก้ไข</a>
                    <a href="process3b.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">ลบ</a>
                </td>
            <?php else: ?>
                <td></td>
            <?php endif; ?>
              </tr>
            <?php endwhile; ?>
          </table>
      </div>
      <!-- Table section End -->

    <?php
      function pre_r($array) {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
      }
    ?>
    <!-- debug part End -->

      <div class="row justify-content-center">
        <form action="process3b.php" method="post">

          <input type="hidden" name="id" value="<?php echo $id; ?>">

          <div class="form-group">
            <label>วันที่</label>
            <!-- <input type="date" name="noti_date" class="form-control" value=""> -->
            <input type="date" name="noti_date" class="form-control" value="<?php echo $dateEd; ?>">
          </div>
          <div class="form-group">
            <label>อุปกรณ์</label>
            <!-- <input type="text" name="equipcode" class="form-control" value=""> -->
            <input type="text" name="equipcode" class="form-control" value="<?php echo $equipcodeEd; ?>">
          </div>
          <div class="form-group">
            <label>สถานที่</label>
            <!-- <input type="text" name="location" class="form-control" value=""> -->
            <input type="text" name="location" class="form-control" value="<?php echo $locationEd; ?>">
          </div>
          <div class="form-group">
            <label>สาเหตุ/รายละเอียด</label>
            <!-- <input type="text" name="detail" class="form-control" value=""> -->
            <input type="text" name="detail" class="form-control" value="<?php echo $detailEd; ?>">
          </div>
          <div class="form-group">
            <label>การแก้ไข</label>
            <!-- <input type="text" name="equipcode" class="form-control" value=""> -->

            <input type="radio" name="action" value="รอการแก้ไข"> รอการแก้ไข
            <input type="radio" name="action" value="แก้ไขแล้ว"> แก้ไขแล้ว
          </div>
          <div class="form-group">
            <label>วันที่แก้ไข</label>
            <!-- <input type="date" name="noti_date" class="form-control" value=""> -->
            <input type="date" name="action_date" class="form-control" value="<?php echo $action_dateEd; ?>">
          </div>
          <div class="form-group">
            <?php if ($update == true): ?>
              <button type="submit" class="btn btn-info" name="update">Update</button>
            <?php else: ?>
              <button type="submit" class="btn btn-primary" name="save">Save</button>
            <?php endif; ?>
          </div>
        </form>
      </div>
    </div>

<?php
  require "footer.php";
?>
