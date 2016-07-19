<?
$pagetitle="Suggestion Queue";
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
$usrid=$myrow["userid"];
$level=$myrow["level"];
$modcat=$myrow["modcat"];
if ($myrow["level"]<50)
{
echo "<table border=0 width=100%>
<tr><td>You are not authorized to view this page.</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
echo "<table border=0 width=100%>

<tr><td COLSPAN=6 align=center><font SIZE=6>Suggestion Queue</font></td></tr>";
echo "<tr><td CLASS=LITE ALIGN=center colspan=6><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"/boards/gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"/boards/genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo " | <a HREF=\"index.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Control Panel</a>";
echo "</i></font></td></tr>";
$sql="SELECT auraby FROM auraed ORDER BY auraid DESC LIMIT 0,1";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$sql="SELECT username FROM users WHERE userid=".$myrow["auraby"];
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
if ($myrow["username"]) { echo "<tr><td class=\"DARK\" colspan=\"6\" align=\"center\">Last Action By: ".$myrow["username"]."</td></tr>"; }
echo "<tr>
<td class=\"LITE\"><i>ID</i></td>
<td class=\"LITE\" width=50%><i>Topic</i></td>
<td class=\"LITE\"><i>Board</i></td>
<td class=\"LITE\"><i>Reason</i></td>
<td class=\"LITE\"><i>Number of Suggests</i></td>
<td class=\"LITE\"><i>Date Suggested</i></td>
</tr>
";
if ($level==50)  {
$modstr=" ";
$sql="SELECT * FROM boards WHERE `type`=$modcat";
$result=mysql_query($sql);
while ($myrow=mysql_fetch_array($result)) {
$modstr.="board=".$myrow["boardid"]." ";
}

$modstr=trim($modstr);
$modstr=explode(" ",$modstr);
$modstr=implode(" OR ",$modstr);
$modstr2="WHERE ".$modstr;
$sql="SELECT * FROM suggested ".$modstr2." AND suggestby<>$usrid ORDER BY suggestid ASC";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$boardid=$myrow["board"];
$topicid=$myrow["topic"];
$suggestid=$myrow["suggestid"];
$sql="SELECT * FROM topics WHERE topicid=$topicid";
$result2=mysql_query($sql);
$myrow2=mysql_fetch_array($result2);
$sql="SELECT * FROM boards WHERE boardid=$boardid";
$resultx=mysql_query($sql);
$myrowx=@mysql_fetch_array($resultx);
$boardn=$myrowx["boardname"];
$sql="SELECT * FROM secsuggested WHERE suggestid=$suggestid";
$result3=mysql_query($sql);
$suggests=mysql_num_rows($result3);
$sql="SELECT * FROM secsuggested WHERE suggestid=$suggestid ORDER BY suggestsec DESC LIMIT 0,1";
$result3=mysql_query($sql);
$myrow3=mysql_fetch_array($result3);
$reason=$myrow["reason"];
$sql="SELECT * FROM sos WHERE sosid=$reason";
$resultre=mysql_query($sql);
$myrowre=@mysql_fetch_array($resultre);
echo "<tr>
<td CLASS=CELL1><a href=sugact.php?suggestid=".$myrow["suggestid"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo ">".$myrow["suggestid"]."</a></td>
<td CLASS=CELL1>".stripslashes($myrow2["topicname"])."</td>
<td CLASS=CELL1>".$boardn."</td>
<td CLASS=CELL1>".$myrowre["ruletitle"]."</td>
<td CLASS=CELL1>".$suggests."</td>
<td CLASS=CELL1>".$myrow["suggestdate"]."</td>
</tr>";
}
} else if ($level==52) {
$modstr=" ";
$sql="SELECT * FROM boards WHERE `type`=$modcat";
$result=mysql_query($sql);
while ($myrow=mysql_fetch_array($result)) {
$modstr.="board=".$myrow["boardid"]." ";
}

$modstr=trim($modstr);
$modstr=explode(" ",$modstr);
$modstr=implode(" OR ",$modstr);
$modstr2="WHERE ".$modstr;
$sql="SELECT * FROM suggested ".$modstr2." ORDER BY suggestid ASC";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$boardid=$myrow["board"];
$topicid=$myrow["topic"];
$suggestid=$myrow["suggestid"];
$sql="SELECT * FROM topics WHERE topicid=$topicid";
$result2=mysql_query($sql);
$myrow2=mysql_fetch_array($result2);
$sql="SELECT * FROM boards WHERE boardid=$boardid";
$resultx=mysql_query($sql);
$myrowx=@mysql_fetch_array($resultx);
$boardn=$myrowx["boardname"];
$sql="SELECT * FROM secsuggested WHERE suggestid=$suggestid";
$result3=mysql_query($sql);
$suggests=mysql_num_rows($result3);
$sql="SELECT * FROM secsuggested WHERE suggestid=$suggestid ORDER BY suggestsec DESC LIMIT 0,1";
$result3=mysql_query($sql);
$myrow3=mysql_fetch_array($result3);
$reason=$myrow["reason"];
$sql="SELECT * FROM sos WHERE sosid=$reason";
$resultre=mysql_query($sql);
$myrowre=@mysql_fetch_array($resultre);
echo "<tr>
<td CLASS=CELL1><a href=sugact.php?suggestid=".$myrow["suggestid"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo ">".$myrow["suggestid"]."</a></td>
<td CLASS=CELL1>".stripslashes($myrow2["topicname"])."</td>
<td CLASS=CELL1>".$boardn."</td>
<td CLASS=CELL1>".$myrowre["ruletitle"]."</td>
<td CLASS=CELL1>".$suggests."</td>
<td CLASS=CELL1>".$myrow["suggestdate"]."</td>
</tr>";
}
$sql="SELECT * FROM suggested ".eregi_replace("=","<>",eregi_replace("OR","AND",$modstr2))." ORDER BY suggestid ASC";
$result=mysql_query($sql);
while ($myrow=mysql_fetch_array($result)) {
$boardid=$myrow["board"];
$topicid=$myrow["topic"];
$suggestid=$myrow["suggestid"];
$sql="SELECT * FROM topics WHERE topicid=$topicid";
$result2=mysql_query($sql);
$myrow2=mysql_fetch_array($result2);
$sql="SELECT * FROM boards WHERE boardid=$boardid";
$resultx=mysql_query($sql);
$myrowx=@mysql_fetch_array($resultx);
$boardn=$myrowx["boardname"];
$sql="SELECT * FROM secsuggested WHERE suggestid=$suggestid";
$result3=mysql_query($sql);
$suggests=mysql_num_rows($result3);
$sql="SELECT * FROM secsuggested WHERE suggestid=$suggestid ORDER BY suggestsec DESC LIMIT 0,1";
$result3=mysql_query($sql);
$myrow3=mysql_fetch_array($result3);
$reason=$myrow["reason"];
$sql="SELECT * FROM sos WHERE sosid=$reason";
$resultre=mysql_query($sql);
$myrowre=@mysql_fetch_array($resultre);
echo "<tr>
<td CLASS=CELL1><a href=sugact.php?suggestid=".$myrow["suggestid"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo ">".$myrow["suggestid"]."</a></td>
<td CLASS=CELL1>".stripslashes($myrow2["topicname"])."</td>
<td CLASS=CELL1>".$boardn."</td>
<td CLASS=CELL1>".$myrowre["ruletitle"]."</td>
<td CLASS=CELL1>".$suggests."</td>
<td CLASS=CELL1>".$myrow["suggestdate"]."</td>
</tr>";
}

} else if (($level==51) || ($level>=53)) {
$sql="SELECT * FROM suggested ORDER BY suggestid ASC";
$result=mysql_query($sql);
while ($myrow=mysql_fetch_array($result)) {
$boardid=$myrow["board"];
$topicid=$myrow["topic"];
$suggestid=$myrow["suggestid"];
$sql="SELECT * FROM topics WHERE topicid=$topicid";
$result2=mysql_query($sql);
$myrow2=mysql_fetch_array($result2);
$sql="SELECT * FROM boards WHERE boardid=$boardid";
$resultx=mysql_query($sql);
$myrowx=@mysql_fetch_array($resultx);
$boardn=$myrowx["boardname"];
$sql="SELECT * FROM secsuggested WHERE suggestid=$suggestid";
$result3=mysql_query($sql);
$suggests=mysql_num_rows($result3);
$sql="SELECT * FROM secsuggested WHERE suggestid=$suggestid ORDER BY suggestsec DESC LIMIT 0,1";
$result3=mysql_query($sql);
$myrow3=mysql_fetch_array($result3);
$reason=$myrow["reason"];
$sql="SELECT * FROM sos WHERE sosid=$reason";
$resultre=mysql_query($sql);
$myrowre=@mysql_fetch_array($resultre);
echo "<tr>
<td CLASS=CELL1><a href=sugact.php?suggestid=".$myrow["suggestid"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo ">".$myrow["suggestid"]."</a></td>
<td CLASS=CELL1>".stripslashes($myrow2["topicname"])."</td>
<td CLASS=CELL1>".$boardn."</td>
<td CLASS=CELL1>".$myrowre["ruletitle"]."</td>
<td CLASS=CELL1>".$suggests."</td>
<td CLASS=CELL1>".$myrow["suggestdate"]."</td>
</tr>";
}
}
echo "</table>";
include("/home/mediarch/foot.php");
?>
