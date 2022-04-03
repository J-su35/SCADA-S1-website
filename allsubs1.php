<?php
  $page = "เพิ่ม/แก้ไข ข้อมูลสถานีไฟฟ้า";
  include_once 'header7s.php';
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
      $result = $mysqli->query("SELECT * FROM equip_problems1") or die($mysqli->error);

      // pre_r($result);
      // pre_r($result->fetch_assoc());
    ?>
      <!-- Table section -->
      <div class="row justify-content-center table-responsive">
        <table class="table table-sm">
          <thead>
            <tr>
              <th>สถานีไฟฟ้า</th>
              <th colspan="2"></th>
            </tr>
          </thead>
            <tbody id="myTable">
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?php echo $row['sub']; ?></td>
            <?php if($_SESSION['username']=='adminS1'): ?>
                <td>
                    <a href="allsubs1.php?edit=<?php echo $row['id']; ?>" class="btn btn-info">แก้ไข</a>
                    <a href="allsubs1.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">ลบ</a>
                </td>
            <?php endif; ?>
              </tr>
            <?php endwhile; ?>
            </tbody>
          </table>
      </div>
      <!-- Table section End -->


      <div class="row justify-content-center">
        <form action="process3.php" method="post">

          <input type="hidden" name="id" value="<?php echo $id; ?>">

          <div class="form-group">
            <label>สถานีไฟฟ้าเต็ม</label>
            <!-- <input type="date" name="noti_date" class="form-control" value=""> -->
            <input type="date" name="noti_date" class="form-control" value="<?php echo $dateEd; ?>">
          </div>
          <div class="form-group">
            <label>สถานีไฟฟ้าย่อ</label>
            <!-- <input type="date" name="noti_date" class="form-control" value=""> -->
            <input type="date" name="noti_date" class="form-control" value="<?php echo $dateEd; ?>">
          </div>
          <div class="form-group">
            <label>Substation Shortname</label>
            <!-- <input type="date" name="noti_date" class="form-control" value=""> -->
            <input type="date" name="noti_date" class="form-control" value="<?php echo $dateEd; ?>">
          </div>
          <div class="form-group">
            <label>ระดับแรงดัน</label>
            <!-- <input type="text" name="equipcode" class="form-control" value=""> -->
            <input type="text" name="equipcode" class="form-control" value="<?php echo $equipcodeEd; ?>">
          </div>
          <div class="form-group">
            <label>เบรกเกอร์</label>
            <!-- <input type="text" name="location" class="form-control" value=""> -->
            <input type="text" name="location" class="form-control" value="<?php echo $locationEd; ?>">
          </div>
          <div class="form-group">
            <label>ตัวคูณ</label>
            <!-- <input type="text" name="detail" class="form-control" value=""> -->
            <input type="text" name="detail" class="form-control" value="<?php echo $detailEd; ?>">
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
