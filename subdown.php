<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>แจ้งสถานีไฟฟ้า DOWN</title>
    <script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </head>
  <body>

    <!-- Navigation  -->
    <nav class="navbar navbar-expand-md navbar-light bg-light stricky-top">
    	<div class="container-fluid">
    		<a class="navbar-brand" href="index.php"><img src="img/scada-logo.png"></a>
    		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
    			<span class="navbar-toggler-icon"></span>
    		</button>
    		<div class="collapse navbar-collapse" id="navbarResponsive">
    			<ul class="navbar-nav ml-auto">
    				<li class="nav-item active">
    					<a class="nav-link" href="index.php">หน้าหลัก</a>
    				</li>
    				<!-- <li class="nav-item">
    					<a class="nav-link" href="https://www.google.co.th/">แผนงานขอดับไฟ P6</a>
    				</li> -->
    				<!-- <li class="nav-item">
    					<a class="nav-link" href="#upload">ลงข้อมูล</a>
    				</li>
    				<li class="nav-item">
    					<a class="nav-link" href='#download'>ดาวน์โหลด</a>
    				</li> -->
    				<li class="nav-item">
    					<a class="nav-link" href="logout.php">ออกจากระบบ</a>
    				</li>
    			</ul>
    	</div>
    </nav>
    
    <?php require_once 'process4.php'; ?>

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
        $result = $mysqli->query("SELECT * FROM commu_down") or die($mysqli->error);

        // pre_r($result);
        // pre_r($result->fetch_assoc());
      ?>
        <!-- Table section -->
        <div class="row justify-content-center">
          <table class="table">
            <thead>
              <tr>
                <th>เวลา</th>
                <th>วันที่</th>
                <th>สถานี</th>
                <th colspan="2">Action</th>
              </tr>
            </thead>
              <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td><?php echo $row['timedown']; ?></td>
                  <td><?php echo $row['notidate']; ?></td>
                  <td><?php echo $row['sub']; ?></td>

                  <td>
                    <a href="subdown.php?edit=<?php echo $row['id']; ?>" class="btn btn-info">Edit</a>
                    <a href="process4.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                  </td>
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
        <form action="process4.php" method="post">

          <input type="hidden" name="id" value="<?php echo $id; ?>">

          <div class="form-group">
            <label>เวลา</label>
            <!-- <input type="time" name="time" value=""> -->
            <input type="time" name="time" class="form-control" value="<?php echo $time; ?>">
          </div>
          <div class="form-group">
            <label>วันที่</label>
            <!-- <input type="date" name="date" class="form-control" value="" /> -->
            <input type="date" name="date" class="form-control" value="<?php echo $date; ?>">
          </div>
          <div class="form-group">
            <label>สถานีไฟฟ้า</label>
            <!-- <input type="text" name="sub" class="form-control" value=""> -->
            <select class="form-control" name="sub" value="<?php echo $sub; ?>">
              <option value="เพชรบุรี 1">เพชรบุรี 1</option>
              <option value="เพชรบุรี 2">เพชรบุรี 2</option>
              <option value="ประจวบคีรีขันธ์">ประจวบคีรีขันธ์</option>
            </select>
            <!-- <input type="text" name="sub" class="form-control" value="<?php echo $sub; ?>"> -->
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
  </body>
</html>
