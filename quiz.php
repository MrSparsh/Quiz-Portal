 <?php
 session_start();
 include_once("database.php");
 extract($_SESSION);

?>

 <html>

 <head>
     <title>Online Quiz</title>
     <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
     <link href="quiz.css" rel="stylesheet" type="text/css">
 </head>

 <body>
 </body>

 </html>

 <?php
	$test_id = $_POST['test_id'];
	$test_password = $_POST['test_password'];
	$rs=mysqli_query($cn,"select * from Test where test_id=$test_id and test_password='$test_password' ");
	if(mysqli_num_rows($rs)<1)
	{
		$found1="N";
		$message = "Invalid Details";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script>document.location.href = 'testlogin.php';</script>";
	}else{


		$res=mysqli_query($cn,"select * from result where test_id=$test_id and user_id='$_SESSION[user_id]' ");
		if(mysqli_num_rows($res)>0){
		$test_row=mysqli_fetch_row($res);
		$date=date("Y-m-d");
		$val=strcmp($test_row[2],$date);
		if($val==0)
		{
			$message = "You have already given the test you can\'t login again";
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script type='text/javascript'>document.location.href = 'testlogin.php';
			</script>";
		}
		}else{
		
			$_SESSION['ques_id'] =1;
			$_SESSION['test_id']=$test_id;
			echo "<script>document.location.href = 'question_detail.php';</script>";
		}
	}
?>