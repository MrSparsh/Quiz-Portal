<?php
  session_start();

  include("database.php");
  extract($_POST);
  if(isset($submit))
  {
    $rs=mysqli_query($cn,"select * from User where user_id='$user_id' and pass='$pass' ");
    if(mysqli_num_rows($rs)<1)
    {
          $found="N";
          echo "<script>alert('Invalid Details');document.location.href = 'index.php';</script>";
    }
    else
    {
      $name=mysqli_fetch_row($rs);
      $_SESSION['name']=$name[2];
      $_SESSION['user_id']=$user_id;
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="./css/newstyle.css" rel="stylesheet" type="text/css"/>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <!-- Nav Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">MNNIT Quiz Portal</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="testlogin.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="result.php">Results</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="signout.php">Signout</a>
            </li>
            </ul>
        </div>
    </nav>


    <!-- Test Form -->
    <div class="container custom-main-content">
        <form action="quiz.php" method="post">
            <div class="form-group">
                <label for="userid">Test ID</label>
                <input type="text" class="form-control" id="test_id" name="test_id"/>
            </div>
            <div class="form-group">
                <label for="pass">Password</label>
                <input type="password" class="form-control" id="test_password" name="test_password"/>
            </div>
            <div class="text-center form-group">
                <input type="submit" id="submit1" class="btn btn-primary" name="submit1"/>
            <div>
        </form>
    </div>

    <!-- BootStrap Required Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
