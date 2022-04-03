<<?php
  require "header.php";
 ?>

    <main>
      <div class="wrapper-main">
        <section class="section-default">
          <h1>Signup</h1>
          <?php
            if (isset($_GET['error'])) {
              if ($_GET['error'] == "emptyfields") {
                echo '<p class="signuperror">Fill in all fields!</p>';
              }
              else if ($_GET['error'] == "invalidmailuid") {
                echo '<p class="signuperror">Invalid username and email!</p>';
              }
              else if ($_GET['error'] == "invalidmail&uid") {
                echo '<p class="signuperror">Invalid username!</p>';
              }
              else if ($_GET['error'] == "invaliduid&mail") {
                echo '<p class="signuperror">Invalid email!</p>';
              }
              else if ($_GET['error'] == "passwordcheckuid") {
                echo '<p class="signuperror">Your password do not macth!</p>';
              }
              else if ($_GET['error'] == "usertaken&mail") {
                echo '<p class="signuperror">Username is already taken!</p>';
              }
            }
            else if ($_GET["signup"] == "success") {
              echo '<p class="signupsuccess">Signup successful!!</p>';
            }
           ?>
          <form class="form-signup" action="includes/signup.inc.php" method="post">
            <input type="text" name="uid" placeholder="Username">
            <input type="text" name="mail" placeholder="E-mail">
            <input type="password" name="pwd" placeholder="Password">
            <input type="password" name="pwd-repeat" placeholder="Repeat password">
            <button type="submit" name="Signup-submit">Signup</button>
          </form>
        </section>
      </div>
    </main>

<?php
  require "footer.php";
?>
