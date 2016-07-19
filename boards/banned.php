<?
$pagetitle="Banned User List";
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
<tr><td colspan="3" align="center"><span style="font-size:250%;"><b>Banned Users - Last 30 Days</span></b></td></tr>
<tr><td colspan="3" align="center" class="lite"><i>
Return to: <a href="index.php" class="menu">Board List</a>
<?
if ($board) echo " | \n<a href=\"gentopic.php?board=".$board."\" class=\"menu\">Topic List</a>";
if ($topic) echo " | \n<a href=\"genmessage.php?board=".$board."&topic=".$topic."\" class=\"menu\">Message List</a>";
?> | <a href="user.php<?= querystring($board,$topic) ?>" class="menu">User Info Page</a>
</i></td></tr>
<tr><td class="dark" width="33%">Date</td><td class="dark" width="33%">User</td><td class="dark" width="33%">Reason</td></tr>
<?
$r=mysql_query("SELECT DISTINCT `moduser` FROM `modded` WHERE `action` >= 11 AND `modsec` >= ".(time()-2592000)." ORDER BY `modsec` DESC");
while ($m=@mysql_fetch_array($r)) {
	$m2 = @mysql_fetch_array(mysql_query("SELECT `reason`, `modsec` FROM `modded` WHERE `moduser` = ".$m["moduser"]." ORDER BY `modid` DESC LIMIT 0,1"));
	$r2=mysql_query("SELECT `username`, `userid` FROM `users` WHERE `userid` = ".$m["moduser"]." AND `level` = -2");
	if (@mysql_num_rows($r2) >= 1) {
		$t=@mysql_fetch_array(mysql_query("SELECT `ruletitle` FROM `tos` WHERE `tosid` = ".$m2["reason"]));
		$u=@mysql_fetch_array($r2);
		echo "<tr><td class=\"cell1\">".str_replace(" ","&nbsp;",gmdate("n/j/Y h:i:s A",($m2["modsec"]+$time_offset)))."</td><td class=\"cell1\"><a href=\"whois.php?user=".$u["userid"].querystring2($board,$topic)."\">".$u["username"]."</a></td><td class=\"cell1\">".$t["ruletitle"]."</td></tr>";
	}
}
?>
</table>
<?
include("/home/mediarch/foot.php");
?>