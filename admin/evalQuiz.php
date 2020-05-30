<?php
session_start();
require("../database.php");
?>

<!DOCTYPE html>
<head>
    <title>Evaluate Quiz</title>
    <link href="css/newstyle.css" rel="stylesheet" type="text/css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body background="../img.jpg">
    <?php
        include('navbar.php');
        createNavbar('eval_quiz');
    ?>
    <div class="container custom-main-content">
        <h1 class="display-4 text-center">Evaluate Quiz</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="test_id">Quiz ID</label>
                <input type="text" class="form-control" id="test_id" name="test_id"/>
            </div>
            <div class="text-center form-group">
                <input type="submit" id="submit" class="btn btn-primary" name="submit" value="Evaluate"/>
            <div>
        </form>
    </div>
    <?php
            extract($_POST);
            if(isset($submit) && strlen($test_id)>0 ){
                $rs=mysqli_query($cn,"select * from Result where test_id=$test_id");
                if (mysqli_num_rows($rs)<1){
                    echo "<br><h3>No student has given this test yet</h3>";
                    }else{
        ?>
                    <br />
                    <div class="container">
                    <table class="table table-striped">
                        <thead?>
                            <th>User ID</th>
                            <th>Test ID</th>
                            <th>Test Date</th>
                            <th>Total Questions</th> 
                            <th>Attempted</th> 
                            <th>Correct</th> 
                            <th>Incorrect</th> 
                            <th>Score</th>
                        </thead>
        <?php
                    while($row=mysqli_fetch_row($rs)){
                        $incorrect=$row[4]-$row[5];
        ?>
                        <tr>
                            <td><?php echo $row[0] ?></td>
                            <td><?php echo $row[1] ?></td>
                            <td><?php echo $row[2] ?></td>
                            <td><?php echo $row[3] ?></td>
                            <td><?php echo $row[4] ?></td>
                            <td><?php echo $row[5] ?></td>
                            <td><?php echo $incorrect ?></td> 
                            <td><?php echo $row[6] ?></td>
                        </tr>
        <?php  
                    }
        ?>
                    </table>
                    </div>
        <?php
                }
            }
        ?>
    <!-- BootStrap Required Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>