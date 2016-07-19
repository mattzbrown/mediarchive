<?
$pagetitle="Update Contributor Information";
include("/home/mediarch/head.php");
echo $harsss;
?>

<table border=0 cellspacing=2 width=100%>
<tr><td COLSPAN=2 align=center><font SIZE=6 FACE=Arial><b>Update Contributor Information</b></font></td></tr>
<?
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
if (!$username) {
echo "<TR><TD CLASS=DARK><B>Not Logged In</B></TD></TR><TR><TD>To submit reviews and become a contributor to Mediarchive, you must first <a HREF=\"http://www.mediarchive.net/boards/register.php\">Register</a> for the boards. If you have already registered, then you must first <a HREF=\"http://www.mediarchive.net/boards/login.php\">Log In</a>.</TD></TR></TABLE>";
include("/home/mediarch/foot.php");
	exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$contribid=$myrow["contribid"];
$sql="SELECT * FROM contributor WHERE id='$contribid' ORDER BY id ASC LIMIT 0,1";
$result2=mysql_query($sql);
$numrows=@mysql_num_rows($result2);
$my_row=@mysql_fetch_array($result2);
if ($numrows>=1) {
$usrname=$my_row["contribname"];
$displayname2=addslashes(trim(htmlentities($displayname)));
$sql="SELECT * FROM contributor WHERE contribname='$displayname2' AND id<>'$contribid'";
$result=mysql_query($sql);
$exist=@mysql_num_rows($result);
if (($submit) && (strlen($fullname)<=50) && (strlen($email)<=50) && (strlen($website)<=150) && ($displayname) && (strlen($displayname)<=20) && ($exist<=0))  {
$displayname=addslashes(trim(htmlentities($displayname)));
$sql="UPDATE contributor SET contribname='".$displayname."' WHERE contribname='$usrname'";
$result=mysql_query($sql);
$sql="UPDATE contributed SET reviewer='".$displayname."' WHERE reviewer='$usrname'";
$result=mysql_query($sql);
$sql="UPDATE contributor SET contribfull='".addslashes(trim(htmlentities($fullname)))."' WHERE contribname='$usrname'";
$result=mysql_query($sql);
$sql="UPDATE contributor SET contribemail='".addslashes(trim(htmlentities($email)))."' WHERE contribname='$usrname'";
$result=mysql_query($sql);
$sql="UPDATE contributor SET contribweb='".addslashes(trim(htmlentities($website)))."' WHERE contribname='$usrname'";
$result=mysql_query($sql);
echo "<tr><td><b>Thank You!</b> Your new information has been stored, and will be reflected in your contributor page.
</TD></TR>
</TABLE>";
include("/home/mediarch/foot.php");
exit;
} else if ($exist>=1) {
echo "<tr><td colspan=2 align=center><b>There was an error updating your contributor information:</b><br>The contributor name you chose has already been taken. Please choose another.</td></tr>";
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$contribid=$myrow["contribid"];
$sql="SELECT * FROM contributor WHERE id='$contribid' ORDER BY id ASC LIMIT 0,1";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$fullname1=$myrow["contribfull"];
$email1=$myrow["contribemail"];
$website1=$myrow["contribweb"];
$displayname=$myrow["contribname"];
$numrows=@mysql_num_rows($result);

	echo "<form action=\"update_info.php\" method=\"POST\">
<TR><TD COLSPAN=2 CLASS=DARK ALIGN=CENTER>Current Information</TD></TR>
<tr><td>Contributor Name (20 chars. max)</td><td><input type=\"text\" size=20 maxlength=20 name=\"displayname\" value=\"".stripslashes($displayname)."\"></td></tr>
<TR><TD>Real Name (50 chars. max)</TD><TD><input type=\"text\" size=30 maxlength=50 name=\"fullname\" value=\"".stripslashes($fullname1)."\"></TD></TR>
<TR><TD>E-Mail (50 chars. max)</TD><TD><input type=\"text\" size=30 maxlength=50 name=\"email\" value=\"".stripslashes($email1)."\"></TD></TR>
<TR><TD>Web Site (full URL)</TD><TD><input type=\"text\" size=40 maxlength=150 name=\"website\" value=\"".stripslashes($website1)."\"></TD></TR>
<TR><TD COLSPAN=2>
<input type=\"submit\" name=\"submit\" value=\"Submit Data\">
</TD></TR>
</form>

</TABLE>";
include("/home/mediarch/foot.php");
exit;
} else {
	echo "<TR><TD CLASS=DARK>Not Registered</TD></TR><TR><TD>To submit reviews to Mediarchive, you must register for both a board username, and a contributor username. If you have not registered for a board username, you may do so <a HREF=\"http://www.mediarchive.net/boards/register.php\">here</a>. Or, if you have already registered for a board username, you can register for a contributor username <a HREF=\"register.php\">here</a>.</TD></TR></TABLE>";
	include("/home/mediarch/foot.php");
	exit;
}