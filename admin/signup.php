<?php
    include("database.php");
    extract($_POST);
    if(isset($Submit)){
        $rs=mysqli_query($cn,"select * from admin where loginid='$loginid' ");
        if (mysqli_num_rows($rs)>0)
        {
            ?>
            <script type='text/javascript'>
                alert("FacultyId Already Exists");
            </script>
            <?php
        }else{
            $query="insert into admin values('$loginid','$pass')";
            $rs=mysqli_query($cn,$query)or die("Could Not Perform the Query");
            ?>
            <script type='text/javascript'>
                alert("FacultyID Created Successfully");
                document.location.href = 'index.php';
            </script>
            <?php
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <script language="javascript">
  function check()
  {
    if(document.form1.pass.value!==document.form1.cpass.value)
    {
      alert("Confirm Password does not matched");
      document.form1.cpass.focus();
      return false;
    }
  }
  </script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup</title>
  <link href="./css/newstyle.css" rel="stylesheet" />
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>

    <!-- Sign-Up Form -->
    <div class="container custom-main-content">
        <h1 class="display-4 text-center">Online Quiz Portal</h1>
        <form name="form1" method="post" action="" onSubmit="return check();">
            <div class="form-group">
                <label for="loginid">Faculty ID</label>
                <input type="text" class="form-control" id="loginid" name="loginid"/>
            </div>
            <div class="form-group">
                <label for="pass">Password</label>
                <input type="password" class="form-control" id="pass" name="pass"/>
            </div>
            <div class="form-group">
                <label for="cpass">Confirm Password</label>
                <input type="password" class="form-control" id="cpass" name="cpass"/>
            </div>
            <div class="text-center form-group">
                <input type="submit" id="submit" class="btn btn-primary" name="Submit" value="Sign Up"/>
            <div>
        </form>
    </div>

    <!-- BootStrap Required Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
