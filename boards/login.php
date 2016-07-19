<?
session_start();
if ((!$storepass) && ($password)) {
if ($userid) {
setcookie ("luname", $userid, time()+600, "/", "$HTTP_HOST", 0);
setcookie ("lpword", $password, time()+600, "/", "$HTTP_HOST", 0);
}
}
if (($storepass) && ($password)) {
if ($userid) {
setcookie ("auname", $userid, time()+99999999999999, "/", "$HTTP_HOST", 0);
setcookie ("apword", $password, time()+99999999999999, "/", "$HTTP_HOST", 0);
}
}
$pagetitle="Login";
include("/home/mediarch/head.php");
echo $harsss;
$heada="<tr><td COLSPAN=2>
Log in to the ".$sitetitle." message boards below to post messages.  If you have not already created a user
name, you can go to the <a HREF=\"register.php\">Registration</a> page to create a new account.<p>

</td></tr>";
$headb="<form ACTION=\"login.php\" METHOD=POST>
<tr><td>User name</td>
    <td><input type=\"text\" size=\"20\" maxlength=\"20\" name=\"userid\" value=\"\" ></td></tr>

<tr><td>Password</td>
    <td><input type=\"password\" size=\"20\" maxlength=\"20\" name=\"password\"></tr>
<tr><td>Store My UserName and Password on This Computer<br>
        (You will be automatically logged in each time you enter the message boards, but so will anyone else using this computer.)</td>
    <td><input type=\"checkbox\" name=\"storepass\" CHECKED></tr>
    <tr><td COLSPAN=2><input type=\"submit\" value=\"Log In\" name=\"post\"><input type=\"reset\" value=\"Reset\" name=\"reset\"></td></tr>
    <tr><td COLSPAN=2><a HREF=\"lostpass.php\">Have you forgotten your password?</a></td></tr>

	</form>


</table>";
echo "<table border=0 width=100%>
<tr><td Colspan=2 align=center><font SIZE=6><b>User Login</b></font></td></tr>";
function getuserid($user)
{
$sql="SELECT * FROM users WHERE username='$user'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
return $myrow["userid"];
}
function usermap($userid1,$userid2)
{
if ($userid1!=$userid2)
{
$sql="SELECT * FROM usermap WHERE userid1='$userid1' AND userid2='$userid2'";
$result=mysql_query($sql);
$time=time();
if (mysql_num_rows($result)==0)
{
$sql="INSERT INTO usermap (userid1,userid2,date) VALUES ('$userid1','$userid2','$time')";
$result=mysql_query($sql);
}
}
}
function auth($userid, $password) {
$sql="SELECT username FROM users WHERE username='$userid' AND userpass='$password'";
$result=mysql_query($sql);
if(!mysql_num_rows($result)) return 0;
else {
$query_data=mysql_fetch_row($result);
return $query_data[0];
}
}
if ($post)
{
if (!$userid)
{
echo "$heada

$headb";
} else {
if (!$password)
{
echo "$heada

$headb";
} else {
$time=time()-3600;
$sql2="SELECT * FROM badlogin WHERE ip='$REMOTE_ADDR' AND date>=$time";
$result2=mysql_query($sql2);
$result2=mysql_num_rows($result2);
if($result2>=3)
{
echo "$heada


<tr><td COLSPAN=2><b>There was an error with your log in:</b> Too many invalid attempts have been made to access accounts from this IP address. Please try again later.</td></tr>

$headb";
} else {
$sql3="SELECT * FROM users WHERE username='$userid'";
$result3=mysql_query($sql3);
$result3=@mysql_num_rows($result3);
if(!$result3)
{
echo "$heada

<tr><td COLSPAN=2><b>There was an error with your log in:</b> User Name '$userid' was not found. Verify the correct name, or <a href=\"register.php\">register</a> a new name.</td></tr>

$headb";
} else {
$username=auth($userid, $password);
if(!$username)
{
$ctime=time();
$sql4="INSERT INTO badlogin (ip,date,username,pass) VALUES ('$REMOTE_ADDR','$ctime','$userid','$password')";
$result4=mysql_query($sql4);
echo "$heada

<tr><td COLSPAN=2><b>There was an error with your log in:</b> The password for User '$userid' was entered incorrectly.</td></tr>

$headb";
} else {
$thissid=session_id();
$sql="UPDATE users SET lastsid='$thissid' WHERE username='$userid'";
$result=mysql_query($sql);
$sql="SELECT * FROM users WHERE lastsid='$thissid'";
$result=mysql_query($sql);
if (mysql_num_rows($result)>=2)
{
while ($myrow=mysql_fetch_array($result))
{
$useid2=$myrow["userid"];
$useid=getuserid($userid);
usermap($useid,$useid2);
usermap($useid2,$useid);
}
}
$lastacip=REMOTE_ADDR;
$sql="SELECT * FROM users WHERE lastacip='$lastacip'";
$result=mysql_query($sql);
if (mysql_num_rows($result)>=2)
{
while ($myrow=mysql_fetch_array($result))
{
$useid2=$myrow["userid"];
$useid=getuserid($userid);
usermap($useid,$useid2);
usermap($useid2,$useid);
}
}
$logindat=date("n/j/Y H:i:s");
$time=time();
$sql="UPDATE users SET lastactivity='$logindat' WHERE username='$userid'";
$result=mysql_query($sql);
$sql="UPDATE users SET lastsec='$time' WHERE username='$userid'";
$result=mysql_query($sql);
$sql="UPDATE users SET defsec='$time' WHERE username='$userid'";
$result=mysql_query($sql);
echo "



<TR><TD COLSPAN=2>
	You have successfully logged in.  
		You can now return to the <A HREF=\"index.php\">General Board List</a>. 
</td></tr>



</table>";
}}}}}} else {
echo "$heada

$headb";
}
include("/home/mediarch/foot.php");
?>