<?
$pagetitle="System Notifications";
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

<tr><td>You are not authorized to view this page.</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$usrname=$myrow["username"];
$level=$myrow["level"];
if ($myrow["level"]<50)
{
echo "<table border=0 width=100%>

<tr><td>You are not authorized to view this page.</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
echo "<table border=0 width=100%>

<tr><td align=center><font SIZE=6>System Notifications</font></td></tr>
<tr><td CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"/boards/gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"/boards/genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
if ($user) {
echo " | <a href=\"/boards/whois.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Whois Page</a>";
}
echo " | <a HREF=\"index.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Control Panel</a>";
echo "</i></font></td></tr>";
if (!$user) {
echo "

<tr><td><br>
<table border=1 cellspacing=0 width=80% align=center>
<form action=\"usernote.php";
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
echo "
<tr><td align=center><b>There was an error viewing this user's system notifications:</b> This user does not exist.</td></tr>
<tr><td><br>
<table border=1 cellspacing=0 width=80% align=center>
<form action=\"usernote.php";
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
$sql="SELECT * FROM systemnot WHERE sendto=$user ORDER BY sentsec DESC";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
echo "<tr><td CLASS=CELL2><font size=2>";
if ($level>=53) {
$sentfrom=$myrow["sentfrom"];
$sql="SELECT * FROM users WHERE userid=$sentfrom";
$result4=mysql_query($sql);
$myrow4=@mysql_fetch_array($result4);
echo "<b>Sent from:</b> <a href=\"mods.php?user=".$myrow["sentfrom"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">".$myrow4["username"]."</a> | ";
}
echo "<b>Notice Date:</b> ".$myrow["sentat"]."</font></td></tr>

<td CLASS=CELL1><font size=2>".stripslashes($myrow["sysbod"])."</font></td></tr>";
}
echo "</table>";
include("/home/mediarch/foot.php");
?>

