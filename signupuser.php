
<html>
<head>
<title>User Signup</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="quiz.css" rel="stylesheet" type="text/css">
</head>

<body background="img.jpg">
<?php
include("header.php");
include("database.php");
extract($_POST);
$rs=mysqli_query($cn,"select * from User where user_id='$uid' ");
if (mysqli_num_rows($rs)>0)
{
	echo "<br><br><br><div class=head1>User Id Already Exists</div>";
	exit;
}
$query="insert into User values('$uid','$pass','$name')";
$rs=mysqli_query($cn,$query)or die("Could Not Perform the Query");
echo "<br><br><br><div class=head1>Welcome $name your User ID  $uid Created Sucessfully</div>";
echo "<br><div class=head1><a href=index.php>Login</a></div>";


?>
</body>
</html>

