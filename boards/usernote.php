<?
$pagetitle="System Notices";
include("/home/mediarch/head.php");
echo $harsss;
$topic = round($_GET["topic"]);
$board = round($_GET["board"]);
?> <table border="0" width="100%"> <?
if (!auth2($uname,$pword)) {
	echo "\n<tr><td>You must be <a href=\"login.php\">logged in</a> to view this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
?>
<tr><td align="center"><span style="font-size:250%;"><b>System Notices</b></span></td></tr>
<tr><td align="center" class="lite"><i>
Return to: <a href="index.php" class="menu">Board List</a>
<?
if ($board) echo " | \n<a href=\"gentopic.php?board=".$board."\" class=\"menu\">Topic List</a>";
if ($topic) echo " | \n<a href=\"genmessage.php?board=".$board."&topic=".$topic."\" class=\"menu\">Message List</a>";
?> | <a href="user.php<?= querystring($board,$topic) ?>" class="menu">User Info Page</a>
</i></td></tr>
<?
$u = @mysql_fetch_array(mysql_query("SELECT `userid`,`level` FROM `users` WHERE `username` = '".$uname."'"));
mysql_query("UPDATE `systemnot` SET `read` = 1 WHERE `sendto` = ".$u["userid"]);
$snr=mysql_query("SELECT `sysbod`, `sentsec`,`sentfrom` FROM `systemnot` WHERE `sendto` = ".$u["userid"]." ORDER BY `sysnotid` DESC");
while ($sn=@mysql_fetch_array($snr)) {
$ub = @mysql_fetch_array(mysql_query("SELECT `username` FROM `users` WHERE `userid` = ".$sn["sentfrom"]));
echo "\n<tr><td class=\"cell2\">";
if ($u["level"] >= LEVEL_NEWMOD) echo "<b>From:</b> <a href=\"whois.php?user=".$sn["sentfrom"].querystring2($board,$topic)."\">".$ub["username"]."</a> | ";
echo "<b>Notice Date:</b> ".str_replace(" ","&nbsp;",gmdate("n/j/Y h:i:s A",($sn["sentsec"]+$time_offset)));
if ($u["level"] >= LEVEL_NEWMOD) echo " | <a href=\"../boardadm/send.php?user=".$sn["sentfrom"].querystring2($board,$topic)."\">Reply</a>";
echo "</td></tr>\n<tr><td class=\"cell1\">".stripslashes($sn["sysbod"])."</td></tr>";
}
?>
<tr><td align="center">All read notices will be deleted after midnight tonight.</td></tr>
</table>
<?
include("/home/mediarch/foot.php");
?>