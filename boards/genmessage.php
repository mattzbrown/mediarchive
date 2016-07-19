<?
$pagetitle="General Message List";
include("/home/mediarch/head.php");
echo $harsss."<table border=\"0\" width=\"100%\">\n";
$topic = round($_GET["topic"]);
$board = round($_GET["board"]);
$page = round($_GET["page"]);
$r=mysql_query("SELECT `boardname`,`boardlevel`,`messlevel` FROM `boards` WHERE `boardid`=".$board);
if (@mysql_num_rows($r)<=0) {
	echo "<tr><td>An invalid Board ID has been used to access this page. Return to the <a href=\"index.php\">General Board List</a> to select a board.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$b=@mysql_fetch_array($r);
echo "<tr><td align=\"center\"><span style=\"font-size:250%;\"><b><i>".stripslashes($b["boardname"])."</i></b></span></td></tr>\n";
$r2=mysql_query("SELECT `topicname`, `closed` FROM `topics` WHERE `topicid`=".$topic);
$r3=mysql_query("SELECT `delid` FROM `deleted` WHERE `topic`=".$topic);
if ((@mysql_num_rows($r2)<=0) && (@mysql_num_rows($r3)<=0)) {
	echo "<tr><td>An invalid Topic ID has been used to access this page. Return to the <a href=\"gentopic.php?board=".$board."\">General Topic List</a> to select a topic.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$r4=mysql_query("SELECT `topicid` FROM `topics` WHERE `topicid`=".$topic." AND `boardnum`<>".$board);
if ((@mysql_num_rows($r3)>=1) || (@mysql_num_rows($r4)>=1)) {
	echo "<tr><td>This Topic has either been deleted or moved to another message board. Return to the <a href=\"gentopic.php?board=".$board."\">General Topic List</a> to select a topic.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$t=@mysql_fetch_array($r2);
$u=@mysql_fetch_array(mysql_query("SELECT `userid`, `username`, `level`, `messagepage`, `messagesort`,`faction` FROM `users` WHERE `username` = '".$uname."'"));
if (!auth2($uname,$pword)) {
	$lvl=0;
	$mp=10;
	$ms="ASC";
} else {
	$lvl=$u["level"];
	switch ($u["messagepage"]) {
		case 0: $mp = 10; break;
		case 1: $mp = 20; break;
		case 2: $mp = 30; break;
		case 3: $mp = 40; break;
		case 4: $mp = 50; break;
		case 5: $mp = 100;
	}
	switch ($u["messagesort"]) {
		case 0: $ms = "ASC"; break;
		case 1: $ms = "DESC";
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
echo "<tr><td align=\"center\"><span style=\"font-size:120%;\"><b>".stripslashes($t["topicname"])."</b></span></td></tr>\n<tr><td class=\"dark\" align=\"center\">";
if (auth2($uname,$pword)) echo "<a href=\"user.php?board=".$board."&topic=".$topic."\" class=\"menu\">".$u["username"]." (".$u["level"].")</a>: \n";
echo "<a href=\"index.php\" class=\"menu\">Board List</a> | \n<a href=\"gentopic.php?board=".$board."\" class=\"menu\">Topic List</a>";
if ((auth2($uname,$pword)) && ($b["messlevel"]<=$lvl) && ($t["closed"]<=0)) echo " | \n<a href=\"post.php?board=".$board."&topic=".$topic."\" class=\"menu\">Post New Message</a>";
if (auth2($uname,$pword)) echo " | \n<a href=\"logout.php\" class=\"menu\">Log Out</a>"; else echo " | \n<a href=\"login.php?board=".$board."&topic=".$topic."\" class=\"menu\">Log In</a>";
echo " | \n<a href=\"help.php?board=".$board."&topic=".$topic."\" class=\"menu\">Help</a>";
if ($lvl >= LEVEL_NEWMOD) echo " | \n<a href=\"/boardadm/index.php?board=".$board."&topic=".$topic."\" class=\"menu\">Control Panel</a>";
echo "\n</td></tr>\n";
$sn = @mysql_num_rows(mysql_query("SELECT `sysnotid` FROM `systemnot` WHERE `sendto` = ".$u["userid"]." AND `read` = 0"));
if ($sn >= 1) echo "<tr><td class=\"sys\" align=\"center\">You have one or more unread <a href=\"usernote.php?board=".$board."&topic=".$topic."\">System Notifications</a>. Please read them at your earliest convenience.</td></tr>\n";
$fi = @mysql_num_rows(mysql_query("SELECT `invid` FROM `invitations` WHERE `touser` = ".$u["userid"]." AND `invread` = 0"));
if ($fi >= 1) echo "<tr><td class=\"sys\" align=\"center\">You have one or more unread <a href=\"invpending.php?board=".$board."&topic=".$topic."\">Faction Invitations</a>. Please read them at your earliest convenience.</td></tr>\n";
if ($t["closed"]>=1) echo "<tr><td class=\"cell1\">This Topic has been marked <b>closed</b>.  No additional messages may be posted.</td></tr>\n";
$n=@mysql_num_rows(mysql_query("SELECT `messageid` FROM `messages` WHERE `topic` = ".$topic));
if ($n > $mp) {
	echo "<tr><td class=\"lite\" align=\"center\"><i>\n";
	if ($page > 0) echo "<a href=\"genmessage.php?board=".$board."&topic=".$topic."&page=0\" class=\"menu\">First Page</a> | \n";
	if ($page > 1) echo "<a href=\"genmessage.php?board=".$board."&topic=".$topic."&page=".($page-1)."\" class=\"menu\">Previous Page</a> | \n";
	echo "Page ".($page + 1)." of ".ceil($n/$mp);
	if ($page < (ceil($n/$mp)-2)) echo " | \n<a href=\"genmessage.php?board=".$board."&topic=".$topic."&page=".($page+1)."\" class=\"menu\">Next Page</a>";
	if ($page < (ceil($n/$mp)-1)) echo " | \n<a href=\"genmessage.php?board=".$board."&topic=".$topic."&page=".(ceil($n/$mp)-1)."\" class=\"menu\">Last Page</a>";
	echo "\n</i></td></tr>\n\n";
}
$c = ($page*$mp);
$f=mysql_query("SELECT `messageid`,`messsec`,`messby`,`messbody` FROM `messages` WHERE `topic` = ".$topic." ORDER BY `messageid` ".$ms." LIMIT ".($page*$mp).", ".$mp);
while ($m=@mysql_fetch_array($f)) {
	$c++;
	$u = @mysql_fetch_array(mysql_query("SELECT `userid`, `username` FROM `users` WHERE `username` = '".$m["messby"]."'"));
	echo "<tr><td class=\"cell2\"><b>From</b>: <a href=\"whois.php?user=".$u["userid"]."&board=".$board."&topic=".$topic."\">".$u["username"]."</a> | <b>Posted:</b> ".str_replace(" ","&nbsp;",gmdate("n/j/Y h:i:s A",($m["messsec"]+$time_offset)))." | <a href=\"detail.php?board=".$board."&topic=".$topic."&message=".$m["messageid"]."\">Message Detail</a>";
	if ($lvl >= 53) {
		$mk = @mysql_num_rows(mysql_query("SELECT `secmarkid` FROM `secmarked` WHERE `message` = ".$m["messageid"]));
		$sg = @mysql_num_rows(mysql_query("SELECT `secsuggestid` FROM `secsuggested` WHERE `message` = ".$m["messageid"]));
		echo " | <a href=\"modmes.php?message=".$m["messageid"]."&board=".$board."&topic=".$topic."\">Moderate Message (".$mk."-".$sg.")</a>";
	}
	echo " | # ";
	if ($c < 1000) echo "0";
	if ($c < 100) echo "0";
	if ($c < 10) echo "0";
	echo $c;
	$a = mysql_query("SELECT `action` FROM `auraed` WHERE `messageid` = ".$m["messageid"]." AND `action` > 0 ORDER BY `auraid` DESC");
	if (@mysql_num_rows($a) >= 1) {
		$a = @mysql_fetch_array($a);
		if ($a["action"] <= 4) echo " | <img src=\"../images/plus.gif\" height=\"14\" width=\"14\" align=\"absbottom\" alt=\"+\" />";
		else echo " | <img src=\"../images/minus.gif\" height=\"14\" width=\"14\" align=\"absbottom\" alt=\"-\" />";
	}
	echo "</td></tr>\n<tr><td class=\"cell1\">".stripslashes($m["messbody"])."</td></tr>\n\n";
}
$c = 1;
if ($n > $mp) {
	echo "<tr><td class=\"lite\" align=\"center\"><i>Jump to Page: \n\n";
	while ($c <= ceil($n/$mp)) {
		if (($page + 1) == $c) echo $c; else echo "<a href=\"genmessage.php?board=".$board."&topic=".$topic."&page=".($c - 1)."\" class=\"menu\">".$c."</a>";
		if ($c < ceil($n/$mp)) echo " | ";
		echo "\n";
		$c++;
	}
	echo "\n</i></td></tr>";
}
echo "\n</table>";
include("/home/mediarch/foot.php");
?>