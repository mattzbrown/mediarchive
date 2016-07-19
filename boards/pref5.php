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
$myuseid=$myrow["userid"];
$myusename=$myrow["username"];
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
<tr><td align=center><font SIZE=6><b>Aura Purchases</b></font></td></tr>";

echo "<tr><td CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo " | <a HREF=\"pref6.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\" CLASS=MENU>Aura Shop</a> | <a HREF=\"user.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\" CLASS=MENU>User Info Page</a>";
echo "</i></font></td></tr>";
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
while (eregi("  ",$sysnote)>=1) {
$sysnote=eregi_replace("  "," ",$sysnote);
}
$sysnote=trim($sysnote);
while (eregi("  ",$boardname)>=1) {
$boardname=eregi_replace("  "," ",$boardname);
}
$boardname=trim(htmlentities($boardname));
if (($sysname) && ($sysnote) && ($syssend) && ($myrow["sendsys"]>=1)) {
	$sql="SELECT * FROM users WHERE username='".trim($sysname)."'";
	$result=mysql_query($sql);
	$userexist=@mysql_num_rows($result);
	if ($userexist>=1) {
		if (strlen($sysnote)<=2048) {
			$myrow2=@mysql_fetch_array($result);
			$sql="UPDATE users SET notify=1 WHERE userid='".$myrow2["userid"]."'";
			$result=mysql_query($sql);
			$datedate=date("n/j/Y h:i:s A");
			$time=time();
			$newval=$myrow["sendsys"]-1;
			$sql="UPDATE users SET sendsys='".$newval."' WHERE userid='$myuseid'";
			$result=mysql_query($sql);
			$sql="INSERT INTO systemnot (sysbod,sendto,sentat,sentfrom,`read`,sentsec) VALUES ('".htmlentities(addslashes($sysnote))."','".$myrow2["userid"]."','$datedate','$myuseid','0','$time')";
			$result=mysql_query($sql);
			echo "<tr><td ALIGN=CENTER><b>Your system notification was sent successfully.</b></td></tr>";
		} else {
			echo "<tr><td ALIGN=CENTER><b>There was an error sending this system notification:</b><br>The maximum allowed size for a system notification is 2KB (2048 characters). Your system notification is ".strlen($sysnote)." characters long.</td></tr>";
		}
	} else {
		echo "<tr><td ALIGN=CENTER><b>There was an error sending this system notification:</b><br>The user you entered does not exist.</td></tr>";
	}
} else if (($boardid) && ($boardname) && ($boardcreate) && ($myrow["secret"]>=1)) {
	$sql="SELECT * FROM boards WHERE boardid='$boardid'";
	$result=mysql_query($sql);
	$boardexist=@mysql_num_rows($result);
	if ($boardexist<=0) {
		if (strlen($boardname)<=255) {
			if (($boardid>=1) && ($boardid<=9999999999999999999999999999999999999999)) {
				$sql="INSERT INTO boards (`boardid`,`boardname`,`boardlevel`,`type`,`topiclevel`,`messlevel`,`caption`,`default`) VALUES ('$boardid','$boardname','5','6','10','5','','0')";
				$result=mysql_query($sql);
				$sql="INSERT INTO favorites (boardid,userid) VALUES ('$boardid','$myuseid')";
				$result=mysql_query($sql);
				$newval=$myrow["secret"]-1;
				$sql="UPDATE users SET secret=$newval WHERE userid='$myuseid'";
				$result=mysql_query($sql);
				echo "<tr><td ALIGN=CENTER><b><a href=\"gentopic.php?board=$boardid\">Your board</a> was successfully created.</b></td></tr>";
			} else {
				echo "<tr><td ALIGN=CENTER><b>There was an error creating your board:</b><br>The board ID you entered is invalid.</td></tr>";
			}
		} else {
			echo "<tr><td ALIGN=CENTER><b>There was an error creating your board:</b><br>The maximum allowed size for a board title is &frac14;KB (255 characters). Your board title is ".strlen($boardname)." characters long.</td></tr>";
		}
	} else {
		echo "<tr><td ALIGN=CENTER><b>There was an error creating your board:</b><br>The board ID you entered already exists.</td></tr>";
	}
} else if (($giftsend1) && ($giftsend) && ($myrow["gift1"]>=1)) {
$sql="SELECT * FROM users WHERE username='".trim($giftsend)."'";
$result=mysql_query($sql);
$userexist=@mysql_num_rows($result);
if ($userexist>=1) {
$myrow2=@mysql_fetch_array($result);
$sql="UPDATE users SET notify=1 WHERE userid='".$myrow2["userid"]."'";
$result=mysql_query($sql);
$newaura=$myrow2["aura"]+1;
$sql="UPDATE users SET aura=$newaura WHERE userid='".$myrow2["userid"]."'";
$result=mysql_query($sql);
$datedate=date("n/j/Y h:i:s A");
$time=time();
$sql="INSERT INTO systemnot (sysbod,sendto,sentat,sentfrom,`read`,sentsec) VALUES ('You have recieved a gift of 1 aura from $myusename.','".$myrow2["userid"]."','$datedate','$myuseid','0','$time')";
$result=mysql_query($sql);
$newval=$myrow["gift1"]-1;
$sql="UPDATE users SET gift1=$newval WHERE userid='$myuseid'";
$result=mysql_query($sql);
echo "<tr><td ALIGN=CENTER><b>A gift of 1&Aring; was successfully sent to ".$myrow2["username"].".</b></td></tr>";
} else {
echo "<tr><td ALIGN=CENTER><b>There was an error sending this gift card:</b><br>The user you entered does not exist.</td></tr>";
}
} else if (($giftsend5) && ($giftsend) && ($myrow["gift5"]>=1)) {
$sql="SELECT * FROM users WHERE username='".trim($giftsend)."'";
$result=mysql_query($sql);
$userexist=@mysql_num_rows($result);
if ($userexist>=1) {
$myrow2=@mysql_fetch_array($result);
$sql="UPDATE users SET notify=1 WHERE userid='".$myrow2["userid"]."'";
$result=mysql_query($sql);
$newaura=$myrow2["aura"]+5;
$sql="UPDATE users SET aura=$newaura WHERE userid='".$myrow2["userid"]."'";
$result=mysql_query($sql);
$datedate=date("n/j/Y h:i:s A");
$time=time();
$sql="INSERT INTO systemnot (sysbod,sendto,sentat,sentfrom,`read`,sentsec) VALUES ('You have recieved a gift of 5 aura from $myusename.','".$myrow2["userid"]."','$datedate','$myuseid','0','$time')";
$result=mysql_query($sql);
$newval=$myrow["gift5"]-1;
$sql="UPDATE users SET gift5=$newval WHERE userid='$myuseid'";
$result=mysql_query($sql);
echo "<tr><td ALIGN=CENTER><b>A gift of 5&Aring; was successfully sent to ".$myrow2["username"].".</b></td></tr>";
} else {
echo "<tr><td ALIGN=CENTER><b>There was an error sending this gift card:</b><br>The user you entered does not exist.</td></tr>";
}
} else if (($giftsend10) && ($giftsend) && ($myrow["gift10"]>=1)) {
$sql="SELECT * FROM users WHERE username='".trim($giftsend)."'";
$result=mysql_query($sql);
$userexist=@mysql_num_rows($result);
if ($userexist>=1) {
$myrow2=@mysql_fetch_array($result);
$sql="UPDATE users SET notify=1 WHERE userid='".$myrow2["userid"]."'";
$result=mysql_query($sql);
$newaura=$myrow2["aura"]+10;
$sql="UPDATE users SET aura=$newaura WHERE userid='".$myrow2["userid"]."'";
$result=mysql_query($sql);
$datedate=date("n/j/Y h:i:s A");
$time=time();
$sql="INSERT INTO systemnot (sysbod,sendto,sentat,sentfrom,`read`,sentsec) VALUES ('You have recieved a gift of 10 aura from $myusename.','".$myrow2["userid"]."','$datedate','$myuseid','0','$time')";
$result=mysql_query($sql);
$newval=$myrow["gift10"]-1;
$sql="UPDATE users SET gift10=$newval WHERE userid='$myuseid'";
$result=mysql_query($sql);
echo "<tr><td ALIGN=CENTER><b>A gift of 10&Aring; was successfully sent to ".$myrow2["username"].".</b></td></tr>";
} else {
echo "<tr><td ALIGN=CENTER><b>There was an error sending this gift card:</b><br>The user you entered does not exist.</td></tr>";
}
} else if (($giftsend25) && ($giftsend) && ($myrow["gift25"]>=1)) {
$sql="SELECT * FROM users WHERE username='".trim($giftsend)."'";
$result=mysql_query($sql);
$userexist=@mysql_num_rows($result);
if ($userexist>=1) {
$myrow2=@mysql_fetch_array($result);
$sql="UPDATE users SET notify=1 WHERE userid='".$myrow2["userid"]."'";
$result=mysql_query($sql);
$newaura=$myrow2["aura"]+25;
$sql="UPDATE users SET aura=$newaura WHERE userid='".$myrow2["userid"]."'";
$result=mysql_query($sql);
$datedate=date("n/j/Y h:i:s A");
$time=time();
$sql="INSERT INTO systemnot (sysbod,sendto,sentat,sentfrom,`read`,sentsec) VALUES ('You have recieved a gift of 25 aura from $myusename.','".$myrow2["userid"]."','$datedate','$myuseid','0','$time')";
$result=mysql_query($sql);
$newval=$myrow["gift25"]-1;
$sql="UPDATE users SET gift25=$newval WHERE userid='$myuseid'";
$result=mysql_query($sql);
echo "<tr><td ALIGN=CENTER><b>A gift of 25&Aring; was successfully sent to ".$myrow2["username"].".</b></td></tr>";
} else {
echo "<tr><td ALIGN=CENTER><b>There was an error sending this gift card:</b><br>The user you entered does not exist.</td></tr>";
}
} else if (($giftsend50) && ($giftsend) && ($myrow["gift50"]>=1)) {
$sql="SELECT * FROM users WHERE username='".trim($giftsend)."'";
$result=mysql_query($sql);
$userexist=@mysql_num_rows($result);
if ($userexist>=1) {
$myrow2=@mysql_fetch_array($result);
$sql="UPDATE users SET notify=1 WHERE userid='".$myrow2["userid"]."'";
$result=mysql_query($sql);
$newaura=$myrow2["aura"]+50;
$sql="UPDATE users SET aura=$newaura WHERE userid='".$myrow2["userid"]."'";
$result=mysql_query($sql);
$datedate=date("n/j/Y h:i:s A");
$time=time();
$sql="INSERT INTO systemnot (sysbod,sendto,sentat,sentfrom,`read`,sentsec) VALUES ('You have recieved a gift of 50 aura from $myusename.','".$myrow2["userid"]."','$datedate','$myuseid','0','$time')";
$result=mysql_query($sql);
$newval=$myrow["gift50"]-1;
$sql="UPDATE users SET gift50=$newval WHERE userid='$myuseid'";
$result=mysql_query($sql);
echo "<tr><td ALIGN=CENTER><b>A gift of 50&Aring; was successfully sent to ".$myrow2["username"].".</b></td></tr>";
} else {
echo "<tr><td ALIGN=CENTER><b>There was an error sending this gift card:</b><br>The user you entered does not exist.</td></tr>";
}
} else if (($giftsend100) && ($giftsend) && ($myrow["gift100"]>=1)) {
$sql="SELECT * FROM users WHERE username='".trim($giftsend)."'";
$result=mysql_query($sql);
$userexist=@mysql_num_rows($result);
if ($userexist>=1) {
$myrow2=@mysql_fetch_array($result);
$sql="UPDATE users SET notify=1 WHERE userid='".$myrow2["userid"]."'";
$result=mysql_query($sql);
$newaura=$myrow2["aura"]+100;
$sql="UPDATE users SET aura=$newaura WHERE userid='".$myrow2["userid"]."'";
$result=mysql_query($sql);
$datedate=date("n/j/Y h:i:s A");
$time=time();
$sql="INSERT INTO systemnot (sysbod,sendto,sentat,sentfrom,`read`,sentsec) VALUES ('You have recieved a gift of 100 aura from $myusename.','".$myrow2["userid"]."','$datedate','$myuseid','0','$time')";
$result=mysql_query($sql);
$newval=$myrow["gift100"]-1;
$sql="UPDATE users SET gift100=$newval WHERE userid='$myuseid'";
$result=mysql_query($sql);
echo "<tr><td ALIGN=CENTER><b>A gift of 100&Aring; was successfully sent to ".$myrow2["username"].".</b></td></tr>";
} else {
echo "<tr><td ALIGN=CENTER><b>There was an error sending this gift card:</b><br>The user you entered does not exist.</td></tr>";
}
}
echo "<tr><td CLASS=DARK ALIGN=CENTER><font SIZE=3>Aura Purchases for ".$myrow["username"]."</font></td></tr>";
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$c=0;
while ($myrow["secret"]>$c) {
$c=$c+1;
echo "<tr><td><br><table width=90% align=center border=1 cellspacing=0><tr><td CLASS=DARK ALIGN=center colspan=2><font SIZE=3>Personal Secret Board Creator</font></td></tr>
<form action=\"pref5.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td CLASS=CELL1>Board ID:</td><td CLASS=CELL1><input type=\"text\" name=\"boardid\" value=\"\" size=\"8\" maxlength=\"40\"></td></tr>
<tr><td CLASS=CELL1>Board Name:</td><td CLASS=CELL1><input type=\"text\" name=\"boardname\" value=\"\" size=\"60\" maxlength=\"255\"></td></tr>
<tr><td colspan=2 CLASS=CELL1><input type=\"submit\" name=\"boardcreate\" value=\"Create Board\"><input type=\"reset\" name=\"reset\" value=\"Reset\">
	</td></tr></table><br></td></tr></form>";
}
$c=0;
while ($myrow["sendsys"]>$c) {
$c=$c+1;
echo "<tr><td><br><table width=80% align=center border=1 cellspacing=0><tr><td CLASS=DARK ALIGN=center colspan=2><font SIZE=3>System Notification Sender</font></td></tr>
<form action=\"pref5.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td CLASS=CELL1>Send notification to:</td><td CLASS=CELL1><input type=\"text\" name=\"sysname\" value=\"\" size=\"20\" maxlength=\"20\"></td></tr>
<tr><td CLASS=CELL1>Notification:</td><td CLASS=CELL1><textarea cols=\"60\" rows=\"10\" name=\"sysnote\" WRAP=\"virtual\"></textarea></td></tr>
<tr><td colspan=2 CLASS=CELL1><input type=\"submit\" name=\"syssend\" value=\"Send\"><input type=\"reset\" name=\"reset\" value=\"Reset\">
	</td></tr></table><br></td></tr></form>";
}
$c=0;
while ($myrow["gift1"]>$c) {
$c=$c+1;
echo "<tr><td><br><table width=50% align=center border=1 cellspacing=0><tr><td CLASS=DARK ALIGN=center colspan=2><font SIZE=3>1&Aring Gift Card</font></td></tr>
<form action=\"pref5.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td CLASS=CELL1>Send gift to:</td><td CLASS=CELL1><input type=\"text\" name=\"giftsend\" value=\"\" size=\"20\" maxlength=\"20\"></td></tr>
	<tr><td CLASS=CELL1 colspan=2><input type=\"submit\" name=\"giftsend1\" value=\"Send\"><input type=\"reset\" name=\"reset\" value=\"Reset\"></td></tr></table><br></td></tr></form>";
}
$c=0;
while ($myrow["gift5"]>$c) {
$c=$c+1;
echo "<tr><td><br><table width=50% align=center border=1 cellspacing=0><tr><td CLASS=DARK ALIGN=center colspan=2><font SIZE=3>5&Aring Gift Card</font></td></tr>
<form action=\"pref5.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td CLASS=CELL1>Send gift to:</td><td CLASS=CELL1><input type=\"text\" name=\"giftsend\" value=\"\" size=\"20\" maxlength=\"20\"></td></tr>
	<tr><td CLASS=CELL1 colspan=2><input type=\"submit\" name=\"giftsend5\" value=\"Send\"><input type=\"reset\" name=\"reset\" value=\"Reset\"></td></tr></table><br></td></tr></form>";
}
$c=0;
while ($myrow["gift10"]>$c) {
$c=$c+1;
echo "<tr><td><br><table width=50% align=center border=1 cellspacing=0><tr><td CLASS=DARK ALIGN=center colspan=2><font SIZE=3>10&Aring Gift Card</font></td></tr>
<form action=\"pref5.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td CLASS=CELL1>Send gift to:</td><td CLASS=CELL1><input type=\"text\" name=\"giftsend\" value=\"\" size=\"20\" maxlength=\"20\"></td></tr>
	<tr><td CLASS=CELL1 colspan=2><input type=\"submit\" name=\"giftsend10\" value=\"Send\"><input type=\"reset\" name=\"reset\" value=\"Reset\"></td></tr></table><br></td></tr></form>";
}
$c=0;
while ($myrow["gift10"]>$c) {
$c=$c+1;
echo "<tr><td><br><table width=50% align=center border=1 cellspacing=0><tr><td CLASS=DARK ALIGN=center colspan=2><font SIZE=3>10&Aring Gift Card</font></td></tr>
<form action=\"pref5.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td CLASS=CELL1>Send gift to:</td><td CLASS=CELL1><input type=\"text\" name=\"giftsend\" value=\"\" size=\"20\" maxlength=\"20\"></td></tr>
	<tr><td CLASS=CELL1 colspan=2><input type=\"submit\" name=\"giftsend10\" value=\"Send\"><input type=\"reset\" name=\"reset\" value=\"Reset\"></td></tr></table><br></td></tr></form>";
}
$c=0;
while ($myrow["gift25"]>$c) {
$c=$c+1;
echo "<tr><td><br><table width=50% align=center border=1 cellspacing=0><tr><td CLASS=DARK ALIGN=center colspan=2><font SIZE=3>25&Aring Gift Card</font></td></tr>
<form action=\"pref5.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td CLASS=CELL1>Send gift to:</td><td CLASS=CELL1><input type=\"text\" name=\"giftsend\" value=\"\" size=\"20\" maxlength=\"20\"></td></tr>
	<tr><td CLASS=CELL1 colspan=2><input type=\"submit\" name=\"giftsend25\" value=\"Send\"><input type=\"reset\" name=\"reset\" value=\"Reset\"></td></tr></table><br></td></tr>
	</form>";
}
$c=0;
while ($myrow["gift50"]>$c) {
$c=$c+1;
echo "<tr><td><br><table width=50% align=center border=1 cellspacing=0><tr><td CLASS=DARK ALIGN=center colspan=2><font SIZE=3>50&Aring Gift Card</font></td></tr>
<form action=\"pref5.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td CLASS=CELL1>Send gift to:</td><td CLASS=CELL1><input type=\"text\" name=\"giftsend\" value=\"\" size=\"20\" maxlength=\"20\"></td></tr>
	<tr><td CLASS=CELL1 colspan=2><input type=\"submit\" name=\"giftsend50\" value=\"Send\"><input type=\"reset\" name=\"reset\" value=\"Reset\"></td></tr></table><br></td></tr></form>";
}
$c=0;
while ($myrow["gift100"]>$c) {
$c=$c+1;
echo "<tr><td><br><table width=50% align=center border=1 cellspacing=0><tr><td CLASS=DARK ALIGN=center colspan=2><font SIZE=3>100&Aring Gift Card</font></td></tr>
<form action=\"pref5.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\" method=\"post\">
<tr><td CLASS=CELL1>Send gift to:</td><td CLASS=CELL1><input type=\"text\" name=\"giftsend\" value=\"\" size=\"20\" maxlength=\"20\"></td></tr>
	<tr><td CLASS=CELL1 colspan=2><input type=\"submit\" name=\"giftsend100\" value=\"Send\"><input type=\"reset\" name=\"reset\" value=\"Reset\"></td></tr></table><br></td></tr></form>";
}
$c=0;
while ($myrow["sigspace"]>$c) {
$c=$c+1;
echo "<tr><td CLASS=LITE ALIGN=center><font SIZE=3>Extra Signature Space</font></td></tr>";
}
echo "</table>";
include("/home/mediarch/foot.php");
?>