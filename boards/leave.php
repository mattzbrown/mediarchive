<?
$pagetitle="Leave Faction";
include("/home/mediarch/head.php");
echo $harsss."<table border=\"0\" width=\"100%\">\n";
$topic = round($_GET["topic"]);
$board = round($_GET["board"]);
$post = $_POST["post"];
if (!auth2($uname,$pword)) {
	echo "\n<tr><td>You must be <a href=\"login.php\">logged in</a> to view this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
?>
<tr><td align="center"><span style="font-size:250%;"><b>Leave Faction</b></span></td></tr>
<?
$u = @mysql_fetch_array(mysql_query("SELECT `faction`,`tempfaction`,`userid` FROM `users` WHERE `username` = '".$uname."'"));
if (($u["faction"] <= 0) && ($u["tempfaction"] <= 0)) {
	echo "\n<tr><td>You are not a member of a faction.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
if ($post) {
		if ($u["faction"] > 0) $fnu = @mysql_num_rows(mysql_query("SELECT `userid` FROM `users` WHERE `faction` = ".$u["faction"]));
		else if ($u["tempfaction"] > 0) $fnu = @mysql_num_rows(mysql_query("SELECT `userid` FROM `users` WHERE `tempfaction` = ".$u["tempfaction"]));
	if ($fnu <= 2) {
		if ($u["faction"] > 0) {
			$f = @mysql_fetch_array(mysql_query("SELECT `boardid` FROM `factions` WHERE `factionid` = ".$u["faction"]));
			mysql_query("DELETE FROM `boards` WHERE `boardid` = ".$f["boardid"]);
			mysql_query("DELETE FROM `topics` WHERE `boardnum` = ".$f["boardid"]);
			mysql_query("DELETE FROM `messages` WHERE `mesboard` = ".$f["boardid"]);
			mysql_query("DELETE FROM `favorites` WHERE `boardid` = ".$f["boardid"]);
			mysql_query("DELETE FROM `marked` WHERE `board` = ".$f["boardid"]);
			mysql_query("DELETE FROM `secmarked` WHERE `board` = ".$f["boardid"]);
			mysql_query("DELETE FROM `suggested` WHERE `board` = ".$f["boardid"]);
			mysql_query("DELETE FROM `secsuggested` WHERE `board` = ".$f["boardid"]);
			mysql_query("DELETE FROM `modded` WHERE `boardid` = ".$f["boardid"]);
			mysql_query("DELETE FROM `auraed` WHERE `boardid` = ".$f["boardid"]);
			mysql_query("DELETE FROM `deleted` WHERE `mesboard` = ".$f["boardid"]);
			mysql_query("DELETE FROM `invitations` WHERE `factionid` = ".$u["faction"]." AND `tempfact` = 0");
			mysql_query("DELETE FROM `factions` WHERE `factionid` = ".$u["faction"]);
			mysql_query("UPDATE `users` SET `faction` = 0 WHERE `faction` = ".$u["faction"]);
		} else if ($u["tempfaction"] > 0) {
			mysql_query("DELETE FROM `invitations` WHERE `factionid` = ".$u["tempfaction"]." AND `tempfact` = 1");
			mysql_query("DELETE FROM `tempfactions` WHERE `tfid` = ".$u["tempfaction"]);
			mysql_query("UPDATE `users` SET `tempfaction` = 0 WHERE `tempfaction` = ".$u["tempfaction"]);
		}
	}
	mysql_query("DELETE FROM `invitations` WHERE `fromuser` = ".$u["userid"]);
	mysql_query("UPDATE `users` SET `faction` = 0, `tempfaction` = 0 WHERE `userid` = ".$u["userid"]);
	echo "\n\n<meta http-equiv=\"refresh\" content=\"10; URL=user.php".querystring($board,$topic)."\" />\n\n<tr><td>You have left this faction. You will be returned to the user info page in 10 seconds. If not, you can click <a href=\"user.php".querystring($board,$topic)."\">here</a>.</td></tr></table>\n\n";
	include("/home/mediarch/foot.php");
	exit;
}
?>
<tr><td align="center" class="lite"><i>
Return to: <a href="index.php" class="menu">Board List</a>
<?
if ($board) echo " | \n<a href=\"gentopic.php?board=".$board."\" class=\"menu\">Topic List</a>";
if ($topic) echo " | \n<a href=\"genmessage.php?board=".$board."&topic=".$topic."\" class=\"menu\">Message List</a>";
?> | <a href="user.php<?= querystring($board,$topic) ?>" class="menu">User Info Page</a>
</i></td></tr>
<form action="<? echo $PHP_SELF.querystring($board,$topic); ?>" method="post">
<tr><td class="sys"><b>WARNING:</b> Leaving a faction with two members or less will result in the faction being deleted.</td></tr>
<tr><td class="cell1">Leave faction <?php echo stripslashes($f["name"]); ?>: Are you sure?<br /><br /><input type="submit" name="post" value="YES, Leave this faction" /></td></tr></form>
</table>
<? include("/home/mediarch/foot.php"); ?>