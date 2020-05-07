<?php
include("header.php");
include("database.php");
extract($_POST);
?>
<html>

<head>
    <title>Online Exam Portal</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="quiz.css" rel="stylesheet" type="text/css">


</head>

<body background="img.jpg" >
    <table width="100%" border="0">
        <tr>
            <td width="70%" height="25">&nbsp;</td>


        </tr>
        <tr>
            <td height="296" valign="top">
                <div style="margin-left:350px;" align="center">
                    <h1 class=head1 >Online Quiz Portal</h1>
                    <form method="post" action="testlogin.php">
                        <table width="200" border="0">
                            <tr>
                                <td><span class="style9">User ID </span></td>
                                <td><input name="user_id" type="text" id="loginid2" class=input></td>
                            </tr>
                            <tr>
                                <td><span class="style9">Password</span></td>
                                <td><input name="pass" type="password" id="pass2" class=input></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span class="errors">
                                        <?php
		                                        if(isset($found))
		                                        {
                                                echo "Invalid Username or Password";
                                            }
                                        ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan=2 align=center class="errors">
                                    <input name="submit" type="submit" id="submit" value="Login"> </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div align="center"><span class="style4">New User ? <a href="signup.php">Register
                                                Here</a></span></div>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </td>
            <td valign="top">
            </td>
        </tr>
    </table>

</body>

</html>