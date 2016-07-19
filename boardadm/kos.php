<?
$pagetitle="KOS";
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
if ($myrow["level"]<=59)
{
echo "<table border=1 cellspacing=0 width=100%>
<tr><td>You are not authorized to view this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
echo "<table border=1 cellspacing=0 width=100%>

<tr><td COLSPAN=5 align=center><font SIZE=6>KOS Utility</font></td></tr>
<tr><td COLSPAN=5 CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"/boards/gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"/boards/genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo " | <a HREF=\"index.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Control Panel</a>
</i></font></td></tr>";
if (($op) && ($id)) {
$sql="DELETE FROM kos WHERE kosid=$id";
$result=mysql_query($sql);
echo "<tr><td align=center colspan=5><b>This KOS was removed successfully.</b></td></tr>";
}
if (($post) && ($alias) && ($ip) && ($isp)) {
$sql="INSERT INTO kos (alias,ip,isp) VALUES ('$alias','$ip','$isp')";
$result=mysql_query($sql);
echo "<tr><td align=center colspan=5><b>This KOS was added successfully.</b></td></tr>";
}
echo "<TR><TD COLSPAN=5 CLASS=DARK ALIGN=CENTER><FONT SIZE=3>Active KOSes</font></td></tr>
<tr>
<td class=\"LITE\"><i>KOS ID</i></td>
<td class=\"LITE\"><i>Alias</i></td>
<td class=\"LITE\"><i>IP</i></td>
<td class=\"LITE\"><i>ISP</i></td>
<td class=\"LITE\"><i>Action</i></td>
</tr>";
$sql="SELECT * FROM kos ORDER BY kosid ASC";
$result=mysql_query($sql);
while ($myrow=mysql_fetch_array($result)) {
echo "<tr><td>".$myrow["kosid"]."</td><td>".$myrow["alias"]."</td><td>".$myrow["ip"]."</td><td>".$myrow["isp"]."</td><td><a href=\"kos.php?op=1&id=".$myrow["kosid"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">[Delete]</a></td></tr>";
}
echo "<form action=\"kos.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\"><tr><td>&nbsp;</td><td><input type=\"text\" name=\"alias\" value=\"\" size=\"20\" maxlength=\"50\"></td><td><input type=\"text\" name=\"ip\" value=\"\" size=\"20\" maxlength=\"50\"></td><td><input type=\"text\" name=\"isp\" value=\"\" size=\"20\" maxlength=\"50\"></td><td><input type=\"submit\" name=\"post\" value=\"Add KOS\"></td></tr>
</form>
<form method=\"post\" action=\"http://ws.arin.net/cgi-bin/whois.pl\" name=\"\">
<tr><td colspan=5>WHOIS query: <input typr=\"test\" name=\"queryinput\" size=\"20\" maxlength=\"20\" value=\"\">
<input type=\"submit\">
</td></tr>
</form>
</table>";
include("/home/mediarch/foot.php");
?>