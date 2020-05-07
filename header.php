<style type="text/css">
body {
    margin-left: 0px;
    margin-top: 0px;
}

</style>
<link href="quiz.css" rel="stylesheet" type="text/css">
<table width="100%">
    <tr>
        <td>
            <?php
 
            @$_SESSION['user_id']; 
  error_reporting(1);
  ?>
        </td>
        <td>
            <?php
        
	if(isset($_SESSION['user_id']))
	{
	 echo "<div align=\"right\" class=style9><a href=\"testlogin.php\"> Home </a>|<a href=\"signout.php\">Signout</a></div>";
	 }
	 else
	 {
	 	echo "&nbsp;";
	 }
	?>
        </td>

    </tr>

</table>