<?
$pagetitle="Advanced Statistics";
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
</table>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$usrname=$myrow["username"];
$useridy=$myrow["userid"];
if ($myrow["level"]<50)
{
echo "<table border=1 cellspacing=0 width=100%>
<tr><td>You are not authorized to view this page.</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
echo "<table border=1 cellspacing=0 width=100%>

<tr><td COLSPAN=2 align=center><font SIZE=6>Advanced Statistics</font></td></tr>";
echo "<tr><td COLSPAN=2 CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"/boards/gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"/boards/genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo " | <a HREF=\"index.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Control Panel</a></i></font></td></tr>
<tr><td align=center width=50%><br>
<table border=1 cellspacing=0 width=95%>
<tr><td COLSPAN=3 CLASS=DARK ALIGN=CENTER WIDTH=50%><font SIZE=3>User Statistics</font></td></tr>";
$sql="SELECT * FROM levels ORDER BY level DESC";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$sql="SELECT * FROM users WHERE level=".$myrow["level"]."";
$result2=mysql_query($sql);
$numrows=@mysql_num_rows($result2);
if (!$numrows) { $numrows=0; }
echo "<tr><td width=1%>".$myrow["level"]."</td><td><b>".$myrow["leveltitle"]."</b></td><td width=1%>".$numrows."</td><tr>";
}
echo "</table><br></td><td align=center width=50%><br>
<table border=1 cellspacing=0 width=95%>
<tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER WIDTH=50%><font SIZE=3>Board Statistics</font></td></tr>";
$sql="SELECT * FROM users";
$result2=mysql_query($sql);
$numrows=@mysql_num_rows($result2);
if (!$numrows) { $numrows=0; }
echo "<tr><td><b>Total Active Users:</b></td><td width=1%>".$numrows."</td></tr>";
$sql="SELECT * FROM messages";
$result2=mysql_query($sql);
$numrows=@mysql_num_rows($result2);
if (!$numrows) { $numrows=0; }
echo "<tr><td><b>Total Active Messages:</b></td><td width=1%>".$numrows."</td></tr>";
$sql="SELECT * FROM topics";
$result2=mysql_query($sql);
$numrows=@mysql_num_rows($result2);
if (!$numrows) { $numrows=0; }
echo "<tr><td><b>Total Active Topics:</b></td><td width=1%>".$numrows."</td></tr>";
$sql="SELECT * FROM boards";
$result2=mysql_query($sql);
$numrows=@mysql_num_rows($result2);
if (!$numrows) { $numrows=0; }
echo "<tr><td><b>Total Boards:</b></td><td width=1%>".$numrows."</td></tr>";
$sql="SELECT * FROM boardcat";
$result2=mysql_query($sql);
$numrows=@mysql_num_rows($result2);
if (!$numrows) { $numrows=0; }
echo "<tr><td><b>Total Board Categories:</b></td><td width=1%>".$numrows."</td></tr>
</table><br>
<table border=1 cellspacing=0 width=95%>
<tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER WIDTH=50%><font SIZE=3>Moderated Message Statistics</font></td></tr>";
$sql="SELECT * FROM modded";
$result2=mysql_query($sql);
$numrows=@mysql_num_rows($result2);
if (!$numrows) { $numrows=0; }
echo "<tr><td><b>Total Moderated Messages:</b></td><td width=1%>".$numrows."</td></tr>";
$sql="SELECT * FROM modded WHERE contest>=1";
$result2=mysql_query($sql);
$numrows2=@mysql_num_rows($result2);
if (!$numrows2) { $numrows2=0; }
echo "<tr><td><b>Total Contested Moderations:</b></td><td width=1%>".$numrows2."</td></tr>";
if ($numrows>0) { $per=$numrows2/$numrows; $per=$per*100; } else { $per=0; }
echo "<tr><td><b>Percent of Moderations Contested:</b></td><td width=1%>".number_format($per,0)."%</td></tr>";
$sql="SELECT * FROM modded WHERE action=0";
$result2=mysql_query($sql);
$numrows=@mysql_num_rows($result2);
if (!$numrows) { $numrows=0; }
echo "<tr><td><b>Total No Actioned Moderations:</b></td><td width=1%>".$numrows."</td></tr>";
$sql="SELECT * FROM modded WHERE action=1";
$result2=mysql_query($sql);
$numrows=@mysql_num_rows($result2);
if (!$numrows) { $numrows=0; }
echo "<tr><td><b>Total Topic Closed Moderations:</b></td><td width=1%>".$numrows."</td></tr>";
$sql="SELECT * FROM modded WHERE action=2";
$result2=mysql_query($sql);
$numrows=@mysql_num_rows($result2);
if (!$numrows) { $numrows=0; }
echo "<tr><td><b>Total Topic Moved Moderations:</b></td><td width=1%>".$numrows."</td></tr>";
$sql="SELECT * FROM modded WHERE action>=3 AND action<=4";
$result2=mysql_query($sql);
$numrows=@mysql_num_rows($result2);
if (!$numrows) { $numrows=0; }
echo "<tr><td><b>Total Message/Topic Deleted Moderations:</b></td><td width=1%>".$numrows."</td></tr>";
$sql="SELECT * FROM modded WHERE action>=5 AND action<=6";
$result2=mysql_query($sql);
$numrows=@mysql_num_rows($result2);
if (!$numrows) { $numrows=0; }
echo "<tr><td><b>Total Notification Moderations:</b></td><td width=1%>".$numrows."</td></tr>";
$sql="SELECT * FROM modded WHERE action>=7 AND action<=8";
$result2=mysql_query($sql);
$numrows=@mysql_num_rows($result2);
if (!$numrows) { $numrows=0; }
echo "<tr><td><b>Total Warning Moderations:</b></td><td width=1%>".$numrows."</td></tr>";
$sql="SELECT * FROM modded WHERE action>=9 AND action<=10";
$result2=mysql_query($sql);
$numrows=@mysql_num_rows($result2);
if (!$numrows) { $numrows=0; }
echo "<tr><td><b>Total Suspension Moderations:</b></td><td width=1%>".$numrows."</td></tr>";
$sql="SELECT * FROM modded WHERE action>=11";
$result2=mysql_query($sql);
$numrows=@mysql_num_rows($result2);
if (!$numrows) { $numrows=0; }
echo "<tr><td><b>Total Banning Moderations:</b></td><td width=1%>".$numrows."</td></tr>
</table><br>
<table border=1 cellspacing=0 width=95%>
<tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER WIDTH=50%><font SIZE=3>Miscellaneous Statistics</font></td></tr>";
$sql="SELECT * FROM systemnot";
$result2=mysql_query($sql);
$numrows=@mysql_num_rows($result2);
if (!$numrows) { $numrows=0; }
echo "<tr><td><b>Total System Notifications:</b></td><td width=1%>".$numrows."</td></tr>";
$sql="SELECT * FROM metamod";
$result2=mysql_query($sql);
$numrows=@mysql_num_rows($result2);
if (!$numrows) { $numrows=0; }
echo "<tr><td><b>Total Meta-Moderations:</b></td><td width=1%>".$numrows."</td></tr>";
$sql="SELECT * FROM boards";
$result2=mysql_query($sql);
$numrows=@mysql_num_rows($result2);
$tot=0;
if ($numrows>0) {
while ($myrow=@mysql_fetch_array($result2)) {
$boardid=$myrow["boardid"];
$sql="SELECT * FROM messages WHERE mesboard=$boardid";
$result3=mysql_query($sql);
$tot=$tot+mysql_num_rows($result3);
}
$tot=$tot/$numrows;
}
echo "<tr><td><b>Average Messages Per Board:</b></td><td width=1%>".number_format($tot,0)."</td></tr>";
$sql="SELECT * FROM boards";
$result2=mysql_query($sql);
$numrows=@mysql_num_rows($result2);
$tot=0;
if ($numrows>0) {
while ($myrow=@mysql_fetch_array($result2)) {
$boardid=$myrow["boardid"];
$sql="SELECT * FROM topics WHERE boardnum=$boardid";
$result3=mysql_query($sql);
$tot=$tot+mysql_num_rows($result3);
}
$tot=$tot/$numrows;
}
echo "<tr><td><b>Average Topics Per Board:</b></td><td width=1%>".number_format($tot,0)."</td></tr>";
$sql="SELECT * FROM messages ORDER BY messsec ASC LIMIT 0,1";
$result2=mysql_query($sql);
$myrow=@mysql_fetch_array($result2);
$sec=$myrow["messsec"];
if (!$sec) { $sec=time(); }
echo "<tr><td><b>Oldest Message Date:</b></td><td width=1%>".str_replace(" ","&nbsp;",date("n/j/Y h:i:s A",$sec))."</td></tr>
</table><br></td></tr>
</table>";
include("/home/mediarch/foot.php");
?>
