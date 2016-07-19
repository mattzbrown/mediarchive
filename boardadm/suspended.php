<?
$pagetitle="Suspension Action";
include("/home/mediarch/head.php");
echo $harsss;
echo "<table border=0 width=100%>

<tr><td align=center><font SIZE=6>Suspension Action</font></td></tr>";
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
$userid=$myrow["userid"];
$level=$myrow["level"];
if ($level<60)
{
echo "<tr><td>You are not authorized to view this page.</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
$usern=$myrow["username"];
echo "<tr><td COLSPAN=2 CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"/boards/gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"/boards/genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo " | <a HREF=\"/boards/whois.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Whois Page</a> | 
<a HREF=\"index.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Control Panel</a>
</i></font></td></tr>";

$sql="SELECT * FROM modded WHERE moduser=$user AND action>=9 AND action<=10";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$numrows=@mysql_num_rows($result);
if ($numrows<=0) {

echo "<tr><td>An invalid link was used to access this page.</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE userid=$user";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
if ($myrow["level"]!=-1) {
echo "<tr><td>An invalid link was used to access this page.</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
if ($modid) {
$sql="SELECT * FROM modded WHERE modid=$modid";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
if ($numrows<=0) {
echo "<tr><td>An invalid link was used to access this page.</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
}
if (($user) && ($modid) && (($post=="Restore") || ($post=="Relax to No Karma Loss") || ($post=="Relax to Notification") || ($post=="Relax to Warning") || ($post=="                     Ban                     ") || ($post=="...And clear profile") || ($post=="Usermap Axe"))) {
if ($post=="Restore") {
$sql="SELECT * FROM users WHERE userid=$user";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$karma=$myrow["cookies"];
if ($karma<10) {
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
} else if ($post=="Relax to No Karma Loss") {
$sql="SELECT * FROM users WHERE userid=$user";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$karma=$myrow["cookies"];
if ($karma<10) {
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
$sql="SELECT * FROM modded WHERE modid=$modid";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
if ($myrow["action"]==9) {
$sql="UPDATE modded SET action=3 WHERE modid=$modid";
$result=mysql_query($sql);
} else if ($myrow["action"]==10) {
$sql="UPDATE modded SET action=4 WHERE modid=$modid";
$result=mysql_query($sql);
}
} else if ($post=="Relax to Notification") {
$sql="SELECT * FROM users WHERE userid=$user";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$karma=$myrow["cookies"];
$karma=$karma-3;
$sql="UPDATE users SET cookies=$karma WHERE userid=$user";
$result=mysql_query($sql);
if ($karma<10) {
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
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$modname=$myrow["userid"];
$time=time();
$datedate=date("n/j/Y h:i:s A");
$sql="INSERT INTO systemnot (sysbod,sendto,sentat,sentfrom,`read`,sentsec) VALUES ('Your account has been <b>Notified</b> for one or more TOS violations. This is considered a standard moderation and comes with a loss of 3 karma. You should review your <a href=\"modhist.php\">Moderated Messages</a> for more information.','$user','$datedate','$modname','0','$time')";
$result=mysql_query($sql);
$sql="UPDATE users SET notify=1 WHERE userid=$user";
$result=mysql_query($sql);
$sql="SELECT * FROM modded WHERE modid=$modid";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
if ($myrow["action"]==9) {
$sql="UPDATE modded SET action=5 WHERE modid=$modid";
$result=mysql_query($sql);
} else if ($myrow["action"]==10) {
$sql="UPDATE modded SET action=6 WHERE modid=$modid";
$result=mysql_query($sql);
}
} else if ($post=="Relax to Warning") {
$sql="SELECT * FROM users WHERE userid=$user";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$karma=$myrow["cookies"];
$karma=$karma-10;
$sql="UPDATE users SET cookies=$karma WHERE userid=$user";
$result=mysql_query($sql);
$sql="UPDATE users SET level=5 WHERE userid=$user";
$result=mysql_query($sql);
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$modname=$myrow["userid"];
$time=time();
$datedate=date("n/j/Y h:i:s A");
$sql="INSERT INTO systemnot (sysbod,sendto,sentat,sentfrom,`read`,sentsec) VALUES ('Your account has been <b>Warned</b> for one or more major TOS violations. Your account will be restored in 48 hours. You should review your <a href=\"modhist.php\">Moderated Messages</a> for more information.','$user','$datedate','$modname','0','$time')";
$result=mysql_query($sql);
$sql="UPDATE users SET notify=1 WHERE userid=$user";
$result=mysql_query($sql);
$sql="SELECT * FROM modded WHERE modid=$modid";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
if ($myrow["action"]==9) {
$sql="UPDATE modded SET action=7 WHERE modid=$modid";
$result=mysql_query($sql);
} else if ($myrow["action"]==10) {
$sql="UPDATE modded SET action=8 WHERE modid=$modid";
$result=mysql_query($sql);
}
} else if ($post=="...And clear profile") {
$sql="SELECT * FROM users WHERE userid=$user";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$karma=$myrow["cookies"];
$karma=$karma-10;
$sql="UPDATE users SET cookies=$karma WHERE userid=$user";
$result=mysql_query($sql);
$sql="UPDATE users SET level=5 WHERE userid=$user";
$result=mysql_query($sql);
$sql="UPDATE users SET sig='' WHERE userid=$user";
$result=mysql_query($sql);
$sql="UPDATE users SET quote='' WHERE userid=$user";
$result=mysql_query($sql);
$sql="UPDATE users SET im='' WHERE userid=$user";
$result=mysql_query($sql);
$sql="UPDATE users SET imtype=0 WHERE userid=$user";
$result=mysql_query($sql);
$sql="UPDATE users SET email2='' WHERE userid=$user";
$result=mysql_query($sql);
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$modname=$myrow["userid"];
$time=time();
$datedate=date("n/j/Y h:i:s A");
$sql="INSERT INTO systemnot (sysbod,sendto,sentat,sentfrom,`read`,sentsec) VALUES ('Your account has been <b>Warned</b> for one or more major TOS violations. Your account will be restored in 48 hours. You should review your <a href=\"modhist.php\">Moderated Messages</a> for more information.','$user','$datedate','$modname','0','$time')";
$result=mysql_query($sql);
$sql="UPDATE users SET notify=1 WHERE userid=$user";
$result=mysql_query($sql);
$sql="SELECT * FROM modded WHERE modid=$modid";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
if ($myrow["action"]==9) {
$sql="UPDATE modded SET action=7 WHERE modid=$modid";
$result=mysql_query($sql);
} else if ($myrow["action"]==10) {
$sql="UPDATE modded SET action=8 WHERE modid=$modid";
$result=mysql_query($sql);
}
} else if ($post=="                     Ban                     ") {
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$modname=$myrow["userid"];
$sql="UPDATE users SET level=-2 WHERE userid=$user";
$result=mysql_query($sql);
$time=time();
$datedate=date("n/j/Y h:i:s A");
$sql="INSERT INTO systemnot (sysbod,sendto,sentat,sentfrom,`read`,sentsec) VALUES ('Your account has been <b>Banned</b> for one or more major TOS violations. This is <b>permanent</b>, and will not be overturned. You should review your <a href=\"modhist.php\">Moderated Messages</a> for more information.','$user','$datedate','$modname','0','$time')";
$result=mysql_query($sql);
$sql="SELECT * FROM modded WHERE modid=$modid";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
if ($myrow["action"]==9) {
$sql="UPDATE modded SET action=11 WHERE modid=$modid";
$result=mysql_query($sql);
} else if ($myrow["action"]==10) {
$sql="UPDATE modded SET action=12 WHERE modid=$modid";
$result=mysql_query($sql);
}
} else if ($post=="Usermap Axe") {
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$modname=$myrow["userid"];
$sql="UPDATE users SET level=-2 WHERE userid=$user";
$result=mysql_query($sql);
$time=time();
$datedate=date("n/j/Y h:i:s A");
$sql="INSERT INTO systemnot (sysbod,sendto,sentat,sentfrom,`read`,sentsec) VALUES ('Your account has been <b>Banned</b> for one or more major TOS violations. This is <b>permanent</b>, and will not be overturned. You should review your <a href=\"modhist.php\">Moderated Messages</a> for more information.','$user','$datedate','$modname','0','$time')";
$result=mysql_query($sql);
$sql="UPDATE users SET notify=1 WHERE userid=$user";
$result=mysql_query($sql);
$sql="SELECT * FROM modded WHERE modid=$modid";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
if ($myrow["action"]==9) {
$sql="UPDATE modded SET action=11 WHERE modid=$modid";
$result=mysql_query($sql);
} else if ($myrow["action"]==10) {
$sql="UPDATE modded SET action=12 WHERE modid=$modid";
$result=mysql_query($sql);
}
$sql="SELECT * FROM users WHERE userid=$user";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$usernaem=$myrow["username"];
$sql="SELECT * FROM usermap WHERE userid1=$user";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$userid2=$myrow["userid2"];
if ($$userid2==1) {
$sql="UPDATE users SET level=-2 WHERE userid=$userid2";
$result2=mysql_query($sql);
$time=time();
$datedate=date("n/j/Y h:i:s A");
$sql="INSERT INTO systemnot (sysbod,sendto,sentat,sentfrom,`read`,sentsec) VALUES ('Your account has been <b>Banned</b> for the actions of your other account &quot;".$usernaem."&quot;. This is <b>permanent</b>, and will not be overturned.','$userid2','$datedate','$modname','0','$time')";
$result2=mysql_query($sql);
$sql="UPDATE users SET notify=1 WHERE userid=$userid2";
$result2=mysql_query($sql);
}
}
}
echo "<tr><td COLSPAN=2>
You have succesfully taken action on this suspended user.<p>

From here, you can:
<ul><li>Return to the <a HREF=\"index.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">Control Panel</a>.</li>

    <li>Return to the <a HREF=\"/boards/index.php\">Board List</a>.</li>

    <li>Go to the <a HREF=\"/boards/whois.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">Whois Page</a> of the user.</li></ul>

</td></tr>
</table>

</td></tr></table>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM modded WHERE moduser=$user AND action>=9 AND action<=10 ORDER BY modsec DESC LIMIT 0,1";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$numrows=mysql_num_rows($result);
$moduser=$myrow["moduser"];
$modby=$myrow["modby"];
$boardid=$myrow["boardid"];
$sql="SELECT * FROM users WHERE userid=$modby";
$resultc=mysql_query($sql);
$myrowc=@mysql_fetch_array($resultc);
$sql="SELECT * FROM users WHERE userid=$moduser";
$resulto=mysql_query($sql);
$myrowo=@mysql_fetch_array($resulto);
$sql="SELECT * FROM boards WHERE boardid=$boardid";
$resultx=mysql_query($sql);
$myrowx=@mysql_fetch_array($resultx);
$boardn=$myrowx["boardname"];

$topicid=$myrow["topicid"];


echo "<tr><td CLASS=CELL2><b>Board:</b> <a href=\"/boards/gentopic.php?board=".$myrow["boardid"]."\">$boardn</a> | <b>Topic:</b> ";
$sql="SELECT * FROM topics WHERE topicid=$topicid";
$resulttop=mysql_query($sql);
$numrowstop=@mysql_num_rows($resulttop);
if ($numrows>=1) {
$myrowtop=@mysql_fetch_array($resulttop);
echo "<a href=\"/boards/genmessage.php?board=".$myrowtop["boardnum"]."&topic=".$myrow["topicid"]."\">".$myrow["topicid"]." - ".stripslashes($myrow["topic"])."</a>";
} else {
echo "".$myrow["topicid"]." - ".stripslashes($myrow["topic"])."";
}
echo " | Moderation ID: ".$myrow["modid"]."</font></td></tr>
<tr><td CLASS=CELL2><b>From:</b> <a href=\"/boards/whois.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">".$myrowo["username"]."</a> | <b>Posted:</b> ".$myrow["postdate"]." | <b>Moderated by:</b> <a href=\"mods.php?user=".$myrowc["userid"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">".$myrowc["username"]."</a></font></td></tr>";
$reason=$myrow["reason"];
$sql="SELECT * FROM tos WHERE tosid=$reason";
$resultre=mysql_query($sql);
$myrowre=@mysql_fetch_array($resultre);
echo "<tr><td CLASS=CELL2><b>Moderated at:</b> ".$myrow["moddate"]." | <b>Reason:</b> ".$myrowre["ruletitle"]." |  <b>Action:</b> ";
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
echo "</font></td></tr>
<tr><td CLASS=CELL1>".stripslashes($myrow["modbod"])."</font></td></tr>
<tr><td CLASS=CELL2 align=CENTER><b>Options:</b> <a href=\"posthist.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">View Posted Messages</a> | <a href=\"modhist.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">View Moderation History</a> | <a href=\"aurahist.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">View Suggested History</a>
</td></tr>
<tr><td>
<form action=\"suspended.php?user=$user&modid=".$myrow["modid"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=post>
<table width=100% cellspacing=0 cellpadding=0 border=0><tr><td width=70% align=center>
<input type=\"submit\" name=\"post\" value=\"Restore\"><br>
<input type=\"submit\" name=\"post\" value=\"Relax to No Karma Loss\"><input type=\"submit\" name=\"post\" value=\"Relax to Notification\"><br>
<input type=\"submit\" name=\"post\" value=\"Relax to Warning\"><input type=\"submit\" name=\"post\" value=\"...And clear profile\"></td><td align=center><font size=3><b>Usermap</b></font><br><table border=1 cellspacing=0 width=100%><tr><td CLASS=CELL1 align=right colspan=2><a href=\"/boards/whois.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">".$myrowo["username"]."</a></td></tr>";
$sql="SELECT * FROM usermap WHERE userid1=$user";
$result=mysql_query($sql);
while ($myrow=mysql_fetch_array($result)) {
$userid2=$myrow["userid2"];
$sql="SELECT * FROM users WHERE userid='$userid2'";
$resultx=mysql_query($sql);
$myrowx=@mysql_fetch_array($resultx);
if ($myrowx["username"]) {
$userd=$myrowx["userid"];
echo "<tr><td CLASS=CELL1 align=left><input type=\"checkbox\" name=\"$userd\" value=\"1\" CHECKED></td><td CLASS=CELL1 align=right width=99%><a href=\"/boards/whois.php?user=$userd";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">".$myrowx["username"]."</a></td></tr>";
}
}
echo "</table></td></tr>
<tr><td align=center><input type=\"submit\" name=\"post\" value=\"                     Ban                     \"></td><td align=center><input type=\"submit\" name=\"post\" value=\"Usermap Axe\"></td></tr>
</form>
</table>
</td></tr></table>";
include("/home/mediarch/foot.php");
?>








