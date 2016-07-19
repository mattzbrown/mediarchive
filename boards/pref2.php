<?
$pagetitle="User Preferences";
include("/home/mediarch/head.php");
echo $harsss;
?>

<table border=1 cellspacing=0 width=100%>
<tr><td COLSPAN=2 align=center><font SIZE=6><b>Quote, Signature, and E-Mail</b></font></td></tr>
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
$usrname=$myrow["username"];
$sigspace=$myrow["sigspace"];
if ($myrow["level"]<5)
{
echo "<tr><td>You are not authorized to view this page.</td></tr>
</table>

";
include("/home/mediarch/foot.php");
exit;
}
echo "<tr><td COLSPAN=2 CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo " | <a HREF=\"user.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\" CLASS=MENU>User Info Page</a>";
echo "</i></font></td></tr>";

$email3 = htmlentities($email);
$email4 = htmlentities($email2);
$im2 = htmlentities($im);
$sig3 = htmlentities($sig);
$sig3 = nl2br($sig3);
$sigbrnum=explode("<br />", $sig3);
$sig3=eregi_replace("<br />", "<br>", $sig3);
$sig2 = nl2br($sig);
$sig2 = eregi_replace("<br />", " ", $sig2);
$sig2 = explode(" ", $sig2);
while (list($key, $val) = each($sig2)) {
if (strlen($val)>80) {
$siglenx=1;
}
}
$quote3 = htmlentities($quote);
$quote3 = nl2br($quote3);
$quotbrnum=explode("<br />", $quote3);
$quote3=eregi_replace("<br />", "<br>", $quote3);
$quote2 = nl2br($quote);
$quote2 = eregi_replace("<br />", " ", $quote2);
$quote2 = explode(" ", $quote2);
while (list($key, $val) = each($quote2)) {
if (strlen($val)>80) {
$quotelenx=1;
}
}
$sql = "SELECT * FROM options WHERE opid=2";
$result70 = mysql_query($sql);
$myrow70 = @mysql_fetch_array($result70);
if ($myrow70["val"]==1) {
$sql = "SELECT * FROM words WHERE `type`=1 ORDER BY wordid ASC";
$result71 = mysql_query($sql);
while ($myrow71=@mysql_fetch_array($result71)) {
if (eregi($myrow71["word"],$email2)>=1) {
$emailban=$myrow71["wordid"];
}
if (eregi($myrow71["word"],$im)>=1) {
$imban=$myrow71["wordid"];
}
if (eregi($myrow71["word"],$quote)>=1) {
$quoteban=$myrow71["wordid"];
}
if (eregi($myrow71["word"],$sig)>=1) {
$sigban=$myrow71["wordid"];
}
}
}
$sql = "SELECT * FROM options WHERE opid=2";
$result70 = mysql_query($sql);
$myrow70 = @mysql_fetch_array($result70);
if ($myrow70["val"]==1) {
$sql = "SELECT * FROM words WHERE `type`=1 ORDER BY wordid ASC";
$result71 = mysql_query($sql);
while ($myrow71=@mysql_fetch_array($result71)) {
if (eregi($myrow71["word"],$email2)>=1) {
$emailban=$myrow71["wordid"];
}
if (eregi($myrow71["word"],$im)>=1) {
$imban=$myrow71["wordid"];
}
if (eregi($myrow71["word"],$quote)>=1) {
$quoteban=$myrow71["wordid"];
}
if (eregi($myrow71["word"],$sig)>=1) {
$sigban=$myrow71["wordid"];
}
}
}
$sql = "SELECT * FROM options WHERE opid=3";
$result70 = mysql_query($sql);
$myrow70 = @mysql_fetch_array($result70);
if ($myrow70["val"]==1) {
$sql = "SELECT * FROM words WHERE `type`=2 ORDER BY wordid ASC";
$result71 = mysql_query($sql);
while ($myrow71=@mysql_fetch_array($result71)) {
if (eregi($myrow71["word"],$email2)>=1) {
$emailban=$myrow71["wordid"];
}
if (eregi($myrow71["word"],$im)>=1) {
$imban=$myrow71["wordid"];
}
if (eregi($myrow71["word"],$quote)>=1) {
$quoteban=$myrow71["wordid"];
}
if (eregi($myrow71["word"],$sig)>=1) {
$sigban=$myrow71["wordid"];
}
}
}
if ($post) {
if (strlen($email)>50) {
echo "<tr><td COLSPAN=2 ALIGN=CENTER><b>There were errors updating your preferences:</b><br>

The maximum allowed length of an e-mail address is 50.</td></tr>";
} else {
if (strlen($email2)>50) {
echo "<tr><td COLSPAN=2 ALIGN=CENTER><b>There were errors updating your preferences:</b><br>
The maximum allowed length of an e-mail address is 50.</td></tr>";
} else {
if (strlen($im)>50) {
echo "<tr><td COLSPAN=2 ALIGN=CENTER><b>There were errors updating your preferences:</b><br>
The maximum allowed length of an IM is 50.</td></tr>";
} else {
if (strlen($sig)>(($sigspace*80)+160)) {
echo "<tr><td COLSPAN=2 ALIGN=CENTER><b>There were errors updating your preferences:</b><br>
The maximum allowed length of an signature is 160.</td></tr>";
} else {
if ($siglenx) {
echo "<tr><td COLSPAN=2 ALIGN=CENTER><b>There were errors updating your preferences:</b><br>
Your signature contains a single word over 80 characters in length. This can cause problems for some browsers, and is not allowed.</td></tr>";
} else {
if ($quotelenx) {
echo "<tr><td COLSPAN=2 ALIGN=CENTER><b>There were errors updating your preferences:</b><br>

Your quote contains a single word over 80 characters in length. This can cause problems for some browsers, and is not allowed.</td></tr>";
} else {
if ($emailban) {
echo "<tr><td COLSPAN=2 ALIGN=CENTER><b>There were errors updating your preferences:</b><br>
The public e-mail address you entered contains possibly offensive language. Please change it.</td></tr>";
} else {
if ($imban) {
echo "<tr><td COLSPAN=2 ALIGN=CENTER><b>There were errors updating your preferences:</b><br>
The IM you entered contains possibly offensive language. Please change it.</td></tr>";
} else {
if ($sigban) {
echo "<tr><td COLSPAN=2 ALIGN=CENTER><b>There were errors updating your preferences:</b><br>
The signature you entered contains possibly offensive language. Please change it.</td></tr>";
} else {
if ($quoteban) {
echo "<tr><td COLSPAN=2 ALIGN=CENTER><b>There were errors updating your preferences:</b><br>
The quote you entered contains possibly offensive language. Please change it.</td></tr>";
} else {
if (count($sigbrnum)>=($sigspace+3)) {
echo "<tr><td COLSPAN=2 ALIGN=CENTER><b>There were errors updating your preferences:</b><br>
The maximum allowed number of lines for a signature is 2.</td></tr>";
} else {
if (strlen($quote)>320) {
echo "<tr><td COLSPAN=2 ALIGN=CENTER><b>There were errors updating your preferences:</b><br>
The maximum allowed length of an quote is 320.</td></tr>";
} else {
if (count($quotbrnum)>=5) {
echo "<tr><td COLSPAN=2 ALIGN=CENTER><b>There were errors updating your preferences:</b><br>
The maximum allowed number of lines for a quote is 4.</td></tr>";
} else {
$sql="UPDATE users SET email='$email3' WHERE username='$uname'";
$result=mysql_query($sql);
$sql="UPDATE users SET email2='$email4' WHERE username='$uname'";
$result=mysql_query($sql);
$sql="UPDATE users SET imtype='$imtype' WHERE username='$uname'";
$result=mysql_query($sql);
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
if ($myrow["imtype"] != 0) {
$sql="UPDATE users SET im='$im2' WHERE username='$uname'";
$result=mysql_query($sql);
} else if ($myrow["imtype"] == 0) {
$sql="UPDATE users SET im='' WHERE username='$uname'";
$result=mysql_query($sql);
}
$sql="UPDATE users SET sig='$sig3' WHERE username='$uname'";
$result=mysql_query($sql);
$sql="UPDATE users SET quote='$quote3' WHERE username='$uname'";
$result=mysql_query($sql);
echo "


<tr><td COLSPAN=2 ALIGN=CENTER><b>Your user preferences have been successfully updated.</b></td></tr>";
}}}}}}}}}}}}}}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
echo "
<tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Change User Settings for ".$myrow["username"]."</font></td></tr>

