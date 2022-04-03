<?php
  $page = "รายงานการอ่านมาตรวัดไฟฟ้าประจำเดือน";
  include_once 'header7.php';
  require_once 'process9.php';
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
      $result = $mysqli->query("SELECT * FROM subkhw") or die($mysqli->error);
    ?>
      <!-- Table section -->
      <div class="row justify-content-center">
        <table class="table">
          <thead>
            <tr>
              <th>เดือน</th>
              <!-- <th>ปี</th> -->
              <th>สถานีไฟฟ้า</th>
              <th colspan="2"></th>
            </tr>
          </thead>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?php echo $row['month']; ?></td>

                <td><?php echo $row['subName']; ?></td>
                <td>
                  <a href="sub_kwhunit.php?edit=<?php echo $row['id']; ?>" class="btn btn-info">เลือก</a>
                  <?php if($_SESSION['username']=='adminS1'): ?>
                    <a href="sub_kwhunit.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">ลบ</a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endwhile; ?>
          </table>
      </div>
      <!-- Table section End -->

      <?php
        $mysqli = new mysqli('localhost', 'root', '123456', 'login') or die(mysqli_error($mysqli));

        if (isset($_GET['delete'])) {
          $id = $_GET['delete'];
          $mysqli->query("DELETE FROM subkhw WHERE id=$id") or die($mysqli->error());

          echo '<div class="alert alert-success">Record deleted successfully</div>';

          header("location: sub_kwhunit.php");
        }
      ?>


    <?php
      function pre_r($array) {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
      }
    ?>
    <!-- debug part End -->

      <div class="container-fluid">
        <form action="process9.php" method="post">
          <div class="form-group col-md-6">

            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <label>เดือน</label>
            <input type="text" name="month" class="form-control" value="<?php echo $monthEd; ?>" readonly><br>
            <label>พ.ศ.</label>
            <input type="text" name="year" id="yeartxt" class="form-control" value="<?php echo $yearEd; ?>" readonly><br>
            <label>สฟฟ.</label>
            <input type="text" name="substaion" id="subName" class="form-control" value="<?php echo $substationEd; ?>" readonly><br>
            <label>แรงดัน</label>
            <input type="text" name="voltage" id="voltage" class="form-control" readonly><br>
            <label>เวลาอ่าน</label>
            <input type="time" name="read_time" class="form-control" value="<?php echo $read_timeEd; ?>" readonly>
            <label>วันที่อ่าน</label>
            <input type="date" name="read_date" class="form-control" value="<?php echo $read_dateEd; ?>" readonly><br><br>
          </div>

        <div class="form-group col-md-6">
          <fieldset>
            <legend id="legend0"><?php echo $legend0; ?></legend>

            <label>ตัวเลขที่อ่านได้ในเดือนนี้</label><br>
            <label>Export (+)</label>
            <input type="number" name="F1_current_Exunit" class="form-control" id = "F1_current_Exunit" value="<?php echo $F1_current_ExunitEd; ?>" readonly><br>
            <label>Import (-)</label>
            <input type="number" name="F1_current_Imunit" class="form-control" id ="F1_current_Imunit" value="<?php echo $F1_current_ImunitEd; ?>" readonly><br>

            <label>ตัวเลขที่อ่านได้ในเดือนก่อน</label><br>
            <label>Export (+)</label>
            <input type="number" name="F1_last_Exunit" class="form-control" id ="F1_last_Exunit" value="<?php echo $F1_last_ExunitEd; ?>" readonly><br>
            <label>Import (-)</label>
            <input type="number" name="F1_last_Imunit" class="form-control" id="F1_last_Imunit" value="<?php echo $F1_last_ImunitEd; ?>" readonly><br>

            <label>ผลต่าง</label><input type="text" name="F1_different" class="form-control" id ="F1_different" value="<?php echo $F1_differentEd; ?>" readonly><br>
            <label>ตัวคูณ</label>
            <input type="text" name="F0_factor" class="form-control" id="factor0" readonly><br>

            <label>ผลลัพธ์</label><input type="text" name="F1_summation" class="form-control" id="F1_summation" value="<?php echo $F1_summationEd; ?>" readonly><br>
          </fieldset>
        </div>

        <div class="form-group col-md-6">
          <fieldset>
            <legend id="legend1"><?php echo $legend1; ?></legend>

            <label>ตัวเลขที่อ่านได้ในเดือนนี้</label><br>
            <label>Export (+)</label>
            <input type="number" name="F2_currnet_Exunit" class="form-control" id="F2_current_Exunit" value="<?php echo $F2_currnet_ExunitEd; ?>" readonly><br>
            <label>Import (-)</label>
            <input type="number" name="F2_current_Imunit" class="form-control" id="F2_current_Imunit" value="<?php echo $F2_current_ImunitEd; ?>" readonly><br>

            <label>ตัวเลขที่อ่านได้ในเดือนก่อน</label><br>
            <label>Export (+)</label>
            <input type="number" name="F2_last_Exunit" class="form-control" id="F2_last_Exunit" value="<?php echo $F2_last_ExunitEd; ?>" readonly><br>
            <label>Import (-)</label>
            <input type="number" name="F2_last_Imunit" class="form-control" id="F2_last_Imunit" value="<?php echo $F2_last_ImunitEd; ?>" readonly><br>

            <label>ผลต่าง</label><input type="text" name="F2_different" class="form-control" id="F2_different" value="<?php echo $F2_differentEd; ?>" readonly><br>
            <label>ตัวคูณ</label>
            <input type="text" name="F1_factor" class="form-control" id="factor1" readonly><br>

            <label>ผลลัพธ์</label><input type="text" name="F2_summation" class="form-control" id="F2_summation" value="<?php echo $F2_summationEd; ?>" readonly><br>
          </fieldset><br>
        </div>

        <div class="form-group col-md-6">
          <fieldset>
            <legend id="legend2"><?php echo $legend2; ?></legend>

            <label>ตัวเลขที่อ่านได้ในเดือนนี้</label><br>
            <label>Export (+)</label>
            <input type="number" name="F3_current_Exunit" class="form-control" id="F3_current_Exunit" value="<?php echo $F3_current_ExunitEd; ?>" readonly><br>
            <label>Import (-)</label>
            <input type="number" name="F3_current_Imunit" class="form-control" id="F3_current_Imunit" value="<?php echo $F3_current_ImunitEd; ?>" readonly><br>

            <label>ตัวเลขที่อ่านได้ในเดือนก่อน</label><br>
            <label>Export (+)</label>
            <input type="number" name="F3_last_Exunit" class="form-control" id="F3_last_Exunit" value="<?php echo $F3_last_ExunitEd; ?>" readonly><br>
            <label>Import (-)</label>
            <input type="number" name="F3_last_Imunit" class="form-control" id="F3_last_Imunit" value="<?php echo $F3_last_ImunitEd; ?>" readonly><br>

            <label>ผลต่าง</label><input type="text" name="F3_different" class="form-control" id="F3_different" value="<?php echo $F3_differentEd; ?>" readonly><br>
            <label>ตัวคูณ</label>
            <input type="text" name="F2_factor" class="form-control" id="factor2" readonly><br>

            <label>ผลลัพธ์</label><input type="text" name="F3_summation" class="form-control" id="F3_summation" value="<?php echo $F3_summationEd; ?>" readonly><br>
          </fieldset><br>
        </div>

        <div class="form-group col-md-6">
          <fieldset>
            <legend id="legend3"><?php echo $legend3; ?></legend>

            <label>ตัวเลขที่อ่านได้ในเดือนนี้</label><br>
            <label>Export (+)</label>
            <input type="number" name="F4_current_Exunit" class="form-control" id="F4_current_Exunit" value="<?php echo $F4_current_ExunitEd; ?>" readonly><br>
            <label>Import (-)</label>
            <input type="number" name="F4_current_Imunit" class="form-control" id="F4_current_Imunit" value="<?php echo $F4_current_ImunitEd; ?>" readonly><br>

            <label>ตัวเลขที่อ่านได้ในเดือนก่อน</label><br>
            <label>Export (+)</label>
            <input type="number" name="F4_last_Exunit" class="form-control" id="F4_last_Exunit" value="<?php echo $F4_last_ExunitEd; ?>" readonly><br>
            <label>Import (-)</label>
            <input type="number" name="F4_last_Imunit" class="form-control" id="F4_last_Imunit" value="<?php echo $F4_last_ImunitEd; ?>" readonly><br>

            <label>ผลต่าง</label><input type="text" name="F4_different" class="form-control" id="F4_different" value="<?php echo $F4_differentEd; ?>" readonly><br>
            <label>ตัวคูณ</label>
            <input type="text" name="F3_factor" class="form-control" id="factor3" readonly><br>

            <label>ผลลัพธ์</label><input type="text" name="F4_summation" class="form-control" id="F4_summation" value="<?php echo $F4_summationEd; ?>" readonly><br>
          </fieldset><br>
        </div>

        <div class="form-group col-md-6">
          <fieldset>
            <legend id="legend4"><?php echo $legend4; ?></legend>

            <label>ตัวเลขที่อ่านได้ในเดือนนี้</label><br>
            <label>Export (+)</label>
            <input type="number" name="F5_current_Exunit" class="form-control" id="F5_current_Exunit" value="<?php echo $F5_current_ExunitEd; ?>" readonly><br>
            <label>Import (-)</label>
            <input type="number" name="F5_current_Imunit" class="form-control" id="F5_current_Imunit" value="<?php echo $F5_current_ImunitEd; ?>" readonly><br>

            <label>ตัวเลขที่อ่านได้ในเดือนก่อน</label><br>
            <label>Export (+)</label>
            <input type="number" name="F5_last_Exunit" class="form-control" id="F5_last_Exunit" value="<?php echo $F5_last_ExunitEd; ?>" readonly><br>
            <label>Import (-)</label>
            <input type="number" name="F5_last_Imunit" class="form-control" id="F5_last_Imunit" value="<?php echo $F5_last_ImunitEd; ?>" readonly><br>

            <label>ผลต่าง</label><input type="text" name="F5_different" class="form-control" id="F5_different" value="<?php echo $F5_differentEd; ?>" readonly><br>
            <label>ตัวคูณ</label>
            <input type="text" name="F4_factor" class="form-control" id="factor4" readonly><br>

            <label>ผลลัพธ์</label><input type="text" name="F5_summation" class="form-control" id="F5_summation" value="<?php echo $F5_summationEd; ?>" readonly><br>
          </fieldset><br>
        </div>

        <div class="form-group col-md-6">
          <label>การถ่ายเทโหลดระหว่าง Incoming</label>
          <input type="text" name="loadtransfer_incoming" class="form-control" value="<?php echo $loadtransfer_incomingEd; ?>" readonly><br>

          <label>การถ่ายเทโหลดระหว่าง Feeder</label>
          <input type="text" name="loadtransfer_feeder" class="form-control" value="<?php echo $loadtransfer_feederEd; ?>" readonly><br>

          <label>พลังงานไฟฟ้า Incoming</label> <input type="text" name="sumIncoming_energy" class="form-control" value="<?php echo $sumIncoming_energyEd; ?>" readonly><br>
          <label>พลังงานไฟฟ้า Feeder</label> <input type="text" name="sumFeeder_energy" class="form-control" value="<?php echo $sumFeeder_energyEd; ?>" readonly><br>
          <label>หมายเหตุ</label>
          <textarea name="message" rows="5" cols="30" class="form-control"></textarea><br>
          <label>ผู้ลงข้อมูล</label> <input type="text" name="operator_name" class="form-control" value="<?php echo $operator_nameEd; ?>" readonly><br>
          <br>
        </div>

        </form>
      </div>
    </div>

<?php
  require "footer.php";
?>
