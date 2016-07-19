<?
$uban=0;
$pban=0;
$kos=0;
$pagetitle="Registration";
include("/home/mediarch/head.php");
echo $harsss;
$time=time()-3600;
$sql="SELECT * FROM users WHERE regip='$REMOTE_ADDR' AND regsec>=$time";
$result4=mysql_query($sql);
$result4=mysql_num_rows($result4);
if ($username) {
$username=htmlentities($username);
$username=trim($username);
while (ereg("  ", $username)>=1) {
$username=@str_replace("  ", " ", $username);
}
}
$sql="SELECT * FROM kos";
$result=mysql_query($sql);
while ($myrow=mysql_fetch_array($result)) {
$ip=$myrow["ip"];
if (eregi("$ip", $REMOTE_ADDR)>=1) {
$kos=1;
$isp = "@";
$isp .= $myrow["isp"];
}
}
$sql = "SELECT * FROM options WHERE opid=2";
$result70 = mysql_query($sql);
$myrow70 = @mysql_fetch_array($result70);
if ($myrow70["val"]==1) {
$sql = "SELECT * FROM words WHERE `type`=1 ORDER BY wordid ASC";
$result71 = mysql_query($sql);
while ($myrow71=@mysql_fetch_array($result71)) {
if (eregi($myrow71["word"],$username)>=1) {
$uban=$myrow71["wordid"];
}
}
}
$sql = "SELECT * FROM options WHERE opid=3";
$result15 = mysql_query($sql);
$myrow15 = @mysql_fetch_array($result15);
if ($myrow15["val"]==1) {
$sql = "SELECT * FROM words WHERE `type`=2 ORDER BY wordid ASC";
$result16 = mysql_query($sql);
while ($myrow16=@mysql_fetch_array($result16)) {
if (eregi($myrow16["word"],$username)>=1) {
$uban=$myrow16["wordid"];
}
}
}
$sql = "SELECT * FROM options WHERE opid=4";
$result11 = mysql_query($sql);
$myrow11 = @mysql_fetch_array($result11);
if ($myrow11["val"]==1) {
$sql = "SELECT * FROM words WHERE `type`=3 ORDER BY wordid ASC";
$result12 = mysql_query($sql);
while ($myrow12=@mysql_fetch_array($result12)) {
if (eregi($myrow12["word"],$username)>=1) {
$uban=$myrow12["wordid"];
}
}
}
$sql = "SELECT * FROM options WHERE opid=5";
$result11 = mysql_query($sql);
$myrow11 = @mysql_fetch_array($result11);
if ($myrow11["val"]==1) {
$sql = "SELECT * FROM words WHERE `type`=4 ORDER BY wordid ASC";
$result12 = mysql_query($sql);
while ($myrow12=@mysql_fetch_array($result12)) {
if (eregi($myrow12["word"],$username)>=1) {
$uban=$myrow12["wordid"];
}
}
}
$sql = "SELECT * FROM options WHERE opid=6";
$result11 = mysql_query($sql);
$myrow11 = @mysql_fetch_array($result11);
if ($myrow11["val"]==1) {
$sql = "SELECT * FROM words WHERE `type`=5 ORDER BY wordid ASC";
$result12 = mysql_query($sql);
while ($myrow12=@mysql_fetch_array($result12)) {
if (eregi($myrow12["word"],$password)>=1) {
$pban=1;
}
}
}
$heada = "<table border=0 width=100%>
<tr><td Colspan=2 align=center><font SIZE=6><b>Registration</b></font></td></tr>


<tr><td COLSPAN=2>
Welcome to the ".$sitetitle." Message Board registration page.  Registration is required for posting messages
on the ".$sitetitle." message boards, but not for just reading.  In order to register, provide a user name,
password, and a valid e-mail address in the boxes below.<p>

Here's how registration works:<br>
<ol><li>Enter your registration information below, including a valid and active e-mail address where you
        can immediately read mail that is sent to it</li>
    <li>After successfully registering, a message will be sent to your e-mail address containing an
        Activation URL.  You must use this URL in a web browser to activate your account within 48 hours
        to enable message posting on your account, otherwise the account will be deleted.</li>
</ol>

Please note that by signing up for a Message Board Username, you agree to the full <a HREF=\"tos.php\">Terms
of Service</a> for the message boards.  It is recommended that you read these terms in advance of signing
up.

</td></tr>";
$footb = "<form ACTION=\"register.php\" METHOD=POST>
<tr><td>User name (between 3 and 20 characters, letters/numbers/spaces, cannot begin or end with a space)</td>
    <td><input type=\"text\" size=\"20\" maxlength=\"20\" name=\"username\"></td></tr>

<tr><td>Password</td>
    <td><input type=\"password\" size=\"20\" maxlength=\"20\" name=\"password\"></tr>
<tr><td>Confirm Your Password</td>

    <td><input type=\"password\" size=\"20\" maxlength=\"20\" name=\"password2\"></tr>
