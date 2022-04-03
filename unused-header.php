<?php
session_start
?>

<header>
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
  				<li class="nav-item">
  					<a class="nav-link" href="https://www.google.co.th/">แผนงานขอดับไฟ P6</a>
  				</li>
  				<li class="nav-item">
  					<a class="nav-link" href="#upload">ลงข้อมูล</a>
  				</li>
  				<li class="nav-item">
  					<a class="nav-link" href='#download'>ดาวน์โหลด</a>
  				</li>
  				<li class="nav-item">
  					<a class="nav-link" href="login.html">เข้าสู่ระบบ</a>
  				</li>
  			</ul>
  	</div>
  </nav>
  <div class="header-login">
    <?php if (isset($_SESSION['userId'])) {
      echo '<form action="includes/logout.inc.php" method="post">
        <button type="submit" name="logout-submit">Logout</button>
      </form>';
    }
    else {
      echo '<form action="includes/login.inc.php" method="post">
        <input type="text" name="mailuid" placeholder="E-mail/Username">
        <input type="password" name="pwd" placeholder="Password">
        <button type="submit" name="login-submit">Login</button>
      </form>
      <a href="signup.php" class="keader-signup">Signup</a>';
    }
    ?>
  </div>

</header>
