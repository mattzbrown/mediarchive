<?
$pagetitle="Aura History";
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
<tr><td colspan="7" align="center"><span style="font-size:250%;"><b>Aura History</b></span></td></tr>
<tr><td colspan="7" align="center" class="lite"><i>
Return to: <a href="index.php" class="menu">Board List</a>
<?
if ($board) echo " | \n<a HREF=\"gentopic.php?board=".$board."\" class=\"menu\">Topic List</a>";
if ($topic) echo " | \n<a HREF=\"genmessage.php?board=".$board."&topic=".$topic."\" class=\"menu\">Message List</a>";
?> | <a href="user.php<?= querystring($board,$topic) ?>" class="menu">User Info Page</a>
</i></td></tr>

<tr>
<td class="dark">ID</td>
<td class="dark">Board</td>
<td class="dark">Topic</td>
<td class="dark">Date</td>
<td class="dark">Reason</td>
<td class="dark">Action</td>
</tr>

<?
$u = @mysql_fetch_array(mysql_query("SELECT `userid` FROM `users` WHERE `username` = '".$uname."'"));
$mr = mysql_query("SELECT `auraid`,`boardid`,`topic`,`aurasec`,`reason`,`action` FROM `auraed` WHERE `aurauser` = ".$u["userid"]." AND `action` > 0 ORDER BY `auraid` DESC");
while ($m = @mysql_fetch_array($mr)) {
$b = @mysql_fetch_array(mysql_query("SELECT `boardname` FROM `boards` WHERE `boardid` = ".$m["boardid"]));
$v = @mysql_fetch_array(mysql_query("SELECT `ruletitle` FROM `sos` WHERE `sosid` = ".$m["reason"]));
switch ($m["action"]) {
	case 0: $a = "No Action"; break;
	case 1: $a = "+1 Aura"; break;
	case 2: $a = "+3 Aura"; break;
	case 3: $a = "+5 Aura"; break;
	case 4: $a = "+10 Aura"; break;
	case 5: $a = "-1 Aura"; break;
	case 6: $a = "-2 Aura"; break;
	case 7: $a = "-3 Aura"; break;
	case 8: $a = "-5 Aura"; break;
	default: $a = "";
}
echo "<tr>\n<td class=\"cell1\"><a href=\"auradetl.php?auraid=".$m["auraid"].querystring2($board,$topic)."\">".$m["auraid"]."</a></td>\n<td class=\"cell1\">".stripslashes($b["boardname"])."</td>\n<td class=\"cell1\">".$m["topic"]."</td>\n<td class=\"cell1\">".str_replace(" ","&nbsp;",gmdate("n/j/Y h:i:s A",($m["aurasec"]+$time_offset)))."</td>\n<td class=\"cell1\">".$v["ruletitle"]."</td>\n<td class=\"cell1\">".$a."</td>\n</tr>\n\n";
}

echo "

</table>";
include("/home/mediarch/foot.php");
?>