<tr><td>E-Mail Address:</td>
    <td><input type=\"text\" size=\"20\" maxlength=\"100\" name=\"email\"></td></tr>

    <tr><td COLSPAN=2>By clicking on the \"Register\" button below, you are certifying that you are 13 years of 
     		      age or older, and that you have read and will follow the rules of the ".$sitetitle." 
   		      Message Boards Terms of Service.</td></tr>

    <tr><td COLSPAN=2><input type=\"submit\" value=\"Register\" name=\"post\"><input type=\"reset\" value=\"Reset\" name=\"reset\"></td></tr>
	</form>
</table>";
if ($post)
{
if (!$username)
{
echo "$heada

</td></tr><tr><td BGCOLOR=#FFFFC0 COLSPAN=2>
<b>There was an error with your registration: </b>User Names must be between three and twenty characters.
</td></tr>

$footb";
include("/home/mediarch/foot.php");
exit;
} else {
if (($kos) && ($isp) && (eregi("$isp", $email)<=0))
{
echo "$heada

<tr><td BGCOLOR=#FFFFC0 COLSPAN=2>

<b>There was an error with your registration: </b>Unfortunately, due to the abuse of the ".$sitetitle." message boards by other users of your
Internet Service Provider, you must use an e-mail address that ends with one of the following: '".@eregi_replace("@","",$isp)."'. If your ISP has given you an alternate e-mail domain, contact boards@$HTTP_HOST with both this message and the full e-mail address that was assigned by your ISP.
</td></tr>

$footb";
include("/home/mediarch/foot.php");
exit;
} else {
if ($username)
{
$sql="SELECT * FROM users WHERE username='$username'";
$result=mysql_query($sql);
$numrows=mysql_num_rows($result);
$sql="SELECT * FROM banned WHERE username='$username'";
$result=mysql_query($sql);
$numrows2=mysql_num_rows($result);
$numrows=$numrows+$numrows2;
if ($numrows>=1)
{
echo "$heada

<tr><td BGCOLOR=#FFFFC0 COLSPAN=2>

<b>There was an error with your registration: </b>User Name '$username' has already been taken.  Please select a different name.
</td></tr>	

$footb";
include("/home/mediarch/foot.php");
exit;
}
}
if (!$email)
{
echo "$heada
<tr><td BGCOLOR=#FFFFC0 COLSPAN=2>
<b>There was an error with your registration: </b>An e-mail address was not provided.
</td></tr>

$footb";
include("/home/mediarch/foot.php");
exit;
}
if ($email)
{
$sql="SELECT * FROM users WHERE regemail='$email'";
$result=mysql_query($sql);
$numrows=mysql_num_rows($result);
$sql="SELECT * FROM banned WHERE email='$email'";
$result=mysql_query($sql);
$numrows2=mysql_num_rows($result);
$numrows=$numrows+$numrows2;
if ($numrows>=1)
{
echo "$heada

<tr><td BGCOLOR=#FFFFC0 COLSPAN=2>
<b>There was an error with your registration: </b>A user with e-mail address '$email' has already been created.
</td></tr>

$footb";
include("/home/mediarch/foot.php");
exit;
}
}
if (!$password)
{
echo "$heada

<tr><td BGCOLOR=#FFFFC0 COLSPAN=2>

<b>There was an error with your registration: </b>Passwords must be between six and twenty characters.
</td></tr>

$footb";
include("/home/mediarch/foot.php");
exit;
} else {
if ($uban)
{
echo "$heada

<tr><td BGCOLOR=#FFFFC0 COLSPAN=2>
<b>There was an error with your registration:</b> The User Name you entered is not allowed. Please select another.
</td></tr>

$footb";
include("/home/mediarch/foot.php");
exit;
} else {
if ($pban)
{
echo "$heada

<tr><td BGCOLOR=#FFFFC0 COLSPAN=2>
<b>There was an error with your registration:</b> The password you have selected is not allowed due to the ease at which it can be guessed.
</td></tr>

$footb";
include("/home/mediarch/foot.php");
exit;
} else {
if (!$password2)
{
echo "$heada

<tr><td BGCOLOR=#FFFFC0 COLSPAN=2>
<b>There was an error with your registration: </b>You must enter the <i>exact</i> same password in the two boxes provided.
</td></tr>

$footb";
include("/home/mediarch/foot.php");
exit;
} else {
if (strcmp($password,$password2)==1)
{
echo "$heada

<tr><td BGCOLOR=#FFFFC0 COLSPAN=2>
<b>There was an error with your registration: </b>You must enter the <i>exact</i> same password in the two boxes provided.

</td></tr>

$footb";
include("/home/mediarch/foot.php");
exit;
} else {
if ($result4)
{
echo "$heada

<tr><td BGCOLOR=#FFFFC0 COLSPAN=2>
<b>There was an error with your registration: </b>A user with your current IP address has already attempted to create an account in the past hour. Please wait and try again later.
</td></tr>

$footb";
include("/home/mediarch/foot.php");
exit;
} else {
if ((strlen($username)>20) || (strlen($username)<3))
{
echo "$heada

<tr><td BGCOLOR=#FFFFC0 COLSPAN=2>
<b>There was an error with your registration: </b>User Names must be between three and twenty characters.
</td></tr>

$footb";
include("/home/mediarch/foot.php");
exit;
} else {
if ((strlen($password)>20) || (strlen($password)<6) || (strlen($password2)>20) || (strlen($password2)<6))
{
echo "$heada

<tr><td BGCOLOR=#FFFFC0 COLSPAN=2>
<b>There was an error with your registration: </b>Passwords must be between six and twenty characters.
</td></tr>

$footb";
include("/home/mediarch/foot.php");
exit;
} else {
$username=addslashes($username);
$username=htmlentities($username);
//$username=@str_replace("-", "&", $username);
//$username=@str_replace("!", "&", $username);
//$username=@str_replace("#", "&", $username);
$username=@str_replace("$", "&", $username);
//$username=@str_replace("%", "&", $username);
$username=@str_replace("'", "&", $username);
$username=@str_replace("(", "&", $username);
$username=@str_replace(")", "&", $username);
//$username=@str_replace("*", "&", $username);
//$username=@str_replace("+", "&", $username);
//$username=@str_replace(",", "&", $username);
//$username=@str_replace(".", "&", $username);
//$username=@str_replace("/", "&", $username);
//$username=@str_replace(":", "&", $username);
//$username=@str_replace(";", "&", $username);
//$username=@str_replace("=", "&", $username);
//$username=@str_replace("?", "&", $username);
//$username=@str_replace("@", "&", $username);
$username=@str_replace("[", "&", $username);
$username=@str_replace("]", "&", $username);
//$username=@str_replace("^", "&", $username);
//$username=@str_replace("_", "&", $username);
$username=@str_replace("`", "&", $username);
$username=@str_replace("{", "&", $username);
$username=@str_replace("}", "&", $username);
//$username=@str_replace("|", "&", $username);
//$username=@str_replace("~", "&", $username);
$username=@str_replace("\\", "&", $username);
if (eregi("&", $username)==1)
{
echo "$heada

<tr><td BGCOLOR=#FFFFC0 COLSPAN=2>
<b>There was an error with your registration: </b>User Name contains illegal character(s).
</td></tr>

$footb";
include("/home/mediarch/foot.php");
exit;
} else {
$password=addslashes($password);
$password=htmlentities($password);
// $password=@str_replace("!", "&", $password);
// $password=@str_replace("#", "&", $password);
$password=@str_replace("$", "&", $password);
// $password=@str_replace("%", "&", $password);
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
if (ereg("&", $password)==1)
{
echo "$heada

<tr><td BGCOLOR=#FFFFC0 COLSPAN=2>
<b>There was an error with your registration: </b>Password contains illegal character(s).
</td></tr>

$footb";
include("/home/mediarch/foot.php");
exit;
} else {
$regat=time();
$randnum=rand(100000000000,9999999999999);
$username2=ereg_replace(" ","+",$username);
$regkey=$username2.$randnum;
$datedate=date("n/j/Y H:i:s");
$sql="INSERT INTO users (username,userpass,level,regsid,email,regdate,lastactivity,regsec,lastsec,lastacip,agent,regip,regemail,defsec) VALUES ('$username','$password','0','$regkey','$email','$datedate','$datedate','$regat','$regat','$REMOTE_ADDR','$HTTP_USER_AGENT','$REMOTE_ADDR','$email','$regat')";
$result=mysql_query($sql);
$sql="SELECT * FROM users WHERE username='$username'";
$result=@mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$myuseid=$myrow["userid"];
if ($myuseid==1) {
$sql="UPDATE users SET level=60 WHERE userid=1";
$result=mysql_query($sql);
}
$sql="SELECT * FROM boards WHERE `default`=1";
$result=@mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$boardid=$myrow["boardid"];
$sql="INSERT INTO favorites (boardid,userid) VALUES ('$boardid','$myuseid')";
$result2=@mysql_query($sql);
}
$result=@mysql_query($sql);
$mail_to=$email;
$mail_subject="".$sitetitle." Registration Activation";
$mail_body="Welcome to the ".$sitetitle." Message Boards!
In order to activate your user name, enter this URL into your browser:
http://".$HTTP_HOST."/boards/act.php?regkey=".$regkey."

The request to create this account came from the IP address ".$REMOTE_ADDR." at ".gmdate("n/j/y g:i:s A")." Greenwich Mean Time";
mail($mail_to,$mail_subject,$mail_body);
echo "<table border=0 width=100%>
<tr><td Colspan=2 align=center><font SIZE=6><b>Registration</b></font></td></tr>
<tr><td></td></tr>
<tr><td>Your activation key has been mailed to you. If you do not receive your activation key within 24 hours, you can use the Re-Send Activation Key function from your user preferences page.</td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}}}}}}}}}}}}} else {
echo "$heada

$footb";
include("/home/mediarch/foot.php");
}
?>