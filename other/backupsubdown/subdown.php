<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>แจ้งสถานีไฟฟ้า DOWN</title>
  </head>
  <body>
    <?php require_once 'process4.php'; ?>
    <div class="row justify-content-center">
      <form action="" method="post">
        <div class="form-group">
          <label>เวลา</label>
          <input type="time" name="time" value="">
        </div>
        <div class="form-group">
          <label>วันที่</label>
          <input type="date" name="date" class="form-control" value="" />
        </div>
        <div class="form-group">
          <label>สถานีไฟฟ้า</label>
          <input type="text" name="sub" class="form-control" value="">
          <!-- <select class="form-control" name="sub">
            <option value="เพชรบุรี 1">เพชรบุรี 1</option>
            <option value="เพชรบุรี 2">เพชรบุรี 2</option>
            <option value="ประจวบคีรีขันธ์">ประจวบคีรีขันธ์</option>
          </select> -->
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary" name="save">บันทึก</button>
        </div>
      </form>
    </div>
  </body>
</html>
