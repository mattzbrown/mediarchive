<?
$pagetitle="Send System Notification";
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

<tr><td align=center colspan=2><font SIZE=6>Send System Notification</font></td></tr>
<tr><td CLASS=LITE ALIGN=center colspan=2><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"/boards/gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"/boards/genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
if ($user) {
echo " | <a href=\"/boards/whois.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo"\" CLASS=MENU>Whois Page</a>";
}
echo " | <a HREF=\"index.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Control Panel</a>";
echo "</i></font></td></tr>";
if (!$user) {
echo "

<tr><td colspan=2><br>
<table border=1 cellspacing=0 width=80% align=center>
<form action=\"send.php";
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
<tr><td align=cente colspan=2><b>There was an error sending a notification:</b> This user does not exist.</td></tr>
<tr><td colspan=2><br>
<table border=1 cellspacing=0 width=80% align=center>
<form action=\"send.php";
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
if (($post) && ($note)) {
$note = htmlentities($note);
$note = nl2br($note);
$note = eregi_replace("&lt;b&gt;", "<b>", $note);
$note = eregi_replace("&lt;/b&gt;", "</b>", $note);
$note = eregi_replace("&lt;i&gt;", "<i>", $note);
$note = eregi_replace("&lt;/i&gt;", "</i>", $note);
$note = eregi_replace("&nbsp;", " ", $note);
$note = eregi_replace("&shy;", "", $note);
$note = addslashes($note);
$time=time();
$datedate=date("n/j/Y h:i:s A");
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$modname=$myrow["userid"];
$sql="UPDATE users SET notify=1 WHERE userid='$user'";
$result=mysql_query($sql);
$sql="INSERT INTO systemnot (sysbod,sendto,sentat,sentfrom,`read`,sentsec) VALUES ('$note','$user','$datedate','$modname','0','$time')";
$result=mysql_query($sql);
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"5; URL=/boards/whois.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">

<tr><td align=center colspan=2>You should be returned to this user's Whois page automatically in five seconds.  If not, you can click <a HREF=\"/boards/whois.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">here</a> to continue.</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
echo "<form action=\"send.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td>Notification:</td><td><textarea cols=\"60\" rows=\"10\" name=\"note\" WRAP=\"virtual\"></textarea><br>
<TR><TD COLSPAN=2 ALIGN=CENTER><input type=\"submit\" name=\"post\" value=\"Send Notification\"><input type=\"reset\" value=\"Reset\" name=\"reset\"></td></tr>
</td></tr>
</form>
</table>";
include("/home/mediarch/foot.php");
?>



