<?
$pagetitle="Control Panel";
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
echo "<table border=1 cellspacing=0 width=100%>
<tr><td>You are not authorized to view this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$usrname=$myrow["username"];
$useridy=$myrow["userid"];
$usrid=$myrow["userid"];
$level=$myrow["level"];
$modcat=$myrow["modcat"];
if ($myrow["level"]<50)
{
echo "<table border=1 cellspacing=0 width=100%>
<tr><td>You are not authorized to view this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
if ($myrow["level"]>=60) {
echo "<table border=1 cellspacing=0 width=100%>

<tr><td COLSPAN=4 align=center><font SIZE=6>Control Panel</font></td></tr>";
echo "<tr><td COLSPAN=2 CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"/boards/gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"/boards/genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo "</i></font></td></tr>
<tr><td colspan=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Administrative Control: Logged in as $usrname</font></td></tr>
<tr><td ALIGN=CENTER WIDTH=25% valign=top><font SIZE=2><a HREF=\"edboards.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">Board Editor</a><br>
<a HREF=\"tos.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">TOS Editor</a><br>
<a HREF=\"karma.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">Karma Boost</a><br>
<a HREF=\"poll.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">Poll Creator</a><br>
<a HREF=\"purge.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">Manual Purge</a><br>
<a HREF=\"kos.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">KOS</a><br>
<a HREF=\"misc.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">Miscellaneous Options</a><br>
<a HREF=\"words.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">Banned Words</a><br>
<a HREF=\"appeals.php";
$sql="SELECT * FROM modded WHERE recont=4";
$result=mysql_query($sql);
$result=@mysql_num_rows($result);
$sql="SELECT * FROM modded WHERE recont=9";
$result2=mysql_query($sql);
$result2=@mysql_num_rows($result2);
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">Contest Appeals Queue (".$result."-".$result2.")</a><br>
<br>
<a HREF=\"modguide.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">Moderator Guide</a><br>
<a HREF=\"search.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">Search</a><br>
<a HREF=\"allmetamod.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">Meta-Mod Tally</a><br>
<a HREF=\"stats.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">Statistics</a><br>
<a HREF=\"modqueue.php";
$sql="SELECT * FROM marked";
$result=mysql_query($sql);
$result=@mysql_num_rows($result);
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">Moderation Queue (".$result.")</a><br>
<a HREF=\"sugqueue.php";
$sql="SELECT * FROM suggested";
$result=mysql_query($sql);
$result=@mysql_num_rows($result);
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">Suggestion Queue (".$result.")</a><br>
<a HREF=\"contqueue.php";
$sql="SELECT * FROM modded WHERE contest=1 AND modby=$useridy AND recont=0";
$result=mysql_query($sql);
$result=@mysql_num_rows($result);
$acceptmods=0;
$result2=mysql_query("SELECT * FROM modded WHERE modby=$useridy AND contest=0 AND recont=0 ORDER BY contsec ASC");
while ($myrow=@mysql_fetch_array($result2)) {
$contbo=$myrow["contbody"];
$recontbo=$myrow["recontbody"];
if (($contbo) && (!$recontbo)) { $acceptmods=$acceptmods+1; }
}
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">Contestion Queue (".$result."-".$acceptmods.")</a>
</font></td>


<td align=center WIDTH=75% valign=TOP><font SIZE=5><b>Suspended Users</b></font><br>
<table border=0 width=100%>
<tr>
<td CLASS=LITE ALIGN=center><i>User</i></td>
<td CLASS=LITE ALIGN=center><i>Supended On</i></td>
<td CLASS=LITE ALIGN=center><i>Reason</i></td>
<td CLASS=LITE ALIGN=center><i>Karma</i></td>
</tr>";

$sql="SELECT * FROM modded WHERE action>=9 AND action<=10 ORDER BY modsec DESC";
$resultw=mysql_query($sql);
while ($myroww=@mysql_fetch_array($resultw)) {
$moduser=$myroww["moduser"];
$sql="SELECT * FROM users WHERE userid='$moduser'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
if ($myrow["level"]==-1) {
$reason=$myroww["reason"];
$sql="SELECT * FROM tos WHERE tosid=$reason";
$resultre=mysql_query($sql);
$myrowre=@mysql_fetch_array($resultre);

echo "
<tr><td CLASS=CELL1><a HREF=\"suspended.php?user=".$myroww["moduser"]."";
if ($board) { echo "&board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">".$myrow["username"]."</a></td><td CLASS=CELL1> ".$myroww["moddate"]."</td><td CLASS=CELL1>".$myrowre["ruletitle"]."</td><td CLASS=CELL1>".$myrow["cookies"]."</td></tr>";
}
}


echo "</table></td></tr>

<tr>
<td CLASS=DARK ALIGN=CENTER colspan=2><font SIZE=3 valign=top>Moderator Statistics</font></td></tr>
<tr><td align=center colspan=2><br>
<table border=1 cellspacing=0 width=95%>
<tr>
<td CLASS=LITE ALIGN=center width=20%><i>Moderator</i></td>
<td CLASS=LITE ALIGN=center width=16%><i>Moderations Handled</i></td>
<td CLASS=LITE ALIGN=center width=16%><i>Suggestions Handled</i></td>
<td CLASS=LITE ALIGN=center width=16%><i>Total</i></td>
<td CLASS=LITE ALIGN=center width=16%><i>Contested Moderations</i></td>
<td CLASS=LITE ALIGN=center width=16%><i>Percent Contested</i></td>
</tr>
";
$sql="SELECT * FROM users WHERE level>=50 ORDER BY username ASC";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$useid=$myrow["userid"];
$sql="SELECT * FROM modded WHERE modby=$useid";
$result2=mysql_query($sql);
$mods=@mysql_num_rows($result2);
$sql="SELECT * FROM auraed WHERE auraby=$useid";
$result2=mysql_query($sql);
$sugs=@mysql_num_rows($result2);
$sql="SELECT * FROM modded WHERE modby=$useid AND contest>=1";
$result2=mysql_query($sql);
$cont=@mysql_num_rows($result2);
if ($mods) {
$contp=$cont/$mods;
$contp=$contp*100;
$contp=number_format($contp, "0", ".", "");
} else {
$contp=0;
}
echo "<tr><td><a href=\"mods.php?user=".$myrow["userid"]."";
if ($board) { echo "&board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">".$myrow["username"]."</a></td><td>".$mods."</td><td>".$sugs."</td><td>".($sugs+$mods)."</td><td>".$cont."</td><td>".$contp."%</td></tr>";
}
echo "</table>
<br>
</td></tr>

</table>
";
include("/home/mediarch/foot.php");
} else {
echo "<table border=1 cellspacing=0 width=100%>

<tr><td COLSPAN=4 align=center><font SIZE=6>Control Panel</font></td></tr>";
echo "<tr><td COLSPAN=2 CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"/boards/gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"/boards/genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo "</i></font></td></tr>
<tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Moderator Control: Logged in as $usrname</font></td></tr>
<tr><td align=center><a HREF=\"modguide.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">Moderator Guide</a><br>
<a HREF=\"search.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">Search</a><br>
<a HREF=\"allmetamod.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">Meta-Mod Tally</a><br>
<a HREF=\"stats.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">Statistics</a>
</td><td align=center>
<a HREF=\"modqueue.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">Moderation Queue</a><br>";
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
$sql="SELECT * FROM marked ".$modstr2." AND markby<>$usrid ORDER BY markid ASC";
} else {
$sql="SELECT * FROM marked";
}
$result=mysql_query($sql);
$result=@mysql_num_rows($result);
echo "<b>Marked Messages:</b> ".$result."<br>
<a HREF=\"sugqueue.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">Suggestion Queue</a><br>";
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
} else {
$sql="SELECT * FROM suggested";
}
$result=mysql_query($sql);
$result=@mysql_num_rows($result);
echo "<b>Suggested Messages:</b> ".$result."
<br>
<a HREF=\"contqueue.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">Moderation Contest Queue</a><br>";
$sql="SELECT * FROM modded WHERE contest=1 AND modby=$useridy AND recont=0";
$result=mysql_query($sql);
$result=@mysql_num_rows($result);
echo "<b>Your Contested Moderations:</b> ".$result."<br>";
$acceptmods=0;
$result=mysql_query("SELECT * FROM modded WHERE modby=$useridy AND contest=0 AND recont=0 ORDER BY contsec ASC");
while ($myrow=@mysql_fetch_array($result)) {
$contbo=$myrow["contbody"];
$recontbo=$myrow["recontbody"];
if (($contbo) && (!$recontbo)) { $acceptmods=$acceptmods+1; }
}
echo "<b>Your Accepted Moderations:</b> ".$acceptmods."
</td></tr>
<tr>
<td CLASS=DARK ALIGN=CENTER colspan=2><font SIZE=3 valign=top>Moderator Statistics</font></td></tr>
<tr><td align=center colspan=2><br>
<table border=1 cellspacing=0 width=95%>
<tr>
<td CLASS=LITE ALIGN=center width=20%><i>Moderator</i></td>
<td CLASS=LITE ALIGN=center width=16%><i>Moderations Handled</i></td>
<td CLASS=LITE ALIGN=center width=16%><i>Suggestions Handled</i></td>
<td CLASS=LITE ALIGN=center width=16%><i>Total</i></td>
<td CLASS=LITE ALIGN=center width=16%><i>Contested Moderations</i></td>
<td CLASS=LITE ALIGN=center width=16%><i>Percent Contested</i></td>
</tr>
";
$sql="SELECT * FROM users WHERE level>=50 ORDER BY username ASC";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$useid=$myrow["userid"];
$sql="SELECT * FROM modded WHERE modby=$useid";
$result2=mysql_query($sql);
$mods=@mysql_num_rows($result2);
$sql="SELECT * FROM auraed WHERE auraby=$useid";
$result2=mysql_query($sql);
$sugs=@mysql_num_rows($result2);
$sql="SELECT * FROM modded WHERE modby=$useid AND contest>=1";
$result2=mysql_query($sql);
$cont=@mysql_num_rows($result2);
if ($mods) {
$contp=$cont/$mods;
$contp=$contp*100;
$contp=number_format($contp, "0", ".", "");
} else {
$contp=0;
}
echo "<tr><td><a href=\"/boards/whois.php?user=".$myrow["userid"]."";
if ($board) { echo "&board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">".$myrow["username"]."</a></td><td>".$mods."</td><td>".$sugs."</td><td>".($sugs+$mods)."</td><td>".$cont."</td><td>".$contp."%</td></tr>";
}
echo "</table>
<br>
</td></tr>

</table>
";
include("/home/mediarch/foot.php");
}
?>