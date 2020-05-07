<?php
session_start();
require("../database.php");

error_reporting(1);
?>
<link href="../quiz.css" rel="stylesheet" type="text/css">
<?php

extract($_POST);

echo "<BR>";
if (!isset($_SESSION['alogin']))
{
	echo "<br><h2><div  class=head1>You are not Logged On Please Login to Access this Page</div></h2>";
	echo "<a href=index.php><h3 align=center>Click Here for Login</h3></a>";
	exit();
}
echo "<BR><h3 class=head1>Evaluate Quiz </h3>";

echo "<table width=100%>";
echo "<tr><td align=center></table>";
if($submit=='submit' || strlen($test_id)>0 )
{
  //echo ;
$rs=mysqli_query($cn,"select * from Result where test_id=$test_id");
if (mysqli_num_rows($rs)<1)
{
	echo "<br><br><br><div class=head1>No test is given till now by Students.</div>";
}else
{
  echo "<table border=1 align=center ><tr class=style9><td width=300 align=center>User ID<td>Test ID <td> Test Date<td> Total Questions <td>Attempted <td> Correct <td> Incorrect <td> Score";
  while($row=mysqli_fetch_row($rs))
  {
      $incorrect=$row[4]-$row[5];
    echo "<tr class=style9><td align=center>$row[0] <td align=center>$row[1] <td align=center> $row[2] <td align=center> $row[3] <td align=center> $row[4]<td align=center> $row[5]<td align=center> $incorrect <td align=center> $row[6] ";
  }
  echo "</table>";
}

$submit="";
}
?>
<table width="100%">
    <tr>
        <td aling=right>
            <?php
	if(isset($_SESSION['alogin']))
	{
	 echo "<div align=\"right\" class=\"style9\" ><strong><a href=\"login.php\">Home </a>|<a href=\"signout.php\"> Signout...</a></strong></div>";
	 }
	 else
	 {
	 	echo "&nbsp;";
	 }
	?>
        </td>
    </tr>
</table>
<div style="margin:auto;width:90%;height:500px;text-align:left">
<title>Evaluate Quiz</title>
    <form name="form1" method="post" onSubmit="return check();">
        <table width="41%" border="0" align="center">
            <tr>
                <td width="45%" height="32">
                    <div align="center" class="style9"><strong>Enter Test ID </strong></div>
                </td>
                <td width="2%" height="5">
                <td width="53%" height="32">
                    <input name="test_id" type="text" id="test_id" class=input required>
            <tr>
                <td height="26"> </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td height="26"></td>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit" value="Evaluate" class="button1"></td>
            </tr>
        </table>
    </form>
    <p>&nbsp; </p>
</div>
<!DOCTYPE html>
<head>
</head>
<body background="../img.jpg">
    
</body>
</html>