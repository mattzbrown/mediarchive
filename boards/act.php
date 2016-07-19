<?
$pagetitle="Registration";
include("/home/mediarch/head.php");
echo $harsss;
echo "<table border=0 width=100%>
<tr><td align=center><font SIZE=6><b>Registration</b></font></td></tr>";
if (!$regkey)
{
echo "<tr><td>

You must provide an activation key to use this page.

</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
if ($regkey)
{
$regkey=ereg_replace(" ","+",$regkey);
$sql="SELECT * FROM users WHERE regsid='$regkey'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
if (mysql_num_rows($result)==1)
{
if ($myrow["level"]==0)
{
$email=$myrow["regemail"];
$sql="SELECT * FROM kos";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$ip=$myrow["ip"];
$isp=$myrow["isp"];
if (eregi("$ip", $REMOTE_ADDR)>=1) {
if (eregi("$isp", $email)<=0) { 
echo "<tr><td>
Unfortunately, due to the abuse of the ".$sitetitle." message boards by other users of your Internet Service Provider, you must use an e-mail address that ends with one of the following: '".eregi_replace("@","",$isp)."'. If your ISP has given you an alternate e-mail domain, contact boards@".$sitetitle.".com with both this message and the full e-mail address that was assigned by your ISP.
</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
}
}
$sql="SELECT * FROM options WHERE opid=1";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$sql="SELECT * FROM emails";
$result=mysql_query($sql);
$numrows=0;
while ($myrow2=@mysql_fetch_array($result)) {
if (eregi($myrow2["email"],$email)>=1) {
$numrows=1;
}
}
if (($numrows>=1) && ($myrow["val"]>=1)) {
$sql="UPDATE users SET level='10' WHERE regsid='$regkey'";
$result=mysql_query($sql);
$sql="UPDATE users SET regsid='' WHERE regsid='$regkey'";
$result=mysql_query($sql);
echo "<tr><td>

User ".$myrow["username"]." has been authorized to post messages and create topics with an intial authorization level of 10. You may proceed to the <a href=\"login.php\">Login</a> page from here to sign on.

</td></tr>
</table>";
include("/home/mediarch/foot.php");
} else {
$sql="UPDATE users SET level='11' WHERE regsid='$regkey'";
$result=mysql_query($sql);
$sql="UPDATE users SET regsid='' WHERE regsid='$regkey'";
$result=mysql_query($sql);
echo "<tr><td>

User ".$myrow["username"]." has been authorized to post messages and create topics with an intial authorization level of 11. You may proceed to the <a href=\"login.php\">Login</a> page from here to sign on.

</td></tr>
</table>";
include("/home/mediarch/foot.php");
}
}
} else {
echo "<tr><td>

The activation key you entered is either incorrect or was already used.
	
</td></tr>
</table>";
include("/home/mediarch/foot.php");
}
}
?>











