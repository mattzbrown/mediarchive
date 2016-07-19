<?

$pagetitle="Lost Password Recovery";
include("/home/mediarch/head.php");
echo $harsss;


echo "
<table border=0 width=100%>
<tr><td Colspan=2 align=center><font SIZE=6><b>Lost Password Recovery</b></font></td></tr>";

$sql="SELECT * FROM users WHERE email='$email'";
$result=mysql_query($sql);

if ($post) {
if (!$email) {
echo "<tr><td COLSPAN=2>
Forgotten your password?  Just enter the e-mail address you used to sign up on the message boards,
and your username and password will be mailed to that address.<p>
If you have not already created a user name, then you should instead go to the 
<a HREF=\"register.php\">Registration</a> page to create a new account.<p>
</td></tr>
<form ACTION=\"lostpass.php\" METHOD=POST>
<tr><td>E-Mail Address</td>
    <td><input type=\"text\" size=\"20\" maxlength=\"50\" name=\"email\"></tr>
    <tr><td COLSPAN=2><input type=\"submit\" value=\"E-Mail My Password\" name=\"post\"><input type=\"reset\" value=\"Reset\" name=\"reset\"></td></tr>

</form>

</table>";
include("/home/mediarch/foot.php");
exit;
} else {
if (mysql_num_rows($result)==0)
{
echo "

<tr><td COLSPAN=2>ERROR: No user was found for the e-mail address \"$email\".</td></tr>

<tr><td COLSPAN=2>
Forgotten your password?  Just enter the e-mail address you used to sign up on the message boards,
and your username and password will be mailed to that address.<p>
If you have not already created a user name, then you should instead go to the 
<a HREF=\"register.php\">Registration</a> page to create a new account.<p>
</td></tr>
<form ACTION=\"lostpass.php\" METHOD=POST>
<tr><td>E-Mail Address</td>
    <td><input type=\"text\" size=\"20\" maxlength=\"50\" name=\"email\"></tr>
    <tr><td COLSPAN=2><input type=\"submit\" value=\"E-Mail My Password\" name=\"post\"><input type=\"reset\" value=\"Reset\" name=\"reset\"></td></tr>

</form>



</table>";
include("/home/mediarch/foot.php");
exit;
} else {
while ($myrow=mysql_fetch_array($result)) {
$datedate=date("n/j/y g:i:s A");
$mailsubject="".$sitetitle." Lost Password Recovery";
$mailbody="Someone has requested that the username and password for the ".$sitetitle." Message boards be sent to this e-mail address.  If this wasn't you, the IP address of the person who made the request is below.

UserName: \"".$myrow["username"]."\"
Password: \"".$myrow["userpass"]."\"

The request to send this information came from the IP address ".$REMOTE_ADDR." at ".gmdate("n/j/y g:i:s A")." Greenwich Mean Time.";
$mailx=mail($email,$mailsubject,$mailbody);
}
echo "<tr><td COLSPAN=2>The username and password have been mailed to the e-mail address \"$email\".</td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}}} else if (!$post) {
echo "

<tr><td COLSPAN=2>
Forgotten your password?  Just enter the e-mail address you used to sign up on the message boards,
and your username and password will be mailed to that address.<p>
If you have not already created a user name, then you should instead go to the 
<a HREF=\"register.php\">Registration</a> page to create a new account.<p>
</td></tr>
<form ACTION=\"lostpass.php\" METHOD=POST>
<tr><td>E-Mail Address</td>
    <td><input type=\"text\" size=\"20\" maxlength=\"50\" name=\"email\"></tr>
    <tr><td COLSPAN=2><input type=\"submit\" value=\"E-Mail My Password\" name=\"post\"><input type=\"reset\" value=\"Reset\" name=\"reset\"></td></tr>

</form>



</table>";
include("/home/mediarch/foot.php");
}
?>



