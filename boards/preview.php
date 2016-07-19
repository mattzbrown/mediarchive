<?
$pagetitle="Preview Message";
include("/home/mediarch/head.php");
echo $harsss;
if (!$board)
{
echo "<table border=0 width=100%>

<tr><td>An invalid Board ID was used to access this page. Return to the <a HREF=\"index.php\">Board List</a> to select a board.</td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}
$correct=0;
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

<tr><td>You must be <a HREF=\"login.php\">logged in</a> to view this page.</td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$userlevel=$myrow["level"];
$useridu=$myrow["userid"];
$hyperlink=$myrow["hyperlink"];
$images=$myrow["images"];
$underline=$myrow["underline"];
if ($myrow["level"]<5) {
echo "<table border=0 width=100%>

<tr><td><font size=2>You are not authorized to view this page.</font></td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}
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
if (($post=="Post Message") && (!$messageid)) {
$messageid=$message;
if ((!$topic) && (!$topicid)) {
$topicid=$topictitle;
}
}
if ($messageid) {
$message=$messageid;
}
if ($message) {
while (eregi("  ",$message)>=1) {
$message=eregi_replace("  "," ",$message);
}
$message=trim($message);
$message=eregi_replace("­","",$message);
$message2 = htmlentities($message);
$message8 = htmlentities($message);
$messageg = nl2br($message);
$message2 = nl2br($message2);
$message2 = eregi_replace("&lt;b&gt;", "<b>", $message2);
$message2 = eregi_replace("&lt;/b&gt;", "</b>", $message2);
$message2 = eregi_replace("&lt;i&gt;", "<i>", $message2);
$message2 = eregi_replace("&lt;/i&gt;", "</i>", $message2);
$message2 = eregi_replace("&lt;u&gt;", "<u>", $message2);
$message2 = eregi_replace("&lt;/u&gt;", "</u>", $message2);
$message2 = eregi_replace("&nbsp;", " ", $message2);
$message2 = eregi_replace("&shy;", "", $message2);
$message2 = eregi_replace("&#160;", " ", $message2);
$message2 = eregi_replace("&#173;", "", $message2);
if (((!$html) && ($myrow["level"]>=53)) || ($myrow["level"]<53)) {
$message2 = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]","<a href=\"\\0\">\\0</a>", $message2);
}
if (($myrow["level"]>=53) && ($html)) {
$message2 = eregi_replace("&lt;", "<", $message2);
$message2 = eregi_replace("&gt;", ">", $message2);
$message2 = eregi_replace("&amp;", "&", $message2);
$message2 = eregi_replace("&quot;", "\"", $message2);
}
$messlenx=0;
$messageq = addslashes($message2);
$message3 = eregi_replace("
", "", $message);
$message3 = eregi_replace(" ", "", $message3);
$message3 = eregi_replace("<b>", "", $message3);
$message3 = eregi_replace("</b>", "", $message3);
$message3 = eregi_replace("<i>", "", $message3);
$message3 = eregi_replace("</i>", "", $message3);
$message3 = eregi_replace("<u>", "", $message3);
$message3 = eregi_replace("</u>", "", $message3);
$message9 = eregi_replace("<b>", "", $message);
$message9 = eregi_replace("</b>", "", $message9);
$message9 = eregi_replace("<i>", "", $message9);
$message9 = eregi_replace("</i>", "", $message9);
$message9 = eregi_replace("<u>", "", $message9);
$message9 = eregi_replace("</u>", "", $message9);
if (($myrow["level"]<53) || (($myrow["level"]>=53) && (!$html))) {
$message4 = eregi_replace("<br />", " ", $messageg);
$message4 = explode(" ", $message4);
while (list($key, $val) = @each($message4)) {
if (strlen($val)>120) {
$messlenx=1;
}
}
}
}
if ($topicid) {
$topictitle=$topicid;
}
$topiclenx=0;
if ($topictitle) {
while (eregi("  ",$topictitle)>=1) {
$topictitle=eregi_replace("  "," ",$topictitle);
}
$topictitle=eregi_replace("­","",$topictitle);
$topictitle=trim($topictitle);
$topictitle2 = htmlentities($topictitle);
$topictitle8 = htmlentities($topictitle);
$topictitle2 = eregi_replace("&nbsp;", " ", $topictitle2);
$topictitle2 = eregi_replace("&shy;", "", $topictitle2);
$topictitle2 = eregi_replace("&#160;", " ", $topictitle2);
$topictitle2 = eregi_replace("&#173;", "", $topictitle2);
$topictitle3 = explode(" ", $topictitle);
while (list($key, $val) = each($topictitle3)) {
if (strlen($val)>25) {
$topiclenx=1;
}
}
if (($myrow["level"]>=53) && ($htmlt)) {
$topictitle2 = eregi_replace("&lt;", "<", $topictitle2);
$topictitle2 = eregi_replace("&gt;", ">", $topictitle2);
$topictitle2 = eregi_replace("&amp;", "&", $topictitle2);
$topictitle2 = eregi_replace("</a>", "&lt;/a&gt;", $topictitle2);
$topictitle2 = eregi_replace("<a", "&lt;a", $topictitle2);
$topictitle2 = eregi_replace("</table", "&lt;/table", $topictitle2);
$topictitle2 = eregi_replace("<table", "&lt;table", $topictitle2);
$topictitle2 = eregi_replace("</tr", "&lt;/tr", $topictitle2);
$topictitle2 = eregi_replace("<tr", "&lt;tr", $topictitle2);
$topictitle2 = eregi_replace("</td", "&lt;/td", $topictitle2);
$topictitle2 = eregi_replace("<td", "&lt;td", $topictitle2);
$topictitle2 = eregi_replace("</th", "&lt;/th", $topictitle2);
$topictitle2 = eregi_replace("<th", "&lt;th", $topictitle2);
}
$topictitleq = addslashes($topictitle2);
}
if (($myrow["level"]>=60) && (!$topic) && ($board==6)) {
$announce=addslashes(htmlentities($announce));
}
$time = time()-60;
$sql = "SELECT * FROM messages WHERE messby='$uname' AND messsec>=$time";
$result9 = mysql_query($sql);
$result9 = @mysql_num_rows($result9);
$time = time()-900;
$sql = "SELECT * FROM topics WHERE topicby='$uname' AND timesec>=$time";
$result2 = mysql_query($sql);
$result2 = @mysql_num_rows($result2);
$time = time()-86400;
$sql = "SELECT * FROM topics WHERE topicby='$uname' AND timesec>=$time AND boardnum=$board";
$result3 = mysql_query($sql);
$result3 = @mysql_num_rows($result3);
$sql = "SELECT * FROM messages WHERE topic=$topic AND mesboard=$board AND messbody='$message2' AND messby='$uname'";
$result4 = mysql_query($sql);
$result4 = @mysql_num_rows($result4);
if (!$topic) {
$sql = "SELECT * FROM topics WHERE boardnum=$board AND topicname='$topictitle2'";
$result5 = mysql_query($sql);
$result5 = @mysql_num_rows($result5);
}
if ($topic) {
$sql = "SELECT * FROM topics WHERE boardnum=$board AND topicid='$topic' AND closed='1'";
$result1c = mysql_query($sql);
$result1c = @mysql_num_rows($result1c);
}
if ($userlevel == 5) {
$time = time()-3600;
$sql = "SELECT * FROM messages WHERE messby='$uname' AND messsec>=$time";
$result6 = mysql_query($sql);
$result6 = @mysql_num_rows($result6);
$time = time()-86400;
$sql = "SELECT * FROM messages WHERE messby='$uname' AND messsec>=$time";
$result7 = mysql_query($sql);
$result7 = @mysql_num_rows($result7);
}
if ($userlevel==6) {
$time = time()-86400;
$sql = "SELECT * FROM messages WHERE messby='$uname' AND messsec>=$time";
$result40 = mysql_query($sql);
$result40 = @mysql_num_rows($result40);
}
$sql = "SELECT * FROM boards WHERE boardid='$board'";
$result10 = mysql_query($sql);
$myrow10 = @mysql_fetch_array($result10);
$topiclevel=$myrow10["topiclevel"];
$messlevel=$myrow10["messlevel"];
$topicban=0;
$messflag=0;
$messban=0;
if (!$topic) {
$sql = "SELECT * FROM options WHERE opid=2";
$result70 = mysql_query($sql);
$myrow70 = @mysql_fetch_array($result70);
if ($myrow70["val"]==1) {
$sql = "SELECT * FROM words WHERE `type`=1 ORDER BY wordid ASC";
$result71 = mysql_query($sql);
while ($myrow71=@mysql_fetch_array($result71)) {
if (eregi($myrow71["word"],$topictitle2)>=1) {
$topicban=$myrow71["wordid"];
}
}
}
$sql = "SELECT * FROM options WHERE opid=3";
$result15 = mysql_query($sql);
$myrow15 = @mysql_fetch_array($result15);
if ($myrow15["val"]==1) {
$sql = "SELECT * FROM words WHERE `type`=2 ORDER BY wordid ASC";
$result16 = mysql_query($sql);
while ($myrow16=@mysql_fetch_array($result16)) {
if (eregi($myrow16["word"],$topictitle2)>=1) {
$topicban=$myrow16["wordid"];
}
}
}
$sql = "SELECT * FROM options WHERE opid=4";
$result11 = mysql_query($sql);
$myrow11 = @mysql_fetch_array($result11);
if ($myrow11["val"]==1) {
$sql = "SELECT * FROM words WHERE `type`=3 ORDER BY wordid ASC";
$result12 = mysql_query($sql);
while ($myrow12=@mysql_fetch_array($result12)) {
if (eregi($myrow12["word"],$topictitle2)>=1) {
$topicban=$myrow12["wordid"];
}
}
}
}
$sql = "SELECT * FROM options WHERE opid=3";
$result16 = mysql_query($sql);
$myrow16 = @mysql_fetch_array($result16);
if ($myrow16["val"]==1) {
$sql = "SELECT * FROM words WHERE `type`=2 ORDER BY wordid ASC";
$result18 = mysql_query($sql);
while ($myrow18=@mysql_fetch_array($result18)) {
if (eregi($myrow18["word"],$message9)>=1) {
$messflag=$myrow18["wordid"];
}
}
}
$sql = "SELECT * FROM options WHERE opid=2";
$result13 = mysql_query($sql);
$myrow13 = @mysql_fetch_array($result13);
if ($myrow13["val"]==1) {
$sql = "SELECT * FROM words WHERE `type`=1 ORDER BY wordid ASC";
$result14 = mysql_query($sql);
while ($myrow14=@mysql_fetch_array($result14)) {
if ((eregi($myrow14["word"],$message9)>=1)) {
$messban=$myrow14["wordid"];
}
}
}
if ((!$message) && (!$post)) {
echo "<table border=0 width=100%>

<tr><td Colspan=2 align=center><font SIZE=6><b>Preview Message</b></font></td></tr><tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Post Error</font></td></tr><tr><td COLSPAN=2><b>There was an error posting your message:</b> There was an error sending data to this page.</td></tr>";
} else if ((!$topictitle) && (!$topic) && (!$messageid)) {
echo "<table border=0 width=100%>

<tr><td Colspan=2 align=center><font SIZE=6><b>Preview Message</b></font></td></tr><tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Post Error</font></td></tr><tr><td COLSPAN=2><b>There was an error posting your message:</b> There was an error sending data to this page.</td></tr>";
} else if ($messban) {
$sql="SELECT * FROM words WHERE wordid=$messban";
$result19=mysql_query($sql);
$myrow19=@mysql_fetch_array($result19);
echo "<table border=0 width=100%>

<tr><td Colspan=2 align=center><font SIZE=6><b>Preview Message</b></font></td></tr><tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Post Error</font></td></tr><tr><td COLSPAN=2><b>There was an error posting your message:</b> The message you entered appears to contain one of the words that ".$sitetitle." has deemed inappropriate for use under any circumstances.<br>
<br>
The only acceptable means of using this word is to completely block it out (i.e. &quot;****&quot;). Partial blocking, misspelling, or other attempts to use the word is considered a <b>censor bypass</b>, and a severe TOS violation.<br>
<br>
Banned word found: <b>".$myrow19["word"]."</b><br></td></tr>";
} else if (($topicban) && (!$topic)) {
$sql="SELECT * FROM words WHERE wordid=$topicban";
$result19=mysql_query($sql);
$myrow19=@mysql_fetch_array($result19);
echo "<table border=0 width=100%>

<tr><td Colspan=2 align=center><font SIZE=6><b>Preview Message</b></font></td></tr><tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Post Error</font></td></tr><tr><td COLSPAN=2><b>There was an error posting your message:</b> The topic you entered contains one or more banned words. You will need to change the topic title in order to post.<br>
<br>
Please change your topic, and please note that using symbols or misspelling banned words to bypass the censor is grounds for immediate revocation.<br>
<br>
Banned word found: <b>".$myrow19["word"]."</b><br></td></tr>";
} else if (($topiclevel>$userlevel) && (!$topic) && ($messageid)) {
echo "<table border=0 width=100%>

<tr><td Colspan=2 align=center><font SIZE=6><b>Preview Message</b></font></td></tr><tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Post Error</font></td></tr><tr><td COLSPAN=2><b>There was an error posting your message:</b> You are not authorized to post topics on this board.</td></tr>";
} else if (($messlevel>$userlevel) && ($topic) && ($messageid)) {
echo "<table border=0 width=100%>

<tr><td Colspan=2 align=center><font SIZE=6><b>Preview Message</b></font></td></tr><tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Post Error</font></td></tr><tr><td COLSPAN=2><b>There was an error posting your message:</b> You are not authorized to post messages on this board.</td></tr>";
} else if ((!$topic) && ((strlen($topictitle)>80) || (strlen($topictitle)<3))) {
echo "<table border=0 width=100%>

<tr><td Colspan=2 align=center><font SIZE=6><b>Preview Message</b></font></td></tr><tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Post Error</font></td></tr><tr><td COLSPAN=2><b>There was an error posting your message:</b> Topic titles must be between 3 and 80 characters.</td></tr>";
} else if (!$message3) {
echo "<table border=0 width=100%>

<tr><td Colspan=2 align=center><font SIZE=6><b>Preview Message</b></font></td></tr><tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Post Error</font></td></tr><tr><td COLSPAN=2><b>There was an error posting your message:</b> Messages cannot be blank.</td></tr>";
} else if ((strlen($message)>32768) && ($messlevel<50)) {
$messlen=strlen($message);
echo "<table border=0 width=100%>

<tr><td Colspan=2 align=center><font SIZE=6><b>Preview Message</b></font></td></tr><tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Post Error</font></td></tr><tr><td COLSPAN=2><b>There was an error posting your message:</b> The maximum allowed size for a message is 32KB (32768 characters). Your message is $messlen characters long.</td></tr>";
} else if (($messlenx) && ($messlevel<50)) {
echo "<table border=0 width=100%>

<tr><td Colspan=2 align=center><font SIZE=6><b>Preview Message</b></font></td></tr><tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Post Error</font></td></tr><tr><td COLSPAN=2><b>There was an error posting your message:</b> Your message contains a single word over 120 characters in length. This can cause problems for certain browsers, and is not allowed.</td></tr>";
} else if (($topiclenx) && (!$topic)) {
echo "<table border=0 width=100%>

<tr><td Colspan=2 align=center><font SIZE=6><b>Preview Message</b></font></td></tr><tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Post Error</font></td></tr><tr><td COLSPAN=2><b>There was an error posting your message:</b> Your topic title contains a single word over 25 characters in length. This can cause problems for certain browsers, and is not allowed.</td></tr>";
} else if (($result1c) && ($messageid)) {
echo "<table border=0 width=100%>

<tr><td Colspan=2 align=center><font SIZE=6><b>Preview Message</b></font></td></tr><tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Post Error</font></td></tr><tr><td COLSPAN=2><b>There was an error posting your message:</b> This topic has been closed. You cannot post in it.</td></tr>";
} else if (($result9>=2) && ($messageid)) {
echo "<table border=0 width=100%>

<tr><td Colspan=2 align=center><font SIZE=6><b>Preview Message</b></font></td></tr><tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Post Error</font></td></tr><tr><td COLSPAN=2><b>There was an error posting your message:</b> To prevent flooding, no user can post more than two messages per minute. Please wait and try your post again in 60 seconds.</td></tr>";
} else if ((!$topic) && ($result2>=3) && ($messageid)) {
echo "<table border=0 width=100%>

<tr><td Colspan=2 align=center><font SIZE=6><b>Preview Message</b></font></td></tr><tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Post Error</font></td></tr><tr><td COLSPAN=2><b>There was an error posting your message:</b> To prevent flooding, users cannot create more than three topics in any 15-minute timespan. Please wait and try your post again later.</td></tr>";
} else if ((!$topic) && ($result3>=10) && ($messageid)) {
echo "<table border=0 width=100%>

<tr><td Colspan=2 align=center><font SIZE=6><b>Preview Message</b></font></td></tr><tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Post Error</font></td></tr><tr><td COLSPAN=2><b>There was an error posting your message:</b> To prevent flooding, users cannot create more than ten topics on any single board in one day. Please wait and try your post again later.</td></tr>";
} else if (($topic) && ($result4) && ($messageid)) {
echo "<table border=0 width=100%>

<tr><td Colspan=2 align=center><font SIZE=6><b>Preview Message</b></font></td></tr><tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Post Error</font></td></tr><tr><td COLSPAN=2><b>There was an error posting your message:</b> You have already posted this identical message in this topic!</td></tr>";
} else if ((!$topic) && ($result5) && ($messageid)) {
echo "<table border=0 width=100%>

<tr><td Colspan=2 align=center><font SIZE=6><b>Preview Message</b></font></td></tr><tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Post Error</font></td></tr><tr><td COLSPAN=2><b>There was an error posting your message:</b> A topic with this title already exists. Please select another title.</td></tr>";
} else if (($userlevel==5) && (!$topic) && ($messageid)) {
echo "<table border=0 width=100%>

<tr><td Colspan=2 align=center><font SIZE=6><b>Preview Message</b></font></td></tr><tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Post Error</font></td></tr><tr><td COLSPAN=2><b>There was an error posting your message:</b> At your current level, Warned, you are not allowed to post any topics.</td></tr>";
} else if (($userlevel==5) && ($result6>=3) && ($messageid)) {
echo "<table border=0 width=100%>

<tr><td Colspan=2 align=center><font SIZE=6><b>Preview Message</b></font></td></tr><tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Post Error</font></td></tr><tr><td COLSPAN=2><b>There was an error posting your message:</b> At your current level, Warned, you are not allowed to post more than 3 messages per hour.</td></tr>";
} else if (($userlevel==5) && ($result7>=10) && ($messageid)) {
echo "<table border=0 width=100%>

<tr><td Colspan=2 align=center><font SIZE=6><b>Preview Message</b></font></td></tr><tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Post Error</font></td></tr><tr><td COLSPAN=2><b>There was an error posting your message:</b> At your current level, Warned, you are not allowed to post more than 10 messages per day.</td></tr>";
} else if (($userlevel==6) && ($result40>=1) && ($messageid)) {
echo "<table border=0 width=100%>

<tr><td Colspan=2 align=center><font SIZE=6><b>Preview Message</b></font></td></tr><tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Post Error</font></td></tr><tr><td COLSPAN=2><b>There was an error posting your message:</b> At your current level, Negative Karma, you are not allowed to post more than 1 message per day.</td></tr>";
} else if (($userlevel==6) && (!$topic) && ($messageid)) {
echo "<table border=0 width=100%>

<tr><td Colspan=2 align=center><font SIZE=6><b>Preview Message</b></font></td></tr><tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Post Error</font></td></tr><tr><td COLSPAN=2><b>There was an error posting your message:</b> At your current level, Negative Karma, you are not allowed to post any topics.</td></tr>";
} else if (($userlevel==5) && (!$topic) && ($messageid)) {
echo "<table border=0 width=100%>

<tr><td Colspan=2 align=center><font SIZE=6><b>Preview Message</b></font></td></tr><tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Post Error</font></td></tr><tr><td COLSPAN=2><b>There was an error posting your message:</b> At your current level, Warned, you are not allowed to post any topics.</td></tr>";
} else if (($messageid) && ($post)) {
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$usename=$myrow["username"];
$posttime=time();
$datedate=date("n/j/Y H:i");
$datedate=eregi_replace(" ","&nbsp;",$datedate);
if (!$topic) {
if (($userlevel<60) || (!$bump)) { $bump=0; }
if (($userlevel>=60) && ($bump)) { $bump=1; }
if (($userlevel>=60) && ($board==6)) {
$sql="UPDATE strings SET announcement='$announce'";
$result=mysql_query($sql);
}
$sql="INSERT INTO topics (topicname,boardnum,topicby,timesec,active,postdate,topicsec,autobump) VALUES ('$topictitleq','$board','$usename','$posttime','1','$datedate','$posttime','$bump')";
$result=mysql_query($sql);
$sql="SELECT * FROM topics WHERE topicname='$topictitleq' AND topicby='$uname' AND boardnum='$board'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$topicnum=$myrow["topicid"];
} else if ($topic) {
$topicnum=$topic;
}
$datedate=date("n/j/Y h:i:s A");
$sql="INSERT INTO messages (topic,messby,messsec,messbody,mesboard,postdate) VALUES ('$topicnum','$usename','$posttime','$messageq','$board','$datedate')";
$result=mysql_query($sql);
$time=time();
$sql="UPDATE topics SET timesec=$time WHERE topicid=$topicnum";
$result=mysql_query($sql);
$datedate=date("n/j/Y H:i");
$datedate=eregi_replace(" ","&nbsp;",$datedate);
$sql="UPDATE topics SET postdate='$datedate' WHERE topicid=$topicnum";
$result=mysql_query($sql);
if ($topic) {
$sql="SELECT * FROM messages WHERE topic='$topic'";
$result=mysql_query($sql);
$result=@mysql_num_rows($result);
if ($result>=1000) {
$sql="UPDATE topics SET closed='1' WHERE topicid='$topic'";
$result=mysql_query($sql);
}
}
if ($messflag) {
$sql="SELECT * FROM words WHERE wordid=$messflag";
$result19=mysql_query($sql);
$myrow19=@mysql_fetch_array($result19);
$sql="SELECT * FROM messages WHERE topic='$topicnum' AND mesboard='$board' AND messbody='$messageq' AND messby='$uname'";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$time=time();
$datedate=date("n/j/Y h:i:s A");
$sql="INSERT INTO marked (reason,markwho,message,topic,board,reason2,markby,marksec,markdate) VALUES ('9','$useridu','".$myrow["messageid"]."','$topicnum','$board','".$myrow19["word"]."','$useridu','$time','$datedate')";
$result=mysql_query($sql);
$sql="SELECT * FROM marked WHERE message=$messageid";
$result30=mysql_query($sql);
$myrow30=@mysql_fetch_array($result30);
$sql="INSERT INTO secmarked (markid,reason,markwho,message,topic,board,reason2,markby,marksec,markdate) VALUES ('".$myrow30["markid"]."','9','$useridu','".$myrow["messageid"]."','$topicnum','$board','".$myrow19["word"]."','$useridu','$time','$datedate')";
$result=mysql_query($sql);
}

echo "<table border=0 width=100%>

<meta HTTP-EQUIV=\"refresh\" CONTENT=\"5; URL=genmessage.php?board=$board&topic=$topicnum\">

<tr><td Colspan=2 align=center><font SIZE=6><b>Message Posted</b></font></td></tr>
<tr><td Colspan=2 align=center>You should be returned to the Message List automatically in five seconds.  If not, you can click <a HREF=\"genmessage.php?board=$board&topic=$topicnum\">here</a> to continue.</td></tr>




</table>";
include("/home/mediarch/foot.php");
exit;
} else {
echo "<table border=0 width=100%>

<tr><td Colspan=2 align=center><font SIZE=6><b>Preview Message</b></font></td></tr>";
if ($messflag) {
$sql="SELECT * FROM words WHERE wordid=$messflag";
$result19=mysql_query($sql);
$myrow19=@mysql_fetch_array($result19);
echo "
<tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Post Warning</font></td></tr><tr><td COLSPAN=2><b>WARNING:</b> The message you entered contains one or more words that are usually associated with violations of the Message Board terms of service.<br>
<br>
".$myrow19["exp"]."<br>
<br>
You may go ahead and make this post, but it will be automatically flagged for review by a moderator.<br></td></tr>";
}
if (!$topic) {
echo "<tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>New Topic Preview</b></font></td></tr>
<tr><td CLASS=CELL1 COLSPAN=2>New Topic Title: <b>&quot;".stripslashes($topictitle2)."&quot;</b></td></tr>";
if (($board==6) && ($userlevel>=60)) {
echo "<tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>New Announcement</b></font></td></tr>
<tr><td CLASS=CELL1 COLSPAN=2>New Announcement: <b>&quot;".stripslashes($announce)."&quot;</b></td></tr>";
}
}
echo "<tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>New Message Preview</b></font></td></tr>

<tr><td CLASS=CELL1 COLSPAN=2>".stripslashes(trim($message2))."</td></tr>
<tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Post This Message?</font></td></tr>

<form ACTION=\"preview.php?board=$board";
if ($topic) {
echo "&topic=$topic";
}
echo "\" METHOD=POST>";
if (!$topic) {
echo "<input TYPE=hidden NAME=\"topicid\" VALUE=\"".stripslashes($topictitle8)."\">";
if ($userlevel>=53) { echo "<input TYPE=hidden NAME=\"htmlt\" VALUE=\"$htmlt\">"; }
if ($userlevel>=60) { echo "<input TYPE=hidden NAME=\"bump\" VALUE=\"$bump\">";
if ($board==6) { echo "<input TYPE=hidden NAME=\"announce\" VALUE=\"".stripslashes($announce)."\">"; }
}
}
echo "<input TYPE=hidden NAME=\"messageid\" VALUE=\"".stripslashes($message8)."\">";
if ($userlevel>=53) { echo "<input TYPE=hidden NAME=\"html\" VALUE=\"$html\">"; }
echo "<tr><td COLSPAN=2 ALIGN=CENTER><input type=\"submit\" value=\"Post Message\" name=\"post\"></td></tr>
</form>";
$correct=1;
}

