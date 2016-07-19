<?
$pagetitle="Moderator Application";
include("/home/mediarch/head.php");
echo $harsss;
$sql="SELECT * FROM options WHERE opid='8'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
if ($myrow["val"]==0) {
echo "<table border=0 cellspacing=2 width=100%>
<tr><td>Moderator applications are currently <b>closed</b>.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
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
$username=auth($uname,$pword);
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$usename=$myrow["username"];
$karma=$myrow["cookies"];
$topictitle="Application for $usename";
if (!$username)
{
echo "<table border=0 cellspacing=2 width=100%>
<tr><td>You are not authorized to view this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
echo "<table border=0 cellspacing=2 width=100%>

<tr><td COLSPAN=2 align=center><font SIZE=6><b>Moderator Applications</b></font></td></tr>";
$sql="SELECT * FROM options WHERE opid='9'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
if ($myrow["val"]>$karma) {
echo "<table border=0 cellspacing=2 width=100%>
<tr><td colspan=2><b>You need a karma of at least ".$myrow["val"]." to apply.</b></td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
if ($post) {
$message="<b>User Name:</b> ".$myrow["username"]."

<b>Real Name:</b> $realname

<b>Age:</b> $age

<b>Location:</b> $location

<b>Country:</b> $country

<b>Category:</b> $cat

<b>Times Available:</b> $ta

$essay";
$message2 = htmlentities($message);
$message8 = htmlentities($message);
$message2 = nl2br($message2);
$message2 = eregi_replace("&lt;b&gt;", "<b>", $message2);
$message2 = eregi_replace("&lt;/b&gt;", "</b>", $message2);
$message2 = eregi_replace("&lt;i&gt;", "<i>", $message2);
$message2 = eregi_replace("&lt;/i&gt;", "</i>", $message2);
$message2 = eregi_replace("&nbsp;", " ", $message2);
$message2 = eregi_replace("&shy;", "", $message2);
$message3 = eregi_replace("
", "", $message);
$message3 = eregi_replace(" ", "", $message3);
$message3 = eregi_replace("<b>", "", $message3);
$message3 = eregi_replace("</b>", "", $message3);
$message3 = eregi_replace("<i>", "", $message3);
$message3 = eregi_replace("</i>", "", $message3);
$message4 = eregi_replace("<br>", " ", $message2);
$message4 = explode(" ", $message4);
while (list($key, $val) = each($message4)) {
if (strlen($val)>80) {
$messlenx=1;
}
}
}
if ($post) {
$sql = "SELECT * FROM topics WHERE boardnum=199 AND topicname='$topictitle'";
$result5 = mysql_query($sql);
$result5 = @mysql_num_rows($result5);
}
if (($post) && ((!$realname) || (!$age) || (!$location) || (!$country) || (!$ta) || (!$essay))) {
echo "<tr><td COLSPAN=2><b>There was an error posting your application:</b> A field in your application is blank.</td></tr>";
} else if (($post) && ((strlen($essay)>6020) || (strlen($realname)>50) || (strlen($age)>2) || (strlen($location)>100) || (strlen($country)>100) || (strlen($cat)>100) || (strlen($ta)>200))) {
echo "<tr><td COLSPAN=2><b>There was an error posting your application:</b> The maximum allowed size for the fields are as follows: Real Name - 50 characters, Age - 2 characters, Location - 100 characters, Country - 100 characters, Times Available - 200 characters, Essay - 6020 characters. Please change your application accordingly.</td></tr>";
} else if (($messlenx) && ($post)) {
echo "<tr><td COLSPAN=2><b>There was an error posting your application:</b> Your application contains a single word over 80 characters in length. This can cause problems for certain browsers, and is not allowed.</td></tr>";
} else if (($result5) && ($post)) {
$sql = "SELECT * FROM topics WHERE boardnum=199 AND topicname='$topictitle'";
$result = mysql_query($sql);
$myrow=mysql_fetch_array($result);
$topicxx=$myrow["topicid"];
$sql = "UPDATE messages WHERE topic='$topicxx' AND mesboard=199 SET messbody='<b>VOIDED</b>'";
$result = mysql_query($sql);
$myrow=@mysql_fetch_array($result);
echo "<tr><td colspan=2 align=center><b>Your application has been submitted. Please do not submit more than one application, or both will be voided. Return to the <a href=\"index.php\">Board List</a>.</b></td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
} else if (($post) && ($realname) && ($age) && ($location) && ($country) && ($cat) && ($ta) && ($essay)) {

$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$usename=$myrow["username"];
$posttime=time();
$datedate=date("n/j/Y H:i");
$topictitle="Application for $usename";
$sql="INSERT INTO topics (topicname,boardnum,topicby,timesec,active,postdate) VALUES ('$topictitle','199','$usename','$posttime','1','$datedate')";
$result=mysql_query($sql);
$sql="SELECT * FROM topics WHERE topicname='$topictitle' AND topicby='$uname' AND boardnum=199";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$topicnum=$myrow["topicid"];
$datedate=date("n/j/Y h:i:s A");
$datedate2=date("n/d g:iA");
$sql="INSERT INTO messages (topic,messby,messsec,messbody,mesboard,postdate) VALUES ('$topicnum','$usename','$posttime','$message2','199','$datedate')";
$result=mysql_query($sql);
$datedate=date("n/j/Y H:i:s A");
$sql="UPDATE users SET lastactivity='$datedate' WHERE username='$uname'";
$result=mysql_query($sql);
$time=time();
$sql="UPDATE users SET lastsec='$time' WHERE username='$uname'";
$result=mysql_query($sql);
echo "<tr><td colspan=2 align=center><b>Your application has been submitted. Please do not submit more than one application, or both will be voided. Return to the <a href=\"index.php\">Board List</a>.</b></td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
echo "<form ACTION=\"modapply.php\" METHOD=\"post\">
<tr><td>Your Message Board Username</td>
    <td>".$myrow["username"]."</td></tr>
<tr><td>Your Real Name</td>
    <td><input type=\"text\" size=\"30\" maxlength=\"80\" name=\"realname\" value=\"$realname\" ></td></tr>

<tr><td>Your Age</td>
    <td><input type=\"text\" size=\"2\" maxlength=\"2\" name=\"age\" value=\"$age\" ></td></tr>

<tr><td>City and State/Provice/Region Where You Live</td>
    <td><input type=\"text\" size=\"30\" maxlength=\"100\" name=\"location\" value=\"$location\" ></td></tr>

<tr><td>Country Where You Live</td>
    <td><input type=\"text\" size=\"30\" maxlength=\"100\" name=\"country\" value=\"$country\" ></td></tr>

<tr><td>Category Choice<br><font SIZE=1>";
$c=0;
$sql="SELECT * FROM boardcat WHERE cathide=0 ORDER BY id ASC";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$c=$c+1;
echo eregi_replace(" Boards","",$myrow["name"]).", ";
}
echo "Other</font></td>
    <td><input type=\"text\" size=\"30\" maxlength=\"100\" name=\"cat\" value=\"$cat\" ></td></tr>

<tr><td>Times Available (in ".$sitetitle." time, Eastern US)</td>
    <td><input type=\"text\" size=\"30\" maxlength=\"200\" name=\"ta\" value=\"$ta\" ></td></tr>

<tr><td COLSPAN=2>Essay Question: Why do you think you should be a moderator? (Please include any additional
information you feel needs to be known here)<br>
<textarea cols=\"60\" rows=\"20\" name=\"essay\" WRAP=\"virtual\">$essay
</textarea></td></tr>

<tr><td COLSPAN=2>By pressing the &quot;Submit Application&quot; button below, you are asking to be an unpaid volunteer for 
".$sitetitle." with absolutely no rights to payment or other compensation.  You may be removed from your moderator
position at any time and for any reason.  You are also giving up your rights to sue ".$sitetitle.", its sponsors, or
affiliates for any reason relating to your position as moderator.  Applying more than once will invalidate
all of your applications, so make absolutely sure that the above information is correct.<br>
<input type=\"submit\" value=\"Submit Application\" name=\"post\"><input type=\"reset\" value=\"Reset\" name=\"reset\">
</font></td></tr></form>";
?>
</table>
<?
include("/home/mediarch/foot.php");
?>

