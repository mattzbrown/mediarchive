<?
$pagetitle="User Preferences";
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

<tr><td>You must be <a HREF=\index.php\">logged in</a> to view this page.</td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
if ($myrow["level"]<0)
{
echo "<table border=0 width=100%>

<tr><td>You are not authorized to view this page.</td></tr>
</table>

";
include("/home/mediarch/foot.php");
exit;
}
echo "<table border=1 cellspacing=0 width=100%>
<tr><td COLSPAN=3 align=center><font SIZE=6><b>Aura Shop</b></font></td></tr>";

echo "<tr><td COLSPAN=3 CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo " | <a HREF=\"pref5.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\" CLASS=MENU>Aura Purchases</a> | <a HREF=\"user.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\" CLASS=MENU>User Info Page</a>";
echo "</i></font></td></tr>";
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$userid=$myrow["userid"];
if ($post) {
	$total=0;
	if ($secret) { $total=$total+500; }
	if (($links) && ($myrow["hyperlink"]<=0)) { $total=$total+275; }
	if (($images) && ($myrow["images"]<=0)) { $total=$total+500; }
	if (($sigspace) && ($myrow["sigspace"]<=1)) { $total=$total+50; }
	if ($sendsys) { $total=$total+150; }
	if ($gift1) { $total=$total+1; }
	if ($gift5) { $total=$total+5; }
	if ($gift10) { $total=$total+10; }
	if ($gift25) { $total=$total+25; }
	if ($gift50) { $total=$total+50; }
	if ($gift100) { $total=$total+100; }
	if ($myrow["aura"]<$total) {
		echo "<tr><td COLSPAN=3 ALIGN=CENTER><b>There was an error making your purchase:</b><br>You do not have enough Aura to purchase the item(s) you selected.</td></tr>";
	} else if ($myrow["aura"]>=$total) {
		$sql="SELECT * FROM users WHERE username='$uname'";
		$result3=mysql_query($sql);
		$myrow=@mysql_fetch_array($result3);
		$newaura=$myrow["aura"];
		if ($secret) {
			$newaura=$newaura-500;
			$newbuy=$myrow["secret"]+1;
			$sql="UPDATE users SET secret='$newbuy' WHERE userid='$userid'";
			$result=mysql_query($sql);
		}
		if (($sigspace) && ($myrow["sigspace"]<=1)) {
			$newaura=$newaura-50;
			$newbuy=$myrow["sigspace"]+1;
			$sql="UPDATE users SET sigspace='$newbuy' WHERE userid='$userid'";
			$result=mysql_query($sql);
		}
		if ($sendsys) {
			$newaura=$newaura-150;
			$newbuy=$myrow["sendsys"]+1;
			$sql="UPDATE users SET sendsys='$newbuy' WHERE userid='$userid'";
			$result=mysql_query($sql);
		}
		if ($gift1) {
			$newaura=$newaura-1;
			$newbuy=$myrow["gift1"]+1;
			$sql="UPDATE users SET gift1='$newbuy' WHERE userid='$userid'";
			$result=mysql_query($sql);
		}
		if ($gift5) {
			$newaura=$newaura-5;
			$newbuy=$myrow["gift5"]+1;
			$sql="UPDATE users SET gift5='$newbuy' WHERE userid='$userid'";
			$result=mysql_query($sql);
		}
		if ($gift10) {
			$newaura=$newaura-10;
			$newbuy=$myrow["gift10"]+1;
			$sql="UPDATE users SET gift10='$newbuy' WHERE userid='$userid'";
			$result=mysql_query($sql);
		}
		if ($gift25) {
			$newaura=$newaura-25;
			$newbuy=$myrow["gift25"]+1;
			$sql="UPDATE users SET gift25='$newbuy' WHERE userid='$userid'";
			$result=mysql_query($sql);
		}
		if ($gift50) {
			$newaura=$newaura-50;
			$newbuy=$myrow["gift50"]+1;
			$sql="UPDATE users SET gift50='$newbuy' WHERE userid='$userid'";
			$result=mysql_query($sql);
		}
		if ($gift100) {
			$newaura=$newaura-100;
			$newbuy=$myrow["gift100"]+1;
			$sql="UPDATE users SET gift100='$newbuy' WHERE userid='$userid'";
			$result=mysql_query($sql);
		}
		$sql="UPDATE users SET aura='$newaura' WHERE userid='$userid'";
		$result=mysql_query($sql);
		if ($total>0) {
		echo "<tr><td COLSPAN=3 ALIGN=CENTER><b><a href=\"pref5.php";
		if ($board) { echo "?board=$board"; }
		if ($topic) { echo "&topic=$topic"; }
		echo "\">The items you requested have been purchased.</a></b></td></tr>";
		}
	}
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
echo "<tr><td COLSPAN=3 CLASS=DARK ALIGN=CENTER><font SIZE=3>".$myrow["username"].": ".$myrow["aura"]."&Aring</font></td></tr>";
echo "<form ACTION=\"pref6.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" METHOD=POST>
<tr>
<td CLASS=LITE ALIGN=center WIDTH=1%><i>&nbsp;</i></td>
<td CLASS=LITE ALIGN=center><i>Item</i></td>
<td CLASS=LITE ALIGN=center><i>Cost</i></td>
</tr>";
echo "<tr>
<td CLASS=CELL1><input type=\"checkbox\" name=\"secret\" value=\"1\" /></td>
<td CLASS=CELL1>Personal Secret Board</td>
<td CLASS=CELL1>500&Aring;</td>
</tr>";
if ($myrow["sigspace"]<=1) {
echo "
<tr>
<td CLASS=CELL1><input type=\"checkbox\" name=\"sigspace\" value=\"1\" /></td>
<td CLASS=CELL1>Extra Line in Signature (can buy up to 2)</td>
<td CLASS=CELL1>50&Aring;</td>
</tr>";
}
echo "<tr>
<td CLASS=CELL1><input type=\"checkbox\" name=\"sendsys\" value=\"1\" /></td>
<td CLASS=CELL1>Send One System Notification</td>
<td CLASS=CELL1>150&Aring;</td>
</tr>
<tr>
<td CLASS=CELL1><input type=\"checkbox\" name=\"gift1\" value=\"1\" /></td>
<td CLASS=CELL1>1&Aring; Gift Card</td>
<td CLASS=CELL1>1&Aring;</td>
</tr>
<tr>
<td CLASS=CELL1><input type=\"checkbox\" name=\"gift5\" value=\"1\" /></td>
<td CLASS=CELL1>5&Aring; Gift Card</td>
<td CLASS=CELL1>5&Aring;</td>
</tr>
<tr>
<td CLASS=CELL1><input type=\"checkbox\" name=\"gift10\" value=\"1\" /></td>
<td CLASS=CELL1>10&Aring; Gift Card</td>
<td CLASS=CELL1>10&Aring;</td>
</tr>
<tr>
<td CLASS=CELL1><input type=\"checkbox\" name=\"gift25\" value=\"1\" /></td>
<td CLASS=CELL1>25&Aring; Gift Card</td>
<td CLASS=CELL1>25&Aring;</td>
</tr>
<tr>
<td CLASS=CELL1><input type=\"checkbox\" name=\"gift50\" value=\"1\" /></td>
<td CLASS=CELL1>50&Aring; Gift Card</td>
<td CLASS=CELL1>50&Aring;</td>
</tr>
<tr>
<td CLASS=CELL1><input type=\"checkbox\" name=\"gift100\" value=\"1\" /></td>
<td CLASS=CELL1>100&Aring; Gift Card</td>
<td CLASS=CELL1>100&Aring;</td>
</tr>";

echo "<tr><td ALIGN=CENTER COLSPAN=3><input type=\"submit\" value=\"Purchase\" name=\"post\"><input type=\"reset\" value=\"Reset\" name=\"reset\">
</td></tr>
</form>

</table>
";
include("/home/mediarch/foot.php");
?>