<<?php
  require "header.php";
 ?>

    <main>
      <div class="wrapper-main">
        <section class="section-default">
          <?php
            if (isset($_SESSION['userId'])) {
              echo '<p class="login-status">You are logged in!</p>';
            }
            else {
              echo '<p class="login-status">You are logged out!</p>';
            }
           ?>
          <p>You are logged out!</p>
          <p>You are logged in!</p>
        </section>
      </div>
    </main>

<?php
  require "footer.php";
?>
