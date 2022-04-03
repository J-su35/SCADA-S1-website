<?php
  $page = "แจ้งการชำรุดของ Master Radio และ FRTU";
  include_once 'header7.php';
  require_once 'process10.php';
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
      $result = $mysqli->query("SELECT * FROM master_frtu") or die($mysqli->error);

      // pre_r($result);
      // pre_r($result->fetch_assoc());
    ?>
      <!-- Table section -->
      <div class="row justify-content-center">
      <!-- <div class="table-responsive"> -->
        <table class="table table-sm">
          <thead>
            <tr>
              <th>รหัสสั่งการ</th>
              <th>สถานที่</th>
              <th>วันที่รับแจ้ง</th>
              <th>ผู้แจ้ง</th>
              <th>สาเหตุเบื้องต้น</th>
              <th>ผู้รับผิดชอบ</th>
              <th>วันที่แก้ไข</th>
              <th>รายละเอียดการชำรุด</th>
              <th>ผู้แก้ไข</th>
              <th colspan="2"></th>
            </tr>
          </thead>
          <tbody id="myTable">
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?php echo $row['equipName']; ?></td>
                <td><?php echo $row['location']; ?></td>
                <td><?php echo $row['date1']; ?></td>
                <td><?php echo $row['name1']; ?></td>
                <td><?php echo $row['cause']; ?></td>
                <td><?php echo $row['division']; ?></td>
                <td><?php echo $row['date2']; ?></td>
                <td><?php echo $row['detail']; ?></td>
                <td><?php echo $row['name2']; ?></td>
            <?php if ($_SESSION['username'] == "adminS1" || $_SESSION['username'] =="commuadmin" || $_SESSION['username'] =="madadmin"): ?>
                <td>
                    <a href="bad_fiber.php?edit=<?php echo $row['id']; ?>" class="btn btn-info">แก้ไข</a>
                    <a href="process10.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">ลบ</a>
                </td>

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
    <?php if ($_SESSION['username'] == "adminS1" || $_SESSION['username'] =="commuadmin" || $_SESSION['username'] =="madadmin"): ?>
      <form action="process10.php" method="post">
        <div class="form-row">

          <input type="hidden" name="id" value="<?php echo $id; ?>">

          <div class="form-group col-md-4">
            <label>ชื่ออุปกรณ์-รหัสสั่งการ</label>
            <!-- <input type="date" name="noti_date" class="form-control" value=""> -->
            <input type="text" name="equipName" class="form-control" value="<?php echo $equipNameEd; ?>">
          </div>
          <div class="form-group col-md-8">
            <label>สถานที่</label>
            <!-- <input type="text" name="equipcode" class="form-control" value=""> -->
            <input type="text" name="location" class="form-control" value="<?php echo $locationEd; ?>">
          </div>
          <div class="form-group col-md-6">
            <label>วันที่รับแจ้ง</label>
            <!-- <input type="date" name="noti_date" class="form-control" value=""> -->
            <input type="date" name="date1" class="form-control">
          </div>
          <div class="form-group col-md-6">
            <label>ผู้แจ้ง</label>
            <!-- <input type="text" name="equipcode" class="form-control" value=""> -->
            <input type="text" name="name1" class="form-control" value="<?php echo $name1Ed; ?>">
          </div>
        </div>
        <div class="form-group">
          <label>สาเหตุเบื้องต้น</label><br>
          <!-- <input type="text" name="location" class="form-control" value=""> -->
          <div class="custom-control custom-radio was-validated">
            <input onclick="autotxt()" type="radio" value="สาเหตุจากอุปกรณ์" class="custom-control-input" id="option1" name="cause">
            <label class="custom-control-label" for="option1">กรส.ตรวจสอบแล้วไม่พบความเสียหาย</label>
          </div>
          <div class="custom-control custom-radio">
            <input type="radio" value="รอการตรวจสอบ" class="custom-control-input" id="option2" name="cause" checked>
            <label class="custom-control-label" for="option2">รอการตรวจสอบ</label>
          </div>
          <div class="custom-control custom-radio was-validated">
            <input onclick="autotxt()" value="สาเหตุจากระบบสื่อสาร" type="radio" class="custom-control-input" id="option3" name="cause">
            <label class="custom-control-label" for="option3">กบษ.ตรวจสอบแล้วไม่พบความเสียหาย</label>
          </div>
          <!-- <input type="radio" name="cause" value="สาเหตุจากอุปกรณ์"> กรส.ตรวจสอบแล้วไม่พบความเสียหาย
          <input type="radio" name="cause" value="รอการตรวจสอบ" checked> รอการตรวจสอบ
          <input type="radio" name="cause" value="สาเหตุจากระบบสื่อสาร"> กบษ.ตรวจสอบแล้วไม่พบความเสียหาย -->
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>ผู้รับผิดชอบ</label>
            <!-- <input type="text" name="equipcode" class="form-control" value=""> -->
            <input type="text" name="division" class="form-control" id="division" value="<?php echo $divisionEd; ?>" readonly required>
          </div>
          <div class="form-group col-md-6">
            <label>วันที่แก้ไข</label>
            <!-- <input type="date" name="noti_date" class="form-control" value=""> -->
            <input type="date" name="date2" class="form-control">
          </div>
          <div class="form-group col-md-12">
            <label>สาเหตุการชำรุด</label>
            <input type="text" name="detail" class="form-control" value="<?php echo $detailEd; ?>">
          </div>
          <div class="form-group col-md-6">
            <label>ผู้แก้ไข</label>
            <!-- <input type="text" name="equipcode" class="form-control" value=""> -->
            <input type="text" name="name2" class="form-control" value="<?php echo $name2Ed; ?>">
          </div>
        </div>

        <div class="form-group">
          <?php if ($update == true): ?>
            <button type="submit" class="btn btn-info" name="update">แก้ไข</button>
          <?php else: ?>
            <button type="submit" class="btn btn-primary" name="save">บันทึก</button>
          <?php endif; ?>
        </div>
      </form>

    <?php endif; ?>
    </div>

    <script>
    function autotxt() {
      if (document.getElementById("option1").checked) {
        document.getElementById("division").value = "กบษ.";
      }
      if (document.getElementById("option3").checked) {
        document.getElementById("division").value = "กรส.";
      }
    }
    </script>

<?php
  require "footer.php";
?>
