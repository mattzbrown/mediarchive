<?
$pagetitle="Review Queue";
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
</table>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$usrname=$myrow["username"];
$usrid=$myrow["userid"];
$level=$myrow["level"];
$modcat=$myrow["modcat"];
if ($myrow["level"]<60)
{
echo "<table border=0 width=100%>
<tr><td>You are not authorized to view this page.</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
echo "<table border=0 width=100%>

<tr><td COLSPAN=6 align=center><font SIZE=6><B>Review Queue</b></font></td></tr>";
echo "<tr><td CLASS=LITE ALIGN=center colspan=6><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
echo "</i></font></td></tr>
<tr>
<td class=\"LITE\"><i>ID</i></td>
<td class=\"LITE\" width=50%><i>Synopsis</i></td>
<td class=\"LITE\"><i>Item</i></td>
<td class=\"LITE\"><i>Genre</i></td>
<td class=\"LITE\"><i>Reviewed By</i></td>
<td class=\"LITE\"><i>Rating</i></td>
</tr>
";
if ($level>=60) {
$sql="SELECT * FROM contributed WHERE accepted<=0 ORDER BY reviewid ASC";
$result=mysql_query($sql);
while ($myrow=mysql_fetch_array($result)) {
$syn=$myrow["synopsis"];
$item=$myrow["name"];
$type=$myrow["genre"];
$revby=$myrow["reviewer"];
$score=$myrow["rating"];
echo "<tr>
<td CLASS=CELL1><a href=revact.php?reviewid=".$myrow["reviewid"]."";
echo ">".$myrow["reviewid"]."</a></td>
<td CLASS=CELL1>".stripslashes(stripslashes($syn))."</td>
<td CLASS=CELL1>".stripslashes(stripslashes($item))."</td>
<td CLASS=CELL1>";
if ($type==1) {
echo "Movies & TV"; }
else if ($type==2) {
echo "Video Game"; }
else if ($type==3) {
echo "Book"; }
else if ($type==4) {
echo "Music"; }
else if ($type==5) {
echo "Other"; }
echo "</td>
<td CLASS=CELL1>".$revby."</td>
<td CLASS=CELL1>".$score."/10</td>
</tr>";
}
}
echo "</table>";
include("/home/mediarch/foot.php");
?>