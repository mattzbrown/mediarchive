<?
$pagetitle="Message Boards";
include("/home/mediarch/head.php");
echo $harsss;
?>
<table border="0" width="100%">
<tr><td align="center" colspan="4"><span style="font-size:250%;"><b><?= $sitetitle ?> Message Boards</b></span></td></tr>


<tr><td colspan="4">
<b>NOTICE:</b> By reading or posting messages on these boards, you are agreeing to the Message Board <a href="tos.php">Terms of Service</a>.  You should also read the <a href="help.php">Help Files</a> for quick answers to some of the most common questions.<br /><br />
<?
$a=@mysql_fetch_array(mysql_query("SELECT `topicsec` FROM `topics` WHERE `boardnum` = 6 ORDER BY `topicsec` DESC LIMIT 0, 1"));
?>
<b>NEW ANNOUNCEMENTS (<?= date("n/j",($a["topicsec"]+$time_offset)) ?>):</b> <?= stripslashes($announcement) ?> Check the <a href="gentopic.php?board=6">Message-Board announcements board</a> for the details.
</td></tr>


<?
$u=@mysql_fetch_array(mysql_query("SELECT `userid`, `username`, `level`, `featboard` FROM `users` WHERE `username`='".$uname."'"));
if (!auth2($uname,$pword)) {
echo "<tr><td align=\"center\" colspan=\"4\">You are not currently logged in. If you have not previously done so, you must first <a href=\"register.php\">Register</a> and then <a href=\"login.php\">Log In</a> to be able to post messages.</td></tr>\n\n";
} else {
echo "<tr><td align=\"center\" colspan=\"4\">You are currently logged in as <b>".$u["username"]."</b></td></tr>";
}
?>

<tr><td align="center" colspan="4">There
<?
$nt=@mysql_num_rows(mysql_query("SELECT `userid` FROM `users` WHERE `defsec` >= ".(time()-600)));
if ($nt != 1) echo " are approximately <a href=\"onlineusers.php\">".$nt."</a> registered users ";
else if ($nt == 1) echo " is approximately <a href=\"onlineusers.php\">".$nt."</a> registered user ";
else echo " are no registered users ";
?>
currently using the message boards.</td></tr>
<?
if (!auth2($uname,$pword)) {
	$lvl = 0;
	$f = 1;
} else {
	$lvl = $u["level"];
	$f = $u["featboard"];
}
?>

<tr><td align="center" colspan="4" class="dark"> <?
if (auth2($uname,$pword)) echo "<a href=\"user.php\" class=\"menu\">".$u["username"]." (".$lvl.")</a>: <a href=\"logout.php\" class=\"menu\">Log Out</a>"; else echo "<a href=\"login.php\" class=\"menu\">Log In</a>";
?> | <a href="help.php" class="menu">Help</a> <?
if ($lvl >= LEVEL_NEWMOD) echo " | <a href=\"/boardadm/index.php\" class=\"menu\">Control Panel</a>";
?> </td></tr> <?
$sn = @mysql_num_rows(mysql_query("SELECT `sysnotid` FROM `systemnot` WHERE `sendto` = ".$u["userid"]." AND `read` = 0"));
if ($sn >= 1) echo "<tr><td class=\"sys\" align=\"center\" colspan=\"4\">You have one or more unread <a href=\"usernote.php\">System Notifications</a>. Please read them at your earliest convenience.</td></tr>\n\n";
$fi = @mysql_num_rows(mysql_query("SELECT `invid` FROM `invitations` WHERE `touser` = ".$u["userid"]." AND `invread` = 0"));
if ($fi >= 1) echo "<tr><td class=\"sys\" align=\"center\" colspan=\"4\">You have one or more unread <a href=\"invpending.php?board=".$board."&topic=".$topic."\">Faction Invitations</a>. Please read them at your earliest convenience.</td></tr>\n";
$n=@mysql_num_rows(mysql_query("SELECT `topicid` FROM `topics` WHERE `boardnum` = ".$board));
?>
<tr>
<td class="dark" align="center" width="60%">Board Title</td>
<td class="dark" align="center">Topics</td>
<td class="dark" align="center">Msgs</td>
<td class="dark" align="center">Last Post</td>
</tr>

