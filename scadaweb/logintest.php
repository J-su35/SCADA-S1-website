<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

    <header>
      <nav>
        <div>
          <ul>
            <li><a href="index.php">Home</a></li>
          </ul>
            <div>
              <form action="includes/login2.inc.php" method="POST">
                <input type="text" name="uid" placeholder="Username">
                <input type="password" name="pwd" placeholder="password">
                <button type="submit" name="submit">Login</button>
              </form>
            </div>
          </div>
      </nav>
    </header>

    <?php
      if (isset($_SESSION['u_id'])) {
        echo "Logged in successful";
        echo '<ul><li class="nav-item active">
          <a class="nav-link" href="logout.php">ออกจากระบบ</a>
        </li></ul>';
      }
    ?>

  </body>
</html>
