<?
$pagetitle="Active Message List";
include("/home/mediarch/head.php");
echo $harsss;
echo "<table border=0 cellspacing=1 width=100%>

<tr><td COLSPAN=4 align=center><font SIZE=6>Active Posts</font></td></tr>";
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
$usrname=$myrow["username"];
if ($myrow["level"]<50)
{
echo "<tr><td>You are not authorized to view this page.</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
echo "<tr><td CLASS=LITE ALIGN=center COLSPAN=4><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"/boards/gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"/boards/genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo " | <a href=\"/boards/whois.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo"\" CLASS=MENU>Whois Page</a>";
echo " | <a HREF=\"index.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Control Panel</a>";
echo "</i></font></td></tr>";
$sql="SELECT * FROM users WHERE userid='$user'";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
if (!$user) {
echo "


<tr><td><br>
<table border=1 cellspacing=0 width=80% align=center>
<form action=\"posthist.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td><b>Enter a User ID to look up:</td><td><input type=\"text\" name=\"user\" value=\"\" size=\"20\" maxlength=\"20\">
<input type=\"submit\" name=\"post\" value=\"Search\">
</td></tr></form></table>

<br>
</tr></td>





</table>";
include("/home/mediarch/foot.php");
exit;
}
if (!$myrow) {
echo "<tr><td align=center><b>There was an error viewing user posts:</b> This user does not exist.</td></tr>
<tr><td><br>
<table border=1 cellspacing=0 width=80% align=center>
<form action=\"posthist.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td><b>Enter a User ID to look up:</td><td><input type=\"text\" name=\"user\" value=\"\" size=\"20\" maxlength=\"20\">
<input type=\"submit\" name=\"post\" value=\"Search\">
</td></tr></form></table>

<br>
</tr></td>
</table>";
include("/home/mediarch/foot.php");
exit;
}
$username=$myrow["username"];
echo "<tr>
<td CLASS=CELL2><font Size=2><b>Board</b></font></td>
<td CLASS=CELL2><font Size=2><b>Topic</b></font></td>
<td CLASS=CELL2><font Size=2><b>Posts</b></font></td>
<td CLASS=CELL2><font Size=2><b>Posted On</b></font></td>
<tr>";
if (!$page) {
$page=0;
}
$pages=$page*20;
$pages2=$page+1;
$pages2=$pages2*20;
$posted=" ";
$sql="SELECT * FROM messages WHERE messby='$username' ORDER BY messsec DESC";
$result=mysql_query($sql);
if (@mysql_num_rows($result)>=1) {
while ($myrow=@mysql_fetch_array($result)) {
$topicid=$myrow["topic"];
$no=0;
if (ereg(" $topicid ", $posted)>=1) {
$no=1;
}
if ($no<=0) {
$posted .= "$topicid ";
}
}
$posted=trim($posted);
$posted=explode(" ", $posted);
while (list($key, $val) = each($posted)) {
if (($key>=$pages) && ($key<$pages2)) {
$sql="SELECT * FROM topics WHERE topicid=$val";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$boardid=$myrow["boardnum"];
$topicname=$myrow["topicname"];
$sql="SELECT * FROM boards WHERE boardid=$boardid";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$boardname=$myrow["boardname"];
$sql="SELECT * FROM messages WHERE topic=$val AND messby='$username'";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
$sql="SELECT * FROM messages WHERE topic=$val AND messby='$username' ORDER BY messsec DESC LIMIT 0, 1";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$postdate=$myrow["postdate"];
echo "<tr>
<td CLASS=CELL2><font Size=2>$boardname</font></td>
<td CLASS=CELL2><font Size=2><a HREF=\"/boards/genmessage.php?board=$boardid&topic=$val\">".stripslashes($topicname)."</a></font></td>
<td CLASS=CELL2><font Size=2>$numrows</font></td>
<td CLASS=CELL2><font Size=2>$postdate</font></td><tr>";
}
}
$numberoftopics=count($posted);
$numberoftopics=$numberoftopics/20;
$maxpages=ceil($numberoftopics);
$maxpages1=$maxpages-1;
$maxpages2=$maxpages-2;
if (count($posted)>20)
{
echo "<tr><td CLASS=LITE ALIGN=center COLSPAN=4><font SIZE=3><i>";
$previouspage=$page-1;
$nextpage=$page+1;
$pagex=$page+1;
if ($page>0) {
echo "<a CLASS=MENU HREF=\"posthist.php?user=$user&";
if ($board) { echo "board=$board&"; }
if ($topic) { echo "topic=$topic&"; }
echo "page=".$previouspage."\">Previous Page</a>";
}
if (($page>0) && ($page<$maxpages1)) { echo " "; }
if ($page<$maxpages1) {
echo "<a CLASS=MENU HREF=\"posthist.php?user=$user&";
if ($board) { echo "board=$board&"; }
if ($topic) { echo "topic=$topic&"; }
echo "page=".$nextpage."\">Next Page</a>";
}
echo "</i></font></td></tr>";
}
}
echo "</table>

<br>
</tr></td></table>";
include("/home/mediarch/foot.php");
?>











