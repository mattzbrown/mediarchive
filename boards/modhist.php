<?
$pagetitle="Moderated Message List";
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
<tr><td colspan="7" align="center"><span style="font-size:250%;"><b>Moderated Message History</b></span></td></tr>
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
<td class="dark">Status</td>
</tr>

<?
$u = @mysql_fetch_array(mysql_query("SELECT `userid` FROM `users` WHERE `username` = '".$uname."'"));
$mr = mysql_query("SELECT `modid`,`boardid`,`topic`,`modsec`,`reason`,`action`,`contest`,`recont`,`contbody` FROM `modded` WHERE `moduser` = ".$u["userid"]." AND `action` > 0 ORDER BY `modid` DESC");
while ($m = @mysql_fetch_array($mr)) {
$b = @mysql_fetch_array(mysql_query("SELECT `boardname` FROM `boards` WHERE `boardid` = ".$m["boardid"]));
$v = @mysql_fetch_array(mysql_query("SELECT `ruletitle` FROM `tos` WHERE `tosid` = ".$m["reason"]));
switch ($m["action"]) {
	case 0: $a = "No Action"; break;
	case 1: $a = "Topic Closed"; break;
	case 2: $a = "Topic Moved"; break;
	case 3: $a = "Message Deleted"; break;
	case 4: $a = "Topic Deleted"; break;
	case 5: $a = "Notified (Msg)"; break;
	case 6: $a = "Notified (Top)"; break;
	case 7: $a = "Warned (Msg)"; break;
	case 8: $a = "Warned (Top)"; break;
	case 9: $a = "Suspended (Msg)"; break;
	case 10: $a = "Suspended (Top)"; break;
	case 11: $a = "Banned (Msg)"; break;
	case 12: $a = "Banned (Top)"; break;
	default: $a = "";
}
switch ($m["contest"]) {
	case 0: if ($m["contbody"]) $s = "Accepted"; else $s = "N/A"; break;
	case 1: switch ($m["recont"]) {
		case 0: $s = "Contested - TOS"; break;
		case 1: $s = "Overturned"; break;
		case 2: $s = "Relaxed"; break;
		case 3: $s = "Upheld"; break;
		case 4: $s = "Appealed"; break;
		case 5: $s = "Overturned by Admin"; break;
		case 6: $s = "Relaxed by Admin"; break;
		case 7: $s = "Upheld by Admin"; break;
		case 8: $s = "Contest Abuse"; break;
		case 9: $s = "Forwarded to Admin"; break;
		default: $s = "N/A";
	} break;
	default: $s = "N/A";
}
echo "<tr>\n<td class=\"cell1\"><a href=\"moddetl.php?modid=".$m["modid"].querystring2($board,$topic)."\">".$m["modid"]."</a></td>\n<td class=\"cell1\">".stripslashes($b["boardname"])."</td>\n<td class=\"cell1\">".$m["topic"]."</td>\n<td class=\"cell1\">".str_replace(" ","&nbsp;",gmdate("n/j/Y h:i:s A",($m["modsec"]+$time_offset)))."</td>\n<td class=\"cell1\">".$v["ruletitle"]."</td>\n<td class=\"cell1\">".$a."</td>\n<td class=\"cell1\">".$s."</td>\n</tr>\n\n";
}

echo "

</table>";
include("/home/mediarch/foot.php");
?>