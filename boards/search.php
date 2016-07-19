<?
$pagetitle="Topic Search";
include("/home/mediarch/head.php");
echo $harsss;
$board = round($_GET["board"]);
$page = round($_GET["page"]);
$boardid = round($_POST["boardid"]);
if (!$boardid) $boardid = $board;
if (!$page) $page = 0;
$string = trim(htmlentities($_REQUEST["string"]));
?> <table border="0" width="100%"> <?
if (!auth2($uname,$pword)) {
	echo "\n<tr><td>You must be <a href=\"login.php\">logged in</a> to view this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$u=@mysql_fetch_array(mysql_query("SELECT `userid`, `username`, `level`, `topicpage` FROM `users` WHERE `username` = '".$uname."'"));
if ($u["level"] < LEVEL_REG) {
	echo "\n<tr><td>You are not authorized to view this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
switch ($u["topicpage"]) {
	case 0: $tp = 10; break;
	case 1: $tp = 20; break;
	case 2: $tp = 30; break;
	case 3: $tp = 40; break;
	case 4: $tp = 50;
}
?>
<tr><td colspan="4" align="center"><span style="font-size:250%;"><b>Topic Search</b></span></td></tr>
<tr><td colspan="4" align="center" class="lite"><i>
Return to: <a href="index.php" class="menu">Board List</a>
<?
if ($board) echo " | \n<a HREF=\"gentopic.php?board=".$board."\" class=\"menu\">Topic List</a>";
?> | <a href="user.php<?= querystring($board,0) ?>" class="menu">User Info Page</a>
</i></td></tr>
<?
if ($string) {
	$br = mysql_query("SELECT `boardname`,`boardlevel` FROM `boards` WHERE `boardid` = ".$boardid);
	$b = @mysql_fetch_array($br);
	if (@mysql_num_rows($br) <= 0) echo "<tr><td class=\"sys\" colspan=\"4\">An invalid Board ID has been used to search.</td></tr>";
	else if ($b["boardlevel"] > $u["level"]) echo "<tr><td class=\"sys\" colspan=\"4\">You cannot search topics on this board.</td></tr>";
	else if (strlen(trim($_REQUEST["string"]))>60) echo "<tr><td class=\"sys\" colspan=\"4\">Search strings must be shorter than 60 characters.</td></tr>";
	else if (strlen(trim($_REQUEST["string"]))<3) echo "<tr><td class=\"sys\" colspan=\"4\">Search strings must be longer than 3 characters.</td></tr>";
	else {
		$n=@mysql_num_rows(mysql_query("SELECT `topicid` FROM `topics` WHERE `boardnum` = ".$boardid." AND `topicname` LIKE '%".$string."%'"));
		$tr=mysql_query("SELECT `topicid`,`timesec`,`topicby`,`topicname`,`closed` FROM topics WHERE `boardnum` = ".$boardid." AND `topicname` LIKE '%".$string."%' ORDER BY `timesec` DESC LIMIT ".($page*$tp).", ".$tp);
		if ($n <= 0) echo "<tr><td class=\"sys\" colspan=\"4\">No topics matching your search string were found.</td></tr>"; else {
			echo "<tr><td class=\"dark\" colspan=\"4\">Search Results ".(($page*$tp)+1)." - ".(($page*$tp)+@mysql_num_rows($tr))." of ".$n." on ".stripslashes($b["boardname"])." for &quot;".$string."&quot;</td></tr>";
			echo "<tr>\n<td class=\"lite\" align=\"center\" width=\"55%\"><i>Topic</i></td>\n<td class=\"lite\" align=\"center\"><i>Created By</i></td>\n<td class=\"lite\" align=\"center\"><i>Messages</i></td>\n<td class=\"lite\" align=\"center\"><i>Last Post</i></td>\n</tr>";
			while ($t=mysql_fetch_array($tr)) {
				$ub = @mysql_fetch_array(mysql_query("SELECT `userid`, `username` FROM `users` WHERE `username` = '".$t["topicby"]."'"));
				echo "<tr>\n<td class=\"cell1\" width=\"55%\"><a href=\"genmessage.php?board=".$boardid."&topic=".$t["topicid"]."\">".stripslashes($t["topicname"])."</a>";
				if ($t["closed"] == 1) echo "<img border=\"0\" src=\"/images/closed.gif\" height=\13\" width=\"11\" ALT=\"**CLOSED**\">";
				echo "</td>\n<td class=\"cell1\">".$ub["username"]."</td>\n<td class=\"cell1\">".@mysql_num_rows(mysql_query("SELECT `messageid` FROM `messages` WHERE `topic` = ".$t["topicid"]))."</td>\n<td class=\"cell1\">".str_replace(" ","&nbsp;",gmdate("n/j/Y H:i",($t["timesec"]+$time_offset)))."</td>\n</tr>\n\n";
			}
			if ($n > $tp) {
				echo "<tr><td class=\"lite\" align=\"center\" colspan=\"4\"><i>\n";
				if ($page > 0) echo "<a href=\"search.php?board=".$boardid."&string=".urlencode($_REQUEST["string"])."&page=0\" class=\"menu\">First Page</a> | \n";
				if ($page > 1) echo "<a href=\"search.php?board=".$boardid."&string=".urlencode($_REQUEST["string"])."&page=".($page-1)."\" class=\"menu\">Previous Page</a> | \n";
				echo "Page ".($page + 1)." of ".ceil($n/$tp);
				if ($page < (ceil($n/$tp)-2)) echo " | \n<a href=\"search.php?board=".$boardid."&string=".urlencode($_REQUEST["string"])."&page=".($page+1)."\" class=\"menu\">Next Page</a>";
				if ($page < (ceil($n/$tp)-1)) echo " | \n<a href=\"search.php?board=".$boardid."&string=".urlencode($_REQUEST["string"])."&page=".(ceil($n/$tp)-1)."\" class=\"menu\">Last Page</a>";
				echo "\n</i></td></tr>\n\n";
			}
		}
	}
}
?>

<form action="<? echo $PHP_SELF.querystring($board,0); ?>" method="post">
<tr><td colspan="4">Board to search:<select name="boardid">
<?
$r = mysql_query("SELECT `boardname` FROM `boards` WHERE `boardid` = ".$boardid);
$b = @mysql_fetch_array($r);
if (@mysql_num_rows($r) >= 1) echo "\n<option value=".$board.">".stripslashes($b["boardname"])."</option>";
else echo "\n<option value=\"0\">Select a Board...</option>";
$r=mysql_query("SELECT `boardid`,`boardname` FROM `boards` WHERE `boardlevel` <= ".$u["level"]." ORDER BY `boardname` ASC");
while ($b=@mysql_fetch_array($r)) {
$fav = @mysql_num_rows(mysql_query("SELECT `favid` FROM `favorites` WHERE `userid` = ".$u["userid"]." AND `boardid` = ".$b["boardid"]));
if ($fav >= 1) {
	echo "\n<option value=\"".$b["boardid"]."\"";
	if ($b["boardid"] == $boardid) echo " selected=\"selected\"";
	echo ">".stripslashes($b["boardname"])."</option>";

}
}
?>
</select><br />
Topic Title Search String: <input type="text" size="60" maxlength="60" name="string" value="<? echo stripslashes(htmlentities($_REQUEST["string"])); ?>" />
<input type="submit" name="post" value="Search" />
</td></tr>
</form>
</table>
<?
include("/home/mediarch/foot.php");
?>




