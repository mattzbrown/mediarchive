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
<tr><td COLSPAN=2 align=center><font SIZE=6><b>Close This Account</b></font></td></tr>

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
if ($userlevel<15) {
echo "

<tr><td align=center colspan=2><b>There were errors closing your account.</b><br>
You can only close level 15 or higher accounts.</td></tr>

";
} else if ((!$oldpass) || (!$oldpass2) || ($oldpass!=$oldpass2) || ($oldpass!=$myrow["userpass"]) || ($oldpass2!=$myrow["userpass"])) {
echo "

<tr><td align=center colspan=2><b>There were errors closing your account.</b><br>
You must confirm your current password in the two boxes provided.</td></tr>

";
} else if (($oldpass) && ($oldpass2) && ($oldpass==$oldpass2) && ($post) && ($oldpass==$myrow["userpass"]) && ($oldpass2==$myrow["userpass"]) && ($userlevel>=15)) {
$sql="UPDATE users SET level=-3 WHERE userid=$useridd";
$result=mysql_query($sql);
$time=time();
$sql="UPDATE users SET closedate='$time' WHERE userid=$useridd";
$result=mysql_query($sql);
echo "<tr><td align=center><b>Your account is now pending closure. After 48 hours, you will not be able to re-open this account.</b></td></tr>
<tr><td>You must be <a href=login.php>logged in</a> in order to edit preferences.</td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
echo "<tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Close Account: ".$myrow["username"]."</font></td></tr>
<form ACTION=\"close.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\" METHOD=POST>
<tr><td COLSPAN=2 CLASS=SYS><font SIZE=2><b>WARNING: You are about to close this ".$sitetitle." Message Board Account.</b>
After 48 hours, this account will be permanently closed.
Once an account is closed, it cannot be re-opened under <i>any</i> circumstances.  The account will be shut down
and it cannot be used to log in to the ".$sitetitle." Message Boards again.<p>
Please be sure you truly want this account closed once and for all by confirming your current password twice
before pressing the &quot;Close Account&quot; button.
</font></td>

<tr><td><font SIZE=2><b>Confirm Your Current Password</b></font></td>
    <td><input type=\"password\" size=\"20\" name=\"oldpass\"></td></tr>
<tr><td><font SIZE=2><b>Confirm Your Current Password Again</b></font></td>
    <td><input type=\"password\" size=\"20\" name=\"oldpass2\"></td></tr>
<tr><td COLSPAN=2><input type=\"submit\" value=\"Close This Account\" name=\"post\"><input type=\"reset\" value=\"Reset\" name=\"reset\">
</td></tr>
</form>

</table>";
include("/home/mediarch/foot.php");
?>




