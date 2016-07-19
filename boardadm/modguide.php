<?
$pagetitle="Moderator Guide";
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
echo "<table border=0 width=100%>

<tr><td>You must be <a HREF=\"/boards/login.php\">logged in</a> to view this page.</td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$userlevel=$myrow["level"];
$myuseid=$myrow["userid"];
if ($myrow["level"]<50) {
echo "<table border=0 width=100%>

<tr><td>You are not authorized to view this page.</td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}
echo "<table border=0 width=100%>
<tr>
<td align=center><font SIZE=6><b>Moderator Guide</b></font></td></tr>
</table><font size=2>
<ol>";
$sql="SELECT * FROM tos ORDER BY tosid ASC";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
echo "<li><b>".$myrow["ruletitle"]."</b></li><br>

".$myrow["ruleguide"]."

";
}
echo "</ol></font>";
include("/home/mediarch/foot.php");
?>