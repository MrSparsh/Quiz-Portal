<!-- Nav Bar -->
<?php
function createNavbar($currId){
?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">MNNIT Quiz Portal</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item" id="home">
                <a class="nav-link" href="login.php">Home</a>
            </li>
            <li class="nav-item" id="add_quiz">
                <a class="nav-link" href="testadd.php">Add Quiz</a>
            </li>
            <li class="nav-item" id="eval_quiz">
                <a class="nav-link" href="evalQuiz.php">Evaluate Quiz</a>
            </li>
            <li class="nav-item" id="del_quiz">
                <a class="nav-link" href="delQuiz.php">Delete Quiz</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="signout.php">Signout</a>
            </li>
            </ul>
        </div>
    </nav>
    <script>
        let currId = <?php echo "$currId" ?>;
        let ele = document.getElementById(currId.id);
        ele.className += ' active';
    </script>
<?php
}
?>