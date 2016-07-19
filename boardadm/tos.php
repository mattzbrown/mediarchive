<?
$pagetitle="TOS Editor";
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
if ($myrow["level"]<60)
{
echo "<table border=1 cellspacing=0 width=100%>
<tr><td>You are not authorized to view this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
echo "<table border=1 cellspacing=0 width=100%>

<tr><td COLSPAN=3 align=center><font SIZE=6>TOS Editor</font></td></tr>
<tr><td COLSPAN=3 CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"/boards/gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"/boards/genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo " | <a HREF=\"index.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Control Panel</a>
</i></font></td></tr>";
if ($id) {
$sql="DELETE FROM tos WHERE tosid=$id";
$result=mysql_query($sql);
echo "<tr><td align=center colspan=3><b>This TOS rule was removed successfully.</b></td></tr>";
}
if (($post) && ($rtitle) && ($rbody) && ($rdesc)) {
if ($tosshow) { $tosshow=1; }
if ($markshow) { $markshow=1; }
if (!$tosshow) { $tosshow=0; }
if (!$markshow) { $markshow=0; }
$sql="INSERT INTO tos (ruletitle,rulebody,ruledesc,ruleguide,tosshow,markshow) VALUES ('".htmlentities($rtitle)."','".nl2br($rbody)."','$rdesc','".nl2br($ruleguide)."','$tosshow','$markshow')";
$result=mysql_query($sql);
echo "<tr><td align=center colspan=3><b>This TOS rule was added successfully.</b></td></tr>";
}
echo "
<td class=\"LITE\" align=center><i>Rule Title</i></td>
<td class=\"LITE\" align=center><i>Explanation</i></td>
<td class=\"LITE\" align=center><i>Remove</i></td>
</tr>";
$sql="SELECT * FROM tos ORDER BY tosid ASC";
$result=mysql_query($sql);
while ($myrow=mysql_fetch_array($result)) {
echo "<tr><td align=center rowspan=3 CLASS=CELL2>".$myrow["ruletitle"]."";
if ($myrow["tosshow"]==0) { echo "<br>(Hidden&nbsp;from&nbsp;TOS)"; }
if ($myrow["markshow"]==0) { echo "<br>(Hidden&nbsp;from&nbsp;marking)"; }
echo "</td><td CLASS=CELL1>".$myrow["rulebody"]."</td><td align=center rowspan=3 CLASS=CELL2><a href=\"tos.php?id=".$myrow["tosid"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">[Remove]</a></td></tr>
<tr><td CLASS=CELL1>".$myrow["ruledesc"]."</td></tr>
<tr><td CLASS=CELL1>".$myrow["ruleguide"]."</td></tr>";
}
echo "<tr><td COLSPAN=3 CLASS=DARK ALIGN=CENTER><font SIZE=3>Add New Rule</font></td></tr>";
echo "<form action=\"tos.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td>Rule Title:</td><td colspan=2><input type=\"text\" name=\"rtitle\" value=\"\" size=\"30\" maxlength=\"255\"></td></tr>
<tr><td>TOS explanation:</td><td colspan=2><textarea cols=\"60\" rows=\"8\" name=\"rbody\" WRAP=\"virtual\"></textarea></td></tr>
<tr><td>Marking explanation:</td><td colspan=2><input type=\"text\" name=\"rdesc\" value=\"\" size=\"60\" maxlength=\"512\"></td></tr>
<tr><td>Moderator guide:</td><td colspan=2><textarea cols=\"60\" rows=\"12\" name=\"rguide\" WRAP=\"virtual\"></textarea></td></tr>
<tr><td colspan=3><input type=\"checkbox\" name=\"tosshow\" value=\"1\"> Showing on TOS</td></tr>
<tr><td colspan=3><input type=\"checkbox\" name=\"markshow\" value=\"1\"> Showing on Message Marking</td></tr>
<tr><td colspan=3><input type=\"submit\" name=\"post\" value=\"Add TOS Rule\"></td></tr>
</form>
</form>
</table>";
include("/home/mediarch/foot.php");
?>