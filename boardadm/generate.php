<?
$pagetitle="Generated Messages";
include("/home/mediarch/head.php");
echo $harsss;
echo "<table border=1 cellspacing=0 width=100%>

<tr><td COLSPAN=1 align=center><font SIZE=6>Generated Message</font></td></tr>";
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
</table>
";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$usrname=$myrow["username"];
if ($myrow["level"]<50)
{
echo "<tr><td>You are not authorized to view this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE userid=$user";
$result=mysql_query($sql);
$result=@mysql_num_rows($result);
if ($result<=0) {
echo "<tr><td>An invalid link was used to access this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
echo "<tr><td CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"/boards/gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"/boards/genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
if ($user) {
echo " | <a href=\"/boards/whois.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Whois Page</a>";
}
echo " | <a HREF=\"index.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Control Panel</a>";
echo "</i></font></td></tr>";



if ($post) {
$sql="SELECT * FROM users WHERE userid=$user";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$topictitle="Generated Message For ".$myrow["username"]."";
$mess="<b>Username:</b> ".$myrow["username"]."<br />
<br />
<b>Signature:</b> ".$myrow["sig"]."<br />
<br />
<b>Quote:</b> ".$myrow["quote"]."<br />
<br />
<b>Public E-Mail Address:</b> ".$myrow["email2"]."<br />
<br />
<b>IM:</b> ";
if ($myrow["imtype"] == 1) {
$mess .= "AIM: ".$myrow["im"]."";
}
if ($myrow["imtype"] == 2) {
$mess .= "ICQ: ".$myrow["im"]."";
}
if ($myrow["imtype"] == 3) {
$mess .= "MSN: ".$myrow["im"]."";
}
if ($myrow["imtype"] == 4) {
$mess .= "YIM: ".$myrow["im"]."";
}
$mess .= "<br />";
$userid=$myrow["userid"];
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$modname=$myrow["userid"];
$sql="SELECT * FROM topics ORDER BY topicid DESC LIMIT 0, 1";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$topicid=$myrow["topicid"]+1;
$sql="SELECT * FROM messages ORDER BY messageid DESC LIMIT 0, 1";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$messageid=$myrow["messageid"]+1;
$time=time();
$datedate=date("n/j/Y h:i:s A");
$sql="INSERT INTO modded (boardid,topic,origtopic,topicid,messageid,modbod,modsec,moddate,postsec,postdate,moduser,modby,action,contest,contsec,contbody,recont,appealsec,recontbody,topmov,reason) VALUES ('98','$topictitle','1','$topicid','$messageid','".addslashes($mess)."','$time','$datedate','$time','$datedate','$userid','$modname','10','0','0','','0','0','','0','$reason')";
$result=mysql_query($sql);
$sql="UPDATE users SET level=-1 WHERE userid='$user'";
$result=mysql_query($sql);
$sql="UPDATE users SET notify=1 WHERE userid='$user'";
$result=mysql_query($sql);
$sql="INSERT INTO systemnot (sysbod,sendto,sentat,sentfrom,`read`,sentsec) VALUES ('Your account has been <b>Suspended</b> for one or more major TOS violations. Your account will be reviewed within the next 24 hours. You should review your <a href=\"modhist.php\">Moderated Messages</a> for more information.','$user','$datedate','$modname','0','$time')";
$result=mysql_query($sql);
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"5; URL=/boards/whois.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">

<tr><td Colspan=2 align=center>You should be returned to this user's Whois page automatically in five seconds.  If not, you can click <a HREF=\"/boards/whois.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">here</a> to continue.</td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}



$sql="SELECT * FROM users WHERE userid=$user";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
echo "<tr><td CLASS=DARK ALIGN=CENTER><font SIZE=3>Generated Message Preview</font></td></tr>

<tr><td CLASS=CELL2><b>From:</b> <a HREF=\"/boards/whois.php?user=".$myrow["userid"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">".$myrow["username"]."</a></td></tr>";
$mess2="<b>Username:</b> ".$myrow["username"]."<br />
<br />
<b>Signature:</b> ".$myrow["sig"]."<br />
<br />
<b>Quote:</b> ".$myrow["quote"]."<br />
<br />
<b>Public E-Mail Address:</b> ".$myrow["email2"]."<br />
<br />
<b>IM:</b> ";
if ($myrow["imtype"] == 1) {
$mess2 .= "AIM: ".$myrow["im"]."";
}
if ($myrow["imtype"] == 2) {
$mess2 .= "ICQ: ".$myrow["im"]."";
}
if ($myrow["imtype"] == 3) {
$mess2 .= "MSN: ".$myrow["im"]."";
}
if ($myrow["imtype"] == 4) {
$mess2 .= "YIM: ".$myrow["im"]."";
}
$mess2 .= "<br />";
echo "  <tr><td CLASS=CELL1>$mess2</td></tr>

<tr><td CLASS=DARK ALIGN=CENTER><font SIZE=3>Generate This Message?</font></td></tr>
<form action=\"generate.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td ALIGN=CENTER><b>Reason: </b>
 <select name=\"reason\" size=\"1\">";
$tosr=mysql_query("SELECT * FROM tos ORDER BY tosid ASC");
while ($tosm=@mysql_fetch_array($tosr)) {
echo "  <option value=\"".$tosm["tosid"]."\">".$tosm["ruletitle"]."</option>
";
}
echo "  </select>
</td></tr>
<tr><td ALIGN=CENTER><input type=\"submit\" value=\"Generate This Message And Suspend This User\" name=\"post\"></td></tr>
</form>

</table>";
include("/home/mediarch/foot.php");
?>