";
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);

echo "<form ACTION=\"pref2.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\" METHOD=\"POST\">
<tr><td COLSPAN=2 CLASS=SYS ALIGN=CENTER><font SIZE=2><b>Warning:</b>  Putting a TOS violation (i.e. Censor Bypass, Flame, etc.) in your signature, quote, or e-mail is grounds for an immediate loss of your account.  Read the <a HREF=\"tos.php\">TOS</a> if you don't know all the rules.</font></td></tr>
<tr><td><font SIZE=2><b>Private E-Mail</b></font><br>

<font SIZE=1>This e-mail will not be publicly displayed at any time, but it will be used to mail your username and password if your forget them.</font></td>
<td><input type=text name=email value=\"".$myrow["email"]."\"></td></tr>

<tr><td><font SIZE=2><b>Public E-Mail</b></font><br>
<font SIZE=1>This e-mail will be publicly displayed on your user information page, but it may be left blank or spam-protected at your leisure.</font></td>
<td><input type=text name=email2 value=\"".$myrow["email2"]."\"></td></tr>

<tr><td><font SIZE=2><b>Instant Messaging</b></font><br>
<font SIZE=1>This will be publicly displayed on your user information page, but it may be left blank at your leisure.</font></td>
<td>
  <select name=\"imtype\" size=\"1\">";
