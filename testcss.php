<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>PHP CRUD Test CSS</title>
        <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

  </head>
  <body>
    <?php require 'process31.php'; ?>

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
      $result = $mysqli->query("SELECT * FROM equip_problemstest") or die($mysqli->error);

      // pre_r($result);
      // pre_r($result->fetch_assoc());
    ?>
      <!-- Table section -->
      <div class="row justify-content-center">
        <table class="table">
          <thead>
            <tr>
              <th>จำนวนเต็ม</th>
              <th>Float</th>
              <th colspan="2"></th>
            </tr>
          </thead>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?php echo $row['numberint']; ?></td>
                <td><?php echo $row['numberfloat']; ?></td>
                <td>
                    <a href="testcss.php.php?edit=<?php echo $row['id']; ?>" class="btn btn-info">แก้ไข</a>
                    <a href="process31.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">ลบ</a>
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
        <form action="process31.php" method="post">

          <input type="hidden" name="id" value="<?php echo $id; ?>">

          <div class="form-group">
            <label>numberint</label>
            <input type="number" name="numberint" class="form-control" step="any" value="<?php echo $numberintEd; ?>">
          </div>
          <div class="form-group">
            <label>numberfloat</label>
            <input type="number" name="numberfloat" class="form-control" step="any" value="<?php echo $numberfloatEd; ?>">
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
