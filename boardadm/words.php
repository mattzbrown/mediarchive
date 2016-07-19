<?
$pagetitle="Banned Words";
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
echo "<tr><td>You are not authorized to view this page.</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$usrname=$myrow["username"];
if ($myrow["level"]<60)
{
echo "<tr><td>You are not authorized to view this page.</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
echo "<table border=1 cellspacing=0 width=100%>

<tr><td COLSPAN=3 align=center><font SIZE=6>Banned Word Control</font></td></tr>
<tr><td COLSPAN=3 CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"/boards/gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"/boards/genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo " | <a HREF=\"index.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Control Panel</a>
</i></font></td></tr>";
if (($post) && ($ban)) {
if ($ban==1) {
$sql="UPDATE options SET val=0 WHERE opid=2";
$result=mysql_query($sql);
}
if ($ban==2) {
$sql="UPDATE options SET val=1 WHERE opid=2";
$result=mysql_query($sql);
}
echo "<tr><td colspan=3 align=center><b>The miscellaneous options have been updated.</b></td></tr>";
}
if (($post) && ($flag)) {
if ($flag==1) {
$sql="UPDATE options SET val=0 WHERE opid=3";
$result=mysql_query($sql);
}
if ($flag==2) {
$sql="UPDATE options SET val=1 WHERE opid=3";
$result=mysql_query($sql);
}
echo "<tr><td colspan=3 align=center><b>The miscellaneous options have been updated.</b></td></tr>";
}
if (($post) && ($topicb)) {
if ($topicb==1) {
$sql="UPDATE options SET val=0 WHERE opid=4";
$result=mysql_query($sql);
}
if ($topicb==2) {
$sql="UPDATE options SET val=1 WHERE opid=4";
$result=mysql_query($sql);
}
echo "<tr><td colspan=3 align=center><b>The miscellaneous options have been updated.</b></td></tr>";
}
if (($post) && ($userb)) {
if ($userb==1) {
$sql="UPDATE options SET val=0 WHERE opid=5";
$result=mysql_query($sql);
}
if ($userb==2) {
$sql="UPDATE options SET val=1 WHERE opid=5";
$result=mysql_query($sql);
}
echo "<tr><td colspan=3 align=center><b>The miscellaneous options have been updated.</b></td></tr>";
}
if (($post) && ($passw)) {
if ($passw==1) {
$sql="UPDATE options SET val=0 WHERE opid=6";
$result=mysql_query($sql);
}
if ($passw==2) {
$sql="UPDATE options SET val=1 WHERE opid=6";
$result=mysql_query($sql);
}
echo "<tr><td colspan=3 align=center><b>The miscellaneous options have been updated.</b></td></tr>";
}
if ($wordid) {
$sql="DELETE FROM words WHERE wordid=$wordid";
$result=mysql_query($sql);
echo "<tr><td colspan=3 align=center><b>This word has been removed successfully.</b></td></tr>";
}
if (($post) && ($type>=1) && ($type<=6) && ($word)) {
$word=htmlentities($word);
$sql="SELECT * FROM words WHERE word='$word' AND type='$type'";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
if ($numrows>=1) {
echo "<tr><td colspan=3 align=center><b>There was an error adding a new word:</b> The exact same word has already been added.</td></tr>";
} else {
$sql="INSERT INTO words (`type`,`word`,`exp`) VALUES ('$type','$word','$exp')";
$result=mysql_query($sql);
echo "<tr><td colspan=3 align=center><b>A new word has been added successfully.</b></td></tr>";
} 
}
$sql="SELECT * FROM options WHERE opid=2";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
echo "<form action=\"words.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td colspan=3 CLASS=CELL2><b>Banned Words</b> <input type=\"radio\" name=\"ban\" value=\"1\"";
if ($myrow["val"]==0) { echo " checked"; }
echo "> Off <input type=\"radio\" name=\"ban\" value=\"2\"";
if ($myrow["val"]==1) { echo " checked"; }
echo "> On <input type=\"submit\" name=\"post\" value=\"Make Changes\"></td></tr>
</form>";
$sql="SELECT * FROM `words` WHERE `type`='1' ORDER BY `wordid` ASC";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
if ($numrows<=0) {
echo "<tr><td colspan=3 CLASS=CELL1>There are currently no banned words.</td></tr>";
} else {
while ($myrow=@mysql_fetch_array($result)) {
echo "<tr><td colspan=2 CLASS=CELL1>".$myrow["word"]."</td><td align=center CLASS=CELL1><a href=\"words.php?wordid=".$myrow["wordid"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">[Remove]</a></td></tr>";
}
}
echo "<form action=\"words.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<input type=\"hidden\" name=\"type\" value=\"1\">
<tr><td colspan=2 CLASS=CELL1><input type=\"text\" name=\"word\" size=\"50\" maxlength=\"255\"></td><td CLASS=CELL1><input type=\"submit\" name=\"post\" value=\"Add new word\"></td></tr>
</form>";
$sql="SELECT * FROM options WHERE opid=3";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
echo "<form action=\"words.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td colspan=3 CLASS=CELL2><b>Auto-Flagged Words</b> <input type=\"radio\" name=\"flag\" value=\"1\"";
if ($myrow["val"]==0) { echo " checked"; }
echo "> Off <input type=\"radio\" name=\"flag\" value=\"2\"";
if ($myrow["val"]==1) { echo " checked"; }
echo "> On <input type=\"submit\" name=\"post\" value=\"Make Changes\"></td></tr>
</form>";
$sql="SELECT * FROM `words` WHERE `type`='2' ORDER BY `wordid` ASC";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
if ($numrows<=0) {
echo "<tr><td colspan=3 CLASS=CELL1>There are currently no auto-flagged words.</td></tr>";
} else {
while ($myrow=@mysql_fetch_array($result)) {
echo "<tr><td CLASS=CELL1>".$myrow["word"]."</td><td width=60% CLASS=CELL1>".$myrow["exp"]."</td><td align=center CLASS=CELL1><a href=\"words.php?wordid=".$myrow["wordid"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">[Remove]</a></td></tr>";
}
}
echo "<form action=\"words.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<input type=\"hidden\" name=\"type\" value=\"2\">
<tr><td CLASS=CELL1><input type=\"text\" name=\"word\" size=\"50\" maxlength=\"255\"></td><td CLASS=CELL1>Explanation: <input type=\"text\" name=\"exp\" size=\"50\" maxlength=\"255\"></td><td CLASS=CELL1><input type=\"submit\" name=\"post\" value=\"Add new word\"></td></tr>
</form>";
$sql="SELECT * FROM options WHERE opid=4";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
echo "<form action=\"words.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\"><tr><td colspan=3 CLASS=CELL2><b>Banned In Topic Titles</b> <input type=\"radio\" name=\"topicb\" value=\"1\"";
if ($myrow["val"]==0) { echo " checked"; }
echo "> Off <input type=\"radio\" name=\"topicb\" value=\"2\"";
if ($myrow["val"]==1) { echo " checked"; }
echo "> On <input type=\"submit\" name=\"post\" value=\"Make Changes\"></td></tr>
</form>";
$sql="SELECT * FROM `words` WHERE `type`='3' ORDER BY `wordid` ASC";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
if ($numrows<=0) {
echo "<tr><td colspan=3 CLASS=CELL1>There are currently no banned words in topic titles.</td></tr>";
} else {
while ($myrow=@mysql_fetch_array($result)) {
echo "<tr><td colspan=2 CLASS=CELL1>".$myrow["word"]."</td><td align=center CLASS=CELL1><a href=\"words.php?wordid=".$myrow["wordid"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">[Remove]</a></td></tr>";
}
}
echo "<form action=\"words.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<input type=\"hidden\" name=\"type\" value=\"3\">
<tr><td colspan=2 CLASS=CELL1><input type=\"text\" name=\"word\" size=\"50\" maxlength=\"255\"></td><td CLASS=CELL1><input type=\"submit\" name=\"post\" value=\"Add new word\"></td></tr>
</form>";
$sql="SELECT * FROM options WHERE opid=5";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
echo "<form action=\"words.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\"><tr><td colspan=3 CLASS=CELL2><b>Banned in Usernames</b> <input type=\"radio\" name=\"userb\" value=\"1\"";
if ($myrow["val"]==0) { echo " checked"; }
echo "> Off <input type=\"radio\" name=\"userb\" value=\"2\"";
if ($myrow["val"]==1) { echo " checked"; }
echo "> On <input type=\"submit\" name=\"post\" value=\"Make Changes\"></td></tr>
</form>";
$sql="SELECT * FROM `words` WHERE `type`='4' ORDER BY `wordid` ASC";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
if ($numrows<=0) {
echo "<tr><td colspan=3 CLASS=CELL1>There are currently no banned words in usernames.</td></tr>";
} else {
while ($myrow=@mysql_fetch_array($result)) {
echo "<tr><td colspan=2 CLASS=CELL1>".$myrow["word"]."</td><td align=center CLASS=CELL1><a href=\"words.php?wordid=".$myrow["wordid"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">[Remove]</a></td></tr>";
}
}
echo "<form action=\"words.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<input type=\"hidden\" name=\"type\" value=\"4\">
<tr><td colspan=2 CLASS=CELL1><input type=\"text\" name=\"word\" size=\"50\" maxlength=\"255\"></td><td CLASS=CELL1><input type=\"submit\" name=\"post\" value=\"Add new word\"></td></tr>
</form>";
$sql="SELECT * FROM options WHERE opid=6";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
echo "<form action=\"words.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\"><tr><td colspan=3 CLASS=CELL2><b>Not Allowed in Passwords</b> <input type=\"radio\" name=\"passw\" value=\"1\"";
if ($myrow["val"]==0) { echo " checked"; }
echo "> Off <input type=\"radio\" name=\"passw\" value=\"2\"";
if ($myrow["val"]==1) { echo " checked"; }
echo "> On <input type=\"submit\" name=\"post\" value=\"Make Changes\"></td></tr>
</form>";
$sql="SELECT * FROM `words` WHERE `type`='5' ORDER BY `wordid` ASC";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
if ($numrows<=0) {
echo "<tr><td colspan=3 CLASS=CELL1>There are currently no words not allowed in passwords.</td></tr>";
} else {
while ($myrow=@mysql_fetch_array($result)) {
echo "<tr><td colspan=2 CLASS=CELL1>".$myrow["word"]."</td><td align=center CLASS=CELL1><a href=\"words.php?wordid=".$myrow["wordid"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">[Remove]</a></td></tr>";
}
}
echo "<form action=\"words.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<input type=\"hidden\" name=\"type\" value=\"5\">
<tr><td colspan=2 CLASS=CELL1><input type=\"text\" name=\"word\" size=\"50\" maxlength=\"255\"></td><td CLASS=CELL1><input type=\"submit\" name=\"post\" value=\"Add new word\"></td></tr>
</form>";
echo "</table>";
include("/home/mediarch/foot.php");
?>