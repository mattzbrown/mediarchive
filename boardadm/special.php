<?
$pagetitle="Special User Levels";
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
if ($myrow["level"]<60)
{
echo "<table border=0 width=100%>

<tr><td>You are not authorized to view this page.</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
echo "<table border=0 width=100%>

<tr><td align=center COLSPAN=2><font SIZE=6>Special User Levels</font></td></tr>
<tr><td CLASS=LITE ALIGN=center COLSPAN=2><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"/boards/gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"/boards/genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
if ($user) {
echo " | <a href=\"/boards/whois.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo"\" CLASS=MENU>Whois Page</a>";
}
if ($myrow["level"]>=60) {
echo " | <a HREF=\"index.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Control Panel</a>";
}
echo "</i></font></td></tr>";
if (!$user) {
echo "


<tr><td COLSPAN=2><br>
<table border=1 cellspacing=0 width=80% align=center>
<form action=\"special.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td><b>Enter a User ID to edit:</td><td><input type=\"text\" name=\"user\" value=\"\" size=\"20\" maxlength=\"20\">
<input type=\"submit\" name=\"post\" value=\"Search\">
</td></tr></form></table>

<br>
</tr></td>





</table>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE userid=$user";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
if (!$myrow) {
echo "<tr><td align=center COLSPAN=2><b>There was an error editing this user:</b> This user does not exist.</td></tr>
<tr><td COLSPAN=2><br>
<table border=1 cellspacing=0 width=80% align=center>
<form action=\"special.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td><b>Enter a User ID to edit:</td><td><input type=\"text\" name=\"user\" value=\"\" size=\"20\" maxlength=\"20\">
<input type=\"submit\" name=\"post\" value=\"Search\">
</td></tr></form></table>

<br>
</tr></td>
</table>";
include("/home/mediarch/foot.php");
exit;
}
$karma=$myrow["cookies"];
if (($newlevel=="Restore") || ($newlevel=="VIP (40)") || ($newlevel=="New Moderator (50)") || ($newlevel=="General Moderator (51)") || ($newlevel=="Specialized Moderator (52)") || ($newlevel=="Lead Moderator (53)") || ($newlevel=="Administrator (60)") || ($newlevel=="Demote")) {
if ($newlevel=="VIP (40)") {
$sql="UPDATE users SET level=40 WHERE userid=$user";
$result=mysql_query($sql);
} else if ($newlevel=="New Moderator (50)") {
$sql="UPDATE users SET level=50 WHERE userid=$user";
$result=mysql_query($sql);
$sql="UPDATE users SET modcat=$modcat WHERE userid=$user";
$result=mysql_query($sql);
} else if ($newlevel=="General Moderator (51)") {
$sql="UPDATE users SET level=51 WHERE userid=$user";
$result=mysql_query($sql);
} else if ($newlevel=="Specialized Moderator (52)") {
$sql="UPDATE users SET level=52 WHERE userid=$user";
$result=mysql_query($sql);
$sql="UPDATE users SET modcat=$modcat2 WHERE userid=$user";
$result=mysql_query($sql);
} else if ($newlevel=="Lead Moderator (53)") {
$sql="UPDATE users SET level=53 WHERE userid=$user";
$result=mysql_query($sql);
} else if ($newlevel=="Administrator (60)") {
$sql="UPDATE users SET level=60 WHERE userid=$user";
$result=mysql_query($sql);
} else if (($newlevel=="Demote") || ($newlevel=="Restore")) {
if ($karma<0) {
$sql="UPDATE users SET level=6 WHERE userid=$user";
$result=mysql_query($sql);
} else if (($karma>=0) && ($karma<10)) {
$sql="UPDATE users SET level=15 WHERE userid=$user";
$result=mysql_query($sql);
} else if (($karma>=10) && ($karma<20)) {
$sql="UPDATE users SET level=20 WHERE userid=$user";
$result=mysql_query($sql);
} else if (($karma>=20) && ($karma<40)) {
$sql="UPDATE users SET level=25 WHERE userid=$user";
$result=mysql_query($sql);
} else if (($karma>=40) && ($karma<75)) {
$sql="UPDATE users SET level=30 WHERE userid=$user";
$result=mysql_query($sql);
} else if (($karma>=75) && ($karma<120)) {
$sql="UPDATE users SET level=31 WHERE userid=$user";
$result=mysql_query($sql);
} else if (($karma>=120) && ($karma<150)) {
$sql="UPDATE users SET level=32 WHERE userid=$user";
$result=mysql_query($sql);
} else if (($karma>=150) && ($karma<200)) {
$sql="UPDATE users SET level=33 WHERE userid=$user";
$result=mysql_query($sql);
} else if (($karma>=200) && ($karma<250)) {
$sql="UPDATE users SET level=34 WHERE userid=$user";
$result=mysql_query($sql);
} else if ($karma>=250) {
$sql="UPDATE users SET level=35 WHERE userid=$user";
$result=mysql_query($sql);
}
}
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"5; URL=/boards/whois.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">
<tr><td COLSPAN=2>You should be returned to the Whois page automatically in five seconds.  If not, you can click <a HREF=\"/boards/whois.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">here</a> to continue.</td></tr>";
} else if (!$newlevel) {
echo "<tr><td CLASS=DARK ALIGN=CENTER COLSPAN=2><font SIZE=3>Edit User</font></td></tr>
<tr><td CLASS=SHADE COLSPAN=2><b>User:</b> ".$myrow["username"]." (".$myrow["level"].")</td></tr>
<form action=\"special.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">";
if ($myrow["level"]<=-1) {
echo "<tr><td align=center><input type=\"submit\" name=\"newlevel\" value=\"Restore\"></td><td></td></tr>";
}
if (($myrow["level"]>=40) && ($myrow["level"]<=60)) {
echo "<tr><td align=center><input type=\"submit\" name=\"newlevel\" value=\"Demote\"></td><td></td></tr>";
}
if ($myrow["level"]!=40) {
echo "<tr><td align=center><input type=\"submit\" name=\"newlevel\" value=\"VIP (40)\"></td><td></td></tr>";
}
if ($myrow["level"]!=50) {
echo "<tr><td align=center><input type=\"submit\" name=\"newlevel\" value=\"New Moderator (50)\"></td><td><select name=\"modcat\">";
$sql="SELECT * FROM boardcat ORDER BY id ASC";
$result2=mysql_query($sql);
while ($myrow2=@mysql_fetch_array($result2)) {
echo "<option value=".$myrow2["id"].">".$myrow2["name"]."</option>";
}
echo "</select></td></tr>";
}
if ($myrow["level"]!=51) {
echo "<tr><td align=center><input type=\"submit\" name=\"newlevel\" value=\"General Moderator (51)\"></td><td></td></tr>";
}
if ($myrow["level"]!=52) {
echo "<tr><td align=center><input type=\"submit\" name=\"newlevel\" value=\"Specialized Moderator (52)\"></td><td><select name=\"modcat2\">";
$sql="SELECT * FROM boardcat ORDER BY id ASC";
$result2=mysql_query($sql);
while ($myrow2=@mysql_fetch_array($result2)) {
echo "<option value=".$myrow2["id"].">".$myrow2["name"]."</option>";
}
echo "</select></td></tr>";
}
if ($myrow["level"]!=53) {
echo "<tr><td align=center><input type=\"submit\" name=\"newlevel\" value=\"Lead Moderator (53)\"></td><td></td></tr>";
}
if ($myrow["level"]!=60) {
echo "<tr><td align=center><input type=\"submit\" name=\"newlevel\" value=\"Administrator (60)\"></td><td></td></tr>";
}
echo "
</form>";
}
echo "</table>";
include("/home/mediarch/foot.php");
?>
