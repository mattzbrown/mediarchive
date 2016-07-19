<?
$pagetitle="Active Message List";
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
if ($u["level"] < LEVEL_NEW3) {
	echo "\n<tr><td>You are not authorized to view this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
?>
<tr><td colspan="4" align="center"><span style="font-size:250%;"><b>Active Message List</b></span></td></tr>
<tr><td colspan="4" align="center" class="lite"><i>
Return to: <a href="index.php" class="menu">Board List</a>
<?
if ($board) echo " | \n<a href=\"gentopic.php?board=".$board."\" class=\"menu\">Topic List</a>";
if ($topic) echo " | \n<a href=\"genmessage.php?board=".$board."&topic=".$topic."\" class=\"menu\">Message List</a>";
?> | <a href="user.php<?= querystring($board,$topic) ?>" class="menu">User Info Page</a>
</i></td></tr>
<tr>
<td class="dark">Board</td>
<td class="dark">Topic</td>
<td class="dark">Posts</td>
<td class="dark">Posted On</td>
</tr>
<?
if ($u["topicpage"] == 0) $tp = 10;
if ($u["topicpage"] == 1) $tp = 20;
if ($u["topicpage"] == 2) $tp = 30;
if ($u["topicpage"] == 3) $tp = 40;
if ($u["topicpage"] == 4) $tp = 50;
if (!$page) $page = 0;
$f=mysql_query("SELECT DISTINCT `topic` FROM `messages` WHERE `messby` = '".$u["username"]."' ORDER BY messsec DESC LIMIT ".($page*$tp).", ".$tp);
while ($m=@mysql_fetch_array($f)) {
	$t = @mysql_fetch_array(mysql_query("SELECT `boardnum`,`topicid`,`topicname` FROM `topics` WHERE `topicid` = ".$m["topic"]));
	$b = @mysql_fetch_array(mysql_query("SELECT `boardid`,`boardname` FROM `boards` WHERE `boardid` = ".$t["boardnum"]));
	$d = @mysql_fetch_array(mysql_query("SELECT `messsec` FROM `messages` WHERE `topic` = ".$t["topicid"]." AND `messby` = '".$u["username"]."' ORDER BY `messsec` DESC LIMIT 0, 1"));
	echo "<tr>\n\t<td class=\"cell1\"><a href=\"gentopic.php?board=".$b["boardid"]."\">".stripslashes($b["boardname"])."</a></td>\n\t<td class=\"cell1\"><a href=\"genmessage.php?board=".$t["boardnum"]."&topic=".$t["topicid"]."\">".stripslashes($t["topicname"])."</a></td>\n\t<td class=\"cell1\">".@mysql_num_rows(mysql_query("SELECT `messageid` FROM `messages` WHERE `messby` = '".$u["username"]."' AND topic = ".$t["topicid"]))."</td>\n\t<td class=\"cell1\">".str_replace(" ","&nbsp;",gmdate("n/j/Y h:i:s A",($d["messsec"]+$time_offset)))."</td>\n</tr>";
}
$n=@mysql_num_rows(mysql_query("SELECT DISTINCT `topic` FROM `messages` WHERE `messby` = '".$u["username"]."'"));
if ($n > $tp) {
	echo "<tr><td class=\"lite\" align=\"center\" colspan=\"4\"><i>\n";
	if ($page > 0) echo "<a href=\"myposts.php?page=0".querystring2($board,$topic)."\" class=\"menu\">First Page</a> | \n";
	if ($page > 1) echo "<a href=\"myposts.php?page=".($page-1).querystring2($board,$topic)."\" class=\"menu\">Previous Page</a> | \n";
	echo "Page ".($page + 1)." of ".ceil($n/$tp);
	if ($page < (ceil($n/$tp)-2)) echo " | \n<a href=\"myposts.php?page=".($page+1).querystring2($board,$topic)."\" class=\"menu\">Next Page</a>";
	if ($page < (ceil($n/$tp)-1)) echo " | \n<a href=\"myposts.php?page=".(ceil($n/$tp)-1).querystring2($board,$topic)."\" class=\"menu\">Last Page</a>";
	echo "\n</i></td></tr>\n\n";
}
?></table><?
include("/home/mediarch/foot.php");
?>