<?
$r=mysql_query("SELECT `id`,`capshow`,`name` FROM `boardcat` ORDER BY `id` ASC");
while ($bc=@mysql_fetch_array($r)) {
	$fv=0;
	if (auth2($uname,$pword)) {
		$r2=mysql_query("SELECT `boardid` FROM `boards` WHERE `type`=".$bc["id"]." AND `boardlevel` <= ".$lvl." ORDER BY `boardname` ASC");
		while ($b=@mysql_fetch_array($r2)) {
			$ss=mysql_num_rows(mysql_query("SELECT `favid` FROM `favorites` WHERE `boardid` = ".$b["boardid"]." AND `userid` = ".$u["userid"]));
			if ($ss>=1) {
				$fv=1;
			}
		}
	} else {
		$r2=mysql_query("SELECT `boardid` FROM `boards` WHERE `type`=".$bc["id"]." AND `default` = 1 ORDER BY `boardname` ASC");
		if (@mysql_num_rows($r2)>=1) $fv=1;
	}
	if ($fv>=1) { 
		echo "\n\n<tr><td class=\"lite\" colspan=\"4\">".stripslashes($bc["name"])."</td></tr>\n";
		if (auth2($uname,$pword)) $r2=mysql_query("SELECT `boardid`, `boardname`, `caption` FROM `boards` WHERE `type`=".$bc["id"]." AND `boardlevel` <= ".$lvl." ORDER BY `boardname` ASC"); else $r2=mysql_query("SELECT `boardid`, `boardname`, `caption` FROM `boards` WHERE `type`=".$bc["id"]." AND `default` = 1 ORDER BY `boardname` ASC");
		while ($b=@mysql_fetch_array($r2)) {
			if (auth2($uname,$pword)) $ss=@mysql_num_rows(mysql_query("SELECT favid FROM `favorites` WHERE `boardid` = ".$b["boardid"]." AND `userid` = ".$u["userid"])); else $ss = 1;
			if ($ss >= 1) {
				$bd=@mysql_fetch_array(mysql_query("SELECT `messsec` FROM `messages` WHERE `mesboard` = ".$b["boardid"]." ORDER BY `messsec` DESC LIMIT 0, 1"));
				echo "\t<tr>\n\t<td class=\"cell1\"><span style=\"font-size:120%;\"><b><a href=\"gentopic.php?board=".$b["boardid"]."\">".stripslashes($b["boardname"])."</a></b></span>";
				if ($bc["capshow"] == 1) echo "<br /><span style=\"font-size:80%;\">".stripslashes($b["caption"])."</span>";
				echo "</td>\n\t<td class=\"cell1\">".@mysql_num_rows(mysql_query("SELECT `topicid` FROM `topics` WHERE `boardnum` = ".$b["boardid"]))."</td>\n\t<td class=\"cell1\">".@mysql_num_rows(mysql_query("SELECT `messageid` FROM `messages` WHERE `mesboard` = ".$b["boardid"]))."</td>\n\t<td class=\"cell1\">";
				if ($bd["messsec"]) echo str_replace(" ","&nbsp;",gmdate("n/d g:iA",($bd["messsec"]+$time_offset)));
				echo "</td>\n\t</tr>\n";
			}
		}
	}
}
if ($f >= 1) {
	echo "\n\n<tr><td class=\"lite\" colspan=\"4\">Today's Featured Boards</td></tr>";
	$r=mysql_query("SELECT `id`, `boardid` FROM `featured` ORDER BY `id` ASC");
	while ($fb=@mysql_fetch_array($r)) {
		$r2=mysql_query("SELECT `boardid`, `boardname`, `caption` FROM `boards` WHERE `boardid` = ".$fb["boardid"]." ORDER BY `boardname` ASC");
		if (@mysql_num_rows($r2) >= 1) {
			$b=@mysql_fetch_array($r2);
			$bd=@mysql_fetch_array(mysql_query("SELECT `messsec` FROM `messages` WHERE `mesboard` = ".$b["boardid"]." ORDER BY `messsec` DESC LIMIT 0, 1"));
			echo "\t<tr>\n\t<td class=\"cell1\"><span style=\"font-size:120%;\"><b><a href=\"gentopic.php?board=".$b["boardid"]."\">".stripslashes($b["boardname"])."</a></b></span><br /><span style=\"font-size:80%;\">".stripslashes($b["caption"])."</span></td>\n\t<td class=\"cell1\">".@mysql_num_rows(mysql_query("SELECT `topicid` FROM `topics` WHERE `boardnum` = ".$b["boardid"]))."</td>\n\t<td class=\"cell1\">".@mysql_num_rows(mysql_query("SELECT `messageid` FROM `messages` WHERE `mesboard` = ".$b["boardid"]))."</td>\n\t<td class=\"cell1\">";
			if ($bd["messsec"]) echo str_replace(" ","&nbsp;",gmdate("n/d g:iA",($bd["messsec"]+$time_offset)));
			echo "</td>\n\t</tr>\n";
		}
	}
}

if ($lvl >= LEVEL_NEW2) echo "\n\n<tr><td class=\"lite\" colspan=\"4\">Meta-Moderation</td></tr>\n<tr><td class=\"cell1\" colspan=\"4\">Use the <a href=\"metamodwarn.php\">Meta-Moderation</a> system to give feedback to the moderators of the ".$sitetitle." message boards.</font></td></tr>";
if (auth2($uname,$pword)) echo "\n\n<tr><td class=\"lite\" colspan=\"4\">Board Manager</td></tr>\n<tr><td class=\"cell1\" colspan=\"4\">Use the <a href=\"bman.php\">Board Manager</a> to add and remove boards from this listing.</font></td></tr>";
?>


</table>
<?
include("/home/mediarch/foot.php");
?>