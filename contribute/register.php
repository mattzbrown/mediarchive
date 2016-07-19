<?
$pagetitle="Contributor Registration";
include("/home/mediarch/head.php");
echo $harsss;
?>

<table border=0 cellspacing=2 width=100%>
<tr><td COLSPAN=2 align=center><font SIZE=6 FACE=Arial><b>Contributor Registration</b></font></td></tr>
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
echo "<TR><TD CLASS=DARK><B>Not Logged In</B></TD></TR><TR><TD>To submit reviews and become a contributor to ".$sitetitle.", you must first <a HREF=\"/boards/register.php\">Register</a> for the boards. If you have already registered, then you must first <a HREF=\"/boards/login.php\">Log In</a>.</TD></TR></TABLE>";
include("/home/mediarch/foot.php");
	exit;
}
echo "<TR><TD>

Contributor Registration allows you to link up your message board account with a contributor
name, ensuring proper credit for all of your current and future contributions.  Additionally,
you'll receive a link on your board profile page directly to your contributor page.<P>

Registration is required for submitting new reviews and codes, as well as using
other contributor forms online.  This will ensure that all future contributor 
ID's are unique and that nobody is able to maliciously submit information under 
another user's name.<P>

You can link multiple message board accounts to a single contributor name if you wish, but we
ask that only one contributor name per actual person ever be used to avoid confusion.