echo "<form ACTION=\"preview.php?board=$board";
if ($topic) {
echo "&topic=$topic";
}
echo "\" METHOD=POST>";

if (!$topic) {
if ($userlevel>=53) {
echo "<tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Enable HTML</font></td></tr>
<tr><td COLSPAN=2><input type=\"checkbox\" value=\"1\" name=\"htmlt\"";
if ($htmlt) { echo  checked; }
echo "/>Enable HTML in the topic title?</td></tr>";
}
if ($userlevel>=60) {
echo "<tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Auto-Bump</font></td></tr>
<tr><td COLSPAN=2><input type=\"checkbox\" value=\"1\" name=\"bump\"";
if ($bump) { echo  checked; }
echo "/>Auto-Bump this topic?</td></tr>";
if ($board==6) {
echo "<tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Announcement</font></td></tr>
<tr><td>Announcement<br>(Between 1 and 512 characters in length)</td>

    <td><input type=\"text\" size=\"60\" maxlength=\"512\" name=\"announce\" value=\"".stripslashes($announce)."\" ></td></tr>";
}
}
echo "<tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Edit Topic</font></td></tr>
<tr><td COLSPAN=2>To create a new topic, enter a title and a Topic Classification for the topic below and create the first message.</td></tr>

<tr><td>Topic Title<br>(Between 5 and 80 characters in length)</td>

    <td><input type=\"text\" size=\"60\" maxlength=\"80\" name=\"topictitle\" value=\"".stripslashes($topictitle)."\" ></td></tr>";
}
if ($userlevel>=53) {
echo "<tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Enable HTML</font></td></tr>
<tr><td COLSPAN=2><input type=\"checkbox\" value=\"1\" name=\"html\"";
if ($html) { echo  checked; }
echo ">Enable HTML in this message?</td></tr>";
}
echo "<tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Edit Message</font></td></tr>
<tr><td COLSPAN=2>Enter your message text below.</td></tr>

<tr><td>Message:</td>

<td><textarea cols=\"60\" rows=\"20\" name=\"message\" WRAP=\"virtual\">".stripslashes($message)."</textarea></td></tr>";
echo "<tr><td COLSPAN=2 ALIGN=CENTER><input type=\"submit\" value=\"Post Message\" name=\"post\"><input type=\"submit\" value=\"Preview Message\" name=\"post\"><input type=\"reset\" value=\"Reset\" name=\"reset\"></td></tr>

</form>


</table>";
include("/home/mediarch/foot.php");
?>