<?php
session_start();
?>

<html>

<head>
    <title>Online Quiz - Result </title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="quiz.css" rel="stylesheet" type="text/css">
</head>

<body background="img.jpg">
    <?php
include("header.php");
include("database.php");
extract($_SESSION);
$rs=mysqli_query($cn,"select * from Result  where user_id=$_SESSION[user_id]") or die(mysqli_error());

echo "<h1 class=head1> Result </h1>";
if(mysqli_num_rows($rs)<1)
{
	echo "<br><br><h1 class=head1> You have not given any quiz</h1>";
	exit;
}
echo "<table border=1 align=center class=style9><tr><td width=300 align=center>Test ID <td> Test Date<td> Total Questions <td>Attempted<td> Correct<td> Score";
while($row=mysqli_fetch_row($rs))
{
echo "<tr class=style9><td align=center>$row[1] <td align=center> $row[2] <td align=center> $row[3] <td align=center> $row[4]<td align=center> $row[5] <td align=center> $row[6]";
}
echo "</table>";
?>
</body>

</html>