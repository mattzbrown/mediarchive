<?
$pagetitle="Meta-Moderation Tally";
include("/home/mediarch/head.php");
echo $harsss;
$topic = round($_GET["topic"]);
$board = round($_GET["board"]);
$page = round($_GET["page"]);
?> <table border="0" width="100%"> <?
if (!auth2($uname,$pword)) {
	echo "\n<tr><td>You must be <a href=\"login.php\">logged in</a> to view this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$u=@mysql_fetch_array(mysql_query("SELECT `userid`, `username`, `level`, `topicpage`, `topicsort` FROM `users` WHERE `username` = '".$uname."'"));
if ($u["level"] < LEVEL_NEWMOD) {
	echo "\n<tr><td>You are not authorized to view this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
?>
<tr><td colspan="9" align="center"><span style="font-size:250%;"><b>Message Board Meta-Moderation Tally</b></span></td></tr>
<tr><td colspan="9" align="center" class="lite"><i>
Return to: <a href="../boards/index.php" class="menu">Board List</a>
<?
if ($board) echo " | \n<a href=\"../boards/gentopic.php?board=".$board."\" class=\"menu\">Topic List</a>";
if ($topic) echo " | \n<a href=\"../boards/genmessage.php?board=".$board."&topic=".$topic."\" class=\"menu\">Message List</a>";
?> | <a href="index.php<?= querystring($board,$topic) ?>" class="menu">Control Panel</a>
</i></td></tr>

<tr>
<td class="dark" width="11%">Moderator</td>
<td class="dark" width="11%">Very Lenient</td>
<td class="dark" width="11%">Slightly Lenient</td>
<td class="dark" width="11%">Fair</td>
<td class="dark" width="11%">Slightly Harsh</td>
<td class="dark" width="11%">Very Harsh</td>
<td class="dark" width="11%">Total</td>
<td class="dark" width="11%">Average</td>
<td class="dark" width="11%">Fair%</td>
</tr>
<?
$r=mysql_query("SELECT `userid`,`username` FROM `users` WHERE `level` >= 50 ORDER BY `username` ASC");
while ($m = @mysql_fetch_array($r)) {
	$very_lenient = @mysql_num_rows(mysql_query("SELECT `metamodid` FROM `metamod` WHERE `modby` = ".$m["userid"]." AND `op` = -2"));
	$slightly_lenient = @mysql_num_rows(mysql_query("SELECT `metamodid` FROM `metamod` WHERE `modby` = ".$m["userid"]." AND `op` = -1"));
	$fair = @mysql_num_rows(mysql_query("SELECT `metamodid` FROM `metamod` WHERE `modby` = ".$m["userid"]." AND `op` = 0"));
	$slightly_harsh = @mysql_num_rows(mysql_query("SELECT `metamodid` FROM `metamod` WHERE `modby` = ".$m["userid"]." AND `op` = 1"));
	$very_harsh = @mysql_num_rows(mysql_query("SELECT `metamodid` FROM `metamod` WHERE `modby` = ".$m["userid"]." AND `op` = 2"));
	$total = @mysql_num_rows(mysql_query("SELECT `metamodid` FROM `metamod` WHERE `modby` = ".$m["userid"]));
	if ($total) {
		$average=round((($very_lenient*-2)+($slightly_lenient*-1)+($fair*0)+($slightly_harsh*1)+($very_harsh*2))/$total);
		$fair_percent = round(($fair/$total)*100);
		switch ($average) {
			case -2: $average_str = "Very Lenient"; break;
			case -1: $average_str = "Slightly Lenient"; break;
			case 0: $average_str = "Fair"; break;
			case 1: $average_str = "Slightly Harsh"; break;
			case 2: $average_str = "Very Harsh";
		}
	} else {
		$average=0;
		$average_str="Fair";
		$fair_percent=0;
	}
	echo "\n<tr>\n<td class=\"cell1\"><a href=\"../boards/whois.php?user=".$m["userid"].querystring2($board,$topic)."\">".$m["username"]."</a></td>\n<td class=\"cell1\">".$very_lenient."</td>\n<td class=\"cell1\">".$slightly_lenient."</td>\n<td class=\"cell1\">".$fair."</td>\n<td class=\"cell1\">".$slightly_harsh."</td>\n<td class=\"cell1\">".$very_harsh."</td>\n<td class=\"cell1\">".$total."</td>\n<td class=\"cell1\">".$average_str."</td>\n<td class=\"cell1\">".$fair_percent."%</td>\n</tr>";
}
?>
</table>
<? include("/home/mediarch/foot.php"); ?>

