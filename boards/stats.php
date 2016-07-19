<?
$pagetitle="Message Board Statistics";
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

<tr><td>You must be <a HREF=\index.php\">logged in</a> to view this page.</td></tr>

</table>
";
include("/home/mediarch/foot.php");
exit;
}
?>
<table border=0 cellspacing=0 width=100%>
<tr><td COLSPAN=2 align=center><FONT SIZE=6><B>Message Board Statistics</b></font></td></tr>
<?
echo "<tr><td COLSPAN=3 CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo " | <a HREF=\"user.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\" CLASS=MENU>User Info Page</a>";
echo "</i></font></td></tr>";
?>
<TR><TD COLSPAN=2 CLASS=DARK ALIGN=CENTER><FONT SIZE=3>User Statistics</font></td></tr>

<TR><TD CLASS=SHADE WIDTH=30%><FONT SIZE=2><B>Total Registered Users</b></font></td><TD CLASS=SHADE WIDTH=70%>
<?
$sql="SELECT * FROM users";
$result=mysql_query($sql); $result=mysql_num_rows($result); echo "$result";
?>
</td></tr>
<TR><TD><FONT SIZE=2><B>Active Users</b> (Last 7 Days)</font></td><TD>
<?
$ctime=(time()-604800);
$sql="SELECT * FROM users WHERE lastsec>=$ctime";
$result=mysql_query($sql); $result=mysql_num_rows($result); echo "$result";
?>
</td></tr>
<TR><TD CLASS=SHADE><FONT SIZE=2><B>Active Users</b> (Last 30 Days)</font></td><TD CLASS=SHADE>
<?
$ctime=(time()-2592000);
$sql="SELECT * FROM users WHERE lastsec>=$ctime";
$result=mysql_query($sql); $result=mysql_num_rows($result); echo "$result";
?>
</td></tr>
<TR><TD><FONT SIZE=2><B>New Users</b> (Last 7 Days)</font></td><TD>
<?
$ctime=(time()-604800);
$sql="SELECT * FROM users WHERE regsec>=$ctime";
$result=mysql_query($sql); $result=mysql_num_rows($result); echo "$result";
?>
</td></tr>
<TR><TD COLSPAN=2 CLASS=DARK ALIGN=CENTER><FONT SIZE=3>Message Statistics</font></td></tr>
<TR><TD CLASS=SHADE WIDTH=30%><FONT SIZE=2><B>Total Active Messages</b></font></td><TD CLASS=SHADE WIDTH=70%>
<?
$sql="SELECT * FROM messages";
$result=mysql_query($sql); $result=mysql_num_rows($result); echo "$result";
?>
</td></tr>
<TR><TD><FONT SIZE=2><B>Total Active Topics</b></font></td><TD>
<?
$sql="SELECT * FROM topics";
$result=mysql_query($sql); $result=mysql_num_rows($result); echo "$result";
?>
</td></tr>
</table>
<?
include("/home/mediarch/foot.php");
?>