if ($myrow["imtype"] == 0) {
echo "
  <option value=\"0\" SELECTED>- None -</option>";
}
if ($myrow["imtype"] == 1) {
echo "
  <option value=\"1\" SELECTED>AIM</option>";
}
if ($myrow["imtype"] == 2) {
echo "
  <option value=\"2\" SELECTED>ICQ</option>";
}
if ($myrow["imtype"] == 3) {
echo "
  <option value=\"3\" SELECTED>MSN</option>";
}
if ($myrow["imtype"] == 4) {
echo "
  <option value=\"4\" SELECTED>YIM</option>";
}
echo "
  <option value=\"1\">AIM</option>

  <option value=\"2\">ICQ</option>
  <option value=\"3\">MSN</option>
  <option value=\"4\">YIM</option>
  <option value=\"0\">- None -</option>  

</select>
<input type=text name=im value=\"".$myrow["im"]."\">
</td></tr>";

$sigstr=eregi_replace("<br>", "", $myrow["sig"]);
$quotestr=eregi_replace("<br>", "", $myrow["quote"]);
$siglines=$sigspace+2;
$sigchars=($sigspace*80)+160;
echo "<tr><td><font SIZE=2><b>Signature</b></font><br>

<font SIZE=1>Max $siglines lines, $sigchars characters total</font></td>
<td><textarea cols=\"60\" rows=\"2\" name=\"sig\" WRAP=\"virtual\">$sigstr</textarea></td></tr>
<tr><td><font SIZE=2><b>Quote</b></font><br>

<font SIZE=1>Max 4 lines, 320 characters total</font></td>
<td><textarea cols=\"60\" rows=\"4\" name=\"quote\" WRAP=\"virtual\">$quotestr</textarea></td></tr>
<tr><td COLSPAN=2><input type=\"submit\" value=\"Make Changes\" name=\"post\"><input type=\"reset\" value=\"Reset\" name=\"reset\">
</td></tr>

</form>

</table>
";
include("/home/mediarch/foot.php");
?>




