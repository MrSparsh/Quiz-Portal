<?php
session_start()
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ADMIN LOGIN</title>

    <!-- Bootstrap core CSS -->
    <link href="css/boot.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sign.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" name="form1" method="post" action="login.php">
      <h1 class="h3 mb-3 font-weight-normal">ADMIN LOGIN</h1>
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="text" id="inputEmail" name="loginid" id="loginid" class="form-control" placeholder="Username" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" name="pass" id="pass" class="form-control" placeholder="Password" required>
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" id="submit">Login</button>
      <p class="mt-5 mb-3 text-muted">Designed By: CS-B (Group 21) </p>
    </form>
  </body>
</html>
