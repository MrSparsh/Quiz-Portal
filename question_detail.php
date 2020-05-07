<?php
	session_start();
	include_once("database.php");
	extract($_SESSION);

	if(isset($_POST))
	{
		extract($_POST);
		$_SESSION['ques_id']=$ques_id;
	}
	$test_id = $_SESSION['test_id'];
	$duration=mysqli_query($cn,"select duration from Test where test_id=$_SESSION[test_id]");
	$duration = mysqli_fetch_row($duration);
	$duration = $duration[0];
	$duration = $duration*60;
	$uniqTimerId = "".$test_id;
	$uniqTimerId.=$_SESSION['user_id'];
	echo "
		<div id='divCounter' align=\"right\" style=\"font-size:50px;color:white\"></div>
		<br/>
		<script>
			if(localStorage.getItem('$uniqTimerId')){
					var value = localStorage.getItem('$uniqTimerId');
			}else{
				var value = $duration;
				localStorage.setItem('$uniqTimerId', $duration);
			}
			var interval = setInterval(function (){counter('$uniqTimerId');}, 1000);
    </script>";
			$ques_rs=mysqli_query($cn,"select * from Question where test_id=$_SESSION[test_id] and ques_id = $_SESSION[ques_id]");
			$ques_count=mysqli_query($cn,"select * from Question where test_id=$_SESSION[test_id]");
			$count=mysqli_num_rows($ques_count);
			$ques_row= mysqli_fetch_row($ques_rs);
			$res=mysqli_query($cn,"select * from UserAnswer where user_id='$_SESSION[user_id]' AND test_id=$_SESSION[test_id] AND ques_id=$_SESSION[ques_id]");
			$x=0;
			if(mysqli_num_rows($res)>0)
			{
				$ans_row=mysqli_fetch_row($res);
				$x=1;
			}

			echo "<p class=style9 style=\"margin-left:26px;\">$ques_row[0].  $ques_row[2]</p>";
			$opt_rs = mysqli_query($cn,"select * from Options where test_id=$_SESSION[test_id]  AND ques_id=$ques_row[0]");
			$img_rs= mysqli_query($cn,"select * from Images where test_id=$_SESSION[test_id]  AND ques_id=$ques_row[0]");
			$tbl_rs= mysqli_query($cn,"select * from Tables where test_id=$_SESSION[test_id]  AND ques_id=$ques_row[0] order by table_num");
			
			echo '<form name="form1" method="post" action="question_detail.php">';
			//Print Images
			while($img_row=mysqli_fetch_row($img_rs))
			{

						$path = $img_row[3];
						echo '<img  height="170" width="200" hspace="20px" src="'.$path.'.jpeg" />';					
			}
			
			//Print Table
			$table_cnt = mysqli_query($cn,"select max(table_num) from Question_tables where test_id=$_SESSION[test_id]  AND ques_id=$ques_row[0]");
			
			$table_cnt = mysqli_fetch_row($table_cnt);
			if($table_cnt){
				$table_cnt = $table_cnt[0];
			}else{
				$table_cnt=-1;
			}
				for($i=0;$i<=$table_cnt ;$i++){
				$row_cnt = mysqli_query($cn,"select max(row_num) from Question_tables where test_id=$_SESSION[test_id]  AND ques_id=$ques_row[0] and table_num=$i");
				$row_cnt = mysqli_fetch_row($row_cnt);
				$row_cnt = $row_cnt[0];
				$col_cnt = mysqli_query($cn,"select max(column_num) from Question_tables where test_id=$_SESSION[test_id]  AND ques_id=$ques_row[0] and table_num=$i");
				$col_cnt = mysqli_fetch_row($col_cnt);
				$col_cnt = $col_cnt[0];
				$table_rs = mysqli_query($cn,"select row_num,column_num,data from Question_tables where test_id=$_SESSION[test_id]  AND ques_id=$ques_row[0] and table_num=$i");
				$table = array();
				for($row_num=0;$row_num<=$row_cnt;$row_num++){
					$row=array();
					for($col_num=0;$col_num<=$col_cnt;$col_num++){
						$row[]='';
					}
					$table[]=$row;
				}
					while($tabledata_row=mysqli_fetch_row($table_rs)){
					$table[$tabledata_row[0]][$tabledata_row[1]] = $tabledata_row[2];			
				}
				$tab='<p style="margin-left:20px;"><table border="4" cellpadding="8">';
					for($i=0;$i<sizeof($table);$i++){
									$tab.='<tr class=style9 >';
									for($j=0;$j<sizeof($table[$i]);$j++){
													$data=$table[$i][$j];
													$tab.='<td>';
													$tab.=$data;
													$tab.='</td>';
									}
									$tab.='</tr>';
						}
					$tab.='</table></p>';
					echo $tab;
					echo '<br>';
			}
			
			//Print Options
			while($option_row=mysqli_fetch_row($opt_rs)){
				
				if($x==1 && $option_row[2]==$ans_row[3])
				{
					echo "	<label class=container> $option_row[3]<input type=radio name='ans' value=$option_row[2] checked style=\"padding-left:4px\"><span  class=checkmark></span>
					</label> ";
				}else
					echo "<label class=container> $option_row[3]<input type=radio name='ans' value=$option_row[2] style=\"padding-left:4px\" ><span class=checkmark></span>
					</label> ";
				echo nl2br("\n");
			}
			echo '<input type=submit name="submit1" value="Submit" >';
			echo '<input type=submit name="reset" value="Reset" >';
			echo '</form>';



			
			if($_SESSION['ques_id']!=$count)
			echo '<form name="form1" method="post" action="question_detail.php">
			<table width="200" border="0" align="center">
			  <tr>
			  <input type=number name=ques_id value='.(min((int)$_SESSION["ques_id"]+1,$count)).' hidden>
			  <input type=submit name=submit value="Next Question" onclick="alert(timer);display.value=timer;">
			  </tr>
			  </table>
			</form>';
			
			if($_SESSION['ques_id']!=1)
			echo '<form name="form1" method="post" action="question_detail.php">
			<table width="200" border="0" align="center">
			  <tr>
			  <input type=number name=ques_id value='.(max((int)$_SESSION["ques_id"]-1,1)).' hidden>
			  <input type=submit name=submit value="Previous Question">
			  </tr>
			</table>
			</form>';
			
			echo '<form name="form1" method="post" action="question_detail.php">
			<table width="200" border="0" align="center">
			  <tr>
			  <input type=submit id="endTestButton" name=ENDTEST value="END TEST">
			  </tr>
			</table>
			</form>';
			
	if (isset($_POST['ENDTEST']))
	{
		$correct=0;
		$attempted=0;
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
	if (isset($_POST['submit1'])) {
		if(isset($_POST['ans']))
		{
			$res=mysqli_query($cn,"select * from UserAnswer where user_id='$_SESSION[user_id]' AND test_id=$_SESSION[test_id] AND ques_id=$_SESSION[ques_id]");
			if(mysqli_num_rows($res)>0){
			$res=mysqli_query($cn,"update UserAnswer set user_ans=$_POST[ans] where user_id='$_SESSION[user_id]' AND test_id=$_SESSION[test_id] AND ques_id=$_SESSION[ques_id]");
		    
		   }
			else
			$res=mysqli_query($cn,"insert into UserAnswer values ('$_SESSION[user_id]',$_SESSION[test_id],$_SESSION[ques_id],$_POST[ans])");
		}
		echo "<script>document.location.href = 'question_detail.php';</script>";
	}
	if (isset($_POST['reset'])) {
		if(isset($_POST['ans']))
		{
			$res=mysqli_query($cn,"delete from UserAnswer where user_id='$_SESSION[user_id]' AND test_id=$_SESSION[test_id] AND ques_id=$_SESSION[ques_id]");
			$x=0;  
		}
		echo "<script>document.location.href = 'question_detail.php';</script>";
	}
		
?>

<html>

<head>
		<title>Ongoing Quiz</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="quiz.css" rel="stylesheet" type="text/css">
</head>

<body background="img.jpg">

		<div id="divCounter"></div>
    <br/>
		<script type="text/javascript">
    var counter = function (str){
      if(value <=0){
				document.getElementById("endTestButton").click();
				localStorage.clear();
      }else{
        value = parseInt(value)-1;
        localStorage.setItem(str, value);
      }
      var min = Math.floor(value/60);
      var sec = value%60;
      document.getElementById('divCounter').innerHTML = ""+min+" : "+sec;
    };
  </script>
</body>

</html>