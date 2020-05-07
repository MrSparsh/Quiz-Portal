
<html>
<head>
<title>New User Signup </title>
<script language="javascript">
function check()
{
 
  if(document.form1.pass.value!=document.form1.cpass.value)
  {
    alert("Confirm Password does not matched");
	document.form1.cpass.focus();
	return false;
  }
}
  
</script>
<link href="quiz.css" rel="stylesheet" type="text/css">
</head>

<body background="img.jpg">
<?php
include("header.php");
?>
 <table width="100%" border="0">
   <tr>
     <td width="132" rowspan="2" valign="top"><span class="style8"></span></td>
     <td width="468" height="57"></td>
   </tr>
   <tr>
    <h1 align="center"><span class="head1">New User Signup</span></h1>
     <td><form name="form1" method="post" action="signupuser.php" onSubmit="return check();">
       <table width="301" border="0" align="left">
         <tr>
           <td><div align="left" class="style9">User ID </div></td>
           <td><input type="text" name="uid" class=input required></td>
         </tr>
         <tr>
           <td class="style9">Password</td>
           <td><input type="password" name="pass"  class=input required></td>
         </tr>
         <tr>
           <td class="style9">Confirm Password </td>
           <td><input name="cpass" type="password" id="cpass" class=input required></td>
         </tr>
         <tr>
           <td class="style9">Name </td>
           <td><input name="name" type="text" id="name" class=input required></td>
         </tr>
         <tr> 
           <td>&nbsp;</td>
           <td><input type="submit" name="Submit" value="Signup" >
           </td>
         </tr>
       </table>
     </form></td>
   </tr>
 </table>
 <p>&nbsp; </p>
</body>
</html>
