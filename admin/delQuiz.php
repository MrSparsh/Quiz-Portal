<?php
session_start();
require("../database.php");
?>
<!DOCTYPE html>
<head>
    <title>Delete Quiz</title>
    <link href="css/newstyle.css" rel="stylesheet" type="text/css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body background="../img.jpg">
    <?php
        include('navbar.php');
        createNavbar('del_quiz');
    ?>
    <div class="container custom-main-content">
        <h1 class="display-4 text-center">Delete Quiz</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="test_id">Quiz ID</label>
                <input type="text" class="form-control" id="test_id" name="test_id"/>
            </div>
            <div class="text-center form-group">
                <input type="submit" id="submit" class="btn btn-primary" name="submit" value="Delete"/>
            <div>
        </form>
        <?php
            extract($_POST);
            if(isset($submit) && strlen($test_id)>0 )
            {
                $rs=mysqli_query($cn,"select * from Test where test_id=$test_id");
                if(mysqli_num_rows($rs)==0)
                {
                    echo "<br><div>No Test is present with this Test ID.</div>";
                }else{
                mysqli_query($cn,"Delete from Result where test_id=$test_id");
                mysqli_query($cn,"Delete from Images where test_id=$test_id");
                mysqli_query($cn,"Delete from Options where test_id=$test_id");
                mysqli_query($cn,"Delete from UserAnswer where test_id=$test_id");
                mysqli_query($cn,"Delete from Test where test_id=$test_id");
                mysqli_query($cn,"Delete from Question where test_id=$test_id");
                mysqli_query($cn,"Delete from Question_Tables where test_id=$test_id");
                echo "<br><div>Test Deleted Successfully.</div>";
                }
            }
        ?>
    </div>
     <!-- BootStrap Required Scripts -->
     <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>