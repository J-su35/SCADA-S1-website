<?php
  $page = "แจ้งการชำรุดของอุปกรณ์สื่อสาร";
  include_once 'header7s.php';
  require_once 'process7.php';
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
      $result = $mysqli->query("SELECT * FROM bad_sdh") or die($mysqli->error);

      // pre_r($result);
      // pre_r($result->fetch_assoc());
    ?>
      <!-- Table section -->
      <div class="row justify-content-center">
        <table class="table">
          <thead>
            <tr>
              <th>วันที่รับแจ้ง</th>
              <th>สถานที่</th>
              <th>อุปกรณ์</th>
              <th>การชำรุด</th>
              <th>รายละเอียด</th>
              <th>วันที่แล้วเสร็จ</th>
              <th>หมายเหตุ</th>
              <th colspan="2"></th>
            </tr>
          </thead>
          <tbody id="myTable">
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo $row['date']; ?></td>
              <td><?php echo $row['location']; ?></td>
              <td><?php echo $row['equipment']; ?></td>
              <td><?php echo $row['causes']; ?></td>
              <td><?php echo $row['detail']; ?></td>
              <td><?php echo $row['dateend']; ?></td>
              <td><?php echo $row['other']; ?></td>
          <?php if ($_SESSION['username'] == "scadaadmin" || $_SESSION['username'] =="commuadmin"): ?>
              <td>
                  <a href="bad_SDH.php?edit=<?php echo $row['id']; ?>" class="btn btn-info">แก้ไข</a>
                  <a href="process7.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">ลบ</a>
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
    <?php if ($_SESSION['username'] == "scadaadmin" || $_SESSION['username'] =="commuadmin"): ?>
      <div class="row justify-content-center">

        <form action="process7.php" method="post">

          <input type="hidden" name="id" value="<?php echo $id; ?>">

          <div class="form-group">
            <label>วันที่รับแจ้ง</label>
            <!-- <input type="date" name="noti_date" class="form-control" value=""> -->
            <input type="date" name="date" class="form-control">
          </div>
          <div class="form-group">
            <label>สถานที่</label>
            <!-- <input type="text" name="equipcode" class="form-control" value=""> -->
            <input type="text" name="location" class="form-control" value="<?php echo $locationEd; ?>">
          </div>
          <div class="form-group">
            <label>อุปกรณ์</label>
            <!-- <input type="text" name="location" class="form-control" value=""> -->
            <input type="radio" name="equipment" value="IP Access"> IP Access
            <input type="radio" name="equipment" value="DWDM"> DWDM
            <input type="radio" name="equipment" value="SDH"> SDH
            <input type="radio" name="equipment" value="MUX"> MUX
            <input type="radio" name="equipment" value="FOM"> FOM
          </div>
          <div class="form-group">
            <label>สาเหตุ</label><br>
            <input type="radio" name="causes" value="Card ชำรุด"> Card ชำรุด
            <input type="radio" name="causes" value="FOM ชำรุด"> FOM ชำรุด <br>
            <input type="radio" name="causes" value="ระบบ NMS มีปัญหา"> ระบบ NMS มีปัญหา <br>
            <input type="radio" name="causes" value="ระบบไฟ"> ระบบไฟ
            <input type="radio" name="causes" value="Rectifier ชำรุด/ระบบไฟ"> Rectifier ชำรุด/ระบบไฟ <br>
            <input type="radio" name="causes" value="patchcord/connector ชำรุด"> patchcord/connector ชำรุด <br>
            <input type="radio" name="causes" value="Surge ชำรุด"> Surge ชำรุด
            <input type="radio" name="causes" value="AC Surge protection ชำรุด"> AC Surge protection ชำรุด
            <input type="radio" name="causes" value="Interface Surge protection ชำรุด"> Interface Surge protection ชำรุด <br>
            <input type="radio" name="causes" value="Battery ชำรุด"> Battery ชำรุด
            <input type="radio" name="causes" value="UPS ชำรุด"> UPS ชำรุด
          </div>
          <div class="form-group">
            <label>รายละเอียด</label>
            <input type="text" name="detail" class="form-control" value="<?php echo $detailEd; ?>">
          </div>
          <div class="form-group">
            <label>วันที่แล้วเสร็จ</label>
            <input type="date" name="datefinished" class="form-control">
          </div>
          <div class="form-group">
            <label>หมายเหตุ</label>
            <input type="text" name="other" class="form-control" value="<?php echo $otherEd; ?>">
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
    <?php endif; ?>
    </div>

<?php
  require "footer.php";
?>
