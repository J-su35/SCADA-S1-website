<?php
  $page = "แจ้งปัญหาอุปกรณ์ในสถานีไฟฟ้า";
  include_once 'header7s.php';
  require_once 'process3d.php';
?>

    <!-- Session message section -->
    <?php
       if (isset($_GET['notify']) && $_GET['notify'] == "successful") {
         echo '<p class="alert alert-success">บันทึกข้อมูลสำเร็จ!</p>';
       }
     ?>


    <!-- Session message section end -->

    <div class="container">

        <form action="process3d.php" method="post">

          <input type="hidden" name="id" value="<?php echo $id; ?>">

          <div class="form-row">
          <div class="form-group col-md-6">
            <label>วันที่</label>
            <!-- <input type="date" name="noti_date" class="form-control" value=""> -->
            <input type="date" name="noti_date" class="form-control" value="<?php echo $dateEd; ?>" required id="date1">
          </div>

          <div class="form-group col-md-12">
            <label>ประเภทการชำรุด</label>
            <div class="form-check">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" name="catgories" value="อุปกรณ์ในสถานีไฟฟ้า" id="radionB_1" required>อุปกรณ์ในสถานีไฟฟ้า
              </label>
            </div>
            <div class="form-check">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" name="catgories" value="อุปกรณ์ในระบบส่ง" id="radionB_2">อุปกรณ์ในระบบส่ง
              </label>
            </div>
            <div class="form-check disabled">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" name="catgories" value="อุปกรณ์ในระบบจำหน่าย" id="radionB_3">อุปกรณ์ในระบบจำหน่าย
              </label>
            </div>
          </div>

          <div class="form-group col-md-12">
            <label>อุปกรณ์ที่ชำรุด</label>
            <!-- <input type="text" name="equipcode" class="form-control" value=""> -->
            <input type="text" name="equipcode" class="form-control" value="<?php echo $equipcodeEd; ?>" required>
          </div>
          <div class="form-group col-md-12">
            <label>สถานที่</label>
            <!-- <input type="text" name="location" class="form-control" value=""> -->
            <input type="text" name="location" class="form-control" value="<?php echo $locationEd; ?>" required>
          </div>
          <div class="form-group col-md-12">
            <label for="detailtxt">รายละเอียดการชำรุด</label>
            <!-- <input type="text" name="detail" class="form-control" value=""> -->
            <textarea name="detail" class="form-control" rows="4" id="detailtxt"><?php echo $detailEd; ?></textarea>
          </div>

          <label class="col-md-2">ระดับความสำคัญ</label>
          <div class="col-md-10">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="radio" name="priority" value="ด่วน" required>ด่วน
              </label>
            </div>
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="radio" name="priority" value="ปกติ">ปกติ
              </label>
            </div>
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="radio" name="priority" value="ทั่วไป">ทั่วไป
              </label>
            </div>
          </div>

          <div class="form-group col-md-12">
            <label>ผู้แจ้ง</label>
            <input type="text" name="customerName" class="form-control" value="<?php echo $cusNameEd; ?>">
          </div>

          <div class="col-md-12">
            <?php if ($update == true): ?>
              <button type="submit" class="btn btn-info" name="update">Update</button>
            <?php else: ?>
              <button type="submit" class="btn btn-primary" name="save">Save</button>
            <?php endif; ?>
          </div>
        </div>
        </form>

    </div>

<?php
  require "footer.php";
?>
