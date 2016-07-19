<?
$pagetitle="Message Board Suggestion";
include("/home/mediarch/head.php");
echo $harsss;
echo "<table border=0 width=100%>

<tr><td align=center colspan=2><font SIZE=6>Message Board Suggestion</font></td></tr>";
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
echo "<tr><td COLSPAN=2 CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"/boards/gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"/boards/genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo " | <a HREF=\"sugqueue.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Suggestion Queue</a>
</i></font></td></tr>";

$sql="SELECT * FROM suggested WHERE suggestid=$suggestid";
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
if (($myrow["suggestby"]==$userid) && ($level==50)) {
echo "<tr><td colspan=2>You cannot take action on mesages that you have suggested yourself.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM suggested WHERE suggestid=$suggestid";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);

$numrows=mysql_num_rows($result);
$suggestwho=$myrow["suggestwho"];
$suggestby=$myrow["suggestby"];
$boardid=$myrow["board"];
$topicid=$myrow["topic"];
$messageid=$myrow["message"];
$sql="SELECT * FROM users WHERE userid=$suggestwho";
$resulto=mysql_query($sql);
$myrowo=@mysql_fetch_array($resulto);
$aura=$myrowo["aura"];
$levvel=$myrow["level"];
$sql="SELECT * FROM secsuggested WHERE suggestid=$suggestid";
$resulto=mysql_query($sql);
$suggestnum=@mysql_num_rows($resulto);
$sql="SELECT * FROM users WHERE userid=$suggestby";
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
$endstr="<meta HTTP-EQUIV=\"refresh\" CONTENT=\"5; URL=sugqueue.php";
if ($board) {$endstr.="?board=$board"; }
if ($topic) {$endstr.="&topic=$topic"; }
$endstr.="\">
<tr><td colspan=2>This message was successfully moderated. You will be returned to the suggestion queue in five seconds. If not, click <a href=\"sugqueue.php";
if ($board) {$endstr.="?board=$board"; }
if ($topic) {$endstr.="&topic=$topic"; }
$endstr.="\">here</a>.</td></tr>
</table>
";
if ($topicmove) {
$sql="SELECT * FROM boards WHERE boardid=$topicmove";
$result5=mysql_query($sql);
$boardexist=@mysql_num_rows($result5);
}
if ($postno=="No Action") {
$sql="INSERT INTO auraed
(boardid,topic,origtopic,topicid,messageid,aurabod,aurasec,auradate,postsec,postdate,aurauser,auraby,action,reason) VALUES ('".$myrow["board"]."','$topicn','$origtopic','$topicid','$messageid','".$myrowm["messbody"]."','$time','$datedate','".$myrowm["messsec"]."','".$myrowm["postdate"]."','".$myrow["suggestwho"]."','$userid','0','$reason')";
$result=mysql_query($sql);
$sql="DELETE FROM suggested WHERE suggestid=$suggestid";
$result=mysql_query($sql);
$sql="DELETE FROM secsuggested WHERE suggestid=$suggestid";
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
} else if ($postno=="Transfer To Moderation Queue") {
$sql="SELECT * FROM marked WHERE message=".$myrow["message"]."";
$resultnm=mysql_query($sql);
$numrowsnm=@mysql_num_rows($resultnm);
if ($numrowsnm>=1) {
$sql="INSERT INTO marked (reason,markwho,message,topic,board,reason2,markby,marksec,markdate) VALUES ('".$myrow["reason"]."','".$myrow["suggestwho"]."','".$myrow["message"]."','".$myrow["topic"]."','".$myrow["board"]."','".addslashes($myrow["reason2"])."','".$myrow["suggestby"]."','".$myrow["suggestsec"]."','".$myrow["suggestdate"]."')";
$result=mysql_query($sql);
$sqlsm="SELECT * FROM secmarked WHERE markid=$markid ORDER BY marksec ASC";
$resultsm=mysql_query($sqlsm);
while ($myrowsm=@mysql_fetch_array($resultsm)) {
$sql="INSERT INTO secmarked (markid,reason,markwho,message,topic,board,reason2,markby,marksec,markdate) VALUES ('".$myrownm["messageid"]."','".$myrowsm["reason"]."','".$myrowsm["suggestwho"]."','".$myrowsm["message"]."','".$myrowsm["topic"]."','".$myrowsm["board"]."','".addslashes($myrowsm["reason2"])."','".$myrowsm["suggestby"]."','".$myrowsm["suggestsec"]."','".$myrowsm["suggestdate"]."')";
$result=mysql_query($sql);
}
}
$sql="SELECT * FROM marked WHERE message=".$myrow["message"]."";
$resultnm=mysql_query($sql);
$myrownm=@mysql_fetch_array($resultnm);
$sql="DELETE FROM suggested WHERE suggestid=$suggestid";
$result=mysql_query($sql);
$sql="DELETE FROM secsuggested WHERE suggestid=$suggestid";
$result=mysql_query($sql);
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"5; URL=modact.php?markid=".$myrownm["markid"];
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\"><tr><td colspan=2>This message was successfully moved. You will be redirected to the moved message in five seconds. If not, click <a href=\"modact.php?markid=".$myrownm["markid"];
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">here</a>.</td></tr></table>";
include("/home/mediarch/foot.php");
exit;
} else if ($postadd=="+1 Aura") {
$sql="INSERT INTO auraed
(boardid,topic,origtopic,topicid,messageid,aurabod,aurasec,auradate,postsec,postdate,aurauser,auraby,action,reason) VALUES ('".$myrow["board"]."','$topicn','$origtopic','$topicid','$messageid','".$myrowm["messbody"]."','$time','$datedate','".$myrowm["messsec"]."','".$myrowm["postdate"]."','".$myrow["suggestwho"]."','$userid','1','$reason')";
$result=mysql_query($sql);
$aura=$aura+1;
$sql="UPDATE users SET aura=$aura WHERE userid=$suggestwho";
$result=mysql_query($sql);
$sql="DELETE FROM suggested WHERE suggestid=$suggestid";
$result=mysql_query($sql);
$sql="DELETE FROM secsuggested WHERE suggestid=$suggestid";
$result=mysql_query($sql);
echo $endstr;
include("/home/mediarch/foot.php");
exit;
} else if ($postadd=="+3 Aura") {
$sql="INSERT INTO auraed
(boardid,topic,origtopic,topicid,messageid,aurabod,aurasec,auradate,postsec,postdate,aurauser,auraby,action,reason) VALUES ('".$myrow["board"]."','$topicn','$origtopic','$topicid','$messageid','".$myrowm["messbody"]."','$time','$datedate','".$myrowm["messsec"]."','".$myrowm["postdate"]."','".$myrow["suggestwho"]."','$userid','2','$reason')";
$result=mysql_query($sql);
$aura=$aura+3;
$sql="UPDATE users SET aura=$aura WHERE userid=$suggestwho";
$result=mysql_query($sql);
$sql="DELETE FROM suggested WHERE suggestid=$suggestid";
$result=mysql_query($sql);
$sql="DELETE FROM secsuggested WHERE suggestid=$suggestid";
$result=mysql_query($sql);
echo $endstr;
include("/home/mediarch/foot.php");
exit;
} else if ($postadd=="+5 Aura") {
$sql="INSERT INTO auraed
(boardid,topic,origtopic,topicid,messageid,aurabod,aurasec,auradate,postsec,postdate,aurauser,auraby,action,reason) VALUES ('".$myrow["board"]."','$topicn','$origtopic','$topicid','$messageid','".$myrowm["messbody"]."','$time','$datedate','".$myrowm["messsec"]."','".$myrowm["postdate"]."','".$myrow["suggestwho"]."','$userid','3','$reason')";
$result=mysql_query($sql);
$aura=$aura+5;
$sql="UPDATE users SET aura=$aura WHERE userid=$suggestwho";
$result=mysql_query($sql);
$sql="DELETE FROM suggested WHERE suggestid=$suggestid";
$result=mysql_query($sql);
$sql="DELETE FROM secsuggested WHERE suggestid=$suggestid";
$result=mysql_query($sql);
echo $endstr;
include("/home/mediarch/foot.php");
exit;
} else if ($postadd=="+10 Aura") {
$sql="INSERT INTO auraed
(boardid,topic,origtopic,topicid,messageid,aurabod,aurasec,auradate,postsec,postdate,aurauser,auraby,action,reason) VALUES ('".$myrow["board"]."','$topicn','$origtopic','$topicid','$messageid','".$myrowm["messbody"]."','$time','$datedate','".$myrowm["messsec"]."','".$myrowm["postdate"]."','".$myrow["suggestwho"]."','$userid','4','$reason')";
$result=mysql_query($sql);
$aura=$aura+10;
$sql="UPDATE users SET aura=$aura WHERE userid=$suggestwho";
$result=mysql_query($sql);
$sql="DELETE FROM suggested WHERE suggestid=$suggestid";
$result=mysql_query($sql);
$sql="DELETE FROM secsuggested WHERE suggestid=$suggestid";
$result=mysql_query($sql);
echo $endstr;
include("/home/mediarch/foot.php");
exit;
} else if ($postsub=="-1 Aura") {
$sql="INSERT INTO auraed
(boardid,topic,origtopic,topicid,messageid,aurabod,aurasec,auradate,postsec,postdate,aurauser,auraby,action,reason) VALUES ('".$myrow["board"]."','$topicn','$origtopic','$topicid','$messageid','".$myrowm["messbody"]."','$time','$datedate','".$myrowm["messsec"]."','".$myrowm["postdate"]."','".$myrow["suggestwho"]."','$userid','5','$reason')";
$result=mysql_query($sql);
$aura=$aura-1;
$sql="UPDATE users SET aura=$aura WHERE userid=$suggestwho";
$result=mysql_query($sql);
$sql="DELETE FROM suggested WHERE suggestid=$suggestid";
$result=mysql_query($sql);
$sql="DELETE FROM secsuggested WHERE suggestid=$suggestid";
$result=mysql_query($sql);
echo $endstr;
include("/home/mediarch/foot.php");
exit;
} else if ($postsub=="-2 Aura") {
$sql="INSERT INTO auraed
(boardid,topic,origtopic,topicid,messageid,aurabod,aurasec,auradate,postsec,postdate,aurauser,auraby,action,reason) VALUES ('".$myrow["board"]."','$topicn','$origtopic','$topicid','$messageid','".$myrowm["messbody"]."','$time','$datedate','".$myrowm["messsec"]."','".$myrowm["postdate"]."','".$myrow["suggestwho"]."','$userid','6','$reason')";
$result=mysql_query($sql);
$aura=$aura-2;
$sql="UPDATE users SET aura=$aura WHERE userid=$suggestwho";
$result=mysql_query($sql);
$sql="DELETE FROM suggested WHERE suggestid=$suggestid";
$result=mysql_query($sql);
$sql="DELETE FROM secsuggested WHERE suggestid=$suggestid";
$result=mysql_query($sql);
echo $endstr;
include("/home/mediarch/foot.php");
exit;
} else if ($postsub=="-3 Aura") {
$sql="INSERT INTO auraed
(boardid,topic,origtopic,topicid,messageid,aurabod,aurasec,auradate,postsec,postdate,aurauser,auraby,action,reason) VALUES ('".$myrow["board"]."','$topicn','$origtopic','$topicid','$messageid','".$myrowm["messbody"]."','$time','$datedate','".$myrowm["messsec"]."','".$myrowm["postdate"]."','".$myrow["suggestwho"]."','$userid','7','$reason')";
$result=mysql_query($sql);
$aura=$aura-3;
$sql="UPDATE users SET aura=$aura WHERE userid=$suggestwho";
$result=mysql_query($sql);
$sql="DELETE FROM suggested WHERE suggestid=$suggestid";
$result=mysql_query($sql);
$sql="DELETE FROM secsuggested WHERE suggestid=$suggestid";
$result=mysql_query($sql);
echo $endstr;
include("/home/mediarch/foot.php");
exit;
} else if ($postsub=="-5 Aura") {
$sql="INSERT INTO auraed
(boardid,topic,origtopic,topicid,messageid,aurabod,aurasec,auradate,postsec,postdate,aurauser,auraby,action,reason) VALUES ('".$myrow["board"]."','$topicn','$origtopic','$topicid','$messageid','".$myrowm["messbody"]."','$time','$datedate','".$myrowm["messsec"]."','".$myrowm["postdate"]."','".$myrow["suggestwho"]."','$userid','8','$reason')";
$result=mysql_query($sql);
$aura=$aura-5;
$sql="UPDATE users SET aura=$aura WHERE userid=$suggestwho";
$result=mysql_query($sql);
$sql="DELETE FROM suggested WHERE suggestid=$suggestid";
$result=mysql_query($sql);
$sql="DELETE FROM secsuggested WHERE suggestid=$suggestid";
$result=mysql_query($sql);
echo $endstr;
include("/home/mediarch/foot.php");
exit;
}


