<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>CRUD</title>
    <script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </head>
  <body>
    <?php require_once 'process2.php'; ?>

      <!-- Session message section -->
      <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?=$_SESSION['msg_type']?>">
          <?php
            echo $_SESSION['message'];
            unset($_SESSION['message']);
           ?>
        </div>
        <!-- Session message section end -->

      <?php endif ?>

    <div class="container">

    <!-- debug part -->
    <?php
      $mysqli = new mysqli('localhost', 'root', '123456', 'login') or die(mysqli_error($mysqli));
      $result = $mysqli->query("SELECT * FROM noti_equip") or die($mysqli->error);

      // pre_r($result);
      // pre_r($result->fetch_assoc());
    ?>
      <!-- Table section -->
      <div class="row justify-content-center">
        <table class="table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Location</th>
              <th colspan="2">Action</th>
            </tr>
          </thead>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['location']; ?></td>
                <td>
                  <a href="notifyequip2.php?edit=<?php echo $row['id']; ?>" class="btn btn-info">Edit</a>
                  <a href="process2.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
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

    <!-- Add data -->
    <div class="row justify-content-center">
      <form action="process2.php" method="post">

        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <div class="form-group">
          <label>Name</label>
          <input type="text" name="name" value="<?php echo $name; ?>"placeholder="Enter your name">
        </div>
        <div class="form-group">
          <label>Location</label>
          <input type="text" name="location" value="<?php echo $location; ?>" placeholder="Enter your name">
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
    <!-- Add data End -->
    </div>
  </body>
</html>
