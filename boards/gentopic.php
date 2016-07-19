<?php
$pagetitle="General Topic List";
include("/home/mediarch/head.php");
echo $harsss."<table border=\"0\" width=\"100%\">\n";
$board = round($_GET["board"]);
$page = round($_GET["page"]);
$r=mysql_query("SELECT `boardname`,`boardlevel`,`topiclevel` FROM `boards` WHERE `boardid`=".$board);
if (@mysql_num_rows($r)<=0) {
	echo "<tr><td>An invalid Board ID has been used to access this page. Return to the <a href=\"index.php\">General Board List</a> to select a board.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$b=@mysql_fetch_array($r);
echo "<tr><td align=\"center\" colspan=\"4\"><span style=\"font-size:250%;\"><b><i>".stripslashes($b["boardname"])."</i></b></span></td></tr>\n";
$u=@mysql_fetch_array(mysql_query("SELECT `userid`, `username`, `level`, `topicpage`, `topicsort`, `faction` FROM `users` WHERE `username` = '".$uname."'"));
if (!auth2($uname,$pword)) {
	$lvl=0;
	$tp=20;
	$ts="`timesec` DESC";
} else {
	$lvl=$u["level"];
	switch ($u["topicpage"]) {
		case 0: $tp = 10; break;
		case 1: $tp = 20; break;
		case 2: $tp = 30; break;
		case 3: $tp = 40; break;
		case 4: $tp = 50;
	}
	switch ($u["topicsort"]) {
		case 0: $ts = "`topicid` ASC"; break;
		case 1: $ts = "`topicid` DESC"; break;
		case 2: $ts = "`timesec` ASC"; break;
		case 3: $ts = "`timesec` DESC";
	}
}
if ($b["boardlevel"]>$lvl) {
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
if (!$page) $page = 0;
echo "<tr><td class=\"dark\" align=\"center\" colspan=\"4\">";
if (auth2($uname,$pword)) echo "<a href=\"user.php?board=".$board."\" class=\"menu\">".$u["username"]." (".$u["level"].")</a>: \n";
echo "<a href=\"index.php\" class=\"menu\">Board List</a>";
if ((auth2($uname,$pword)) && ($b["topiclevel"]<=$lvl)) echo " | \n<a href=\"post.php?board=".$board."\" class=\"menu\">Create New Topic</a>";
if (auth2($uname,$pword)) echo " | \n<a href=\"addfav.php?board=".$board."\" class=\"menu\">Add to Favorites</a>";
if ($lvl >= LEVEL_REG) echo " | \n<a href=\"search.php?board=".$board."\" class=\"menu\">Search</a>";
if (auth2($uname,$pword)) echo " | \n<a href=\"logout.php\" class=\"menu\">Log Out</a>"; else echo " | \n<a href=\"login.php?board=".$board."\" class=\"menu\">Log In</a>";
echo " | \n<a href=\"help.php?board=".$board."\" class=\"menu\">Help</a>";
if ($lvl >= LEVEL_NEWMOD) echo " | \n<a href=\"/boardadm/index.php?board=".$board."\" class=\"menu\">Control Panel</a>";
echo "\n</td></tr>\n";
$sn = @mysql_num_rows(mysql_query("SELECT `sysnotid` FROM `systemnot` WHERE `sendto` = ".$u["userid"]." AND `read` = 0"));
if ($sn >= 1) echo "<tr><td class=\"sys\" align=\"center\" colspan=\"4\">You have one or more unread <a href=\"usernote.php?board=".$board."\">System Notifications</a>. Please read them at your earliest convenience.</td></tr>\n";
$fi = @mysql_num_rows(mysql_query("SELECT `invid` FROM `invitations` WHERE `touser` = ".$u["userid"]." AND `invread` = 0"));
if ($fi >= 1) echo "<tr><td class=\"sys\" align=\"center\" colspan=\"4\">You have one or more unread <a href=\"invpending.php?board=".$board."&topic=".$topic."\">Faction Invitations</a>. Please read them at your earliest convenience.</td></tr>\n";
$n=@mysql_num_rows(mysql_query("SELECT `topicid` FROM `topics` WHERE `boardnum` = ".$board));
if ($n > $tp) {
	echo "<tr><td class=\"lite\" align=\"center\" colspan=\"4\"><i>\n";
	if ($page > 0) echo "<a href=\"gentopic.php?board=".$board."&page=0\" class=\"menu\">First Page</a> | \n";
	if ($page > 1) echo "<a href=\"gentopic.php?board=".$board."&page=".($page-1)."\" class=\"menu\">Previous Page</a> | \n";
	echo "Page ".($page + 1)." of ".ceil($n/$tp);
	if ($page < (ceil($n/$tp)-2)) echo " | \n<a href=\"gentopic.php?board=".$board."&page=".($page+1)."\" class=\"menu\">Next Page</a>";
	if ($page < (ceil($n/$tp)-1)) echo " | \n<a href=\"gentopic.php?board=".$board."&page=".(ceil($n/$tp)-1)."\" class=\"menu\">Last Page</a>";
	echo "\n</i></td></tr>\n\n";
}
?>
<tr>
<td class="lite" align="center" width="55%"><i>Topic</i></td>
<td class="lite" align="center"><i>Created By</i></td>
<td class="lite" align="center"><i>Messages</i></td>
<td class="lite" align="center"><i>Last Post</i></td>
</tr>


<?php
$f=mysql_query("SELECT `topicid`,`timesec`,`topicby`,`topicname`,`closed` FROM `topics` WHERE `boardnum` = ".$board." ORDER BY ".$ts." LIMIT ".($page*$tp).", ".$tp);
while ($t=@mysql_fetch_array($f)) {
	$u = @mysql_fetch_array(mysql_query("SELECT `userid`, `username` FROM `users` WHERE `username` = '".$t["topicby"]."'"));
	echo "<tr>\n<td class=\"cell1\" width=\"55%\"><a href=\"genmessage.php?board=".$board."&topic=".$t["topicid"]."\">".stripslashes($t["topicname"])."</a>";
	if ($t["closed"] == 1) echo "<img border=\"0\" src=\"/images/closed.gif\" height=\13\" width=\"11\" ALT=\"**CLOSED**\">";
	echo "</td>\n<td class=\"cell1\">".$u["username"]."</td>\n<td class=\"cell1\">".@mysql_num_rows(mysql_query("SELECT `messageid` FROM `messages` WHERE `topic` = ".$t["topicid"]))."</td>\n<td class=\"cell1\">".str_replace(" ","&nbsp;",gmdate("n/j/Y H:i",($t["timesec"]+$time_offset)))."</td>\n</tr>\n\n";
}
$c = 1;
if ($n > $tp) {
	echo "<tr><td class=\"lite\" align=\"center\" colspan=\"4\"><i>Jump to Page: \n\n";
	while ($c <= ceil($n/$tp)) {
		if (($page + 1) == $c) echo $c; else echo "<a href=\"gentopic.php?board=".$board."&page=".($c - 1)."\" class=\"menu\">".$c."</a>";
		if ($c < ceil($n/$tp)) echo " | ";
		echo "\n";
		$c++;
	}
	echo "\n</i></td></tr>";
}
echo "\n</table>";
include("/home/mediarch/foot.php");
?>