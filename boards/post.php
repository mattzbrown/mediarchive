<?
$pagetitle="Post Message";
include("/home/mediarch/head.php");
echo $harsss;

if (!$board)
{
echo "<table border=0 width=100%>

<tr><td>An invalid Board ID was used to access this page. Return to the <a HREF=\index.php\">Board List</a> to select a board.</td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}
function check($board) {
$sql="SELECT * FROM boards WHERE boardid='$board'";
$result=mysql_query($sql);
if(!mysql_num_rows($result))
{
return 0;
} else {
return 1;
}
}
function check2($board, $topic) {
$sql="SELECT * FROM topics WHERE boardnum='$board' AND topicid='$topic'";
$result=mysql_query($sql);
if(!mysql_num_rows($result))
{
return 0;
} else {
return 1;
}
}
function getlevel($username)
{
$sql="SELECT * FROM users WHERE username='$username'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
if ($myrow["level"]<5) {
echo "<table border=0 width=100%>

<tr><td><font size=2>You are not authorized to view this page.</font></td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}
return $myrow["level"];
}
$username=auth2($uname,$pword);
if (!$username)
{
echo "<table border=0 width=100%>

<tr><td>You must be <a HREF=\"login.php\">logged in</a> to view this page.</td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$userlevel=$myrow["level"];
$boardex=check($board);
if (!$boardex)
{
echo "<table border=0 width=100%>

<tr><td>An invalid Board ID was used to access this page. Return to the <a HREF=\index.php\">Board List</a> to select a board.</td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}
$topex=check2($board, $topic);
if ((!$topex) && ($topic))
{
echo "<table border=0 width=100%>

<tr><td>An invalid Topic ID was used to access this page. Return to the <a HREF=\gentopic.php?board=".$board."\">Topic List</a> to select a board.</td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}
echo "<table border=0 width=100%>
<tr><td Colspan=2 align=center><FONT SIZE=6><B>Post Message</b></font></td></tr>

<FORM ACTION=\"preview.php?board=".$board."";
if ($topic) { echo "&topic=".$topic.""; }
echo "\" METHOD=POST>";
if ($userlevel==5) {
echo "<TR><TD COLSPAN=2 CLASS=DARK ALIGN=CENTER><FONT SIZE=3>Message Count Reminder</font></td></tr>
<TR><TD COLSPAN=2>At your current user level, Warned, you are only allowed to post 10 messages every 24 hours and 3 messages every hour.
In the past 24 hours, you have posted ";
$ctime=time()-86400; 
$sql="SELECT * FROM messages WHERE messsec>=$ctime AND messby='$uname'";
$result=mysql_query($sql);
$result=mysql_num_rows($result);
if (!$result) { echo "0"; } else if ($result) { echo "$result"; }
echo " messages. In the past 3 hours, you have posted ";
$ctime=time()-3600; 
$sql="SELECT * FROM messages WHERE messsec>=$ctime AND messby='$uname'";
$result=mysql_query($sql);
$result=mysql_num_rows($result);
if (!$result) { echo "0"; } else if ($result) { echo "$result"; }
echo " messages.</td></tr>";
}
if ($userlevel==6) {
echo "<TR><TD COLSPAN=2 CLASS=DARK ALIGN=CENTER><FONT SIZE=3>Message Count Reminder</font></td></tr>
<TR><TD COLSPAN=2>At your current user level, Negative Karma, you are only allowed to post 1 messages every 24 hours.
In the past 24 hours, you have posted ";
$ctime=time()-86400; 
$sql="SELECT * FROM messages WHERE messsec>=$ctime AND messby='$uname'";
$result=mysql_query($sql);
$result=mysql_num_rows($result);
if (!$result) { echo "0"; } else if ($result) { echo "$result"; }
echo " messages.</td></tr>";
}
$sql="SELECT * FROM boards WHERE boardid=$board";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
if ($myrow["topiclevel"]>=60) {
echo "<TR><TD COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>BOARD GROUND RULES: Read Before Posting</td></tr><TR><TD COLSPAN=2 CLASS=SYS>While we're all very proud of the fact that you know how to count, posting \"FIRST\" or counting off posts in a topic is disruptive and adds absolutely nothing to the conversation.
<p>
Post counting in this manner falls well under the &quot;Disruptive&quot; category of the TOS, and those posts will be deleted with Karma loss.</td></tr>";
}
if (!$topic) {
if ($userlevel>=53) {
echo "<tr><td COLSPAN=2  CLASS=DARK ALIGN=CENTER><font SIZE=3>Enable HTML</font></td></tr>
<tr><td COLSPAN=2><input type=\"checkbox\" value=\"1\" name=\"htmlt\" CHECKED>Enable HTML in the topic title?</td></tr>";
}
if ($userlevel>=60) {
echo "<tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Auto-Bump</font></td></tr>
<tr><td COLSPAN=2><input type=\"checkbox\" value=\"1\" name=\"bump\" />Auto-Bump this topic?</td></tr>";
if ($board==6) {
echo "<tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Announcement</font></td></tr>
<tr><td>Announcement<br>(Between 1 and 512 characters in length)</td>

    <td><input type=\"text\" size=\"60\" maxlength=\"512\" name=\"announce\" value=\"".stripslashes($announce)."\" ></td></tr>";
}
}
echo "<TR><TD COLSPAN=2 CLASS=DARK ALIGN=CENTER><FONT SIZE=3>Create New Topic</font></td></tr>
<TR><TD COLSPAN=2>To create a new topic, enter a title for the topic below and create the first message.</td></tr>
<TR><TD>Topic Title<BR>(Between 5 and 80 characters in length)</td>
    <TD><input type=\"text\" size=\"60\" maxlength=\"80\" name=\"topictitle\" value=\"\" ></td></tr>";
} else if ($topic) {
echo "<TR><TD COLSPAN=2 CLASS=DARK ALIGN=CENTER><FONT SIZE=3>Current Topic</font></td></tr>

<TR><TD COLSPAN=2><FONT Size=3><B><A TARGET=\"_new\" HREF=\"genmessage.php?board=".$board."&topic=".$topic."\">";
$sql="SELECT * FROM topics WHERE topicid=$topic";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
echo "".stripslashes($myrow["topicname"])."</a></b></font></td></tr><TR><TD COLSPAN=2>(Click to open a new window with the current messages)</td></tr>";
}
if ($userlevel>=53) {
echo "<tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Enable HTML</font></td></tr>
<tr><td COLSPAN=2><input type=\"checkbox\" value=\"1\" name=\"html\" CHECKED>Enable HTML in this message?</td></tr>";
}
echo "<TR><TD COLSPAN=2 CLASS=DARK ALIGN=CENTER><FONT SIZE=3>Your Message</font></td></tr>
<TR><TD COLSPAN=2>Enter your message text below.</td></tr>
<TR><TD>Message:</td>

    <TD><textarea cols=\"60\" rows=\"20\" name=\"message\" WRAP=\"virtual\">
";
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
if ($myrow["sig"]) {
$sigstr = eregi_replace("<br>", "", $myrow["sig"]);
echo "
---
$sigstr";
}
echo "</textarea></td></tr>

    <TR><TD COLSPAN=2 ALIGN=CENTER><input type=\"submit\" value=\"Post Message\" name=\"post\"><input type=\"submit\" value=\"Preview Message\" name=\"post\"><input type=\"reset\" value=\"Reset\" name=\"reset\"></td></tr>

</form>

</table>";
include("/home/mediarch/foot.php");
?>