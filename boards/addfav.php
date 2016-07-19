<?
$pagetitle="Add to Favorites";
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
echo "<table WIDTH=100%>

<tr><td>You are not authorized to view this page.</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM boards WHERE boardid=$board";
$result=mysql_query($sql);
$result=mysql_num_rows($result);
if (!$result) {
echo "<table WIDTH=100%>

<tr><td>An invalid link was used to access this page.</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
if ($board) {
if (!$return) {
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"5; URL=gentopic.php?board=$board&page=$page\">";
} else if ($return) {
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"5; URL=boardlist.php?id=$return\">";
}
}
$sql="SELECT * FROM users WHERE username='$uname'";
$resultg=mysql_query($sql);
$myrowg=mysql_fetch_array($resultg);
$myuseid=$myrowg["userid"];
$sql="SELECT * FROM favorites WHERE boardid=$board AND userid=$myuseid";
$resulty=mysql_query($sql);
$resulty=mysql_num_rows($resulty);
if ($return) {
if ($resulty) {
echo "<table WIDTH=100%>

<tr><td ALIGN=CENTER>This board has already been added to your favorite boards list previously.</td></tr><tr><td ALIGN=CENTER>You will be automatically returned to the previous page in five seconds, or you can <a HREF=\"boardlist.php?id=$return\">click here</a> to return manually.</td></tr>";
} else if (!$resulty) {
$sql="INSERT INTO favorites (boardid,userid) VALUES ('$board','$myuseid')";
$result=mysql_query($sql);
echo "<table WIDTH=100%>

<tr><td ALIGN=CENTER>This board has been successfully added to your favorites list.</td></tr><tr><td ALIGN=CENTER>You will be automatically returned to the previous page in five seconds, or you can <a HREF=\"boardlist.php?id=$return\">click here</a> to return manually.</td></tr>";
}
} else if (!$return) {
if ($resulty) {
echo "<table WIDTH=100%>

<tr><td ALIGN=CENTER>This board has already been added to your favorite boards list previously.</td></tr><tr><td ALIGN=CENTER>You will be automatically returned to the previous page in five seconds, or you can <a HREF=\"gentopic.php?board=$board&page=$page\">click here</a> to return manually.</td></tr>";
} else if (!$resulty) {
$sql="INSERT INTO favorites (boardid,userid) VALUES ('$board','$myuseid')";
$result=mysql_query($sql);
echo "<table WIDTH=100%>

<tr><td ALIGN=CENTER>This board has been successfully added to your favorites list.</td></tr><tr><td ALIGN=CENTER>You will be automatically returned to the previous page in five seconds, or you can <a HREF=\"gentopic.php?board=$board&page=$page\">click here</a> to return manually.</td></tr>";
}
}
echo "</table>";
include("/home/mediarch/foot.php");
?>

