<?php
	session_start();
	include_once("database.php");
	extract($_SESSION);
	extract($_POST);
	if(isset($_POST['ques_id'])){
		$_SESSION['ques_id']=$_POST['ques_id'];
	}
	?>

	<?php
	if (isset($_POST['ENDTEST']))
	{
		$correct=0;
		$attempted=0;
		$count = mysqli_query($cn,"select count(*) from question where test_id=$_SESSION[test_id]");
        $count = mysqli_fetch_row($count);
        $count = $count[0];
		$res_row=mysqli_query($cn,"select * from UserAnswer where user_id='$_SESSION[user_id]' AND test_id=$_SESSION[test_id]");
		while($res_row1=mysqli_fetch_row($res_row))
		{
			$attempted=$attempted+1;
			$_SESSION['ques_id']=$res_row1[2];
			$ans_row1=mysqli_query($cn,"select * from Question where  test_id=$_SESSION[test_id] AND ques_id=$_SESSION[ques_id]");
			if($ans_row2=mysqli_fetch_row($ans_row1))
			{
					if($ans_row2[3]==$res_row1[3])
					$correct=$correct+1;
			}
		}
		$mark_sch=mysqli_query($cn,"select * from Test where test_id=$_SESSION[test_id]");
		$marks_scheme=mysqli_fetch_row($mark_sch);
		$positive=$marks_scheme[4];
		$negative=$marks_scheme[5];
		$marks=$correct*$positive-($attempted-$correct)*$negative;
		$date=date("Y-m-d");
		mysqli_query($cn,"insert into Result values('$_SESSION[user_id]',$_SESSION[test_id],'$date',$count,$attempted,$correct,$marks)");
		echo "<script>document.location.href = 'testlogin.php';</script>";
	}
	if (isset($_POST['submit'])) {
		if(isset($_POST['ans']))
		{
			$res=mysqli_query($cn,"select * from UserAnswer where user_id='$_SESSION[user_id]' AND test_id=$_SESSION[test_id] AND ques_id=$_SESSION[ques_id]");
			if(mysqli_num_rows($res)>0){
			$res=mysqli_query($cn,"update UserAnswer set user_ans=$_POST[ans] where user_id='$_SESSION[user_id]' AND test_id=$_SESSION[test_id] AND ques_id=$_SESSION[ques_id]");  
		   }
			else
			$res=mysqli_query($cn,"insert into UserAnswer values ('$_SESSION[user_id]',$_SESSION[test_id],$_SESSION[ques_id],$_POST[ans])");
		}
	}
	if (isset($_POST['reset'])) {
		if(isset($_POST['ans']))
		{
			$res=mysqli_query($cn,"delete from UserAnswer where user_id='$_SESSION[user_id]' AND test_id=$_SESSION[test_id] AND ques_id=$_SESSION[ques_id]");
		}
	}
		
?>




<html>

<head>
	<title>Quiz</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="./css/newstyle.css" rel="stylesheet" />
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>

	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">MNNIT Quiz Portal</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
		<span class="navbar-brand ml-auto" href="testlogin.php" id='divCounter'></span>
    </nav>
	<!-- <div class="text-center">
		<div id='divCounter'><h4>Time Remaining  Loading...</h4></div>
	</div> -->
	<div class="container  custom-main-content">
		
		<form method="post" action="question_detail.php">
			<?php	
				include('displayHelper.php');
				showQuestion($cn,$_SESSION['test_id'],$_SESSION['ques_id']);
				showImages($cn,$_SESSION['test_id'],$_SESSION['ques_id']);
				showTables($cn,$_SESSION['test_id'],$_SESSION['ques_id']);
				showOptions($cn,$_SESSION['user_id'],$_SESSION['test_id'],$_SESSION['ques_id']);
			?>
		<div class="row "> 
			<div class="col-sm">
				<input type="submit" name="submit" value="Submit" class="btn btn-success  btn-block"/>
			</div>
			<div class="col-sm">
				<input type="submit" name="reset" value="Reset" class="btn btn-primary btn-block"/>
			</div>
		</div>
		</form>
		
			<div class="row">
	<?php
		if($_SESSION['ques_id']!=1){
		?>
			<div class="col-sm">
				<form method="post" action="question_detail.php">
					<input type=number name=ques_id value=<?php echo max((int)$_SESSION["ques_id"]-1,1) ?> hidden />
					<input type=submit name=prev value="Previous Question" class="btn btn-secondary btn-block" />
				</form>	
			</div>
		<?php
		}
		$ques_count=mysqli_query($cn,"select * from Question where test_id=$_SESSION[test_id]");
		$count=mysqli_num_rows($ques_count);
		if($_SESSION['ques_id']!=$count){ ?>
			
			<div class="col-sm">
				<form method="post" action="question_detail.php">
					<input type=number name=ques_id value=<?php echo min((int)$_SESSION["ques_id"]+1,$count)?> hidden />
					<input type=submit name=next value="Next Question" class="btn btn-secondary btn-block" />
				</form>
			</div>
			
		<?php 
		}
		?>	
			</div>
		
		<form name="form1" method="post" action="question_detail.php">
			<div class="row">
				<div class="col-sm">
					<input type=submit id="endTestButton" name=ENDTEST value="END TEST" class="btn btn-danger btn-block">
				</div>
			</div>	
		</form>
		
  	<div>

	  <?php
			$res=mysqli_query($cn,"select start_timestamp from usertest where user_id='$_SESSION[user_id]' AND test_id=$_SESSION[test_id]");
			$start_timestamp = mysqli_fetch_row($res);
			$start_timestamp = $start_timestamp[0];
			$res=mysqli_query($cn,"select Duration from test where test_id=$_SESSION[test_id]");
			$duration = mysqli_fetch_row($res);
			$duration = $duration[0];

			$secondsPassed = time() - $start_timestamp;
			$allowedSeconds = $duration*60;
			if($secondsPassed > $allowedSeconds){	
		?>
				<script type='text/javascript'>
					alert("Test is over");
                    document.location.href = 'testlogin.php';
                </script>
        <?php
			}
			$secondsLeft = $allowedSeconds - $secondsPassed;

		?>
	<script type="text/javascript">
		let secondsLeft = <?php echo $secondsLeft ?>;
		var counter = function (){
			if(secondsLeft <=0){
				alert("Test is over");
				document.getElementById('endTestButton').click();
				return;
					
			}else{
				secondsLeft = secondsLeft-1;
			}
			let min = (Math.floor(secondsLeft/60)%60);
			let hours = Math.floor(secondsLeft/3600);
			let sec = secondsLeft%60;
			if(min<10) min='0'+min;
			if(sec<10) sec='0'+sec;
			let timeLeft = hours>0 ? `${hours}h : ${min}m : ${sec}s` : `${min}m : ${sec}s`;
			document.getElementById('divCounter').innerHTML = timeLeft;
			setTimeout(counter,1000);
		};
		counter();
	</script>

  <!-- BootStrap Required Scripts -->
  	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>