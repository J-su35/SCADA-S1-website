<?php
  $page = "แจ้งการชำรุดของสายเคเบิลใยแก้วนำแสง";
  include_once 'header7s.php';
  require_once 'process6.php';
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
      $mysqli = new mysqli('sql113.epizy.com', 'epiz_24636187', 'uONrYWxJLD', 'epiz_24636187_login') or die(mysqli_error($mysqli));
      $result = $mysqli->query("SELECT * FROM bad_fiber") or die($mysqli->error);

      // pre_r($result);
      // pre_r($result->fetch_assoc());
    ?>
      <!-- Table section -->
      <div class="row justify-content-center">
        <table class="table">
          <thead>
            <tr>
              <th>หมายเลขงาน</th>
              <th>ชื่อ-เส้นทาง</th>
              <th>ผลกระทบต่ออุปกรณ์</th>
              <th>ลูกค้า</th>
              <th>วันที่รับแจ้ง</th>
              <th>เวลาที่รับแจ้ง</th>
              <th>วันที่ปิดงาน</th>
              <th>เวลาที่ปิดงาน</th>
              <th>สาเหตุ</th>
              <th>รายละเอียด</th>
              <th>สถานที่ที่ชำรุด</th>
              <th>การแก้ไข</th>
              <th colspan="2"></th>
            </tr>
          </thead>
          <tbody id="myTable">
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?php echo $row['jobnum']; ?></td>
                <td><?php echo $row['route']; ?></td>
                <td><?php echo $row['equipment']; ?></td>
                <td><?php echo $row['client']; ?></td>
                <td><?php echo $row['dateopen']; ?></td>
                <td><?php echo $row['timeopen']; ?></td>
                <td><?php echo $row['dateclose']; ?></td>
                <td><?php echo $row['timeclose']; ?></td>
                <td><?php echo $row['causes']; ?></td>
                <td><?php echo $row['detail']; ?></td>
                <td><?php echo $row['location']; ?></td>
                <td><?php echo $row['repairing']; ?></td>
            <?php if ($_SESSION['username'] == "scadaadmin" || $_SESSION['username'] =="commuadmin"): ?>
                <td>
                    <a href="bad_fiber.php?edit=<?php echo $row['id']; ?>" class="btn btn-info">แก้ไข</a>
                    <a href="process6.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">ลบ</a>
                </td>
            <?php else: ?>
                <td></td>
            <?php endif; ?>
              </tr>
            <?php endwhile; ?>
          </tbody>
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
        <form action="process6.php" method="post">

          <input type="hidden" name="id" value="<?php echo $id; ?>">

          <div class="form-group">
            <label>หมายเลขงาน</label>
            <!-- <input type="date" name="noti_date" class="form-control" value=""> -->
            <input type="text" name="jobnum" class="form-control" value="<?php echo $jobnumEd; ?>">
          </div>
          <div class="form-group">
            <label>ชื่อ-เส้นทาง</label>
            <!-- <input type="text" name="equipcode" class="form-control" value=""> -->
            <input type="text" name="route" class="form-control" value="<?php echo $routeEd; ?>">
          </div>
          <div class="form-group">
            <label>ผลกระทบต่ออุปกรณ์</label>
            <!-- <input type="text" name="location" class="form-control" value=""> -->
            <input type="text" name="equipment" class="form-control" value="<?php echo $equipmentEd; ?>">
          </div>
          <div class="form-group">
            <label>ลูกค้า</label>
            <!-- <input type="text" name="detail" class="form-control" value=""> -->
            <input type="text" name="client" class="form-control" value="<?php echo $clientEd; ?>">
          </div>
          <div class="form-group">
            <label>วันที่รับแจ้ง</label>
            <input type="date" name="dateopen" class="form-control" value="<?php echo $dateopenEd; ?>">
          </div>
          <div class="form-group">
            <label>เวลาที่รับแจ้ง</label>
            <input type="time" name="timeopen" class="form-control" >
          </div>
          <div class="form-group">
            <label>วันที่ปิดงาน</label>
            <input type="date" name="dateclose" class="form-control" >
          </div>
          <div class="form-group">
            <label>เวลาที่ปิดงาน</label>
            <input type="time" name="timeclose" class="form-control" >
          </div>
          <div class="form-group">
            <label>สาเหตุ</label>
            <input type="text" name="causes" class="form-control" >
          </div>
          <div class="form-group">
            <label>รายละเอียด</label>
            <input type="text" name="detail" class="form-control" value="<?php echo $detailEd; ?>">
          </div>
          <div class="form-group">
            <label>สถานที่ชำรุด</label>
            <input type="text" name="location" class="form-control" value="<?php echo $locationEd; ?>">
          </div>
          <div class="form-group">
            <label>การแก้ไข</label>
            <input type="text" name="repairing" class="form-control" value="<?php echo $repairingEd; ?>">
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
