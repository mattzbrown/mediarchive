<?
$pagetitle="Send Faction Invitations";
include("/home/mediarch/head.php");
echo $harsss."<table border=\"0\" cellspacing=\"0\" width=\"100%\">\n";
$topic = round($_GET["topic"]);
$board = round($_GET["board"]);
$delete = round($_GET["delete"]);
$post = $_POST["post"];
$send_to = htmlentities(trim($_POST["send_to"]));
if (!auth2($uname,$pword)) {
	echo "\n<tr><td>You must be <a href=\"login.php\">logged in</a> to view this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$x = 0;
$y = 0;
$z = 0;
function shadebar1() {
	global $x;
	$x++;
	$str = "";
	if (($x % 2) == 1) $str = " class=\"shade\""; 
	return $str;
}
function shadebar2() {
	global $y;
	$y++;
	$str = "";
	if (($y % 2) == 1) $str = " class=\"shade\""; 
	return $str;
}
function shadebar3() {
	global $z;
	$z++;
	$str = "";
	if (($z % 2) == 1) $str = " class=\"shade\""; 
	return $str;
}
?>
<tr><td align="center" colspan="3"><span style="font-size:250%;"><b>Send Faction Invitations</b></span></td></tr>
<?
$u = @mysql_fetch_array(mysql_query("SELECT `faction`,`tempfaction`,`userid` FROM `users` WHERE `username` = '".$uname."'"));
if (($u["faction"] <= 0) && ($u["tempfaction"] <= 0)) {
	echo "\n<tr><td>You are not a member of a faction.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
?>
<tr><td align="center" class="lite" colspan="3"><i>
Return to: <a href="index.php" class="menu">Board List</a>
<?
if ($board) echo " | \n<a href=\"gentopic.php?board=".$board."\" class=\"menu\">Topic List</a>";
if ($topic) echo " | \n<a href=\"genmessage.php?board=".$board."&topic=".$topic."\" class=\"menu\">Message List</a>";
?> | <a href="user.php<?= querystring($board,$topic) ?>" class="menu">User Info Page</a>
</i></td></tr>
<?
if ($post) {
	if ($u["faction"] > 0) { $faction_id = $u["faction"]; $tmp = 0; } else if ($u["tempfaction"] > 0) { $faction_id = $u["tempfaction"]; $tmp = 1; }
	if ($u["tempfaction"] > 0) $nu = @mysql_num_rows(mysql_query("SELECT `userid` FROM `users` WHERE `tempfaction` = ".$u["tempfaction"])); else if ($u["faction"] > 0) $nu = @mysql_num_rows(mysql_query("SELECT `userid` FROM `users` WHERE `faction` = ".$u["faction"]));
	$ni = @mysql_num_rows(mysql_query("SELECT `invid` FROM `invitations` WHERE `fromuser` = ".$u["userid"]));
	$ur = mysql_query("SELECT `userid`,`username` FROM `users` WHERE `username` = '".$send_to."'");
	$ub = @mysql_fetch_array($ur);
	$user_exists = @mysql_num_rows($ur);
	$user_not_you = @mysql_num_rows(mysql_query("SELECT `userid` FROM `users` WHERE `username` = '".$send_to."' AND `userid` <> ".$u["userid"]));
	$user_no_faction = @mysql_num_rows(mysql_query("SELECT `userid` FROM `users` WHERE `username` = '".$send_to."' AND `faction` <= 0 AND `tempfaction` <= 0"));
	$user_banned = @mysql_num_rows(mysql_query("SELECT `userid` FROM `users` WHERE `username` = '".$send_to."' AND `level` > ".LEVEL_INACT));
	$user_no_invs = @mysql_num_rows(mysql_query("SELECT `invid` FROM `invitations` WHERE `touser` = ".$ub["userid"]." AND `factionid` = ".$faction_id." AND `tempfact` = ".$tmp));
	if ($nu >= 10) echo "\n\n<tr><td colspan=\"3\" align=\"center\"><b>There was an error sending your invitation:</b><br />Your faction currently has 10 members, you cannot invite any more.</td></tr>\n\n";
	else if ($ni >= 5) echo "\n\n<tr><td colspan=\"3\" align=\"center\"><b>There was an error sending your invitation:</b><br />You cannot have more than five active invitations at once. Cancel one of your current invitations, or wait until one is accepted/rejected.</td></tr>\n\n";
	else if ($user_exists <= 0) echo "\n\n<tr><td colspan=\"3\" align=\"center\"><b>There was an error sending your invitation:</b><br />User ".$send_to." does not exist.</td></tr>\n\n";
	else if ($user_not_you <= 0) echo "\n\n<tr><td colspan=\"3\" align=\"center\"><b>There was an error sending your invitation:</b><br />You cannot send an invitation to yourself.</td></tr>\n\n";
	else if ($user_no_faction <= 0) echo "\n\n<tr><td colspan=\"3\" align=\"center\"><b>There was an error sending your invitation:</b><br />User ".$send_to." is already in a faction.</td></tr>\n\n";
	else if ($user_banned <= 0) echo "\n\n<tr><td colspan=\"3\" align=\"center\"><b>There was an error sending your invitation:</b><br />User ".$send_to." is not able to recieve invitations due to his/her user level.</td></tr>\n\n";
	else if ($user_no_invs >= 1) echo "\n\n<tr><td colspan=\"3\" align=\"center\"><b>There was an error sending your invitation:</b><br />This user already has an invitation to your faction.</td></tr>\n\n";
	else {
		mysql_query("INSERT INTO `invitations` (`touser`,`fromuser`,`sendtime`,`factionid`,`tempfact`) VALUES (".$ub["userid"].",".$u["userid"].",".time().",".$faction_id.",".$tmp.")");
		echo "\n\n<tr><td colspan=\"3\" align=\"center\"><b>Your invitation was successfully sent to ".$ub["username"].".</b></td></tr>\n\n";
	}
} else if ($delete) {
	$check = mysql_query("SELECT `factionid`,`touser` FROM `invitations` WHERE `invid` = ".$delete." AND `fromuser` = ".$u["userid"]);
	if (@mysql_num_rows($check) >= 1) {
		$i = @mysql_fetch_array($check);
		$ub = @mysql_fetch_array(mysql_query("SELECT `username` FROM `users` WHERE `userid` = ".$i["touser"]));
		mysql_query("DELETE FROM `invitations` WHERE `invid` = ".$delete);
		echo "\n\n<tr><td colspan=\"3\" align=\"center\"><b>Your invitation to ".$ub["username"]." was cancelled.</b></td></tr>\n\n";
	}
}
?>
<tr><td class="dark" align="center" colspan="3">Send Invitation</td></tr>
<form action="<? echo $PHP_SELF.querystring($board,$topic); ?>" method="post">
<tr><td class="cell1">Send To:</td><td class="cell1" colspan="2"><input type="text" name="send_to" value="<? echo $send_to; ?>" size="20" maxlength="20" /></td></tr>
<tr><td class="cell1" colspan="3"><input type="submit" name="post" value="Send" /><input type="reset" /></td></tr></form>
<tr><td class="dark" align="center" colspan="3">Pending Invitations</td></tr>
<tr><td class="lite"><i>To User</i></td><td class="lite"><i>Sent At</i></td><td class="lite" width="1%"><i>Cancel</i></td></tr>
<?
$r = mysql_query("SELECT `invid`,`touser`,`sendtime` FROM `invitations` WHERE `fromuser` = ".$u["userid"]);
while ($i = @mysql_fetch_array($r)) {
	$ub = @mysql_fetch_array(mysql_query("SELECT `username` FROM `users` WHERE `userid` = ".$i["touser"]));
	echo "\n<tr><td".shadebar1()."><a href=\"whois.php?user=".$i["touser"].querystring2($board,$topic)."\">".$ub["username"]."</a></td><td".shadebar2().">".str_replace(" ","&nbsp;",gmdate("n/j/Y h:i:s A",($i["sendtime"]+$time_offset)))."</td><td".shadebar3()." width=\"1%\"><a href=\"".$PHP_SELF."?delete=".$i["invid"].querystring2($board,$topic)."\">[Cancel]</a></td></tr>";
}
?>

</table>
<? include("/home/mediarch/foot.php"); ?>