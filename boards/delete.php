<?
$pagetitle="Delete a Message";
include("/home/mediarch/head.php");
echo $harsss."<table border=\"0\" width=\"100%\">\n<tr><td align=\"center\"><b><span style=\"font-size:250%;\">Delete Message</span></b></td></tr>";
$topic = round($_GET["topic"]);
$board = round($_GET["board"]);
$message = round($_POST["messageid"]);
if (!auth2($uname,$pword)) {
	echo "\n<tr><td>You must be <a href=\"login.php\">logged in</a> to view this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$r=mysql_query("SELECT `boardname`,`boardlevel`,`messlevel` FROM `boards` WHERE `boardid` = ".$board);
if (@mysql_num_rows($r)<=0) {
	echo "<tr><td>An invalid Board ID has been used to access this page. Return to the <a href=\"index.php\">General Board List</a> to select a board.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$b=@mysql_fetch_array($r);
$r2=mysql_query("SELECT `topicname`, `closed` FROM `topics` WHERE `topicid`=".$topic);
$r3=mysql_query("SELECT `delid` FROM `deleted` WHERE `topic`=".$topic);
if ((@mysql_num_rows($r2)<=0) && (@mysql_num_rows($r3)<=0)) {
	echo "<tr><td>An invalid Topic ID has been used to access this page. Return to the <a href=\"gentopic.php?board=".$board."\">General Topic List</a> to select a topic.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$r4=mysql_query("SELECT `topicid` FROM `topics` WHERE `topicid`=".$topic." AND `boardnum` <> ".$board);
if ((@mysql_num_rows($r3)>=1) || (@mysql_num_rows($r4)>=1)) {
	echo "<tr><td>This Topic has either been deleted or moved to another message board. Return to the <a href=\"gentopic.php?board=".$board."\">General Topic List</a> page to select a topic.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$t=@mysql_fetch_array($r2);
$u=@mysql_fetch_array(mysql_query("SELECT `userid`, `username`, `level`, `faction`,`ignore` FROM `users` WHERE `username` = '".$uname."'"));
if ($b["boardlevel"]>$u["level"]) {
	echo "<tr><td>You are not authorized to view topics on this board. This board is restricted to users level ".$b["boardlevel"]." and higher. Return to the <a href=\"index.php\">General Board List</a> to select a board.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$fcr = mysql_query("SELECT `factionid`,`boardid`,`name` FROM `factions` WHERE `boardid` = ".$board);
$fc = @mysql_fetch_array($fcr);
if ((@mysql_num_rows($fcr) >= 1) && ($fc["factionid"] != $u["faction"])) {
	echo "<tr><td>You are not authorized to view topics on this board. This board is restricted to users of the faction ".stripslashes($fc["name"]).". Return to the <a href=\"index.php\">General Board List</a> to select a board.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$f=mysql_query("SELECT `messageid`,`messsec`,`messby`,`messbody` FROM `messages` WHERE `messageid` = ".$message);
if (@mysql_num_rows($f) <= 0) {
	echo "<tr><td>An invalid Message ID has been used to access this page. Return to the <a href=\"genmessage.php?board=".$board."&topic=".$topic."\">General Message List</a> to select a message.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
if ($u["level"] < LEVEL_NEW1) {
	echo "\n<tr><td>You are not authorized to delete messages.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$m=@mysql_fetch_array($f);
$ub = @mysql_fetch_array(mysql_query("SELECT `userid`, `username` FROM `users` WHERE `username` = '".$m["messby"]."'"));
$first = FALSE;
$last = FALSE;
$first_r = @mysql_fetch_array(mysql_query("SELECT `messageid` FROM `messages` WHERE `topic` = ".$topic." ORDER BY `messageid` ASC LIMIT 0, 1"));
$last_r = @mysql_fetch_array(mysql_query("SELECT `messageid` FROM `messages` WHERE `topic` = ".$topic." ORDER BY `messageid` DESC LIMIT 0, 1"));
if ($first_r["messageid"] == $message) $first = TRUE;
if ($last_r["messageid"] == $message) $last = TRUE;
$mins = @mysql_num_rows(mysql_query("SELECT `messageid` FROM `messages` WHERE `topic` = ".$topic." AND `messsec` >= ".(time()-1200)));
if ($u["userid"] == $ub["userid"]) {
	if ((!$first) && (!$last)) {
		mysql_query("UPDATE `messages` SET `messbody` = '[This message was deleted at the request of the original poster]' WHERE `messageid` = ".$message);
		echo "\n\n<meta http-equiv=\"refresh\" content=\"10; URL=genmessage.php?board=".$board."&topic=".$topic."\" />\n\n<tr><td>Your message has been deleted. You will be returned to the <a href=\"genmessage.php?board=".$board."&topic=".$topic."\">General Message List</a> in ten seconds.</td></tr>\n</table>";
	} else if ((!$first) && ($last)) {
		$dt = @mysql_fetch_array(mysql_query("SELECT `messsec` FROM `messages` WHERE `topic` = ".$topic." ORDER BY `messsec` DESC LIMIT 0, 1"));
		mysql_query("DELETE FROM `messages` WHERE `messageid` = ".$message);
		mysql_query("DELETE FROM `marked` WHERE `message` = ".$message);
		mysql_query("DELETE FROM `secmarked` WHERE `message` = ".$message);
		mysql_query("DELETE FROM `suggested` WHERE `message` = ".$message);
		mysql_query("DELETE FROM `secsuggested` WHERE `message` = ".$message);
		mysql_query("UPDATE `topics` SET `timesec` = ".$dt["messsec"]." WHERE `topicid` = ".$topic);
		echo "\n\n<meta http-equiv=\"refresh\" content=\"10; URL=genmessage.php?board=".$board."&topic=".$topic."\" />\n\n<tr><td>Your message has been deleted. You will be returned to the <a href=\"genmessage.php?board=".$board."&topic=".$topic."\">General Message List</a> in ten seconds.</td></tr>\n</table>";
	} else if (($first) && (!$last) && (!$mins)) {
		mysql_query("UPDATE `topics` SET `closed` = 1 WHERE `topicid` = ".$topic);
		echo "\n\n<meta http-equiv=\"refresh\" content=\"10; URL=genmessage.php?board=".$board."&topic=".$topic."\" />\n\n<tr><td>Your topic has been closed. You will be returned to the <a href=\"genmessage.php?board=".$board."&topic=".$topic."\">General Message List</a> in ten seconds.</td></tr>\n</table>";
	} else if (($first) && (!$last) && ($mins)) {
		echo "\n\n<meta http-equiv=\"refresh\" content=\"10; URL=genmessage.php?board=".$board."&topic=".$topic."\" />\n\n<tr><td>Since somebody has posted in this topic in the last 20 minutes, you cannot close it. You will be returned to the <a href=\"genmessage.php?board=".$board."&topic=".$topic."\">General Message List</a> in ten seconds.</td></tr>\n</table>";
	} else if (($first) && ($last)) {
		mysql_query("DELETE FROM `topics` WHERE `topicid` = ".$topic);
		mysql_query("DELETE FROM `messages` WHERE `messageid` = ".$message);
		mysql_query("DELETE FROM `marked` WHERE `message` = ".$message);
		mysql_query("DELETE FROM `secmarked` WHERE `message` = ".$message);
		mysql_query("DELETE FROM `suggested` WHERE `message` = ".$message);
		mysql_query("DELETE FROM `secsuggested` WHERE `message` = ".$message);
		echo "\n\n<meta http-equiv=\"refresh\" content=\"10; URL=gentopic.php?board=".$board."\" />\n\n<tr><td>Your topic has been deleted. You will be returned to the <a href=\"gentopic.php?board=".$board."\">General Topic List</a> in ten seconds.</td></tr>\n</table>";
	}
} else if ($u["userid"] != $ub["userid"]) {
		echo "\n\n<meta http-equiv=\"refresh\" content=\"10; URL=genmessage.php?board=".$board."&topic=".$topic."\" />\n\n<tr><td>You are only allowed to delete your own messages. You will be returned to the <a href=\"genmessage.php?board=".$board."&topic=".$topic."\">General Message List</a> in ten seconds.</td></tr>\n</table>";
}

echo "</table>";
include("/home/mediarch/foot.php");
?>


