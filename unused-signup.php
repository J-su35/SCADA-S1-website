<?php
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
        else if ($_GET['error'] == "invaliduidmail") {
      echo '<p class=""signuperror">Fill in all fields!</p>'
        }
      } ?>
      <form class="form-signup" action="includes/signup.inc.php" method="post">
        <input type="text" name="uid" placeholder="Username">
        <input type="password" name="pwd" placeholder="Repeat password">
        <button type="submit" name="signup-submit">Signup</button>
      </form>
    </section>
  </div>
</main>
