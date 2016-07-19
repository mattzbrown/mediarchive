<?
$pagetitle="Log Out";
include("/home/mediarch/head.php");
@setcookie("luname", "", 0, "/", $HTTP_HOST, 0);
@setcookie("lpword", "", 0, "/", $HTTP_HOST, 0);
echo $harsss;
?>
<table border=0 width=100%>
<tr><td Colspan=2 align=center><font SIZE=6><b>User Log Out</b></font></td></tr>


<tr><td COLSPAN=2>
You have been successfully logged out. Note that if you elected to save your login information on your computer, you will be automatically logged in on the next message board page you enter.<p>

From here, you can:
<ul><li>Return to the <a HREF="/">Home Page</a>.</li>
    <li>Go to the <a HREF="login.php">Log In Page</a> and sign on as the same or a different user.</li>
    <li><a HREF="remove.php">Remove</a> the Auto-Login cookie from your computer.</li></ul>

</td></tr>

</table>

<?
include("/home/mediarch/foot.php");
?>
























