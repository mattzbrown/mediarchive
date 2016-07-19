<?
$pagetitle="User Map";
include("/home/mediarch/head.php");
echo $harsss;
echo "<table border=1 cellspacing=0 width=100%>

<tr><td COLSPAN=4 align=center><font SIZE=6>User Map</font></td></tr>";
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
echo "<tr><td>You are not authorized to view this page.</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$usrname=$myrow["username"];
if ($myrow["level"]<50)
{
echo "<tr><td>You are not authorized to view this page.</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
echo "<tr><td CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"/boards/gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"/boards/genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo " | <a href=\"/boards/whois.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo"\" CLASS=MENU>Whois Page</a>";
echo " | <a HREF=\"index.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Control Panel</a>";
echo "</i></font></td></tr>";
$sql="SELECT * FROM users WHERE userid=$user";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
if (!$user) {
echo "


<tr><td><br>
<table border=1 cellspacing=0 width=80% align=center>
<form action=\"usermap.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td><b>Enter a User ID to look up:</td><td><input type=\"text\" name=\"user\" value=\"\" size=\"20\" maxlength=\"20\">
<input type=\"submit\" name=\"post\" value=\"Search\">
</td></tr></form></table>

<br>
</tr></td>





</table>";
include("/home/mediarch/foot.php");
exit;
}
if (!$myrow) {
echo "<tr><td align=center><b>There was an error viewing this usermap:</b> This user does not exist.</td></tr>
<tr><td><br>
<table border=1 cellspacing=0 width=80% align=center>
<form action=\"usermap.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td><b>Enter a User ID to look up:</td><td><input type=\"text\" name=\"user\" value=\"\" size=\"20\" maxlength=\"20\">
<input type=\"submit\" name=\"post\" value=\"Search\">
</td></tr></form></table>

<br>
</tr></td>
</table>";
include("/home/mediarch/foot.php");
exit;
}
echo "<tr><td><br>
<table border=1 cellspacing=0 width=25% align=center>
<tr><td class=LITE align=center><font size=3><i><a href=\"/boards/whois.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>".$myrow["username"]."</a></i></font></td></tr>";
$sql="SELECT * FROM usermap WHERE userid1=$user";
$result=mysql_query($sql);
while ($myrow=mysql_fetch_array($result)) {
$userid2=$myrow["userid2"];
$sql="SELECT * FROM users WHERE userid='$userid2'";
$resultx=mysql_query($sql);
$myrowx=@mysql_fetch_array($resultx);
$userd=$myrowx["userid"];
echo "<tr><td CLASS=CELL1 align=center><a href=\"usermap.php?user=$userd";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">".$myrowx["username"]."</a></td></tr>";
}
echo "</table>

<br>
</tr></td></table>";
include("/home/mediarch/foot.php");
?>