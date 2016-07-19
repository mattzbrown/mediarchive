<?
$pagetitle="Message Board Moderation";
include("/home/mediarch/head.php");
echo $harsss;
echo "<table border=0 width=100%>

<tr><td align=center colspan=2><font SIZE=6>Message Board Moderation</font></td></tr>";
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
echo "<tr><td colspan=2>You are not authorized to view this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
if ($myrow["level"]<50)
{
echo "<tr><td colspan=2>You are not authorized to view this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
$userid=$myrow["userid"];
$level=$myrow["level"];
$usern=$myrow["username"];
echo "<tr><td COLSPAN=2 CLASS=LITE ALIGN=center WIDTH=55%><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"/boards/gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"/boards/genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo " | <a HREF=\"modqueue.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Moderation Queue</a>
</i></font></td></tr>";

$sql="SELECT * FROM marked WHERE markid=$markid";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$numrows=@mysql_num_rows($result);
if ($numrows<=0) {

echo "<tr><td colspan=2>An invalid link was used to access this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
if (($myrow["markby"]==$userid) && ($level==50)) {
echo "<tr><td colspan=2>You cannot take action on messages that you have marked yourself.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM marked WHERE markid=$markid";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);

$numrows=mysql_num_rows($result);
$markwho=$myrow["markwho"];
$markby=$myrow["markby"];
$boardid=$myrow["board"];
$topicid=$myrow["topic"];
$messageid=$myrow["message"];
$sql="SELECT * FROM users WHERE userid=$markwho";
$resulto=mysql_query($sql);
$myrowo=@mysql_fetch_array($resulto);
$karma=$myrowo["cookies"];
$levvel=$myrow["level"];
$sql="SELECT * FROM secmarked WHERE markid=$markid";
$resulto=mysql_query($sql);
$marknum=@mysql_num_rows($resulto);
$sql="SELECT * FROM users WHERE userid=$markby";
$resulto=mysql_query($sql);
$myrowb=@mysql_fetch_array($resulto);
$sql="SELECT * FROM boards WHERE boardid=$boardid";
$resultx=mysql_query($sql);
$myrowx=@mysql_fetch_array($resultx);
$boardn=$myrowx["boardname"];
$sql="SELECT * FROM topics WHERE topicid=$topicid";
$resultx=mysql_query($sql);
$myrowx=@mysql_fetch_array($resultx);
$topicn=$myrowx["topicname"];
$sql="SELECT * FROM messages WHERE messageid=$messageid";
$resultx=mysql_query($sql);
$myrowm=@mysql_fetch_array($resultx);

$sql="SELECT * FROM messages WHERE topic=$topicid ORDER BY messsec ASC LIMIT 0,1";
$resultx=mysql_query($sql);
$myrowj=@mysql_fetch_array($resultx);
if ($myrowj["messageid"]==$messageid) { $origtopic=1; } else { $origtopic=0; }
$datedate=date("n/j/Y h:i:s A");
$time=time();
$endstr="<meta HTTP-EQUIV=\"refresh\" CONTENT=\"5; URL=modqueue.php";
if ($board) {$endstr.="?board=$board"; }
if ($topic) {$endstr.="&topic=$topic"; }
$endstr.="\">
<tr><td colspan=2>This message was successfully moderated. You will be returned to the moderation queue in five seconds. If not, click <a href=\"modqueue.php";
if ($board) {$endstr.="?board=$board"; }
if ($topic) {$endstr.="&topic=$topic"; }
$endstr.="\">here</a>.</td></tr>
</table>";
if ($topicmove) {
$sql="SELECT * FROM boards WHERE boardid=$topicmove";
$result5=mysql_query($sql);
$boardexist=@mysql_num_rows($result5);
}
if ($postno=="No Action") {
$sql="INSERT INTO modded
(boardid,topic,origtopic,topicid,messageid,modbod,modsec,moddate,postsec,postdate,moduser,modby,action,contest,contsec,contbody,recont,appealsec,recontbody,topmov,reason) VALUES ('".$myrow["board"]."','$topicn','$origtopic','$topicid','$messageid','".$myrowm["messbody"]."','$time','$datedate','".$myrowm["messsec"]."','".$myrowm["postdate"]."','".$myrow["markwho"]."','$userid','0','0','0','','0','0','','','$reason')";
$result=mysql_query($sql);
$sql="DELETE FROM marked WHERE markid=$markid";
$result=mysql_query($sql);
$sql="DELETE FROM secmarked WHERE markid=$markid";
$result=mysql_query($sql);
echo $endstr;
include("/home/mediarch/foot.php");
exit;
} else if ($postno=="Close Topic") {
$sql="INSERT INTO modded
(boardid,topic,origtopic,topicid,messageid,modbod,modsec,moddate,postsec,postdate,moduser,modby,action,contest,contsec,contbody,recont,appealsec,recontbody,topmov,reason) VALUES ('".$myrow["board"]."','$topicn','$origtopic','$topicid','$messageid','".$myrowm["messbody"]."','$time','$datedate','".$myrowm["messsec"]."','".$myrowm["postdate"]."','".$myrow["markwho"]."','$userid','1','0','0','','0','0','','','$reason')";
$result=mysql_query($sql);
$sql="UPDATE topics SET closed=1 WHERE topicid=$topicid";
$result=mysql_query($sql);
$sql="DELETE FROM marked WHERE markid=$markid";
$result=mysql_query($sql);
$sql="DELETE FROM secmarked WHERE markid=$markid";
$result=mysql_query($sql);
echo $endstr;
include("/home/mediarch/foot.php");
exit;
} else if ($postno=="Transfer To Suggest Queue") {
$sql="SELECT * FROM suggested WHERE message=".$myrow["message"]."";
$resultnm=mysql_query($sql);
$numrowsnm=@mysql_num_rows($resultnm);
if ($numrowsnm>=1) {
$sql="INSERT INTO suggested (reason,suggestwho,message,topic,board,reason2,suggestby,suggestsec,suggestdate) VALUES ('".$myrow["reason"]."','".$myrow["markwho"]."','".$myrow["message"]."','".$myrow["topic"]."','".$myrow["board"]."','".addslashes($myrow["reason2"])."','".$myrow["markby"]."','".$myrow["marksec"]."','".$myrow["markdate"]."')";
$result=mysql_query($sql);
$sqlsm="SELECT * FROM secsuggested WHERE suggestid=$suggestid ORDER BY suggestsec ASC";
$resultsm=mysql_query($sqlsm);
while ($myrowsm=@mysql_fetch_array($resultsm)) {
$sql="INSERT INTO secsuggested (suggestid,reason,suggestwho,message,topic,board,reason2,suggestby,suggestsec,suggestdate) VALUES ('".$myrownm["messageid"]."','".$myrowsm["reason"]."','".$myrowsm["markwho"]."','".$myrowsm["message"]."','".$myrowsm["topic"]."','".$myrowsm["board"]."','".addslashes($myrowsm["reason2"])."','".$myrowsm["markby"]."','".$myrowsm["marksec"]."','".$myrowsm["markdate"]."')";
$result=mysql_query($sql);
}
}
$sql="SELECT * FROM suggested WHERE message=".$myrow["message"]."";
$resultnm=mysql_query($sql);
$myrownm=@mysql_fetch_array($resultnm);
$sql="DELETE FROM marked WHERE markid=$markid";
$result=mysql_query($sql);
$sql="DELETE FROM secmarked WHERE markid=$markid";
$result=mysql_query($sql);
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"5; URL=sugact.php?suggestid=".$myrownm["suggestid"];
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\"><tr><td colspan=2>This message was successfully moved. You will be redirected to the moved message in five seconds. If not, click <a href=\"sugact.php?suggestid=".$myrownm["suggestid"];
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">here</a>.</td></tr></table>";
include("/home/mediarch/foot.php");
exit;
} else if (($postno=="Move Topic") && ($boardexist>=1) && ($origtopic==1)) {
$sql="INSERT INTO modded
(boardid,topic,origtopic,topicid,messageid,modbod,modsec,moddate,postsec,postdate,moduser,modby,action,contest,contsec,contbody,recont,appealsec,recontbody,topmov,reason) VALUES ('".$myrow["board"]."','$topicn','$origtopic','$topicid','$messageid','".$myrowm["messbody"]."','$time','$datedate','".$myrowm["messsec"]."','".$myrowm["postdate"]."','".$myrow["markwho"]."','$userid','2','0','0','','0','0','','','$reason')";
$result=mysql_query($sql);
$sql="SELECT * FROM boards WHERE boardid=$topicmove";
$result5=mysql_query($sql);
$myrow5=@mysql_fetch_array($result5);
$boardn2=$myrow5["boardname"];
$sql="UPDATE users SET notify=1 WHERE userid=$markwho";
$result=mysql_query($sql);
$sql="INSERT INTO systemnot (sysbod,sendto,sentat,sentfrom,`read`,sentsec) VALUES ('Your topic entitled &quot;".stripslashes($topicn)."&quot; has been moved from $boardn to $boardn2.','".$myrow["markwho"]."','$datedate','$userid','0','$time')";
$result=mysql_query($sql);
$sql="UPDATE topics SET boardnum=$topicmove WHERE topicid=$topicid";
$result=mysql_query($sql);
$sql="UPDATE messages SET mesboard=$topicmove WHERE topic=$topicid";
$result=mysql_query($sql);
$sql="DELETE FROM marked WHERE markid=$markid";
$result=mysql_query($sql);
$sql="DELETE FROM secmarked WHERE markid=$markid";
$result=mysql_query($sql);
echo $endstr;
include("/home/mediarch/foot.php");
exit;
} else if (($postno=="Move Topic") && ($boardexist<=0) && ($origtopic==1)) {
echo "<tr><td colspan=2><b>There was an error moving this topic:</b> The board number provided is not valid.</td></tr>";
} else if (($postmes=="No Karma Loss") && ($origtopic==0)) {
$sql="INSERT INTO modded
(boardid,topic,origtopic,topicid,messageid,modbod,modsec,moddate,postsec,postdate,moduser,modby,action,contest,contsec,contbody,recont,appealsec,recontbody,topmov,reason) VALUES ('".$myrow["board"]."','$topicn','$origtopic','$topicid','$messageid','".$myrowm["messbody"]."','$time','$datedate','".$myrowm["messsec"]."','".$myrowm["postdate"]."','".$myrow["markwho"]."','$userid','3','0','0','','0','0','','','$reason')";
$result=mysql_query($sql);
$sql="UPDATE messages SET messbody='[This message was deleted by ".$usern."]' WHERE messageid=$messageid";
$result=mysql_query($sql);
$sql="DELETE FROM marked WHERE markid=$markid";
$result=mysql_query($sql);
$sql="DELETE FROM secmarked WHERE markid=$markid";
$result=mysql_query($sql);
echo $endstr;
include("/home/mediarch/foot.php");
exit;
} else if (($postmes=="Notify") && ($origtopic==0)) {
$sql="INSERT INTO modded
(boardid,topic,origtopic,topicid,messageid,modbod,modsec,moddate,postsec,postdate,moduser,modby,action,contest,contsec,contbody,recont,appealsec,recontbody,topmov,reason) VALUES ('".$myrow["board"]."','$topicn','$origtopic','$topicid','$messageid','".$myrowm["messbody"]."','$time','$datedate','".$myrowm["messsec"]."','".$myrowm["postdate"]."','".$myrow["markwho"]."','$userid','5','0','0','','0','0','','','$reason')";
$result=mysql_query($sql);
$sql="UPDATE users SET notify=1 WHERE userid=$markwho";
$result=mysql_query($sql);
$karma=$karma-3;
$sql="UPDATE users SET cookies=$karma WHERE userid=$markwho";
$result=mysql_query($sql);
if (($levvel>=6) && ($levvel<40)) {
if ($karma<0) {
$sql="UPDATE users SET level=6 WHERE userid=$markwho";
$result=mysql_query($sql);
} else if (($karma>=0) && ($karma<10)) {
$sql="UPDATE users SET level=15 WHERE userid=$markwho";
$result=mysql_query($sql);
} else if (($karma>=10) && ($karma<20)) {
$sql="UPDATE users SET level=20 WHERE userid=$markwho";
$result=mysql_query($sql);
} else if (($karma>=20) && ($karma<40)) {
$sql="UPDATE users SET level=25 WHERE userid=$markwho";
$result=mysql_query($sql);
} else if (($karma>=40) && ($karma<75)) {
$sql="UPDATE users SET level=30 WHERE userid=$markwho";
$result=mysql_query($sql);
} else if (($karma>=75) && ($karma<120)) {
$sql="UPDATE users SET level=31 WHERE userid=$markwho";
$result=mysql_query($sql);
} else if (($karma>=120) && ($karma<150)) {
$sql="UPDATE users SET level=32 WHERE userid=$markwho";
$result=mysql_query($sql);
} else if (($karma>=150) && ($karma<200)) {
$sql="UPDATE users SET level=33 WHERE userid=$markwho";
$result=mysql_query($sql);
} else if (($karma>=200) && ($karma<250)) {
$sql="UPDATE users SET level=34 WHERE userid=$markwho";
$result=mysql_query($sql);
} else if ($karma>=250) {
$sql="UPDATE users SET level=35 WHERE userid=$markwho";
$result=mysql_query($sql);
}
}
$sql="INSERT INTO systemnot (sysbod,sendto,sentat,sentfrom,`read`,sentsec) VALUES ('Your account has been <b>Notified</b> for one or more TOS violations. This is considered a standard moderation and comes with a loss of 3 karma. You should review your <a href=\"modhist.php\">Moderated Messages</a> for more information.','".$myrow["markwho"]."','$datedate','$userid','0','$time')";
$result=mysql_query($sql);
$sql="UPDATE messages SET messbody='[This message was deleted by ".$usern."]' WHERE messageid=$messageid";
$result=mysql_query($sql);
$sql="DELETE FROM marked WHERE markid=$markid";
$result=mysql_query($sql);
$sql="DELETE FROM secmarked WHERE markid=$markid";
$result=mysql_query($sql);
echo $endstr;
include("/home/mediarch/foot.php");
exit;
} else if (($postmes=="Warn") && ($origtopic==0)) {
$sql="INSERT INTO modded
(boardid,topic,origtopic,topicid,messageid,modbod,modsec,moddate,postsec,postdate,moduser,modby,action,contest,contsec,contbody,recont,appealsec,recontbody,topmov,reason) VALUES ('".$myrow["board"]."','$topicn','$origtopic','$topicid','$messageid','".$myrowm["messbody"]."','$time','$datedate','".$myrowm["messsec"]."','".$myrowm["postdate"]."','".$myrow["markwho"]."','$userid','7','0','0','','0','0','','','$reason')";
$result=mysql_query($sql);
$sql="UPDATE users SET notify=1 WHERE userid=$markwho";
$result=mysql_query($sql);
$karma=$karma-10;
$sql="UPDATE users SET cookies=$karma WHERE userid=$markwho";
$result=mysql_query($sql);
$sql="UPDATE users SET level=5 WHERE userid=$markwho";
$result=mysql_query($sql);
$sql="INSERT INTO systemnot (sysbod,sendto,sentat,sentfrom,`read`,sentsec) VALUES ('Your account has been <b>Warned</b> for one or more major TOS violations. Your account will be restored in 48 hours. You should review your <a href=\"modhist.php\">Moderated Messages</a> for more information.','".$myrow["markwho"]."','$datedate','$userid','0','$time')";
$result=mysql_query($sql);
$sql="UPDATE messages SET messbody='[This message was deleted by ".$usern."]' WHERE messageid=$messageid";
$result=mysql_query($sql);
$sql="DELETE FROM marked WHERE markid=$markid";
$result=mysql_query($sql);
$sql="DELETE FROM secmarked WHERE markid=$markid";
$result=mysql_query($sql);
echo $endstr;
include("/home/mediarch/foot.php");
exit;
} else if (($postmes=="Suspend") && ($origtopic==0)) {
$sql="INSERT INTO modded
(boardid,topic,origtopic,topicid,messageid,modbod,modsec,moddate,postsec,postdate,moduser,modby,action,contest,contsec,contbody,recont,appealsec,recontbody,topmov,reason) VALUES ('".$myrow["board"]."','$topicn','$origtopic','$topicid','$messageid','".$myrowm["messbody"]."','$time','$datedate','".$myrowm["messsec"]."','".$myrowm["postdate"]."','".$myrow["markwho"]."','$userid','9','0','0','','0','0','','','$reason')";
$result=mysql_query($sql);
$sql="UPDATE users SET notify=1 WHERE userid=$markwho";
$result=mysql_query($sql);
$sql="UPDATE users SET level=-1 WHERE userid=$markwho";
$result=mysql_query($sql);
$sql="INSERT INTO systemnot (sysbod,sendto,sentat,sentfrom,`read`,sentsec) VALUES ('Your account has been <b>Suspended</b> for one or more major TOS violations. Your account will be reviewed within the next 24 hours. You should review your <a href=\"modhist.php\">Moderated Messages</a> for more information.','".$myrow["markwho"]."','$datedate','$userid','0','$time')";
$result=mysql_query($sql);
$sql="UPDATE messages SET messbody='[This message was deleted by ".$usern."]' WHERE messageid=$messageid";
$result=mysql_query($sql);
$sql="DELETE FROM marked WHERE markid=$markid";
$result=mysql_query($sql);
$sql="DELETE FROM secmarked WHERE markid=$markid";
$result=mysql_query($sql);
echo $endstr;
include("/home/mediarch/foot.php");
exit;
} else if ($posttop=="No Karma Loss") {
$sql="INSERT INTO modded
(boardid,topic,origtopic,topicid,messageid,modbod,modsec,moddate,postsec,postdate,moduser,modby,action,contest,contsec,contbody,recont,appealsec,recontbody,topmov,reason) VALUES ('".$myrow["board"]."','$topicn','$origtopic','$topicid','$messageid','".$myrowm["messbody"]."','$time','$datedate','".$myrowm["messsec"]."','".$myrowm["postdate"]."','".$myrow["markwho"]."','$userid','4','0','0','','0','0','','','$reason')";
$result=mysql_query($sql);
$sql="SELECT * FROM messages WHERE topic=$topicid";
$resulttop=mysql_query($sql);
while ($myrowtop=@mysql_fetch_array($resulttop)) {
$sql="INSERT INTO deleted (messageid,topic,messby,messsec,messbody,mesboard,postdate) VALUES ('".$myrowtop["messageid"]."','".$myrowtop["topic"]."','".$myrowtop["messby"]."','".$myrowtop["messsec"]."','".$myrowtop["messbody"]."','".$myrowtop["mesboard"]."','".$myrowtop["postdate"]."')";
$result=mysql_query($sql);
}
$sql="DELETE FROM messages WHERE topic=$topicid";
$result=mysql_query($sql);
$sql="DELETE FROM topics WHERE topicid=$topicid";
$result=mysql_query($sql);
$sql="DELETE FROM secmarked WHERE topic=$topicid";
$result=mysql_query($sql);
$sql="DELETE FROM marked WHERE topic=$topicid";
$result=mysql_query($sql);
$sql="DELETE FROM marked WHERE markid=$markid";
$result=mysql_query($sql);
$sql="DELETE FROM secmarked WHERE markid=$markid";
$result=mysql_query($sql);
echo $endstr;
include("/home/mediarch/foot.php");
exit;
} else if ($posttop=="Notify") {
$sql="INSERT INTO modded
(boardid,topic,origtopic,topicid,messageid,modbod,modsec,moddate,postsec,postdate,moduser,modby,action,contest,contsec,contbody,recont,appealsec,recontbody,topmov,reason) VALUES ('".$myrow["board"]."','$topicn','$origtopic','$topicid','$messageid','".$myrowm["messbody"]."','$time','$datedate','".$myrowm["messsec"]."','".$myrowm["postdate"]."','".$myrow["markwho"]."','$userid','6','0','0','','0','0','','','$reason')";
$result=mysql_query($sql);
$sql="SELECT * FROM messages WHERE topic=$topicid";
$resulttop=mysql_query($sql);
while ($myrowtop=@mysql_fetch_array($resulttop)) {
$sql="INSERT INTO deleted (messageid,topic,messby,messsec,messbody,mesboard,postdate) VALUES ('".$myrowtop["messageid"]."','".$myrowtop["topic"]."','".$myrowtop["messby"]."','".$myrowtop["messsec"]."','".$myrowtop["messbody"]."','".$myrowtop["mesboard"]."','".$myrowtop["postdate"]."')";
$result=mysql_query($sql);
}
$sql="DELETE FROM messages WHERE topic=$topicid";
$result=mysql_query($sql);
$sql="DELETE FROM topics WHERE topicid=$topicid";
$result=mysql_query($sql);
$sql="DELETE FROM secmarked WHERE topic=$topicid";
$result=mysql_query($sql);
$sql="DELETE FROM marked WHERE topic=$topicid";
$result=mysql_query($sql);
$sql="UPDATE users SET notify=1 WHERE userid=$markwho";
$result=mysql_query($sql);
$karma=$karma-3;
$sql="UPDATE users SET cookies=$karma WHERE userid=$markwho";
$result=mysql_query($sql);
if (($levvel>=6) && ($levvel<40)) {
if ($karma<0) {
$sql="UPDATE users SET level=6 WHERE userid=$markwho";
$result=mysql_query($sql);
} else if (($karma>=0) && ($karma<10)) {
$sql="UPDATE users SET level=15 WHERE userid=$markwho";
$result=mysql_query($sql);
} else if (($karma>=10) && ($karma<20)) {
$sql="UPDATE users SET level=20 WHERE userid=$markwho";
$result=mysql_query($sql);
} else if (($karma>=20) && ($karma<40)) {
$sql="UPDATE users SET level=25 WHERE userid=$markwho";
$result=mysql_query($sql);
} else if (($karma>=40) && ($karma<75)) {
$sql="UPDATE users SET level=30 WHERE userid=$markwho";
$result=mysql_query($sql);
} else if (($karma>=75) && ($karma<120)) {
$sql="UPDATE users SET level=31 WHERE userid=$markwho";
$result=mysql_query($sql);
} else if (($karma>=120) && ($karma<150)) {
$sql="UPDATE users SET level=32 WHERE userid=$markwho";
$result=mysql_query($sql);
} else if (($karma>=150) && ($karma<200)) {
$sql="UPDATE users SET level=33 WHERE userid=$markwho";
$result=mysql_query($sql);
} else if (($karma>=200) && ($karma<250)) {
$sql="UPDATE users SET level=34 WHERE userid=$markwho";
$result=mysql_query($sql);
} else if ($karma>=250) {
$sql="UPDATE users SET level=35 WHERE userid=$markwho";
$result=mysql_query($sql);
}
}
$sql="INSERT INTO systemnot (sysbod,sendto,sentat,sentfrom,`read`,sentsec) VALUES ('Your account has been <b>Notified</b> for one or more TOS violations. This is considered a standard moderation and comes with a loss of 3 karma. You should review your <a href=\"modhist.php\">Moderated Messages</a> for more information.','".$myrow["markwho"]."','$datedate','$userid','0','$time')";
$result=mysql_query($sql);
$sql="DELETE FROM marked WHERE markid=$markid";
$result=mysql_query($sql);
$sql="DELETE FROM secmarked WHERE markid=$markid";
$result=mysql_query($sql);
echo $endstr;
include("/home/mediarch/foot.php");
exit;
} else if ($posttop=="Warn") {
$sql="INSERT INTO modded
(boardid,topic,origtopic,topicid,messageid,modbod,modsec,moddate,postsec,postdate,moduser,modby,action,contest,contsec,contbody,recont,appealsec,recontbody,topmov,reason) VALUES ('".$myrow["board"]."','$topicn','$origtopic','$topicid','$messageid','".$myrowm["messbody"]."','$time','$datedate','".$myrowm["messsec"]."','".$myrowm["postdate"]."','".$myrow["markwho"]."','$userid','8','0','0','','0','0','','','$reason')";
$result=mysql_query($sql);
$sql="SELECT * FROM messages WHERE topic=$topicid";
$resulttop=mysql_query($sql);
while ($myrowtop=@mysql_fetch_array($resulttop)) {
$sql="INSERT INTO deleted (messageid,topic,messby,messsec,messbody,mesboard,postdate) VALUES ('".$myrowtop["messageid"]."','".$myrowtop["topic"]."','".$myrowtop["messby"]."','".$myrowtop["messsec"]."','".$myrowtop["messbody"]."','".$myrowtop["mesboard"]."','".$myrowtop["postdate"]."')";
$result=mysql_query($sql);
}
$sql="DELETE FROM messages WHERE topic=$topicid";
$result=mysql_query($sql);
$sql="DELETE FROM topics WHERE topicid=$topicid";
$result=mysql_query($sql);
$sql="DELETE FROM secmarked WHERE topic=$topicid";
$result=mysql_query($sql);
$sql="DELETE FROM marked WHERE topic=$topicid";
$result=mysql_query($sql);
$sql="UPDATE users SET notify=1 WHERE userid=$markwho";
$result=mysql_query($sql);
$karma=$karma-10;
$sql="UPDATE users SET cookies=$karma WHERE userid=$markwho";
$result=mysql_query($sql);
$sql="UPDATE users SET level=5 WHERE userid=$markwho";
$result=mysql_query($sql);
$sql="INSERT INTO systemnot (sysbod,sendto,sentat,sentfrom,`read`,sentsec) VALUES ('Your account has been <b>Warned</b> for one or more major TOS violations. Your account will be restored in 48 hours. You should review your <a href=\"modhist.php\">Moderated Messages</a> for more information.','".$myrow["markwho"]."','$datedate','$userid','0','$time')";
$result=mysql_query($sql);
$sql="DELETE FROM marked WHERE markid=$markid";
$result=mysql_query($sql);
$sql="DELETE FROM secmarked WHERE markid=$markid";
$result=mysql_query($sql);
echo $endstr;
include("/home/mediarch/foot.php");
exit;
} else if ($posttop=="Suspend") {
$sql="INSERT INTO modded
(boardid,topic,origtopic,topicid,messageid,modbod,modsec,moddate,postsec,postdate,moduser,modby,action,contest,contsec,contbody,recont,appealsec,recontbody,topmov,reason) VALUES ('".$myrow["board"]."','$topicn','$origtopic','$topicid','$messageid','".$myrowm["messbody"]."','$time','$datedate','".$myrowm["messsec"]."','".$myrowm["postdate"]."','".$myrow["markwho"]."','$userid','10','0','0','','0','0','','','$reason')";
$result=mysql_query($sql);
$sql="SELECT * FROM messages WHERE topic=$topicid";
$resulttop=mysql_query($sql);
while ($myrowtop=@mysql_fetch_array($resulttop)) {
$sql="INSERT INTO deleted (messageid,topic,messby,messsec,messbody,mesboard,postdate) VALUES ('".$myrowtop["messageid"]."','".$myrowtop["topic"]."','".$myrowtop["messby"]."','".$myrowtop["messsec"]."','".$myrowtop["messbody"]."','".$myrowtop["mesboard"]."','".$myrowtop["postdate"]."')";
$result=mysql_query($sql);
}
$sql="DELETE FROM messages WHERE topic=$topicid";
$result=mysql_query($sql);
$sql="DELETE FROM topics WHERE topicid=$topicid";
$result=mysql_query($sql);
$sql="DELETE FROM secmarked WHERE topic=$topicid";
$result=mysql_query($sql);
$sql="DELETE FROM marked WHERE topic=$topicid";
$result=mysql_query($sql);
$sql="UPDATE users SET notify=1 WHERE userid=$markwho";
$result=mysql_query($sql);
$sql="UPDATE users SET level=-1 WHERE userid=$markwho";
$result=mysql_query($sql);
$sql="INSERT INTO systemnot (sysbod,sendto,sentat,sentfrom,`read`,sentsec) VALUES ('Your account has been <b>Suspended</b> for one or more major TOS violations. Your account will be reviewed within the next 24 hours. You should review your <a href=\"modhist.php\">Moderated Messages</a> for more information.','".$myrow["markwho"]."','$datedate','$userid','0','$time')";
$result=mysql_query($sql);
$sql="DELETE FROM marked WHERE markid=$markid";
$result=mysql_query($sql);
$sql="DELETE FROM secmarked WHERE markid=$markid";
$result=mysql_query($sql);
echo $endstr;
include("/home/mediarch/foot.php");
exit;
}


$reason2=$myrow["reason"];
$sql="SELECT * FROM tos WHERE tosid=$reason2";
$resultre=mysql_query($sql);
$myrowre=@mysql_fetch_array($resultre);

echo "<tr><td CLASS=CELL2 colspan=2><b>Board:</b> <a href=\"/boards/gentopic.php?board=".$myrow["board"]."\">$boardn</a> | <b>Topic:</b> <a href=\"/boards/genmessage.php?board=".$myrow["board"]."&topic=".$myrow["topic"]."\">".$myrow["topic"]." - ".stripslashes($topicn)."</a> | Mark ID: $markid</font></td></tr>
<tr><td CLASS=CELL2 colspan=2><b>From:</b> <a href=\"/boards/whois.php?user=".$myrow["markwho"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">".$myrowo["username"]."</a> | <b>Posted:</b> ".date("n/j/Y h:i:s A",$myrowm["messsec"])." | <b>Marked by:</b> <a href=\"/boards/whois.php?user=".$myrow["markby"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">".$myrowb["username"]."</a></font></td></tr>
<tr><td CLASS=CELL2 colspan=2><b>Marked at:</b> ".date("n/j/Y h:i:s A",$myrow["marksec"])." | <b>Number of Marks:</b> <a href=\"viewmarks.php?markid=$markid";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">".$marknum."</a> | <b>Reason Marked:</b> ".$myrowre["ruletitle"];
if ($myrowre["ruletitle"]=="Other") { echo ": ".stripslashes($myrow["reason2"]); }
echo "</font></td></tr>
<tr><td CLASS=CELL1 colspan=2>".stripslashes($myrowm["messbody"])."</font></td></tr>
<tr><td CLASS=CELL2 align=CENTER colspan=2><b>Options:</b> <a href=\"posthist.php?user=$markwho";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">View Posted Messages</a> | <a href=\"modhist.php?user=$markwho";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">View Moderation History</a> | <a href=\"aurahist.php?user=$markwho";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">View Suggested History</a> | <a href=\"usermap.php?user=$markwho";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">View Usermap</a>
</td></tr>";
if ($myrowo["level"]==5) {
echo "<tr><td CLASS=SYS colspan=2>This user is currently <b>warned</b>.</td></tr>";
} else if ($myrowo["level"]==6) {
echo "<tr><td CLASS=SYS colspan=2>This user currently has <b>negative karma</b>.</td></tr>";
}
echo "<form action=\"modact.php?markid=$markid";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td width=25%><b>Reason for Moderation</b></td><td><select name=\"reason\">
<option value=\"".$myrow["reason"]."\">".$myrowre["ruletitle"]." (Current)</option>";
$sql="SELECT * FROM tos ORDER BY tosid";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
echo "<option value=\"".$myrow["tosid"]."\">".$myrow["ruletitle"]."</option>";
}
echo "</select></td></tr>
<tr><td><b>No Action</b></td><td><input type=\"submit\" name=\"postno\" value=\"No Action\"><input type=\"submit\" name=\"postno\" value=\"Close Topic\"><input type=\"submit\" name=\"postno\" value=\"Transfer To Suggest Queue\">";
if ($origtopic>=1) { 
echo "<input type=\"submit\" name=\"postno\" value=\"Move Topic\"><input type=\"text\" name=\"topicmove\" size=\"5\" maxlength=\"40\">";
}
echo "</td></tr>";
if ($origtopic<=0) {
echo "<tr><td><b>Delete Message</b></td><td><input type=\"submit\" name=\"postmes\" value=\"No Karma Loss\"><input type=\"submit\" name=\"postmes\" value=\"Notify\"><input type=\"submit\" name=\"postmes\" value=\"Warn\"><input type=\"submit\" name=\"postmes\" value=\"Suspend\"></td></tr>";
}
echo "<tr><td><b>Delete Topic</b></td><td><input type=\"submit\" name=\"posttop\" value=\"No Karma Loss\"><input type=\"submit\" name=\"posttop\" value=\"Notify\"><input type=\"submit\" name=\"posttop\" value=\"Warn\"><input type=\"submit\" name=\"posttop\" value=\"Suspend\"></td></tr>
</form>
<tr><td align=center>
</table>";
include("/home/mediarch/foot.php");
?>
