<?
$pagetitle="Message Marks";
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

<tr><td align=center><font SIZE=6>Marks</font></td></tr>
<tr><td CLASS=LITE ALIGN=center colspan=2><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"/boards/gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"/boards/genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
if ($markid) {
echo " | <a HREF=\"modact.php?markid=$markid";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Marked Message</a>";
}
echo " | <a HREF=\"modqueue.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Moderation Queue</a>";
echo "</i></font></td></tr>";
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
echo "<tr><td colspan=2>You cannot view marks for that you have marked yourself.</td></tr>
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
echo "<tr><td CLASS=CELL2 colspan=2><b>Board:</b> <a href=\"/boards/gentopic.php?board=".$myrow["board"]."\">$boardn</a> | <b>Topic:</b> <a href=\"/boards/genmessage.php?board=".$myrow["board"]."&topic=".$myrow["topic"]."\">".$myrow["topic"]." - ".stripslashes($topicn)."</a> | Mark ID: $markid</font></td></tr>
<tr><td CLASS=CELL2 colspan=2><b>From:</b> <a href=\"/boards/whois.php?user=".$myrow["markwho"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">".$myrowo["username"]."</a> | <b>Posted:</b> ".date("n/j/Y h:i:s A",$myrowm["messsec"])."</td></tr><tr><td CLASS=CELL1 colspan=2>".stripslashes($myrowm["messbody"])."</td></tr>";
$sqlsm="SELECT * FROM secmarked WHERE markid=$markid ORDER BY marksec ASC";
$resultsm=mysql_query($sqlsm);
while ($myrowsm=@mysql_fetch_array($resultsm)) {
$sql="SELECT * FROM users WHERE userid=".$myrowsm["markby"]."";
$resulto=mysql_query($sql);
$myrowb=@mysql_fetch_array($resulto);
$reason2=$myrowsm["reason"];
$sql="SELECT * FROM tos WHERE tosid=$reason2";
$resultre=mysql_query($sql);
$myrowre=@mysql_fetch_array($resultre);
echo "<tr><td colspan=2 class=cell2><b>Marked by:</b> <a href=\"/boards/whois.php?user=".$myrowsm["markby"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">".$myrowb["username"]."</a> | <b>Marked at:</b> ".date("n/j/Y h:i:s A",$myrowsm["marksec"])." | <b>Reason Marked:</b> ".$myrowre["ruletitle"];
if ($myrowre["ruletitle"]=="Other") { echo ": ".stripslashes($myrow["reason2"]); }
echo "</font></td></tr>";
}
echo "</table>";
include("/home/mediarch/foot.php");
?>

