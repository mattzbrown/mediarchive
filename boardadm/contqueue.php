<?
$pagetitle="Moderation Contest Queue";
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

<tr><td COLSPAN=5 align=center><FONT SIZE=6><B>Moderation Contest Queue</b></font></td></tr>

<tr><td COLSPAN=5 CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=menu>Board List</a>";
if ($board) { echo " | <a HREF=\"/boards/gentopic.php?board=$board\" CLASS=menu>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"/boards/genmessage.php?board=$board&topic=$topic\" CLASS=menu>Message List</a>";
}
echo " | <a HREF=\"index.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=menu>Control Panel</a>";
echo "</i></font></td></tr>
<tr>
<td CLASS=LITE ALIGN=center><i>ID</i></td>
<td CLASS=LITE ALIGN=center><i>Topic</i></td>
<td CLASS=LITE ALIGN=center><i>Reason</i></td>
<td CLASS=LITE ALIGN=center><i>Action</i></td>
<td CLASS=LITE ALIGN=center><i>Contestion Date</i></td>
</tr>
<tr><td CLASS=DARK colspan=5 ALIGN=center>Contested Moderations</td></tr>";
$result=mysql_query("SELECT * FROM modded WHERE modby=$myuseid AND contest=1 AND recont=0 ORDER BY contsec ASC");
while ($myrow=@mysql_fetch_array($result)) {
echo "<tr><td CLASS=CELL2><a href=\"moddetl.php?user=".$myrow["moduser"]."&modid=".$myrow["modid"]."";
if ($board) { echo "&board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">".$myrow["modid"]."</a></td><td CLASS=CELL2>".$myrow["topic"]."</td><td CLASS=CELL2>";
$reason=$myrow["reason"];
$sql="SELECT * FROM tos WHERE tosid=$reason";
$resultre=mysql_query($sql);
$myrowre=@mysql_fetch_array($resultre);
echo $myrowre["ruletitle"];
echo "</td><td CLASS=CELL2>";
if ($myrow["action"]==1) {
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
echo "</td><td CLASS=CELL2>".date("n/j/Y h:i:s A",$myrow["contsec"])."</td></tr>";
}
echo "<tr><td CLASS=DARK colspan=5 ALIGN=center>Accepted Moderations</td></tr>";
$result=mysql_query("SELECT * FROM modded WHERE modby=$myuseid AND contest=0 AND recont=0 ORDER BY contsec ASC");
while ($myrow=@mysql_fetch_array($result)) {
$contbo=$myrow["contbody"];
$recontbo=$myrow["recontbody"];
if (($contbo) && (!$recontbo)) {
echo "<tr><td CLASS=CELL2><a href=\"moddetl.php?user=".$myrow["moduser"]."&modid=".$myrow["modid"]."";
if ($board) { echo "&board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">".$myrow["modid"]."</a></td><td CLASS=CELL2>".$myrow["topic"]."</td><td CLASS=CELL2>";
$reason=$myrow["reason"];
$sql="SELECT * FROM tos WHERE tosid=$reason";
$resultre=mysql_query($sql);
$myrowre=@mysql_fetch_array($resultre);
echo $myrowre["ruletitle"];
echo "</td><td CLASS=CELL2>";
if ($myrow["action"]==1) {
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
echo "</td><td CLASS=CELL2>".date("n/j/Y h:i:s A",$myrow["contsec"])."</td></tr>";
}
}
echo "</table>";
include("/home/mediarch/foot.php");
?>
