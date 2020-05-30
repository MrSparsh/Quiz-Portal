<?php
session_start();

require("../database.php");

?>


<form name="form1" method="post" action="upload.php" enctype="multipart/form-data">
   
</form>

<!DOCTYPE html>
<head>
    <title>Add Quiz</title>
    <link href="css/newstyle.css" rel="stylesheet" type="text/css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body background="../img.jpg">
    <?php
        include('navbar.php');
        createNavbar('add_quiz');
    ?>
    <div class="container custom-main-content">
        <h1 class="display-4 text-center">Add Quiz</h1>
        <form name="form1" action="upload.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
            <label for="duration">Test Duration in Minutes</label>
                <input type="number" class="form-control" id="duration" name="duration" required/>
            </div>
            <div class="form-group">
                <label for="test_password">Test Password</label>
                <input type="text" class="form-control" id="test_password" name="test_password" required/>
            </div>
            <div class="form-group">
                <label for="positive">Positive Marks</label>
                <input type="number" class="form-control" id="positive" name="positive" required/>
            </div>
            <div class="form-group">
                <label for="negative">Negative Marks</label>
                <input type="number" class="form-control" id="negative" name="negative" required/>
            </div>
            <div class="form-group">
                <label for="ques_file">Question File</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="ques_file" name="ques_file" required>
                    <label class="custom-file-label" for="ques_file" id="ques_file_label">Choose file</label>
                </div>
            </div>
            <div class="form-group">
                <label for="ans_file">Answer File</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="ans_file" name="ans_file">
                    <label class="custom-file-label" for="ans_file" id="ans_file_label" >Choose file</label>
                </div>
            </div>
            <div class="text-center form-group">
                <input type="submit" id="submit" class="btn btn-primary" name="submit" value="Add Quiz"/>
            <div>
        </form>
    </div>

    <script>
    document.getElementById('ques_file').addEventListener("change", onQuesFileSelected, false);
    document.getElementById('ans_file').addEventListener("change", onAnsFileSelected, false);
    function onQuesFileSelected(e) {
        document.getElementById('ques_file_label').innerHTML= "File Selected";
    }
    function onAnsFileSelected(e) {
        document.getElementById('ans_file_label').innerHTML= "File Selected";
    }
    </script>

    <!-- BootStrap Required Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>