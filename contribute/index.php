<?
$pagetitle="Contributor Central";
include("/home/mediarch/head.php");
echo $harsss;
?>

<table border=0 cellspacing=2 width=100%>
<tr><td COLSPAN=2 align=center><font SIZE=6 FACE=Arial><b>Contributor Central</b></font></td></tr>
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
echo "<TR><TD CLASS=DARK><B>Not Logged In</B></TD></TR><TR><TD>To submit reviews and become a contributor to Mediarchive, you must first <a HREF=\"http://www.mediarchive.net/boards/register.php\">Register</a> for the boards. If you have already registered, then you must first <a HREF=\"http://www.mediarchive.net/boards/login.php\">Log In</a>.</TD></TR>
<tr><td><br><A HREF=\"recog.php\">Contributor Recognition</A></td></tr>";
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$contribid=$myrow["contribid"];
if ($level>=60) {
	$sql="SELECT * FROM contributed WHERE accepted=0";
	$result=mysql_query($sql);
	$numrow=@mysql_num_rows($result);
	echo "<tr><td><br><a HREF=\"revqueue.php\">Review Current Submissions (".$numrow.")</a></td></tr>";
}

echo "</table>";
include("/home/mediarch/foot.php");
	exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$contribid=$myrow["contribid"];
$sql="SELECT * FROM contributor WHERE id='$contribid' ORDER BY id ASC LIMIT 0,1";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$numrows=@mysql_num_rows($result);
if ($numrows<=0) {

echo "<TR><TD CLASS=DARK><B>Not Registered</B></TD></TR>
<TR><TD>You must be a registered contributor to use this page.  You already have a message board account, so just visit the <A HREF=\"register.php\">Registration Page</A>,
then return here and refresh the page when you're done.</TD></TR>
<tr><td><br><A HREF=\"recog.php\">Contributor Recognition</A></td></tr>";
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$level=$myrow["level"];
if ($level>=60) {
	$sql="SELECT * FROM contributed WHERE accepted=0";
	$result=mysql_query($sql);
	$numrow=@mysql_num_rows($result);
	echo "<tr><td><br><a HREF=\"revqueue.php\">Review Current Submissions (".$numrow.")</a></td></tr>";
}
echo "</table>";
include("/home/mediarch/foot.php");
exit;
}
echo "<TR><TD CLASS=DARK ALIGN=CENTER>Welcome, ".$myrow["contribname"]."</font></TD></TR><TR><TD CLASS=LITE ALIGN=CENTER><i>";
$sql="SELECT * FROM contributed WHERE reviewer='".$myrow["contribname"]."' AND accepted>=1";
$result2=mysql_query($sql);
$numrows=@mysql_num_rows($result2);
if ($numrows<=0) {
	echo "Status: Registered, No Posted Reviews";
}
else if ($numrows>=1) {
	echo "Status: Registered, One or More Posted Reviews";
}
echo "</font></i></TD></TR>
<TR><TD>On this page, you can change your contributor information (and your contributor page, if you have one), submit
codes and reviews, and read the other contributor documents.<P>
Select one:<BR>
<A HREF=\"submit.php\">Submit a Review Online</A><BR><BR>
<A HREF=\"update_info.php\">Update Your Contributor Information</A><BR>
<A HREF=\"rev_rate.php\">View Your Review Ratings</A><BR>
<BR>
<A HREF=\"recog.php\">Contributor Recognition</A><BR>
<A HREF=\"/boards/gentopic.php?board=4\">Review Contributors Message Board</A><BR>
</TD></TR>";
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$level=$myrow["level"];
if ($level>=60) {
	$sql="SELECT * FROM contributed WHERE accepted=0";
	$result=mysql_query($sql);
	$numrow=@mysql_num_rows($result);
	echo "<tr><td><br><a HREF=\"revqueue.php\">Review Current Submissions (".$numrow.")</a></td></tr>";
}

echo "</TABLE>";
include("/home/mediarch/foot.php");














