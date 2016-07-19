<?
$pagetitle="Delete Review";
include("/home/mediarch/head.php");
echo $harsss;
function auth($userid, $password) {
$sql="SELECT username FROM users WHERE username='$userid' AND userpass='$password'";
$result=mysql_query($sql);
if(!mysql_num_rows($result)) return 0;
else {
$query_data=mysql_fetch_row($result);
return $query_data[0];
}
}
$username=auth($uname,$pword);
if (!$username)
{
echo "<table border=\"0\" width=\"100%\"><tr><td>You are not authorized to view this page.</td></tr></table>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
if ($myrow["level"]<60)
{
echo "<table border=\"0\" width=\"100%\"><tr><td>You are not authorized to view this page.</td></tr></table>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM contributed WHERE reviewid='$id' AND accepted>=1";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
if ($numrows<=0) {
echo "<table border=\"0\" width=\"100%\">\n<tr><td>An invalid link was used to access this page.</td></tr>\n</table>";
include("/home/mediarch/foot.php");
exit;
}
echo "<table border=\"0\" width=\"100%\">\n<tr><td align=\"center\"><font size=\"6\"><b>Delete Review</b></font></td></tr>\n";
mysql_query("DELETE FROM contributed WHERE reviewid='$id'");
echo "<tr><td>This review was successfully deleted.</td></tr>\n</table>";
include("/home/mediarch/foot.php");
?>