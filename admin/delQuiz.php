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
	echo "<a href=admin/index.php class= \"style9\"><h3 align=center>Click Here for Login</h3></a>";
	exit();
}
echo "<BR><h3 class=head1>Delete Quiz </h3>";

echo "<table width=100%>";
echo "<tr><td align=center></table>";
if($submit=='submit' || strlen($test_id)>0 )
{
    $rs=mysqli_query($cn,"select * from Test where test_id=$test_id");
    if(mysqli_num_rows($rs)==0)
    {
        echo "<br><br><br><div class=head1>No Test is present with this Test ID.</div>";
    }else{
    mysqli_query($cn,"Delete from Result where test_id=$test_id");
    mysqli_query($cn,"Delete from Images where test_id=$test_id");
    mysqli_query($cn,"Delete from Options where test_id=$test_id");
    mysqli_query($cn,"Delete from UserAnswer where test_id=$test_id");
    mysqli_query($cn,"Delete from Test where test_id=$test_id");
    mysqli_query($cn,"Delete from Question where test_id=$test_id");
    mysqli_query($cn,"Delete from Question_Tables where test_id=$test_id");
    echo "<br><br><br><div class=tans2>Test Deleted Successfully.</div>";
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
<title>Delete Quiz</title>
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
                <td><input type="submit" name="submit" value="Delete" class="button1"></td>
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