<?
$pagetitle="Poll Creator";
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

<tr><td><font size=2>You must be <a HREF=\"/boards/login.php\">logged in</a> to view this page.</font></td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
if ($myrow["level"]<60) {
echo "<table border=0 width=100%>

<tr><td><font size=2>You are not authorized to view this page.</font></td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}
echo "<table border=1 cellspacing=0 width=100%>

<tr><td align=center COLSPAN=2><font SIZE=6><b>Poll Creator</b></font></td></tr>
<tr><td CLASS=LITE ALIGN=center COLSPAN=2><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"/boards/gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"/boards/genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo " | <a HREF=\"index.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "?topic=$topic"; }
echo "\" CLASS=MENU>Control Panel</a>
</i></font></td></tr>";
if ((!$post) && (!$post2)) { 
echo "<form ACTION=\"".$PHP_SELF."\" METHOD=POST><tr><td CLASS=SYS ALIGN=CENTER COLSPAN=2><font SIZE=2><b>Warning:</b>  This utility will lock the votes in the previous poll and create a brand new poll.</font></td></tr>
<tr><td><font SIZE=2><b>Question</b></font></td>
<td>
<input type=text name=ques value=\"\" size=\"60\" maxlength=\"200\"></input>
</td></tr>
<tr><td><font SIZE=2><b>Number of Choices</b></font></td><td>
  <select name=\"num\" size=\"1\">
  <option value=\"2\">2</option>
  <option value=\"3\">3</option>
  <option value=\"4\">4</option>
  <option value=\"5\">5</option>
  <option value=\"6\">6</option>
  <option value=\"7\">7</option>
  <option value=\"8\">8</option>
  <option value=\"9\">9</option>
  <option value=\"10\">10</option>
  <option value=\"11\">11</option>
  <option value=\"12\">12</option>
  <option value=\"13\">13</option>
  <option value=\"14\">14</option>
  <option value=\"15\">15</option>
  <option value=\"16\">16</option>
  <option value=\"17\">17</option>
  <option value=\"18\">18</option>
  <option value=\"19\">19</option>
  <option value=\"20\">20</option>
  </select>
</td></tr>
<tr><td colspan=2><input type=\"submit\" value=\"Continue\" name=\"post\"><input type=\"reset\" value=\"Reset\" name=\"reset\">
</td></tr>

</form>

</table>";
include("/home/mediarch/foot.php");
exit;
} else if (($post) && (!$post2) && ($num>1) && ($num<=20)) {
$ques2 = htmlentities($ques);
$quesq = addslashes($ques2);
$cc=0;
echo "
<form ACTION=\"".$PHP_SELF."\" METHOD=POST><tr><td><font SIZE=2><b>Question</b></font></td><td><font SIZE=2>".$ques2."</font></td></tr>";
while ($cc<$num) {
$cc++;
echo "<tr><td><font SIZE=2><b>Choice $cc</b></font></td>
<td>
<input type=text name=ch".$cc." value=\"\"></input>
</td></tr>";
}
echo "</td></tr>
<tr><td colspan=2><input type=\"hidden\" name=\"ques\" value=\"$ques2\"><input type=\"hidden\" value=\"Continue\" name=\"post\"><input type=\"hidden\" name=\"num\" value=\"$num\">
<input type=\"submit\" value=\"Create Poll\" name=\"post2\"><input type=\"reset\" value=\"Reset\" name=\"reset\">
</td></tr></form></table>";
include("/home/mediarch/foot.php");
exit;
} else if (($post) && ($post2) && ($ch1) && ($ch2)) {
$quesq = addslashes($ques);
$sql="DELETE FROM polluser";
$result=mysql_query($sql);
$sql="DELETE FROM pollip";
$result=mysql_query($sql);
$date=date("n/j/Y");
$sql="INSERT INTO pollques (date,val) VALUES ('$date','$quesq')";
$result=mysql_query($sql);
$sql="SELECT * FROM pollques WHERE val='$quesq'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$poll=$myrow["pollid"];
if ($ch1) {
$sql="INSERT INTO pollsel (`pollid`,`order`,`val`,`votes`) VALUES ('$poll','1','$ch1','0')";
$result=mysql_query($sql);
}
if ($ch2) {
$sql="INSERT INTO pollsel (`pollid`,`order`,`val`,`votes`) VALUES ('$poll','2','$ch2','0')";
$result=mysql_query($sql);
}
if ($ch3) {
$sql="INSERT INTO pollsel (`pollid`,`order`,`val`,`votes`) VALUES ('$poll','3','$ch3','0')";
$result=mysql_query($sql);
}
if ($ch4) {
$sql="INSERT INTO pollsel (`pollid`,`order`,`val`,`votes`) VALUES ('$poll','4','$ch4','0')";
$result=mysql_query($sql);
}
if ($ch5) {
$sql="INSERT INTO pollsel (`pollid`,`order`,`val`,`votes`) VALUES ('$poll','5','$ch5','0')";
$result=mysql_query($sql);
}
if ($ch6) {
$sql="INSERT INTO pollsel (`pollid`,`order`,`val`,`votes`) VALUES ('$poll','6','$ch6','0')";
$result=mysql_query($sql);
}
if ($ch7) {
$sql="INSERT INTO pollsel (`pollid`,`order`,`val`,`votes`) VALUES ('$poll','7','$ch7','0')";
$result=mysql_query($sql);
}
if ($ch8) {
$sql="INSERT INTO pollsel (`pollid`,`order`,`val`,`votes`) VALUES ('$poll','8','$ch8','0')";
$result=mysql_query($sql);
}
if ($ch9) {
$sql="INSERT INTO pollsel (`pollid`,`order`,`val`,`votes`) VALUES ('$poll','9','$ch9','0')";
$result=mysql_query($sql);
}
if ($ch10) {
$sql="INSERT INTO pollsel (`pollid`,`order`,`val`,`votes`) VALUES ('$poll','10','$ch10','0')";
$result=mysql_query($sql);
}
if ($ch11) {
$sql="INSERT INTO pollsel (`pollid`,`order`,`val`,`votes`) VALUES ('$poll','11','$ch11','0')";
$result=mysql_query($sql);
}
if ($ch12) {
$sql="INSERT INTO pollsel (`pollid`,`order`,`val`,`votes`) VALUES ('$poll','12','$ch12','0')";
$result=mysql_query($sql);
}
if ($ch13) {
$sql="INSERT INTO pollsel (`pollid`,`order`,`val`,`votes`) VALUES ('$poll','13','$ch13','0')";
$result=mysql_query($sql);
}
if ($ch14) {
$sql="INSERT INTO pollsel (`pollid`,`order`,`val`,`votes`) VALUES ('$poll','14','$ch14','0')";
$result=mysql_query($sql);
}
if ($ch15) {
$sql="INSERT INTO pollsel (`pollid`,`order`,`val`,`votes`) VALUES ('$poll','15','$ch15','0')";
$result=mysql_query($sql);
}
if ($ch16) {
$sql="INSERT INTO pollsel (`pollid`,`order`,`val`,`votes`) VALUES ('$poll','16','$ch16','0')";
$result=mysql_query($sql);
}
if ($ch17) {
$sql="INSERT INTO pollsel (`pollid`,`order`,`val`,`votes`) VALUES ('$poll','17','$ch17','0')";
$result=mysql_query($sql);
}
if ($ch18) {
$sql="INSERT INTO pollsel (`pollid`,`order`,`val`,`votes`) VALUES ('$poll','18','$ch18','0')";
$result=mysql_query($sql);
}
if ($ch19) {
$sql="INSERT INTO pollsel (`pollid`,`order`,`val`,`votes`) VALUES ('$poll','19','$ch19','0')";
$result=mysql_query($sql);
}
if ($ch20) {
$sql="INSERT INTO pollsel (`pollid`,`order`,`val`,`votes`) VALUES ('$poll','20','$ch20','0')";
$result=mysql_query($sql);
}
echo "<tr><td align=center><font size=2>Poll created successfully.</td></tr>
";

include("/home/mediarch/foot.php");
exit;
} else {
echo "<form ACTION=\"".$PHP_SELF."\" METHOD=POST><tr><td BGCOLOR=#FFFF00 ALIGN=CENTER COLSPAN=2><font SIZE=2><b>Warning:</b>  This utility will lock the votes in the previous poll and create a brand new poll.</font></td></tr>
<tr><td><font SIZE=2><b>Question</b></font></td>
<td>
<input type=text name=ques value=\"\" size=\"60\" maxlength=\"200\"></input>
</td></tr>
<tr><td><font SIZE=2><b>Number of Choices</b></font></td><td>
  <select name=\"num\" size=\"1\">
  <option value=\"2\">2</option>
  <option value=\"3\">3</option>
  <option value=\"4\">4</option>
  <option value=\"5\">5</option>
  <option value=\"6\">6</option>
  <option value=\"7\">7</option>
  <option value=\"8\">8</option>
  <option value=\"9\">9</option>
  <option value=\"10\">10</option>
  <option value=\"11\">11</option>
  <option value=\"12\">12</option>
  <option value=\"13\">13</option>
  <option value=\"14\">14</option>
  <option value=\"15\">15</option>
  <option value=\"16\">16</option>
  <option value=\"17\">17</option>
  <option value=\"18\">18</option>
  <option value=\"19\">19</option>
  <option value=\"20\">20</option>
  </select>
</td></tr>
<tr><td colspan=2><input type=\"submit\" value=\"Continue\" name=\"post\"><input type=\"reset\" value=\"Reset\" name=\"reset\">
</td></tr>

</form>

</table>";
include("/home/mediarch/foot.php");
}
?>

