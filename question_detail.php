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
		var counter = function (refreshId){
		if(secondsLeft <=0){
				alert("Test is over");
				document.getElementById('endTestButton').click();
				clearInterval(refreshId);
				
		}else{
			secondsLeft = secondsLeft-1;
		}
		let min = Math.floor(secondsLeft/60);
		let sec = secondsLeft%60;
		document.getElementById('divCounter').innerHTML = ""+min+" : "+sec;
		};
		
		let refreshId = setInterval(() => counter(refreshId),1000);
	</script>
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
	<div id='divCounter'></div>
	<div class="container  custom-main-content">
		<br/>
		<form method="post" action="question_detail.php">
			<?php	
				include('displayHelper.php');
				showQuestion($cn,$_SESSION['test_id'],$_SESSION['ques_id']);
				showImages($cn,$_SESSION['test_id'],$_SESSION['ques_id']);
				showTables($cn,$_SESSION['test_id'],$_SESSION['ques_id']);
				showOptions($cn,$_SESSION['user_id'],$_SESSION['test_id'],$_SESSION['ques_id']);
			?>
			<input type="submit" name="submit" value="Submit" />
			<input type="submit" name="reset" value="Reset" />
		</form>
		<form method="post" action="question_detail.php">
	<?php
		$ques_count=mysqli_query($cn,"select * from Question where test_id=$_SESSION[test_id]");
		$count=mysqli_num_rows($ques_count);
		if($_SESSION['ques_id']!=$count){
		?>
			<input type=number name=ques_id value=<?php echo min((int)$_SESSION["ques_id"]+1,$count)?> hidden>
			<input type=submit name=next value="Next Question" ">
		<?php
		}
		if($_SESSION['ques_id']!=1){
		?>
			<input type=number name=ques_id value=<?php echo max((int)$_SESSION["ques_id"]-1,1) ?> hidden>
			<input type=submit name=prev value="Previous Question">
		<?php
		}
		?>	
		</form>
		<form name="form1" method="post" action="question_detail.php">
			<input type=submit id="endTestButton" name=ENDTEST value="END TEST">
		</form>
  	<div>

  <!-- BootStrap Required Scripts -->
  	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>