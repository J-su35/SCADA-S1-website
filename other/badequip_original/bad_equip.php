<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>แจ้งปัญหาอุปกรณ์ในระบบและสถานีไฟฟ้า</title>
  </head>
  <body>
    <?php require_once 'process3.php'; ?>
    <div class="row justify-content-center">
      <form action="" method="post">
        <div class="form-group">
          <label>วันที่</label>
          <input type="date" name="noti_date" value="">
        </div>
        <div class="form-group">
          <label>รหัสอุปกรณ์</label>
          <input type="text" name="equipcode" class="form-control" value="">
        </div>
        <div class="form-group">
          <label>สถานที่</label>
          <input type="text" name="location" class="form-control" value="">
        </div>
        <div class="form-group">
          <label>รายละเอียด</label>
          <input type="text" name="detail" class="form-control" value="">
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary" name="save">บันทึก</button>
        </div>
      </form>
    </div>
  </body>
</html>
