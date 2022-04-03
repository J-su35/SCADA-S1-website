<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login Page</title>
    <link href="style.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <div id="frm">
      <form action="process2.php" method="$_POST">
        <p>
          <label>Username: </label>
          <input type="text" id="user" name="user" />
        </p>
        <p>
          <label>Password: </label>
          <input type="password" id="pass" name="pass" />
        </p>
        <p>
          <input type="submit" id="btn" value="Login" />
        </p>
      </form>
    </div>

  </body>
</html>
