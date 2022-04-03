<?php
  $page = "เปลี่ยนแปลงสถานะงาน";
  include_once 'header7s.php';
  require_once 'process3d2.php';
?>

    <div class="container">
        <form action="process3d2.php" method="post">
          <input type="hidden" name="id" value="<?php echo $id; ?>">

          <div class="form-row">
            <div class="form-group col-md-6">
              <label>วันที่แก้ไข</label>
              <input type="date" name="date_end" class="form-control" value="<?php echo $date_endEd; ?>" required id="date2">
            </div>

            <div class="form-group col-md-12">
              <label>สถานะ</label>
              <div class="form-check">
                <label class="form-check-label">
                  <input type="radio" class="form-check-input" name="status" value="อยู่ระหว่างการแก้ไข" id="radionB_1" required>อยู่ระหว่างการแก้ไข
                </label>
              </div>
              <div class="form-check">
                <label class="form-check-label">
                  <input type="radio" class="form-check-input" name="status" value="แก้ไขแล้วเสร็จ" id="radionB_2">แก้ไขแล้วเสร็จ
                </label>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label>ผู้แจ้ง</label>
              <input type="text" name="ma_name" class="form-control" value="<?php echo $ma_nameEd; ?>">
            </div>


            <div class="col-md-12">
              <button type="submit" class="btn btn-info" name="updateStatus">Update</button>
            </div>
          </div>
        </form>

    </div>

<?php
  require "footer.php";
?>
