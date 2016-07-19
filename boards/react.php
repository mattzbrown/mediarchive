<?
$pagetitle="Re-Send Activation Key";
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
if ($myrow["level"]!=0) {
echo "<table border=0 width=100%>

<tr><td Colspan=2 align=center><font SIZE=6><b>Re-Send Activation Key</b></font></td></tr>
<tr><td COLSPAN=2><font size=2>
You must be logged on and have an authorization level of zero to use this page.
</font></td></tr>


</table>";
include("/home/mediarch/foot.php");
exit;
}

echo "<table border=0 width=100%>
<tr><td Colspan=2 align=center><font SIZE=6><b>Re-Send Activation Key</b></font></td></tr>";
$sql2="SELECT * FROM users WHERE regemail='$email' AND username<>'$uname'";
$result2=mysql_query($sql2);
if (($post) && (mysql_num_rows($result2)>=1))
{
echo "<tr><td BGCOLOR=#FFFFC0 COLSPAN=2>
<b>There was an error with your registration: </b>A user with e-mail address '$email' has already been created.
</td></tr>";
} else if (($post) && (strlen($email)>=50)) {
echo "<tr><td BGCOLOR=#FFFFC0 COLSPAN=2>
<b>There was an error with your registration: </b>E-mail addresses must be 50 characters or less.
</td></tr>";
} else if (($post) && ($email)) {
$email=htmlentities($email);
$regat=time();
$randnum=rand(1000000000,9999999999);
$username2=ereg_replace(" ","+",$username);
$regkey=$username2.$randnum;
$datedate=date("n/j/Y H:i:s");
$sql="UPDATE users SET regemail='$email' WHERE username='$uname'";
$result=mysql_query($sql);
$sql="UPDATE users SET email='$email' WHERE username='$uname'";
$result=mysql_query($sql);
$sql="UPDATE users SET regsid='$regkey' WHERE username='$uname'";
$result=mysql_query($sql);
$mail_to=$email;
$mail_subject="".$sitetitle." Registration Activation";
$mail_body="Welcome to the ".$sitetitle." Message Boards!
In order to activate your user name, enter this URL into your browser:
http://".$HTTP_HOST."/boards/act.php?regkey=".$regkey."

The request to create this account came from the IP address ".$REMOTE_ADDR." at ".gmdate("n/j/y g:i:s A")." Greenwich Mean Time.";
if (mail($mail_to,$mail_subject,$mail_body)) {
echo "
<tr><td COLSPAN=2>Your activation key has been mailed to you. If you do not receive your activation key shortly, you should re-check your e-mail address or contact your ISP to inquire about your e-mail server status.</td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}
}

echo "<tr><td COLSPAN=2>
If you did not receive your activation key when signing up for the message boards, you can request
that the key be re-generated and re-sent to you at this time.  You will still need to provide a valid
e-mail address to activate your account, and you still must follow any ISP restrictions listed below.

</td></tr>


	

	<form ACTION=\"react.php\" METHOD=POST>
<tr><td>E-Mail Address:</td>
    <td><input type=\"text\" size=\"20\" maxlength=\"100\" name=\"email\" value=\"\"></td></tr>

    <tr><td COLSPAN=2><input type=\"submit\" value=\"Re-Send Key\" name=\"post\"><input type=\"reset\" value=\"Reset\" name=\"reset\"></td></tr>
	</form>


</table>";
include("/home/mediarch/foot.php");
?>

