<?
$pagetitle="User Directory";
include("/home/mediarch/head.php");
echo $harsss;
echo "<table border=0 cellspacing=2 width=100%>

<tr><td COLSPAN=6 align=center><font SIZE=5><b>User Directory</font></b></td></tr>";
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
echo "<tr><td COLSPAN=6 CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"/boards/gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"/boards/genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo " | <a HREF=\"onlineusers.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\" CLASS=MENU>Online Users</a>";
echo " | <a HREF=\"user.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\" CLASS=MENU>User Info Page</a>";
echo "</i></font></td></tr>";
if (!$page) {
$page=0;
}
$pages=$page*50;
if (!$order) {
$order="userid";
}
if (($order!="userid") && ($order!="username") && ($order!="cookies") && ($order!="aura") && ($order!="regsec") && ($order!="lastsec")) {
$order="userid";
}
if (($tem!="ASC") && ($tem!="DESC")) {
$tem="ASC";
}
if (!$tem) {
$tem="ASC";
}
if ($tem=="ASC") {
$newtem="DESC";
}
if ($tem=="DESC") {
$newtem="ASC";
}
if (!$newtem) {
$newtem="ASC";
}
echo "<tr><td CLASS=DARK width=17%><font size=3><a href=\"userlist.php?order=userid&tem=";
if ($order=="userid") {
echo "$newtem";
} else {
echo "ASC";
}
echo "&page=$page\" CLASS=MENU>User ID</a>";
if (($order=="userid") && ($tem=="ASC")) {
echo " (Ascending)";
} else if (($order=="userid") && ($tem=="DESC")) {
echo " (Descending)";
}
echo "</td><td CLASS=DARK width=17%><font size=3><a href=\"userlist.php?order=username&tem=";
if ($order=="username") {
echo "$newtem";
} else {
echo "ASC";
}
echo "&page=$page\" CLASS=MENU>UserName</a>";
if (($order=="username") && ($tem=="ASC")) {
echo " (Ascending)";
} else if (($order=="username") && ($tem=="DESC")) {
echo " (Descending)";
}
echo "</td><td CLASS=DARK width=16%><font size=3><a href=\"userlist.php?order=cookies&tem=";
if ($order=="cookies") {
echo "$newtem";
} else {
echo "ASC";
}
echo "&page=$page\" CLASS=MENU>Karma</a>";
if (($order=="cookies") && ($tem=="ASC")) {
echo " (Ascending)";
} else if (($order=="cookies") && ($tem=="DESC")) {
echo " (Descending)";
}
echo "</td><td CLASS=DARK width=16%><font size=3><a href=\"userlist.php?order=aura&tem=";
if ($order=="aura") {
echo "$newtem";
} else {
echo "ASC";
}
echo "&page=$page\" CLASS=MENU>Aura</a>";
if (($order=="aura") && ($tem=="ASC")) {
echo " (Ascending)";
} else if (($order=="aura") && ($tem=="DESC")) {
echo " (Descending)";
}
echo "</td><td CLASS=DARK width=17%><font size=3><a href=\"userlist.php?order=regsec&tem=";
if ($order=="regsec") {
echo "$newtem";
} else {
echo "ASC";
}
echo "&page=$page\" CLASS=MENU>Register Date</a>";
if (($order=="regsec") && ($tem=="ASC")) {
echo " (Ascending)";
} else if (($order=="regsec") && ($tem=="DESC")) {
echo " (Descending)";
}
echo "</td><td CLASS=DARK width=17%><font size=3><a href=\"userlist.php?order=lastsec&tem=";
if ($order=="lastsec") {
echo "$newtem";
} else {
echo "ASC";
}
echo "&page=$page\" CLASS=MENU>Last Login</a>";
if (($order=="lastsec") && ($tem=="ASC")) {
echo " (Ascending)";
} else if (($order=="lastsec") && ($tem=="DESC")) {
echo " (Descending)";
}
echo "</td></tr>";
$sql="SELECT * FROM users ORDER BY $order $tem LIMIT $pages,50";
$result=@mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
echo "<tr><td width=17%>".$myrow["userid"]."</td><td width=17%>";
echo "<a href=\"/boards/whois.php?user=".$myrow["userid"]."";
if ($board) { echo "&board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">".$myrow["username"]."</a></td><td width=16%>".$myrow["cookies"]."</td><td width=16%>".$myrow["aura"]."</td><td width=17%>".str_replace(" ","&nbsp;",date("n/j/Y h:i:s A",($myrow["regsec"]+$time_offset)))."</td><td width=17%>".str_replace(" ","&nbsp;",date("n/j/Y h:i:s A",($myrow["lastsec"]+$time_offset)))."</td></tr>";
}

$sql="SELECT * FROM users";
$result=mysql_query($sql);
$numberoftopics=mysql_num_rows($result);
$numberoftopics=$numberoftopics/50;
$maxpages=ceil($numberoftopics);
$maxpages1=$maxpages-1;
$maxpages2=$maxpages-2;
if (mysql_num_rows($result)>50)
{
echo "<tr><td COLSPAN=6 CLASS=LITE ALIGN=center><font size=3><i>";
$previouspage=$page-1;
$nextpage=$page+1;
$sql="SELECT * FROM users";
$result=mysql_query($sql);
$numberoftopics=mysql_num_rows($result);
$numberoftopics=$numberoftopics/50;
$pagex=$page+1;
if ($page>0) echo "<a CLASS=MENU HREF=\"userlist.php?order=$order&tem=$tem&page=0\">First Page</a>";
if (($page>0) && ($page>1)) echo " | <a CLASS=MENU HREF=\"userlist.php?order=$order&tem=$tem&page=".$previouspage."\">Previous Page</a>";
if (($page>0) || ($page>1)) echo " | ";
echo "Page $pagex of $maxpages";
if (($page<$maxpages1) || ($page<$maxpages2)) echo " | ";
if (($page<$maxpages1) && ($page<$maxpages2)) echo "<a CLASS=MENU HREF=\"userlist.php?order=$order&tem=$tem&page=".$nextpage."\">Next Page</a> | ";
if ($page<$maxpages1) echo "<a CLASS=MENU HREF=\"userlist.php?order=$order&tem=$tem&page=".$maxpages1."\">Last Page</a>";
echo "</i></font></td></tr>";
}



echo "</table>";
include("/home/mediarch/foot.php");
?>


