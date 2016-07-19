<?
$pagetitle="Create A Faction";
include("/home/mediarch/head.php");
echo $harsss."<table border=\"1\" cellspacing=\"0\" width=\"100%\">\n";
$topic = round($_GET["topic"]);
$board = round($_GET["board"]);
$faction_name = trim($_POST["faction_name"]);
$board_name = trim($_POST["board_name"]);
$post = $_POST["post"];
for ($i=1; $i <= 9; $i++) {
	$str = "mem".$i;
	$$str = htmlentities(trim($_POST[$str]));
}
if (!auth2($uname,$pword)) {
	echo "\n<tr><td>You must be <a href=\"login.php\">logged in</a> to view this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
?>
<tr><td align="center" colspan="2"><span style="font-size:250%;"><b>Create A Faction</b></span></td></tr>
<?
$u = @mysql_fetch_array(mysql_query("SELECT `level`,`aura`,`faction`,`tempfaction`,`userid` FROM `users` WHERE `username` = '".$uname."'"));
$fn = @mysql_num_rows(mysql_query("SELECT `factionid` FROM `factions`"));
if ($u["level"] < LEVEL_NEW2) {
	echo "\n<tr><td>You must be at least level ".LEVEL_NEW2." to create a faction.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
if ($u["aura"] < 5) {
	echo "\n<tr><td>You must have at least 5 aura to create a faction.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
if (($u["faction"] > 0) || ($u["tempfaction"] > 0)) {
	echo "\n<tr><td>You are already a member of a faction, you cannot create another.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
if ($fn >= 20) {
	echo "\n<tr><td>The maximum amount of factions has been reached. You cannot create a faction at this time.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
?>
<tr><td colspan="2" align="center" class="lite"><i>
Return to: <a href="index.php" class="menu">Board List</a>
<?
if ($board) echo " | \n<a href=\"gentopic.php?board=".$board."\" class=\"menu\">Topic List</a>";
if ($topic) echo " | \n<a href=\"genmessage.php?board=".$board."&topic=".$topic."\" class=\"menu\">Message List</a>";
?> | <a href="user.php<?= querystring($board,$topic) ?>" class="menu">User Info Page</a>
</i></td></tr>
<?
$con = 0;
$i = 1;
if ($post) {
	$faction_exists = @mysql_num_rows(mysql_query("SELECT `factionid` FROM `factions` WHERE `name` = '".htmlentities($faction_name)."'")) + @mysql_num_rows(mysql_query("SELECT `tfid` FROM `tempfactions` WHERE `name` = '".htmlentities($faction_name)."'"));
	$board_exists = @mysql_num_rows(mysql_query("SELECT `boardid` FROM `boards` WHERE `boardname` = '".htmlentities($board_name)."'"));
	if ((strlen($faction_name) < 5) || (strlen($faction_name) > 40)) echo "\n\n<tr><td colspan=\"2\" align=\"center\"><b>There was an error creating your faction:</b><br />Faction names must be between 5 and 40 characters. The name you inputted is ".strlen($faction_name)." characters long.</td></tr>\n\n";
	else if ((strlen($board_name) < 5) || (strlen($board_name) > 80)) echo "\n\n<tr><td colspan=\"2\" align=\"center\"><b>There was an error creating your faction:</b><br />Board names must be between 5 and 80 characters. The name you inputted is ".strlen($board_name)." characters long.</td></tr>\n\n";
	else if ($faction_exists >= 1) echo "\n\n<tr><td colspan=\"2\" align=\"center\"><b>There was an error creating your faction:</b><br />The faction name &quot;".htmlentities($faction_name)."&quot; is already taken.</td></tr>\n\n";
	else if ($board_exists >= 1) echo "\n\n<tr><td colspan=\"2\" align=\"center\"><b>There was an error creating your faction:</b><br />The board name &quot;".htmlentities($board_name)."&quot; is already taken.</td></tr>\n\n";
	if ((!$mem1) || (!$mem2) || (!$mem3) || (!$mem4)) echo "\n\n<tr><td colspan=\"2\" align=\"center\"><b>There was an error creating your faction:</b><br />You must input at least the first 4 members.</td></tr>\n\n";
	else $con = 1;
	for ($i=1; $i <= 9; $i++) {
		if ($con == 1) {
			$str = "mem".$i;
			if ($$str) {
				$user_exists = @mysql_num_rows(mysql_query("SELECT `userid` FROM `users` WHERE `username` = '".$$str."' AND `level` > ".LEVEL_INACT));
				$user_faction = @mysql_num_rows(mysql_query("SELECT `userid` FROM `users` WHERE `username` = '".$$str."' AND `faction` > 0"));
				$user_not_you = @mysql_num_rows(mysql_query("SELECT `userid` FROM `users` WHERE `username` = '".$$str."' AND `userid` <> ".$u["userid"]));
				if ($user_exists <= 0) { echo "\n\n<tr><td colspan=\"2\" align=\"center\"><b>There was an error creating your faction:</b><br />The user &quot;".$$str."&quot; either does not exist, or is banned, closed, suspended, or inactive.</td></tr>\n\n"; $con = 0; }
				else if ($user_not_you <= 0) { echo "\n\n<tr><td colspan=\"2\" align=\"center\"><b>There was an error creating your faction:</b><br />You cannot list yourself as a member, as you are already made one when you create the faction.</td></tr>\n\n"; $con = 0; }
				else if ($user_faction >= 1) { echo "\n\n<tr><td colspan=\"2\" align=\"center\"><b>There was an error creating your faction:</b><br />The user &quot;".$$str."&quot; is already a member of a faction.</td></tr>\n\n"; $con = 0; }
			}
		}
	}
	if ($con == 1) {
		mysql_query("INSERT INTO `tempfactions` (`name`,`board`) VALUES ('".htmlentities($faction_name)."','".htmlentities($board_name)."')");
		$f = @mysql_fetch_array(mysql_query("SELECT `tfid` FROM `tempfactions` WHERE `name` = '".htmlentities($faction_name)."'"));
		mysql_query("UPDATE `users` SET `tempfaction` = ".$f["tfid"].", `rank` = 5 WHERE `userid` = ".$u["userid"]);
		for ($i=1; $i <= 9; $i++) {
			$str = "mem".$i;
			if ($$str) {
				$ub = @mysql_fetch_array(mysql_query("SELECT `userid` FROM `users` WHERE `username` = '".$$str."'"));
				mysql_query("INSERT INTO `invitations` (`touser`,`fromuser`,`sendtime`,`factionid`,`tempfact`) VALUES (".$ub["userid"].",".$u["userid"].",".time().",".$f["tfid"].",1)");
			}
		}
		echo "\n\n<meta http-equiv=\"refresh\" content=\"10; URL=user.php".querystring($board,$topic)."\" />\n\n<tr><td colspan=\"2\">Your faction has been created, but it is currently inactive. In order for your faction to be activated, it must have at least 5 members, You will be notified via sysnote when your faction has gained the required amount of users. You will be returned to the user info page in 10 seconds. If not, you can click <a href=\"user.php".querystring($board,$topic)."\">here</a>.</td></tr>\n\n</table>";
		include("/home/mediarch/foot.php");
		exit;
	}
}
?>
<form action="<? echo $PHP_SELF.querystring($board,$topic); ?>" method="post">
<tr>
	<td><b>Faction Name:</b><br /><font size="1">Between 5 and 40 characters</font></td>
	<td><input type="text" name="faction_name" value="<? echo htmlentities($faction_name); ?>" size="40" maxlength="40" /></td>
</tr><tr>
	<td><b>Faction Board Name:</b><br /><font size="1">Between 5 and 80 characters</font></td>
	<td><input type="text" name="board_name" value="<? echo htmlentities($board_name); ?>" size="80" maxlength="80" /></td>
</tr><tr>
	<td><b>Faction Members:</b><br /><font size="1">Minimum 5, maximum 10 (including you)<br />Leave unnecessary fields blank</font></td>
	<td><? for ($i=1; $i <= 9; $i++) { $str = "mem".$i; echo "\n\t\t".($i+1).": <input type=\"text\" name=\"mem".$i."\" value=\"".$$str."\" size=\"20\" maxlength=\"20\" /><br />"; } ?>
	</td>
</tr><tr>
	<td colspan="2"><input type="submit" name="post" value="Create" /><input type="reset" /></td>
</tr>
</form>
</table>

<? include("/home/mediarch/foot.php"); ?>