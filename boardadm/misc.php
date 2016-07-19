<?
$pagetitle="Miscellaneous Options";
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
echo "
<table border=0 width=100%>

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
echo "
<table border=0 width=100%>

<tr><td>You are not authorized to view this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
echo "<table border=1 cellspacing=0 width=100%>

<tr><td COLSPAN=3 align=center><font SIZE=6>Miscellaneous Options</font></td></tr>
<tr><td COLSPAN=3 CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"/boards/gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"/boards/genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo " | <a HREF=\"index.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Control Panel</a>
</i></font></td></tr>";
$sql="SELECT * FROM options WHERE opid=1";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
if (($post) && ($prov)) {
if ($prov==1) {
$sql="UPDATE options SET val=0 WHERE opid=1";
$result=mysql_query($sql);
}
if ($prov==2) {
$sql="UPDATE options SET val=1 WHERE opid=1";
$result=mysql_query($sql);
}
echo "<tr><td colspan=3 align=center><b>The miscellaneous options have been updated.</b></td></tr>";
}
if (($st) && ($stt)) {
$sql="UPDATE strings SET sitetitle='".htmlentities($stt)."'";
$result=mysql_query($sql);
echo "<tr><td colspan=3 align=center><b>The miscellaneous options have been updated.</b></td></tr>";
}
if (($post) && ($mod)) {
if ($mod==1) {
$sql="UPDATE options SET val=0 WHERE opid=8";
$result=mysql_query($sql);
}
if ($mod==2) {
$sql="UPDATE options SET val=1 WHERE opid=8";
$result=mysql_query($sql);
}
$sql="UPDATE options SET val='$karma' WHERE opid=9";
$result=mysql_query($sql);
echo "<tr><td colspan=3 align=center><b>The miscellaneous options have been updated.</b></td></tr>";
}
if ($email) {
$sql="DELETE FROM emails WHERE emailid=$email";
$result=mysql_query($sql);
echo "<tr><td colspan=3 align=center><b>This e-mail address has been removed successfully.</b></td></tr>";
}
if (($post) && ($newemail)) {
$sql="SELECT * FROM emails WHERE email='$newemail'";
$result=mysql_query($sql);
$numrows=mysql_num_rows($result);
if ($numrows>=1) {
echo "<tr><td colspan=3 align=center><b>There was an error adding a new e-mail:</b> An e-mail with this address has already been added.</td></tr>";
} else {
$sql="INSERT INTO emails (email) VALUES ('$newemail')";
$result=mysql_query($sql);
echo "<tr><td colspan=3 align=center><b>A new e-mail address has been added successfully.</b></td></tr>";
} 
}
$sql="SELECT * FROM strings";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
echo "<form action=\"misc.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td colspan=3 CLASS=CELL2><b>Site Title</b> 
<input type=\"text\" name=\"stt\" value=\"".$myrow["sitetitle"]."\" size=\"40\" maxlength=\"200\">
<input type=\"submit\" name=\"st\" value=\"Make Changes\">
</form>";
$sql="SELECT * FROM options WHERE opid=1";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
echo "<form action=\"misc.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td colspan=3 CLASS=CELL2><b>Level 10: Provisional (1) E-mails</b> <input type=\"radio\" name=\"prov\" value=\"1\"";
if ($myrow["val"]==0) { echo " checked"; }
echo "> Off <input type=\"radio\" name=\"prov\" value=\"2\"";
if ($myrow["val"]==1) { echo " checked"; }
echo "> On <input type=\"submit\" name=\"post\" value=\"Make Changes\"></td></tr>
</form>";
$sql="SELECT * FROM emails ORDER BY emailid ASC";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
if ($numrows<=0) {
echo "<tr><td colspan=3 CLASS=CELL1>There are no provisonal (1) level e-mails.</td></tr>";
} else {
while ($myrow=@mysql_fetch_array($result)) {
echo "<tr><td colspan=2 CLASS=CELL1>".$myrow["email"]."</td><td align=center CLASS=CELL1><a href=\"misc.php?email=".$myrow["emailid"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">[Remove]</a></td></tr>";
}
}
echo "<form action=\"misc.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td colspan=2 CLASS=CELL1><input type=\"text\" name=\"newemail\" size=\"50\" maxlength=\"100\"></td><td CLASS=CELL1><input type=\"submit\" name=\"post\" value=\"Add new e-mail\"></td></tr>
</form>";
$sql="SELECT * FROM options WHERE opid=8";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
echo "<form action=\"misc.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td colspan=3 CLASS=CELL2><b>Moderator Applications</b> <input type=\"radio\" name=\"mod\" value=\"1\"";
if ($myrow["val"]==0) { echo " checked"; }
echo "> Closed <input type=\"radio\" name=\"mod\" value=\"2\"";
if ($myrow["val"]==1) { echo " checked"; }
echo "> Open </td></tr>";
$sql="SELECT * FROM options WHERE opid=9";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
echo "<tr><td CLASS=CELL1 colspan=3>
<b>Minimum Karma Needed:</b> <input type=\"text\" name=\"karma\" value=\"".$myrow["val"]."\" size=\"6\" maxlength=\"40\"><input type=\"submit\" name=\"post\" value=\"Make Changes\"></td></tr>
</form>
</table>";
include("/home/mediarch/foot.php");
?>