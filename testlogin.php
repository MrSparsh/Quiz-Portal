<?php
session_start();

include("database.php");
extract($_POST);
if(isset($submit))
{
	$rs=mysqli_query($cn,"select * from User where user_id='$user_id' and pass='$pass' ");
  if(mysqli_num_rows($rs)<1)
	{
        $found="N";
        echo "<script>alert('Invalid Details');document.location.href = 'index.php';</script>";
	}
	else
	{
    $name=mysqli_fetch_row($rs);
    $_SESSION['name']=$name[2];
		$_SESSION['user_id']=$user_id;
	}
}
if (isset($_SESSION['user_id']))
{
  include("header.php");
  echo "<h2 align=\"right\" class=style9>Welcome ".$_SESSION['name']."</h2>";
  echo '<form name="form1" method="post" action="quiz.php">
    <table width="200" border="0" align="center">
      <tr>
          <td><span class=style9>Test ID </span></td>
          <td><input name="test_id" type="text" id="test_id" class=input></td>
      </tr>
      <tr>
          <td><span class=style9>Password</span></td>
          <td><input name="test_password" type="password" id="test_password" class=input></td>
      </tr>
      <tr>
          <td colspan=2 align=center class="errors">
              <input name="submit1" type="submit" id="submit1" value="Login1" > </td>
      </tr>
    </table>
  </form>';
 
 echo '<center><a href="result.php" class=head1 > Result</a></center>';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Student Dashboard</title>
<link href="quiz.css" rel="stylesheet" type="text/css">
</head>
<body background="img.jpg">
  
</body>
</html>