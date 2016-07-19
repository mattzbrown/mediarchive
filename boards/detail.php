<?
$pagetitle="Message Detail";
include("/home/mediarch/head.php");
echo $harsss."<table border=\"0\" width=\"100%\">\n<tr><td colspan=\"2\" align=\"center\"><b><span style=\"font-size:250%;\">Message Detail</span></b></td></tr>";
$topic = round($_GET["topic"]);
$board = round($_GET["board"]);
$message = round($_GET["message"]);
if (!auth2($uname,$pword)) {
	echo "\n<tr><td>You must be <a href=\"login.php\">logged in</a> to view this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$r=mysql_query("SELECT `boardname`,`boardlevel`,`messlevel` FROM `boards` WHERE `boardid`=".$board);
if (@mysql_num_rows($r)<=0) {
	echo "<tr><td>An invalid Board ID has been used to access this page. Return to the <a href=\"index.php\">General Board List</a> to select a board.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$b=@mysql_fetch_array($r);
echo "<tr><td align=\"center\" colspan=\"2\"><span style=\"font-size:120%;\"><b>Board: <a href=\"gentopic.php?board=".$board."\">".stripslashes($b["boardname"])."</a></b></span></td></tr>\n";
$r2=mysql_query("SELECT `topicname`, `closed` FROM `topics` WHERE `topicid`=".$topic);
$r3=mysql_query("SELECT `delid` FROM `deleted` WHERE `topic`=".$topic);
if ((@mysql_num_rows($r2)<=0) && (@mysql_num_rows($r3)<=0)) {
	echo "<tr><td>An invalid Topic ID has been used to access this page. Return to the <a href=\"gentopic.php?board=".$board."\">General Topic List</a> to select a topic.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$r4=mysql_query("SELECT `topicid` FROM `topics` WHERE `topicid`=".$topic." AND `boardnum`<>".$board);
if ((@mysql_num_rows($r3)>=1) || (@mysql_num_rows($r4)>=1)) {
	echo "<tr><td>This Topic has either been deleted or moved to another message board. Return to the <a href=\"gentopic.php?board=".$board."\">General Topic List</a> page to select a topic.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$t=@mysql_fetch_array($r2);
$u=@mysql_fetch_array(mysql_query("SELECT `userid`, `username`, `level`, `faction` FROM `users` WHERE `username` = '".$uname."'"));
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
echo "<tr><td align=\"center\" colspan=\"2\"><span style=\"font-size:120%;\"><b>Topic: <a href=\"genmessage.php?board=".$board."&topic=".$topic."\">".stripslashes($t["topicname"])."</a></b></span></td></tr>\n";
$f=mysql_query("SELECT `messageid`,`messsec`,`messby`,`messbody` FROM `messages` WHERE `messageid` = ".$message);
if (@mysql_num_rows($f) <= 0) {
	echo "<tr><td>An invalid Message ID has been used to access this page. Return to the <a href=\"genmessage.php?board=".$board."&topic=".$topic."\">General Message List</a> to select a message.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
if ($u["level"] < LEVEL_NEW1) {
	echo "\n<tr><td>You are not authorized to mark, suggest, or delete messages.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$m=@mysql_fetch_array($f);
$ub = @mysql_fetch_array(mysql_query("SELECT `userid`, `username` FROM `users` WHERE `username` = '".$m["messby"]."'"));
?>
<tr><td class="cell2" colspan="2"><b>From</b>: <a href="whois.php?user=<? echo $ub["userid"]; ?>&board=<? echo $board; ?>&topic=<? echo $topic; ?>"><? echo $ub["username"]; ?></a> | <b>Posted:</b> <? echo str_replace(" ","&nbsp;",gmdate("n/j/Y h:i:s A",($m["messsec"]+$time_offset))); ?></td></tr>
<tr><td class="cell1" colspan="2"><? echo stripslashes($m["messbody"]); ?></td></tr>

<?
$first = FALSE;
$last = FALSE;
$first_r = @mysql_fetch_array(mysql_query("SELECT `messageid` FROM `messages` WHERE `topic` = ".$topic." ORDER BY `messageid` ASC LIMIT 0, 1"));
$last_r = @mysql_fetch_array(mysql_query("SELECT `messageid` FROM `messages` WHERE `topic` = ".$topic." ORDER BY `messageid` DESC LIMIT 0, 1"));
if ($first_r["messageid"] == $message) $first = TRUE;
if ($last_r["messageid"] == $message) $last = TRUE;
$mins = @mysql_num_rows(mysql_query("SELECT `messageid` FROM `messages` WHERE `topic` = ".$topic." AND `messsec` >= ".(time()-1200)));
if ($u["userid"] == $ub["userid"]) {
if ((!$first) && (!$last))
echo "<tr><td align=\"center\" colspan=\"2\"><span style=\"font-size:125%;\"><b>Delete this Message</b></span></td></tr>\n<tr><td colspan=\"2\">Since other users have since posted in this Topic, you can delete your message, but your message will <b>not</b> be completely eliminated, but instead replaced with a notice that the message was removed at your request.  If you wish to do this, just click YES below.</td></tr>\n<tr><td colspan=\"2\"><form method=\"post\" action=\"delete.php?board=$board&topic=$topic\">Are you sure you want to mark your post as deleted?<br /><input type=\"submit\" name=\"yes\" value=\"YES, Delete this Post\" /><input type=\"hidden\" name=\"messageid\" value=\"".$message."\" /></form></td></tr>";
else if ((!$first) && ($last))
echo "<tr><td align=\"center\" colspan=\"2\"><span style=\"font-size:125%;\"><b>Delete this Message</b></span></td></tr>\n<tr><td colspan=\"2\">Since this is the latest post in the Topic, you can delete this message from the boards. If you wish to do this, just click YES below.</td></tr>\n<tr><td colspan=\"2\"><form method=\"post\" action=\"delete.php?board=".$board."&topic=".$topic."\">Are you sure you want to remove your post?<br /><input type=\"submit\" name=\"yes\" value=\"YES, Delete this Post\" /><input type=\"hidden\" name=\"messageid\" value=\"".$message."\" /></form></td></tr>";
else if (($first) && (!$last) && (!$mins))
echo "<tr><td align=\"center\" colspan=\"2\"><span style=\"font-size:125%;\"><b>Close this Topic</b></span></td></tr>\n<tr><td colspan=\"2\">As nobody has posted in this topic for the past 20 minutes, you have the option of closing it, making it impossible to post any additional messages.</td></tr>\n<tr><td colspan=\"2\"><form method=\"post\" action=\"delete.php?board=".$board."&topic=".$topic."\">Do you want to Close this Topic?<br /><input type=\"submit\" name=\"yes\" value=\"YES, Close This Topic\" /><input type=\"hidden\" name=\"messageid\" value=\"".$message."\" /></form></td></tr>";
else if (($first) && (!$last) && ($mins))
echo "<tr><td align=\"center\" colspan=\"2\"><span style=\"font-size:125%;\"><b>Close this Topic</b></span></td></tr>\n<tr><td colspan=\"2\">Since somebody has posted in this topic in the past 20 minutes, you cannot close it.</td></tr>";
else if (($first) && ($last))
echo "<tr><td align=\"center\" colspan=\"2\"><span style=\"font-size:125%;\"><b>Delete this Message</b></span></td></tr>\n<tr><td colspan=\"2\">Since this is the only message in the Topic, you can delete this topic from the boards. If you wish to do this, just click YES below.</td></tr>\n<tr><td colspan=\"2\"><form method=\"post\" action=\"delete.php?board=$board&topic=$topic\">Are you sure you want to remove this topic?<br /><input type=\"submit\" name=\"yes\" value=\"YES, Delete this Post\" /><input type=\"hidden\" name=\"messageid\" value=\"".$message."\" /></form></td></tr>";
} else if ($u["userid"] != $ub["userid"]) {
echo "<tr><td align=\"center\"><span style=\"font-size:125%;\"><b>Mark for Moderation</b></span></td><td align=\"center\"><span style=\"font-size:125%;\"><b>Suggest for Aura</b></span></td></tr><tr><td colspan=\"2\">You have the ability to mark other user's messages for moderation, or suggest them to recieve aura. This function allows you to report TOS violations and intelligent/humorous messages to the moderators, which then will take appropriate action on it as they reach this message in the queue. The reporting function is anonymous; only the moderators will see who has marked this message, and that information is deleted when the moderator takes action. Please note that <b>abuse</b> of this form could result in karma loss or termination of your account.</td></tr>\n<tr><td><form method=\"post\" action=\"mod.php?board=".$board."&topic=".$topic."\">";
$y=mysql_query("SELECT `tosid`,`ruletitle`,`ruledesc` FROM `tos` WHERE `markshow` = 1 ORDER BY `tosid` ASC");
while ($s=@mysql_fetch_array($y)) {
echo "\n<input type=\"radio\" name=\"reason\" value=\"".$s["tosid"]."\" /><b>".$s["ruletitle"]."</b>: ".$s["ruledesc"]."<br />";
}
echo "<input type=\"hidden\" name=\"messageid\" value=\"".$message."\" /><input type=\"submit\" name=\"submit\" value=\"Report Message\" /></form></td><td><form method=\"post\" action=\"suggest.php?board=".$board."&topic=".$topic."\">";
$sql="SELECT * FROM sos ORDER BY sosid ASC";
$y=mysql_query("SELECT `sosid`,`ruletitle`,`ruledesc` FROM `sos` ORDER BY `sosid` ASC");
while ($s=@mysql_fetch_array($y)) {
echo "\n<input type=\"radio\" name=\"reason\" value=\"".$s["sosid"]."\" /><b>".$s["ruletitle"]."</b>";
if ($s["ruledesc"]) echo ": ".$s["ruledesc"];
echo "<br />";
}
echo "<input type=\"hidden\" name=\"messageid\" value=\"".$message."\" /><input type=\"submit\" name=\"submit\" value=\"Suggest Message\" /></form></td></tr>";
}
?>
</table>
<?
include("/home/mediarch/foot.php");
?>