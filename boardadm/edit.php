<?
$pagetitle="Board Editor";
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
echo "<table border=0 width=100%>

<tr><td>You are not authorized to view this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
if ((!$id) && (!$bid))
{
echo "<table border=0 width=100%>

<tr><td>An invalid link was used to access this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
if (($id) && ($bid))
{
echo "<table border=0 width=100%>

<tr><td>An invalid link was used to access this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
if ($id) {
$sql="SELECT * FROM boardcat WHERE id=$id";
$result=mysql_query($sql);
$numrows=mysql_num_rows($result);
if ($numrows<=0) {
echo "<table border=0 width=100%>

<tr><td>An invalid link was used to access this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
}
if ($bid) {
$sql="SELECT * FROM boards WHERE boardid=$bid";
$result=mysql_query($sql);
$numrows=mysql_num_rows($result);
if ($numrows<=0) {
echo "<table border=0 width=100%>

<tr><td>An invalid link was used to access this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
}
if (($id) && ($post) && ($name)) {
$sql="UPDATE boardcat SET `name`='$name' WHERE id=$id";
$result=mysql_query($sql);
if (!$hidden) { $hidden=0; }
if ($hidden) { $hidden=1; }
$sql="UPDATE boardcat SET `hidden`='$hidden' WHERE id=$id";
$result=mysql_query($sql);
if (!$caps) { $caps=0; }
if ($caps) { $caps=1; }
$sql="UPDATE boardcat SET `capshow`='$caps' WHERE id=$id";
$result=mysql_query($sql);
if ($swap>0) {
$sql="UPDATE boards SET `type`=0 WHERE `type`=$id";
$result=mysql_query($sql);
$sql="UPDATE boards SET `type`=$id WHERE `type`=$swap";
$result=mysql_query($sql);
$sql="UPDATE boards SET `type`=$swap WHERE `type`=0";
$result=mysql_query($sql);
$sql="UPDATE boardcat SET `id`=0 WHERE `id`=$id";
$result=mysql_query($sql);
$sql="UPDATE boardcat SET `id`=$id WHERE `id`=$swap";
$result=mysql_query($sql);
$sql="UPDATE boardcat SET `id`=$swap WHERE `id`=0";
$result=mysql_query($sql);
}
echo "<table border=0 width=100%>
<meta HTTP-EQUIV=\"refresh\" CONTENT=\"5; URL=edboards.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">
<tr><td align=center><font SIZE=6>Board Editor</font></td></tr>
<tr><td>This category has been updated. You will be returned to the Board Editor in 5 seconds. If not, click <a href=\"edboards.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">here</a>.</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
$errorst="";
if ($boardid) {
$sql="SELECT * FROM boards WHERE boardid=$boardid AND boardid<>$bid";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
}
if (($boardid) && ($numrows<=0)) {
if (($bid) && ($post) && ($boardid) && ($boardname) && ($type)) {
$sql="UPDATE boards SET `boardname`='$boardname' WHERE boardid=$bid";
$result=mysql_query($sql);
$sql="UPDATE boards SET `type`='$type' WHERE boardid=$bid";
$result=mysql_query($sql);
$sql="UPDATE boards SET `messlevel`='$messlevel' WHERE boardid=$bid";
$result=mysql_query($sql);
$sql="UPDATE boards SET `topiclevel`='$topiclevel' WHERE boardid=$bid";
$result=mysql_query($sql);
$sql="UPDATE boards SET `boardlevel`='$boardlevel' WHERE boardid=$bid";
$result=mysql_query($sql);
if (!$default) { $default=0; }
if ($default) { $default=1; }
$sql="UPDATE boards SET `default`='$default' WHERE boardid=$bid";
$result=mysql_query($sql);
$sql="UPDATE boards SET `boardid`='$boardid' WHERE boardid=$bid";
$result=mysql_query($sql);
echo "<table border=0 width=100%>
<meta HTTP-EQUIV=\"refresh\" CONTENT=\"5; URL=edboards.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">
<tr><td align=center><font SIZE=6>Board Editor</font></td></tr>
<tr><td>This board has been updated. You will be returned to the Board Editor in 5 seconds. If not, click <a href=\"edboards.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">here</a>.</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
} else if (($boardid) && ($numrows>=1)) {
$errorst="<tr><td><b>There was an error updating this board:</b> There is already a board with this same ID number!</td></tr>";
}
echo "<table border=0 width=100%>

<tr><td align=center><font SIZE=6>Board Editor</font></td></tr>
<tr><td CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo " | <a HREF=\"admpanel.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Control Panel</a>
</i></font></td></tr>";
if ($id) {
$sql="SELECT * FROM boardcat WHERE id=$id";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
echo "<tr><td CLASS=LITE><font Size=3>Edit Category</font></td></tr>
<form action=\"edit.php?id=$id";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td>Category Name: <input type=\"text\" name=\"name\" value=\"".$myrow["name"]."\" size=\"80\" maxlength=\"255\"><br>
<input type=\"checkbox\" name=\"hidden\" value=\"1\"";
if ($myrow["cathide"]==1) { echo " checked"; }
echo "> Hidden<br>
<input type=\"checkbox\" name=\"caps\" value=\"1\"";
if ($myrow["capshow"]==1) { echo " checked"; }
echo "> Showing Captions<br>
Swap with: <select name=\"swap\" size=\"1\">
	<option value=\"0\">N/A</option>";
$sql="SELECT * FROM boardcat WHERE id<>$id ORDER BY id ASC";
$result88=mysql_query($sql);
while ($myrow88=@mysql_fetch_array($result88)) {
echo "<option value=\"".$myrow88["id"]."\">".$myrow88["name"]."</option>
";
}
echo "</select><br>
<input type=\"submit\" name=\"post\" value=\"Apply Changes\">
</td></tr>
</form>
</table>
";
include("/home/mediarch/foot.php");
} else if ($bid) {
$sql="SELECT * FROM boards WHERE boardid=$bid";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$t5=$myrow["type"];
echo "$errorst
<form action=\"edit.php?bid=$bid";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td CLASS=LITE><font Size=3>Edit Board</font></td></tr>
<tr><td>Board ID: <input type=\"text\" name=\"boardid\" value=\"".$myrow["boardid"]."\" size=\"5\" maxlength=\"10\"><br>
Board Name: <input type=\"text\" name=\"boardname\" value=\"".$myrow["boardname"]."\" size=\"80\" maxlength=\"255\"><br>
Caption: <input type=\"text\" name=\"caption\" value=\"".$myrow["caption"]."\" size=\"80\" maxlength=\"255\"><br>
View Level: <input type=\"text\" name=\"boardlevel\" value=\"".$myrow["boardlevel"]."\" size=\"2\" maxlength=\"2\"><br>
Topic Level: <input type=\"text\" name=\"topiclevel\" value=\"".$myrow["topiclevel"]."\" size=\"2\" maxlength=\"2\"><br>
Message Level: <input type=\"text\" name=\"messlevel\" value=\"".$myrow["messlevel"]."\" size=\"2\" maxlength=\"2\"><br>
Board Category: <select name=\"type\" size=\"1\">";
$sql="SELECT * FROM boardcat WHERE `id`=$t5";
$result2=mysql_query($sql);
$myrow2=@mysql_fetch_array($result2);
echo "<option value=\"".$myrow2["id"]."\">".$myrow2["name"]." (Current)</option>";
$sql="SELECT * FROM boardcat ORDER BY id ASC";
$result2=mysql_query($sql);
while ($myrow2=@mysql_fetch_array($result2)) {
echo "<option value=\"".$myrow2["id"]."\">".$myrow2["name"]."</option>
";
}
echo "</select><br>
<input type=\"checkbox\" name=\"default\" value=\"1\"";
if ($myrow["default"]==1) { echo " checked"; }
echo "> Default<br>
<input type=\"submit\" name=\"post\" value=\"Apply Changes\">
</td></tr>
</form>
</table>";
include("/home/mediarch/foot.php");
}
?>

