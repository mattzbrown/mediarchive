<?
$pagetitle="Registration";
include("/home/mediarch/head.php");
echo $harsss;
?>
<table border=0 width=100%>
<tr><td align=center><FONT SIZE=6><B>Contributor Registration</b></font></td></tr>
<?
if ($key) {
$sql="SELECT * FROM users WHERE regcontrib='$key'";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
if ($numrows>=1) {
$myrow=@mysql_fetch_array($result);
$sql="UPDATE users SET contribid='".$myrow["tempcontrib"]."' WHERE regcontrib='$key'";
$result=mysql_query($sql);
$sql="UPDATE users SET regcontrib='' WHERE regcontrib='$key'";
$result=mysql_query($sql);
echo "<TR><TD CLASS=DARK>Contributor Name Registered</TD></TR>
<TR><TD>Thank you for completing contributor registration.
Your message board account has been registered with your contributor name, and your board profile should
already contain a link to your contributor page.</TD></TR>";
} else {
echo "<tr><td CLASS=DARK>Activation Key Error</td></tr>
<tr><td>The activation key entered is invalid.";
}
} else {
echo "<tr><td CLASS=DARK>Activation Key Error</td></tr>
<tr><td>You must provide an activation key to use this page.";
}
?>
</table>
<?
include("/home/mediarch/foot.php");
?>