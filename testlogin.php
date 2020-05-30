<?php
    session_start();
    include_once("database.php");
    extract($_SESSION);
    extract($_POST);
    if(isset($submit1))
    {
        $test_id = $_POST['test_id'];
        $test_password = $_POST['test_password'];
        $rs=mysqli_query($cn,"select * from Test where test_id=$test_id and test_password='$test_password' ");
        if(mysqli_num_rows($rs)<1)
        {
            ?>
            <script type='text/javascript'>
                alert('Invalid Details');
            </script>
            <?php
        }else{
            $res=mysqli_query($cn,"select * from result where test_id=$test_id and user_id='$_SESSION[user_id]' ");
            if(mysqli_num_rows($res)>0){
            $test_row=mysqli_fetch_row($res);
            $date=date("Y-m-d");
            $val=strcmp($test_row[2],$date);
            if($val==0)
            {
                ?>
                <script type='text/javascript'>
                    let message = "You have already given the test. You can't login again";
                    alert(message);
                </script>
                <?php
            }
            }else{
                $_SESSION['ques_id'] =1;
                $_SESSION['test_id']=$test_id;
                $timestamp = time();
		        $res=mysqli_query($cn,"select test_id from usertest where user_id='$_SESSION[user_id]' and test_id='$_SESSION[test_id]'");
                if(mysqli_num_rows($res)==0){
                    mysqli_query($cn,"insert into usertest values('$_SESSION[user_id]',$_SESSION[test_id],now(),$timestamp)");
                }
                ?>
                <script type='text/javascript'>
                    document.location.href = 'question_detail.php';
                </script>
                <?php
            }
        }
    }
?>
<?php
	
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
<body background="img.jpg">
    
    <?php
    include("navbar.php");
    createNavbar('home');
    ?>

    <!-- Test Form -->
    <div class="container custom-main-content">
        <form action="" method="post">
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
