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
$sql="SELECT * FROM messages WHERE messby='$uname'";
$result20=mysql_query($sql);
$result20=mysql_num_rows($result20);
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$userlevel=$myrow["level"];
$useridd=$myrow["userid"];
echo "<table border=1 cellspacing=0 width=100%>
<tr><td COLSPAN=2 align=center><font SIZE=6><b>Delete This Account</b></font></td></tr>

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
if (($userlevel!=-4) && ($userlevel!=0)) {
echo "

<tr><td align=center colspan=2><b>There were errors deleting your account.</b><br>
You can only delete closed or inactive accounts.</td></tr>

";
} else if ((!$oldpass) || (!$oldpass2) || ($oldpass!=$oldpass2) || ($oldpass!=$myrow["userpass"]) || ($oldpass2!=$myrow["userpass"])) {
echo "

<tr><td align=center colspan=2><b>There were errors deleting your account.</b><br>
You must confirm your current password in the two boxes provided.</td></tr>

";
} else if ($result20) {
echo "

<tr><td align=center colspan=2><b>There were errors deleting your account.</b><br>
There are currently $result20 messages from this account active on the boards. Only accounts with no posted messages can be deleted.</td></tr>

";
} else if (($oldpass) && ($oldpass2) && ($oldpass==$oldpass2) && ($post) && ($oldpass==$myrow["userpass"]) && ($oldpass2==$myrow["userpass"]) && (($userlevel==-4) || ($userlevel==0))) {
$sql="DELETE FROM users WHERE userid=$useridd";
$result=mysql_query($sql);
$sql="DELETE FROM usermap WHERE userid1='$useridd'";
$result3=mysql_query($sql);
$sql="DELETE FROM usermap WHERE userid2='$useridd'";
$result3=mysql_query($sql);
$sql="DELETE FROM favorites WHERE userid='$useridd'";
$result3=mysql_query($sql);
echo "<tr><td align=center><b>Your account has been deleted from the ".$sitetitle." board system. The username can now be re-used by any person.</b></td></tr>
<tr><td>You must be <a href=login.php>logged in</a> in order to edit preferences.</td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
echo "<tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3 COLOR=#FFFFFF>Delete Account: ".$myrow["username"]."</font></td></tr>
<form ACTION=\"delacct.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\" METHOD=POST>
<tr><td COLSPAN=2 CLASS=SYS><font SIZE=2><b>WARNING: You are about to delete this ".$sitetitle." Message Board Account.</b>
Closed or inactive accounts can be deleted from the system, freeing the username to be re-used by another person.
Closed accounts can only be deleted if there are no active posts on any message board.  The deletion is instant and irreversible.
It cannot be undone under <i>any</i> circumstances, as the actual account data is removed from the system.<p>
Please be sure you truly want this account deleted once and for all by confirming your current password twice
before pressing the \"Delete Account\" button.
</font></td>

<tr><td><font SIZE=2><b>Confirm Your Current Password</b></font></td>
    <td><input type=\"password\" size=\"20\" name=\"oldpass\"></td></tr>
<tr><td><font SIZE=2><b>Confirm Your Current Password Again</b></font></td>
    <td><input type=\"password\" size=\"20\" name=\"oldpass2\"></td></tr>
<tr><td COLSPAN=2><input type=\"submit\" value=\"Delete This Account\" name=\"post\"><input type=\"reset\" value=\"Reset\" name=\"reset\">
</td></tr>
</form>

</table>";
include("/home/mediarch/foot.php");
?>

