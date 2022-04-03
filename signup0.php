<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Create Account</title>
  </head>
  <body>

<section>
   <div>
     <h2>สร้างบัญชีใช้งาน</h2>
     <?php
      if (isset($_GET['error'])) {
        if ($_GET['error'] == "emptyfields") {
          echo '<p class="signuperror">กรุณากรอกข้อมูลให้ครบทุกช่อง!</p>';
        }
        elseif ($_GET['error'] == "passwordcheck") {
          echo '<p class="signuperror">รหัสผ่านไม่ตรงกัน!</p>';
        }
      } if (isset($_GET['signup']) && $_GET['signup'] == "success") {
        echo '<p class="signupsuccess">สร้างบัญชีใช้งานสำเร็จ!</p>';

        header("Refresh: 3; index.php");
        exit();
      }
    ?>

     <form action="includes/signup0.inc.php" method="post">
       <input type="text" name="username" placeholder="Username">
       <input type="password" name="pwd" placeholder="Password">
       <input type="password" name="pwd-repeat" placeholder="Password">
       <button type="submit" name="submit">สร้างบัญชีใช้งาน</button>
     </form>
   </div>
</section>

  </body>
</html>
