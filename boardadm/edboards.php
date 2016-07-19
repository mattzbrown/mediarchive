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
if ($myrow["level"]<60)
{
echo "<table border=0 width=100%>

<tr><td>You are not authorized to view this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
echo "<table border=0 width=100%>

<tr><td COLSPAN=11 align=center><font SIZE=6>Board Editor</font></td></tr>
<tr><td COLSPAN=11 CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"/boards/gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"/boards/genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo " | <a HREF=\"index.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Control Panel</a>
</i></font></td></tr>";
if ($id) {
$sql="SELECT * FROM boards WHERE `type`=$id";
$result2=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result2)) {
$bbid=$myrow["boardid"];
$sql="DELETE FROM topics WHERE boardnum=$bbid";
$result=mysql_query($sql);
$sql="DELETE FROM messages WHERE mesboard=$bbid";
$result=mysql_query($sql);
$sql="DELETE FROM boards WHERE boardid=$bbid";
$result=mysql_query($sql);
$sql="DELETE FROM favorites WHERE boardid=$bbid";
$result=mysql_query($sql);
$sql="DELETE FROM featured WHERE boardid=$bbid";
$result=mysql_query($sql);
}
$sql="DELETE FROM boardcat WHERE id=$id";
$result=mysql_query($sql);
echo "<tr><td colspan=11 align=center><b>This board category was deleted successfully.</b></td></tr>";
}
if (($bid) && ($op=="p")) {
$sql="DELETE FROM topics WHERE boardnum=$bid";
$result=mysql_query($sql);
$sql="DELETE FROM messages WHERE mesboard=$bid";
$result=mysql_query($sql);
echo "<tr><td colspan=11 align=center><b>This board was purged successfully.</b></td></tr>";
}
if (($bid) && ($op=="d")) {
$sql="DELETE FROM boards WHERE boardid=$bid";
$result=mysql_query($sql);
$sql="DELETE FROM topics WHERE boardnum=$bid";
$result=mysql_query($sql);
$sql="DELETE FROM messages WHERE mesboard=$bid";
$result=mysql_query($sql);
$sql="DELETE FROM favorites WHERE boardid=$bid";
$result=mysql_query($sql);
$sql="DELETE FROM featured WHERE boardid=$bid";
$result=mysql_query($sql);
echo "<tr><td colspan=11 align=center><b>This board was deleted successfully.</b></td></tr>";
}
if (($post=="Add Category") && ($name)) {
if (!$hidden) { $hidden=0; }
if ($hidden) { $hidden=1; }
if (!$caps) { $caps=0; }
if ($caps) { $caps=1; }
$name=htmlentities($name);
$sql="INSERT INTO boardcat (name,cathide,capshow) VALUES ('$name','$hidden','$caps')";
$result=mysql_query($sql);
echo "<tr><td colspan=11 align=center><b>This board category was added successfully.</b></td></tr>";
}
if ($type) {
$sql="SELECT * FROM boardcat WHERE id=$type";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
}
if (($post=="Add Board") && ($boardid) && ($boardname) && ($type) && ($numrows>=1)) {
$sql="SELECT * FROM boards WHERE boardid=$boardid";
$result222=mysql_query($sql);
$num222=@mysql_num_rows($result222);
if ($num222<=0) {
if (!$default) { $default=0; }
if ($default) { $default=1; }
$boardname=htmlentities($boardname);
if ($caption) { $caption=htmlentities(addslashes($caption)); }
$sql="INSERT INTO boards (`boardid`,`boardname`,`boardlevel`,`type`,`topiclevel`,`messlevel`,`caption`,`default`) VALUES ('$boardid','$boardname','$boardlevel','$type','$topiclevel','$messlevel','$caption','$default')";
$result=mysql_query($sql);
echo "<tr><td colspan=11 align=center><b>This board was added successfully.</b></td></tr>";
} else {
echo "<tr><td colspan=11 align=center><b>There was an error adding this board:</b><br>The board ID you entered already exists.</td></tr>";
}
}
echo "<tr>
<td CLASS=LITE ALIGN=center><i>Board&nbsp;ID</i></td>
<td CLASS=LITE ALIGN=center><i>Board&nbsp;Name</i></td>
<td CLASS=LITE ALIGN=center><i>View&nbsp;Level</i></td>
<td CLASS=LITE ALIGN=center><i>Topic&nbsp;Level</i></td>
<td CLASS=LITE ALIGN=center><i>Message&nbsp;Level</i></td>
<td CLASS=LITE ALIGN=center><i>Default</i></td>
<td CLASS=LITE ALIGN=center><i>Topics</i></td>
<td CLASS=LITE ALIGN=center><i>Messages</i></td>
<td CLASS=LITE ALIGN=center><i>Purge</i></td>
<td CLASS=LITE ALIGN=center><i>Edit</i></td>
<td CLASS=LITE ALIGN=center><i>Delete</i></td>
</tr>";
$sql="SELECT * FROM boardcat ORDER BY id ASC";
$result1=mysql_query($sql);
while ($mycat=@mysql_fetch_array($result1)) {
$type=$mycat["id"];
echo "<tr><td CLASS=LITE COLSPAN=9><font Size=3>".$mycat["name"]."";
if ($mycat["cathide"]>=1) {
echo " (Hidden)";
}
if ($mycat["capshow"]>=1) {
echo " (Showing Captions)";
}
echo "</font></td><td CLASS=LITE><font Size=3><a href=\"edit.php?id=".$mycat["id"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>[Edit]</a></font></td><td CLASS=LITE><font Size=3><a href=\"edboards.php?id=".$mycat["id"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>[Delete]</a></font></td></tr>";
$sql="SELECT * FROM boards WHERE `type`=$type ORDER BY boardname ASC";
$result=mysql_query($sql);
$numrows=mysql_num_rows($result);
if ($numrows>=1) {
while ($myrow=@mysql_fetch_array($result)) {
$boardiid=$myrow["boardid"];
$sql="SELECT * FROM topics WHERE boardnum=$boardiid";
$resultn=mysql_query($sql);
$topics=mysql_num_rows($resultn);
$sql="SELECT * FROM messages WHERE mesboard=$boardiid";
$resultn=mysql_query($sql);
$messages=mysql_num_rows($resultn);
echo "<tr>
<td CLASS=CELL1>".$myrow["boardid"]."</td>
<td CLASS=CELL1><font SIZE=3><b><a href=\"/boards/gentopic.php?board=".$myrow["boardid"]."\">".$myrow["boardname"]."</a></b></font>";
if ($myrow["caption"]) { echo "<br><font SIZE=1>".stripslashes($myrow["caption"])."</font>"; }
echo "</td>
<td CLASS=CELL1>".$myrow["boardlevel"]."</td>
<td CLASS=CELL1>".$myrow["topiclevel"]."</td>
<td CLASS=CELL1>".$myrow["messlevel"]."</td>
<td CLASS=CELL1>";
if ($myrow["default"]==1) echo "<font face=\"wingdings\" size=\"3\">ü</font>";
echo "</td>
<td CLASS=CELL1>".$topics."</td>
<td CLASS=CELL1>".$messages."</td>
<td CLASS=CELL1><a href=\"edboards.php?bid=".$myrow["boardid"]."&op=p";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">[Purge]</a></td>
<td CLASS=CELL1><a href=\"edit.php?bid=".$myrow["boardid"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">[Edit]</a></td>
<td CLASS=CELL1><a href=\"edboards.php?bid=".$myrow["boardid"]."&op=d";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">[Delete]</a></td></tr>";
}
} else {
echo "<tr><td CLASS=CELL1 colspan=11>There are no boards in this category.</td></tr>";
}
}
echo "<tr><td CLASS=DARK COLSPAN=11><font Size=3>Add New Category</font></td></tr>
<form action=\"edboards.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td colspan=11>Category Name: <input type=\"text\" name=\"name\" size=\"80\" maxlength=\"255\"><br>
<input type=\"checkbox\" name=\"hidden\" value=\"1\"> Hidden<br>
<input type=\"checkbox\" name=\"caps\" value=\"1\"> Showing Captions<br>
<input type=\"submit\" name=\"post\" value=\"Add Category\">
</td></tr>
</form>";
$sql="SELECT * FROM boardcat";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
if ($numrows>=1) {
echo "
<tr><td CLASS=DARK COLSPAN=11><font Size=3>Add New Board</font></td></tr>
<form action=\"edboards.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td colspan=11>Board ID: <input type=\"text\" name=\"boardid\" size=\"10\" maxlength=\"20\"><br>
<tr><td colspan=11>Board Name: <input type=\"text\" name=\"boardname\" size=\"80\" maxlength=\"255\"><br>
Caption: <input type=\"text\" name=\"caption\" size=\"80\" maxlength=\"255\"><br>
View Level: <input type=\"text\" name=\"boardlevel\" size=\"2\" maxlength=\"2\"><br>
Topic Level: <input type=\"text\" name=\"topiclevel\" size=\"2\" maxlength=\"2\"><br>
Message Level: <input type=\"text\" name=\"messlevel\" size=\"2\" maxlength=\"2\"><br>
Board Category: <select name=\"type\" size=\"1\">";
$sql="SELECT * FROM boardcat ORDER BY id ASC";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
echo "<option value=\"".$myrow["id"]."\">".$myrow["name"]."</option>
";
}
echo "</select><br>
<input type=\"checkbox\" name=\"default\" value=\"1\" checked> Default<br>
<input type=\"submit\" name=\"post\" value=\"Add Board\">
</td></tr>
</form>";
}

echo "</table>";
include("/home/mediarch/foot.php");
?>


