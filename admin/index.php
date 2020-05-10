<?php
    session_start();
    include("database.php");
    extract($_POST);
    if(isset($submit))
    {
        $rs=mysqli_query($cn,"select * from admin where loginid='$loginid' and pass='$pass' ");
        if(mysqli_num_rows($rs)<1)
        {
            ?>
            <script type="text/javascript">
                alert("Invalid Details");
            </script>
            <?php
        }
        else
        {
            $name=mysqli_fetch_row($rs);
            $_SESSION['alogin']="true";
            $_SESSION['loginid']=$loginid;
            ?>
            <script type="text/javascript">
                window.location="login.php";
            </script>
            <?php
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Exam Portal</title>
    <link href="./css/newstyle.css" rel="stylesheet" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>

    <!-- Sign-In Form -->
    <div class="container custom-main-content">
        <h1 class="display-4 text-center">Online Quiz Portal</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="loginid">Faculty ID</label>
                <input type="text" class="form-control" id="loginid" name="loginid"/>
            </div>
            <div class="form-group">
                <label for="pass">Password</label>
                <input type="password" class="form-control" id="pass" name="pass"/>
            </div>
            <div class="text-center form-group">
                <input type="submit" id="submit" class="btn btn-primary" name="submit"/>
            <div>
        </form>
        <div class="text-center">
            <small>New User ? <a href="signup.php">Register Here</a></small>
        </div>
    </div>

    <!-- BootStrap Required Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
