<?php
  $page = "สร้างบัญชีใช้งาน";
  include_once 'header.php';
  // include_once 'header-Captcha.php'; //for epizy
?>

<style>

#form {
  background-color: #DDA0DD;
  min-height: 700px;
  padding: 40px;
}

.btn-primary {
  padding: 10px;
}

</style>


<section class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-3" id="form">
      <h2 class="text-center">สร้างบัญชีใช้งาน</h2>

     <?php
      if (isset($_GET['error'])) {
        if ($_GET['error'] && $_GET['error']== "emptyfields") {
          echo '<p class="alert alert-danger">กรุณากรอกข้อมูลให้ครบทุกช่อง!</p>';
        }
        elseif ($_GET['error'] && $_GET['error']== "invalidfirstlastname") {
          echo '<p class="alert alert-danger">ชื่อ และนามสกุลต้องเป็นภาษาไทย</p>';
        }
        elseif ($_GET['error'] && $_GET['error']== "invalidmail") {
          echo '<p class="alert alert-danger">email ไม่ถูกต้อง!</p>';
        }
        elseif ($_GET['error'] == "passwordcheck") {
          echo '<p class="alert alert-danger">รหัสผ่านไม่ตรงกัน!</p>';
        }
        elseif ($_GET['error'] == "usertaken") {
          echo '<p class="alert alert-danger">Username นี้ถูกใช้แล้ว</p>';
        }
      } if (isset($_GET['signup']) && $_GET['signup'] == "success") {
        echo '<p class="alert alert-success">สร้างบัญชีใช้งานสำเร็จ!</p>';

        header("Refresh: 3; index.php");
        exit();
      }
    ?>

     <form class="form-group" action="includes/signup.inc.php" method="post">
       <div class="form-group">
         <label>ชื่อ :</label>
         <input type="text" name="first" class="form-control" placeholder="ชื่อ">
       </div>

       <div class="form-group">
         <label>นามสกุล :</label>
         <input type="text" name="last" class="form-control" placeholder="นามสกุล">
       </div>

       <div class="form-group">
         <label>Email :</label>
         <input type="text" name="email" class="form-control" placeholder="PEA mail">
       </div>

       <div class="form-group">
         <label>รหัสประจำตัว :</label>
         <input type="text" name="uid" class="form-control" placeholder="รหัสประจำตัว">
       </div>

       <div class="form-group">
         <label>สังกัดหน่วยงาน :</label>
         <input type="text" name="affi" class="form-control" placeholder="สังกัดหน่วยงาน">
       </div>

       <div class="form-group">
         <label>รหัสผ่าน :</label>
         <input type="password" name="pwd" class="form-control" placeholder="รหัสผ่าน">
       </div>

       <div class="form-group">
         <label>ยืนยันรหัสผ่าน :</label>
         <input type="password" name="pwd-repeat" class="form-control" placeholder="รหัสผ่าน">
       </div>

       <div class="form-group">
         <div class="g-recaptcha" data-sitekey="6LemYs4ZAAAAAMoUG-Z0VlCVyNftAc_k2yDqWyMF">
         </div>
         <span id="captcha_error" class="text-danger"></span>
       </div>

       <div class="form-group">
         <input type="submit" name="submit" id="register" value="สร้างบัญชีใช้งาน" class="btn btn-primary" />
       </div>

     </form>
   </div>
  </div>
</section>

<script>
$(document).ready(function(){
  $('#captcha_form').on('submit', function(event){
    event.preventDefault();
    $.ajax({
      url:"includes/signup.inc.php",
      method:"POST",
      data:$(this).serialize(),
      dataType:"json",
      beforeSend:function()
      {
        $('#register').attr('disabled','disabled');
      },
      success:function(data)
      {
        $('#register').attr('disabled',false);
        if(data.success)
        {
          $('#captcha_form')[0].reset();
          $('#captcha_error').text('');
          grecaptcha.reset();
          alert('Form successfully validated');
        }
        else {
          $('#captcha_error').text(data.captcha_error);
        }
      }
    })
  });
});
</script>

 <?php
  include_once 'footer.php';
  ?>
