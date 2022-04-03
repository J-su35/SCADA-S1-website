<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/login2.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
  </head>
  <body>

    <form class="login-form" action="logincheck2.php" method="POST">
      <h1>Login</h1>

      <?php
       if (isset($_GET['error'])) {
         if ($_GET['error'] == "empty") {
           echo '<p style="color:red;text-align:center;padding-top: 30px;">กรุณากรอกข้อมูลให้ครบทุกช่อง!</p>';
         }
         elseif ($_GET['error']== "userinvalid") {
           echo '<p style="color:red;text-align:center;padding-top: 30px;">Login Error!</p>';
         }
         elseif ($_GET['error']== "wrongpassword") {
           echo '<p>รหัสผ่านไม่ถูกต้อง!</p>';
         }
       }
     ?>

      <div class="txtb">
        <input type="text" name="username" placeholder="Username">
        <span data-placeholder="Username"></span>
      </div>

      <div class="txtb">
        <input type="password" name="password" placeholder="Password">
        <span data-placeholder="Password"></span>
      </div>

      <input type="submit" name="submit" class="logbtn" value="LOGIN">

      <div class="bottom-text">
        <a href="signup.php">ลงทะเบียนใช้งาน</a>
      </div>

    </form>

    <script type="text/javascript">
      $(".txtb input").on("focus",function(){
        $(this).addClass("focus");
      });

      $(".txtb input").on("blur",function(){
        if($(this).val() == "")
        $(this).removeClass("focus");
      });
    </script>

  </body>
</html>
