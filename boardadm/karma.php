<?
$pagetitle="Karma Boost";
include("/home/mediarch/head.php");
echo $harsss;
echo "<table border=1 cellspacing=0 width=100%>

<tr><td COLSPAN=4 align=center><font SIZE=6>Karma Boost</font></td></tr>";
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
if ($myrow["level"]<=59)
{
echo "<tr><td>You are not authorized to view this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
echo "<tr><td COLSPAN=2 CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"/boards/gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"/boards/genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo " | <a HREF=\"index.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Control Panel</a>
</i></font></td></tr>";
if ($post) {
if (!$percentage) {
echo "<tr><td COLSPAN=2><font SIZE=2><b>You did not enter a percentage.</b></font></td></tr>";
} else if ($percentage>100) {
echo "<tr><td COLSPAN=2><font SIZE=2><b>You cannot give a karma boost of more than 100%.</b></font></td></tr>";
} else if ($percentage) {
$percentage=$percentage*0.01;
$percentage=$percentage+1;
$sql="SELECT * FROM users WHERE cookies>0 AND level>0";
$result=mysql_query($sql);
while ($myrow=mysql_fetch_array($result)) {
$karma=$myrow["cookies"]*$percentage;
$karma=round($karma);
$unamee=$myrow["username"];
$sql3="UPDATE users SET cookies=$karma WHERE username='$unamee'";
$result3=mysql_query($sql3);
}
echo "<tr><td COLSPAN=3><font SIZE=2>Karma successfully boosted.</font></td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}
}
echo "<form ACTION=\"karma.php\" METHOD=POST>
<tr><td COLSPAN=2 CLASS=SYS ALIGN=CENTER><font SIZE=2><b>Warning:</b>  This utility will give a certain percentage of karma to every user with positive karma. Do not hit the button multiple times or hit refresh once you have initiated the karma boost, unless you want to give multiple boosts.</font></td></tr>
<tr><td><font SIZE=2><b>Percentage of Karma to Boost</b></font></td>
<td><input type=text name=percentage value=\"\" maxlength=\"3\">%</td></tr>
<tr><td COLSPAN=2><input type=\"submit\" value=\"Boost\" name=\"post\"><input type=\"reset\" value=\"Reset\" name=\"reset\">
</td></tr>

</form>

</table>";
include("/home/mediarch/foot.php");
?>







