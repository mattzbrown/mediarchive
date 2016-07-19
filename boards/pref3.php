<?
$pagetitle="User Preferences";
include("/home/mediarch/head.php");
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
if ($myrow["level"]<0)
{
echo "<table border=0 width=100%>

<tr><td>You are not authorized to view this page.</td></tr>
</table>

";
include("/home/mediarch/foot.php");
exit;
}
if ($password) {
$password=addslashes($password);
$password=htmlentities($password);
$password=@str_replace("!", "&", $password);
$password=@str_replace("#", "&", $password);
$password=@str_replace("$", "&", $password);
$password=@str_replace("%", "&", $password);
$password=@str_replace("'", "&", $password);
$password=@str_replace("(", "&", $password);
$password=@str_replace(")", "&", $password);
$password=@str_replace("*", "&", $password);
$password=@str_replace("+", "&", $password);
$password=@str_replace(",", "&", $password);
$password=@str_replace(".", "&", $password);
$password=@str_replace("/", "&", $password);
$password=@str_replace(":", "&", $password);
$password=@str_replace(";", "&", $password);
$password=@str_replace("=", "&", $password);
$password=@str_replace("?", "&", $password);
$password=@str_replace("@", "&", $password);
$password=@str_replace("[", "&", $password);
$password=@str_replace("]", "&", $password);
$password=@str_replace("^", "&", $password);
$password=@str_replace("_", "&", $password);
$password=@str_replace("`", "&", $password);
$password=@str_replace("{", "&", $password);
$password=@str_replace("}", "&", $password);
$password=@str_replace("|", "&", $password);
$password=@str_replace("~", "&", $password);
$password=@str_replace("\\", "&", $password);
}
if (($oldpass) && ($password) && ($password2) && ($post) && ($oldpass==$myrow["userpass"]) && ($password==$password2) && (ereg("&", $password)==0)) {
if (($luname) && ($lpword)) {
setcookie ("lpword", $password, time() + 600, "/", "$HTTP_HOST", 0);
} else if (($auname) && ($apword)) {
setcookie ("apword", $password, time() + 99999999999999, "/", "$HTTP_HOST", 0);
}
}
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

</table>
";
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
<tr><td COLSPAN=2 align=center><font SIZE=6><b>Change Password</b></font></td></tr>

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
if ((strlen($password)>20) || (strlen($password)<6) || (strlen($password2)>20) || (strlen($password2)<6)) {
echo "

<tr><td align=center colspan=2><b>There were errors updating your password:</b><br>
Passwords must be between six and twenty characters.</td></tr>

";
} else if ((!$oldpass) || (!$password) || (!$password2) || ($oldpass!=$myrow["userpass"]) || ($password!=$password2)) {
echo "

<tr><td align=center colspan=2><b>There were errors updating your password:</b><br>
You must confirm your current password in the two boxes provided.</td></tr>

";
} else if (ereg("&", $password)==1)
{
echo "<tr><td align=center colspan=2><b>There were errors updating your password:</b><br>
Password contains illegal character(s).</td></tr>";
} else if (($oldpass) && ($password) && ($password2) && ($post) && ($oldpass==$myrow["userpass"]) && ($password==$password2)) {
$sql="UPDATE users SET userpass='$password' WHERE userid='".$useridd."'";
$result=mysql_query($sql);
echo "<tr><td align=center colspan=2><b>Your password has been successfully updated.</b></td></tr>";
}
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
echo "<tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Change Password for ".$myrow["username"]."</font></td></tr>
<form ACTION=\"pref3.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\" METHOD=POST>
<tr><td><font SIZE=2><b>Confirm Your Current Password</b></font></td>
    <td><input type=\"password\" size=\"20\" name=\"oldpass\"></td></tr>
<tr><td><font SIZE=2>Enter A New Password (between 6 and 20 characters)</font></td>
    <td><input type=\"password\" size=\"20\" maxlength=\"20\" name=\"password\"></td></tr>
<tr><td><font SIZE=2>Confirm Your New Password</font></td>

    <td><input type=\"password\" size=\"20\" maxlength=\"20\" name=\"password2\"></td></tr>
<tr><td COLSPAN=2><input type=\"submit\" value=\"Make Changes\" name=\"post\"><input type=\"reset\" value=\"Reset\" name=\"reset\">
</td></tr>
</form>

</table>";
include("/home/mediarch/foot.php");
?>
