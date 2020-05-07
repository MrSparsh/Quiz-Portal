<?php
session_start();
error_reporting(1);
if (!isset($_SESSION['alogin']))
{
	echo "<br><h2>You are not Logged On Please Login to Access this Page</h2>";
	echo "<a href=index.php><h3 align=center>Click Here for Login</h3></a>";
	exit();
}
?>
<link href="../quiz.css" rel="stylesheet" type="text/css">
<?php
require("../database.php");

include("header.php");


echo "<br><h2><div  class=head1>Add Quiz</div></h2>";
?>
<SCRIPT LANGUAGE="JavaScript">
function check() {
    mt = document.form1.testname.value;
    if (mt.length < 1) {
        alert("Please Enter Test Name");
        document.form1.testname.focus();
        return false;
    }
    tt = document.form1.totque.value;
    if (tt.length < 1) {
        alert("Please Enter Total Question");
        document.form1.totque.value;
        return false;
    }
    return true;
}
</script>

<table width="100%">
    <tr>
        <td aling=right>
            <?php
	if(isset($_SESSION['alogin']))
	{
	 echo "<div align=\"right\" class=\"style9\" ><a href=\"login.php\" >Home </a>|<a href=\"signout.php\" > Signout...</a></div>";
	 }
	 else
	 {
	 	echo "&nbsp;";
	 }
	?>
        </td>
    </tr>
</table>
<form name="form1" method="post" action="upload.php" enctype="multipart/form-data">
    <table width="58%" border="0" align="center">
        <tr>
            <td height="26">
                <div align="left" class="style9"><strong>Enter Test Duration(Minutes)</strong></div>
            </td>
            <td>&nbsp;</td>
            <td><input name="duration" type="number" id="duration" class=input required></td>
        </tr>
        <tr>
            <td height="26">
                <div align="left" class="style9"><strong>Test Password </strong></div>
            </td>
            <td>&nbsp;</td>
            <td><input name="test_password" type="text" id="test_password" class=input required></td>
        </tr>

        <tr>
            <td height="26">
                <div align="left" class="style9"><strong>Positive Marks </strong></div>
            </td>
            <td>&nbsp;</td>
            <td><input name="positive" type="number" id="positive"  class=input required></td>
        </tr>
        <tr>
            <td height="26">
                <div align="left" class="style9"><strong>Negative Marks </strong></div>
            </td>
            <td>&nbsp;</td>
            <td><input name="negative" type="number" id="negative"  class=input required></td>
        </tr>
        <tr>
            <td height="26">
                <div align="left" class="style9"><strong>Question File</strong></div>
            </td>
            <td>&nbsp;</td>
            <td><label id=100>Enter docx file<input type="file" name="ques_file"  required></label></td>
        </tr>
        <tr>
            <td height="26">
                <div align="left" class="style9"><strong>Answer File </strong></div>
            </td>
            <td>&nbsp;</td>
            <td><label id=100 >Enter xlsx file<input type="file" name="ans_file"  required></label></td>
        </tr>
        <tr>
            <td height="26"></td>
            <td>&nbsp;</td>
            <td><button name="submit" type="submit" class=button1 >Add Test</button>
            <td>
        </tr>
    </table>
</form>
<p>&nbsp;
</p>


<!DOCTYPE html>
<head>
    <title>Add Quiz</title>
</head>
<body background="../img.jpg">
    
</body>
</html>