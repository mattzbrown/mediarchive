<?
$pagetitle="Disable Auto-Login";
include("/home/mediarch/head.php");
@setcookie("auname", "", 0, "/", $HTTP_HOST, 0);
@setcookie("apword", "", 0, "/", $HTTP_HOST, 0);
echo $harsss;
?>
<table border=0 width=100%>
<tr><td Colspan=2 align=center><font SIZE=6><b>Disable Auto-Login</b></font></td></tr>
<tr><td COLSPAN=2>

The Auto-Login feature has been disabled on this computer.  You will now have to manually Log In to 
the message boards to post messages.<p>

From here, you can:
<ul><li>Return to the <a HREF="/">Home Page</a>.</li>
    <li>Go to the <a HREF="login.php">Log In Page</a> and sign on as the same or a different user.</li></ul>

</td></tr>
</table>
<?
include("/home/mediarch/foot.php");
?>



