<?
$pagetitle="Message Board Contribution";
include("/home/mediarch/head.php");
echo $harsss;
echo "<table border=0 width=100%>

<tr><td align=center colspan=2><font SIZE=6>Message Board Contribution</font></td></tr>";
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
echo "<tr><td colspan=2>You are not authorized to view this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
if ($myrow["level"]<60)
{
echo "<tr><td colspan=2>You are not authorized to view this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
$userid=$myrow["userid"];
$level=$myrow["level"];
$usern=$myrow["username"];
echo "<tr><td COLSPAN=2 CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
echo " | <a HREF=\"revqueue.php";
echo "\" CLASS=MENU>Review Queue</a>
</i></font></td></tr>";

$sql="SELECT * FROM contributed WHERE reviewid=$reviewid AND accepted='0'";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$numrows=@mysql_num_rows($result);
if ($numrows<=0) {

echo "<tr><td colspan=2>An invalid link was used to access this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM contributed WHERE reviewid=$reviewid";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$numrows=mysql_num_rows($result);
$type=$myrow["genre"];
$item=$myrow["name"];
$syn=$myrow["synopsis"];
$revby=$myrow["reviewer"];
$review=$myrow["review"];
$review2=$myrow["review"];
$score=$myrow["rating"];
$sql="SELECT * FROM users WHERE username=$revby";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($resulto);
if ($accept) {
$sql="UPDATE contributed SET genre='$newtype' WHERE reviewid='$reviewid'";
$result=mysql_query($sql);
$sql="UPDATE contributed SET name='".addslashes($newname)."' WHERE reviewid='$reviewid'";
$result=mysql_query($sql);
$sql="UPDATE contributed SET synopsis='".addslashes($oneline)."' WHERE reviewid='$reviewid'";
$result=mysql_query($sql);
$sql="UPDATE contributed SET review='".addslashes(eregi_replace("&lt;b&gt;", "<b>", eregi_replace("&lt;/b&gt;", "</b>", eregi_replace("&lt;i&gt;", "<i>", eregi_replace("&lt;/i&gt;", "</i>", nl2br(htmlentities($newrev)))))))."' WHERE reviewid='$reviewid'";
$result=mysql_query($sql);
$sql="UPDATE contributed SET accepted='1' WHERE reviewid='$reviewid'";
$result=mysql_query($sql);
echo "<tr><td class=dark colspan=2>Submission Accepted</td></tr><tr><td colspan=2>This submission has been successfully added. The reviewer will receiver +1 Contribution Points, and the review will be posted shortly.</td></tr><tr><td colspan=2>You may now return to the <a HREF=\"index.php\">Contributor Central</a>, or you may <a HREF=\"revqueue.php\">Review More Submissions</a>.</td></tr></table>";
include("/home/mediarch/foot.php");
exit;
}
if ($reject) {
	$sql="DELETE FROM contributed WHERE reviewid=$reviewid";
	$result=mysql_query($sql);
	echo "<tr><td class=dark colspan=2>Submission Rejected</td></tr><tr><td colspan=2>This submission has been rejected and will be deleted from the database shortly. The reviewer will gain, nor lose any contribution points.</td></tr><tr><td colspan=2>You may now return to the <a HREF=\"index.php\">Contributor Central</a>, or you may <a HREF=\"revqueue.php\">Review More Submissions</a>.</td></tr></table>";
	include("/home/mediarch/foot.php");
	exit;
}
echo "<form ACTION=\"revact.php?reviewid=$reviewid\" METHOD=\"POST\"><tr><td class=cell1><b>Genre:</b></td><td class=cell1><select name=\"newtype\" size=\"1\">";
$rows=ceil(strlen($review2)/60)+count(explode("<br />",$review2))-1;
if ($type==1) {
echo "
  <option value=\"1\" SELECTED>Movies & TV (Current)</option>";
}
if ($type==2) {
echo "
  <option value=\"2\" SELECTED>Video Game (Current)</option>";
}
if ($type==3) {
echo "
  <option value=\"3\" SELECTED>Book (Current)</option>";
}
if ($type==4) {
echo "
  <option value=\"4\" SELECTED>Music (Current)</option>";
}
if ($type==5) {
echo "
  <option value=\"5\" SELECTED>Other (Current)</option>";
}
echo "
  <option value=\"1\">Movies & TV</option>

  <option value=\"2\">Video Game</option>
  <option value=\"3\">Book</option>
  <option value=\"4\">Music</option>
  <option value=\"5\">Other</option>  

</select></td></tr><tr><td class=cell1><b>Title:</b></td><td class=cell1><textarea cols=\"60\" name=\"newname\">".stripslashes(stripslashes($item))."</textarea></td></tr><tr><td class=cell1><b>Synopsis:</b></td><td class=cell1><textarea cols=\"60\" name=\"oneline\">".stripslashes(stripslashes($syn))."</textarea></td></tr><tr><td class=cell1><b>Reviewed By:</td><td class=cell1>$revby</td></tr><tr><td class=cell1><b>Score:</b></td><td class=cell1>$score/10</td></tr><tr><td class=cell1 colspan=2 align=center><textarea cols=\"60\" rows=\"".$rows."\" name=\"newrev\" WRAP=\"virtual\">".stripslashes(str_replace("<br />","",$review))."
</textarea></td></tr><tr><td COLSPAN=2 class=cell1 align=center><input type=\"submit\" value=\"Accept Review\" name=\"accept\"><input type=\"submit\" value=\"Reject Review\" name=\"reject\"></td></tr></table>";
include("/home/mediarch/foot.php");
?>