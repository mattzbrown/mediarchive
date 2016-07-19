<?
$pagetitle="Moderation History";
include("/home/mediarch/head.php");
echo $harsss;
function getlevel($username)
{
$sql="SELECT * FROM users WHERE username='$username'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
return $myrow["level"];
}
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

echo "<table border=0 width=100%>
<tr><td align=center colspan=7><font SIZE=6><b>Moderated Messages History</b></font></td></tr>";

$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$usrname=$myrow["username"];
$userid=$myrow["userid"];
if ($myrow["level"]<60)
{
echo "<tr><td>You are not authorized to view this page.</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
echo "<tr><td CLASS=LITE ALIGN=center COLSPAN=7><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
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
echo "\" CLASS=MENU>Control Panel</a>
</i></font></td></tr>";
$sql="SELECT * FROM users WHERE userid='$user' AND level>=50";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
if (!$user) {
echo "


<tr><td><br>
<table border=1 cellspacing=0 width=80% align=center>
<form action=\"modhist.php";
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
echo "<tr><td align=center><b>There was an error viewing user moderations:</b> This user either does not exist or is not a moderator.</td></tr>
<tr><td><br>
<table border=1 cellspacing=0 width=80% align=center>
<form action=\"modhist.php";
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
echo "<tr>
<td class=\"LITE\"><i>ID</i></td>
<td class=\"LITE\"><i>Board</i></td>
<td class=\"LITE\"><i>Topic</i></td>
<td class=\"LITE\"><i>Date</i></td>
<td class=\"LITE\"><i>Reason</i></td>
<td class=\"LITE\"><i>Action</i></td>
<td class=\"LITE\"><i>Status</i></td>
</tr>";

$sql="SELECT * FROM modded WHERE modby=$user ORDER BY modid DESC";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {

$boardid=$myrow["boardid"];
$sql="SELECT * FROM boards WHERE boardid=$boardid";
$resultx=mysql_query($sql);
$myrowx=@mysql_fetch_array($resultx);
$boardn=$myrowx["boardname"];
echo "<tr>
<td CLASS=CELL2><a href=\"moddetl.php?user=".$myrow["moduser"]."&modid=".$myrow["modid"]."";
if ($board) { echo "&board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">".$myrow["modid"]."</a></td>
<td CLASS=CELL2>".$boardn."</td>
<td CLASS=CELL2>".$myrow["topic"]."</td>
<td CLASS=CELL2>".$myrow["moddate"]."</td>
<td CLASS=CELL2>";
$reason=$myrow["reason"];
$sql="SELECT * FROM tos WHERE tosid=$reason";
$resultre=mysql_query($sql);
$myrowre=@mysql_fetch_array($resultre);
echo $myrowre["ruletitle"];
echo "</td>
<td CLASS=CELL2>";
if ($myrow["action"]==0) {
echo "No Action";
} else if ($myrow["action"]==1) {
echo "Topic Closed";
} else if ($myrow["action"]==2) {
echo "Topic Moved";
} else if ($myrow["action"]==3) {
echo "Message Deleted";
} else if ($myrow["action"]==4) {
echo "Topic Deleted";
} else if ($myrow["action"]==5) {
echo "Notified (Msg)";
} else if ($myrow["action"]==6) {
echo "Notified (Top)";
} else if ($myrow["action"]==7) {
echo "Warned (Msg)";
} else if ($myrow["action"]==8) {
echo "Warned (Top)";
} else if ($myrow["action"]==9) {
echo "Suspended (Msg)";
} else if ($myrow["action"]==10) {
echo "Suspended (Top)";
} else if ($myrow["action"]==11) {
echo "Banned (Msg)";
} else if ($myrow["action"]==12) {
echo "Banned (Top)";
}
echo "</td>
<td CLASS=CELL2>";
if (($myrow["contest"]==0) && ($myrow["recont"]==0)) {
echo "N/A";
} else if (($myrow["contest"]==0) && ($myrow["contbody"])) {
echo "Accepted";
} else if (($myrow["contest"]==1) && ($myrow["recont"]==0)) {
echo "Contested - TOS";
} else if (($myrow["contest"]==1) && ($myrow["recont"]==3)) {
echo "Upheld";
} else if (($myrow["contest"]==1) && ($myrow["recont"]==2)) {
echo "Relaxed";
} else if (($myrow["contest"]==1) && ($myrow["recont"]==1)) {
echo "Overturned";
} else if (($myrow["contest"]==1) && ($myrow["recont"]==4)) {
echo "Appealed to Admin";
} else if (($myrow["contest"]==1) && ($myrow["recont"]==7)) {
echo "Upheld by Admin";
} else if (($myrow["contest"]==1) && ($myrow["recont"]==6)) {
echo "Relaxed by Admin";
} else if (($myrow["contest"]==1) && ($myrow["recont"]==5)) {
echo "Overturned by Admin";
} else if (($myrow["contest"]==1) && ($myrow["recont"]==8)) {
echo "Contest Abuse";
} else if (($myrow["contest"]==1) && ($myrow["recont"]==9)) {
echo "Forwarded to Admin";
}
echo "</td></tr>";
}

echo "

</table>";
include("/home/mediarch/foot.php");
?>