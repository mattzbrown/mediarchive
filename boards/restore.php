<?
$pagetitle="User Preferences";
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

<tr><td>You must be <a HREF=\"login.php\">logged in</a> to view this page.</td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$userlevel=$myrow["level"];
$useridd=$myrow["userid"];
echo "<table border=1 cellspacing=0 width=100%>
<tr><td COLSPAN=2 align=center><font SIZE=6><b>Restore This Closed Account</b></font></td></tr>

<tr><td COLSPAN=2 CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo " | <a HREF=\"user.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\" CLASS=MENU>User Info Page</a>";
echo "</i></font></td></tr>";
if ($post) {
if ($userlevel!=-3) {
echo "

<tr><td align=center colspan=2><b>There were errors restoring your account.</b><br>
You can only restore Pending Closure accounts.</td></tr>

";
} else if ((!$oldpass) || (!$oldpass2) || ($oldpass!=$oldpass2) || ($oldpass!=$myrow["userpass"]) || ($oldpass2!=$myrow["userpass"])) {
echo "

<tr><td align=center colspan=2><b>There were errors restoring your account.</b><br>
You must confirm your current password in the two boxes provided.</td></tr>

";
} else if (($oldpass) && ($oldpass2) && ($oldpass==$oldpass2) && ($post) && ($oldpass==$myrow["userpass"]) && ($oldpass2==$myrow["userpass"]) && ($userlevel==-3)) {
$sql="UPDATE users SET level=15 WHERE userid=$useridd";
$result=mysql_query($sql);
$sql="UPDATE users SET closedate='' WHERE userid=$useridd";
$result=mysql_query($sql);
echo "<tr><td align=center><b>Your account has been restored to Level 15.</b></td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
echo "<tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Restore Account: ".$myrow["username"]."</font></td></tr>
<form ACTION=\"restore.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\" METHOD=POST>
<tr><td COLSPAN=2 BGCOLOR=#FFFF00><font SIZE=2><b>WARNING: You are about to restore this ".$sitetitle." Message Board Account.</b>
Your account will initially be restored to Level 15, and it will be upgraded per
the normal account procedures.
</font></td>

<tr><td><font SIZE=2><b>Confirm Your Current Password</b></font></td>
    <td><input type=\"password\" size=\"20\" name=\"oldpass\"></td></tr>
<tr><td><font SIZE=2><b>Confirm Your Current Password Again</b></font></td>
    <td><input type=\"password\" size=\"20\" name=\"oldpass2\"></td></tr>
<tr><td COLSPAN=2><input type=\"submit\" value=\"Restore This Account\" name=\"post\"><input type=\"reset\" value=\"Reset\" name=\"reset\">
</td></tr>
</form>

</table>";
include("/home/mediarch/foot.php");
?>