$reason2=$myrow["reason"];
$sql="SELECT * FROM sos WHERE sosid=$reason2";
$resultre=mysql_query($sql);
$myrowre=@mysql_fetch_array($resultre);

echo "<tr><td CLASS=CELL2 colspan=2><b>Board:</b> <a href=\"/boards/gentopic.php?board=".$myrow["board"]."\">$boardn</a> | <b>Topic:</b> <a href=\"/boards/genmessage.php?board=".$myrow["board"]."&topic=".$myrow["topic"]."\">".$myrow["topic"]." - ".stripslashes($topicn)."</a> | Suggest ID: $suggestid</font></td></tr>
<tr><td CLASS=CELL2 colspan=2><b>From:</b> <a href=\"/boards/whois.php?user=".$myrow["suggestwho"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">".$myrowo["username"]."</a> | <b>Posted:</b> ".date("n/j/Y h:i:s A",$myrowm["messsec"])." | <b>Suggested by:</b> <a href=\"/boards/whois.php?user=".$myrow["suggestby"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">".$myrowb["username"]."</a></font></td></tr>
<tr><td CLASS=CELL2 colspan=2><b>Suggested at:</b> ".date("n/j/Y h:i:s A",$myrow["suggestsec"])." | <b>Number of Suggests:</b> <a href=\"viewsugs.php?suggestid=$suggestid";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">".$suggestnum."</a> | <b>Reason Suggested:</b> ".$myrowre["ruletitle"];
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
echo "<form action=\"sugact.php?suggestid=$suggestid";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td width=25%><b>Reason for Suggestion</b></td><td><select name=\"reason\">
<option value=\"".$myrow["reason"]."\">".$myrowre["ruletitle"]." (Current)</option>";
$sql="SELECT * FROM sos ORDER BY sosid";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
echo "<option value=\"".$myrow["sosid"]."\">".$myrow["ruletitle"]."</option>";
}
echo "</select></td></tr>
<tr><td><b>No Action</b></td><td><input type=\"submit\" name=\"postno\" value=\"No Action\"> <input type=\"submit\" name=\"postno\" value=\"Transfer To Moderation Queue\"></td></tr>
<tr><td><b>Give Aura</b></td><td>
<input type=\"submit\" name=\"postadd\" value=\"+1 Aura\">
<input type=\"submit\" name=\"postadd\" value=\"+3 Aura\">
<input type=\"submit\" name=\"postadd\" value=\"+5 Aura\">
<input type=\"submit\" name=\"postadd\" value=\"+10 Aura\">
</td></tr>
<tr><td><b>Remove Aura</b></td><td>
<input type=\"submit\" name=\"postsub\" value=\"-1 Aura\">
<input type=\"submit\" name=\"postsub\" value=\"-2 Aura\">
<input type=\"submit\" name=\"postsub\" value=\"-3 Aura\">
<input type=\"submit\" name=\"postsub\" value=\"-5 Aura\">
</td></tr>
</form>
<tr><td align=center>
</table>";
include("/home/mediarch/foot.php");
?>