</TD></tr>";
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$contribid=$myrow["contribid"];
$usrnme=$myrow["username"];
$sql="SELECT * FROM contributor WHERE id='$contribid' ORDER BY id ASC LIMIT 0,1";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$numrows=@mysql_num_rows($result);
if ($numrows<=0) {
	if ($step=="Register New Name") {
$sql="INSERT INTO contributor (contribname,contribweb,contribemail,contribfull) VALUES ('$username','".htmlentities(addslashes($website))."','".htmlentities(addslashes($email))."','".htmlentities(addslashes($fullname))."')";
$result=mysql_query($sql);
$sql="SELECT * FROM contributor WHERE contribname='$username'";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$sql="UPDATE users SET contribid=".$myrow["id"]." WHERE username='$username'";
$result=mysql_query($sql);
echo "<TR><TD CLASS=DARK>Registration Complete</TD></TR>
<TR><TD>
Your contributor account has been registered.  With your first accepted review contribution to ".$sitetitle.", you'll receive a contributor page,
and your message board profile should automatically link to it.
</TD></TR>
</TABLE>";
include("/home/mediarch/foot.php");
exit;
} else if (($step=="Check Name") && ($alias)) {
$sql="SELECT * FROM contributor WHERE contribname='$alias'";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$numrows=@mysql_num_rows($result);
if ($numrows>=1) {
if ($myrow["contribemail"]) {
echo "<TR><TD CLASS=DARK>Address Confirmation</TD></TR>
<TR><TD>The contributor ".$myrow["contribname"]." is currently assigned to the e-mail address ".$myrow["contribemail"].".  Are you currently able to receive messages on this account?<P>
<FORM ACTION=\"register.php\" METHOD=POST>
<input type=\"hidden\" value=\"".$myrow["id"]."\" name=\"cid\">
<input type=\"submit\" value=\"Yes, Send Confirmation\" name=\"step\">
<input type=\"submit\" value=\"No, What Now?\" name=\"step\">
</FORM>
</TD></TR>
<table>";
include("/home/mediarch/foot.php");
exit;
} else {
echo "<TR><TD CLASS=DARK>No E-Mail Specified</TD></TR>
<TR><TD>The contributor name &quot;$alias&quot; does not have an e-mail address. If the contributor name truly belongs to you, log into an account currently linked to it and provide a contributor e-mail via the update information page.</TD></TR>
<table>";
include("/home/mediarch/foot.php");
exit;
}
} else {
echo "<TR><TD CLASS=DARK>Name Not Found</TD></TR>
<TR><TD>The contributor name &quot;$alias&quot; was not found in the database.</TD></TR>
<table>";
include("/home/mediarch/foot.php");
exit;
}
} else if (($step=="No, What Now?") && ($cid)) {
echo "<TR><TD CLASS=DARK>Unable to Confirm</TD></TR>
<TR><TD>
As your e-mail address has changed since you last updated your contributor page, please log into an account currently linked to your contributor page and update your e-mail address.  Once this is done, you'll be able to register your contributor name with your message board account with no problems.
</TD></TR>
</TABLE>";
include("/home/mediarch/foot.php");
exit;
} else if (($step=="Yes, Send Confirmation") && ($cid)) {
$sql="SELECT * FROM contributor WHERE id='$cid'";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$numrows=@mysql_num_rows($result);
if ($numrows>=1) {
if ($myrow["contribemail"]) {
$contribkey=$usrnme.rand(100000000000,9999999999999);
$sql="UPDATE users SET regcontrib='$contribkey' WHERE username='$uname'";
$result=mysql_query($sql);
$contribkey=eregi_replace(" ","+",$contribkey);
$sql="UPDATE users SET tempcontrib='".$myrow["id"]."' WHERE username='$uname'";
$result=mysql_query($sql);
mail($myrow["contribemail"],"".$sitetitle." Contributor Activation","Thank you for registering your contributor name. In order to complete registration, enter this URL into your browser:
http://".$HTTP_HOST."/boards/cact.php?key=".$contribkey."

The request to create this account came from the IP address $REMOTE_ADDR at ".date("n/j/Y h:i:s A")." Pacific Time (US)");
echo "<TR><TD CLASS=DARK>Confirmation E-Mail Sent</TD></TR>
<TR><TD>A confirmation e-mail with an activation key has been sent to ".$myrow["contribemail"].". Use the URL included in the e-mail to complete your registration.</TD></TR>
<table>";
include("/home/mediarch/foot.php");
exit;
} else {
echo "<TR><TD CLASS=DARK>No E-Mail Specified</TD></TR>
<TR><TD>The contributor name &quot;".$myrow["contribname"]."&quot; does not have an e-mail address. If the contributor name truly belongs to you, log into an account currently linked to it and provide a contributor e-mail via the update information page.</TD></TR>
<table>";
include("/home/mediarch/foot.php");
exit;
}
} else {
echo "<TR><TD CLASS=DARK>Name Not Found</TD></TR>
<TR><TD>The contributor name &quot;".$myrow["contribname"]."&quot; was not found in the database.</TD></TR>
<table>";
include("/home/mediarch/foot.php");
exit;
}
}

	echo "
<tr><td CLASS=DARK>Existing Contributors</td></tr>
<tr><td>
If you have already contributed Reviews to ".$sitetitle." (i.e. you 
have a Contributor Page online), then simply enter your contributor name below.
<form ACTION=\"register.php\" METHOD=POST>
What is your current contributor name? 

<input type=\"text\" size=\"20\" maxlength=\"20\" name=\"alias\">
<input type=\"submit\" value=\"Check Name\" name=\"step\"><p>
Warning: Attempting to falsely register a contributor name that does not belong to you is 
grounds for immediate termination of your message board accounts.
</form>
</td></tr>
<TR><TD CLASS=DARK>New Contributors</TD></TR>
<TR><TD>
If you have not yet contributed Reviews to ".$sitetitle.", then your
current message board name will be taken as your contributor name, <B>$usrname</B>.  You can also
enter in alternate information below (which will be made public on your contributor
page).
<FORM ACTION=\"register.php\" METHOD=POST>
What is your e-mail address (optional)?
<input type=\"text\" size=\"20\" maxlength=\"50\" name=\"email\"><BR>
What is your web site address (optional)?
<input type=\"text\" size=\"20\" maxlength=\"100\" name=\"website\"><BR>
What is your real or alternate name (optional)?
<input type=\"text\" size=\"20\" maxlength=\"40\" name=\"fullname\"><BR>
<input type=\"submit\" value=\"Register New Name\" name=\"step\"><P>
</FORM>
</TD></TR>
</TABLE>";
include("/home/mediarch/foot.php");
exit;
} else {
	echo "<TR><TD>You have already registed for a contributor name with this username. Return to <a HREF=\"index.php\">Contributor Central</a>.</TD></TR></TABLE>";
	include("/home/mediarch/foot.php");
	exit;
}





