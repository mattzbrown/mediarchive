<?php
$pagetitle="Aura Detail";
include("/home/mediarch/head.php");
echo $harsss;
$topic = round($_GET["topic"]);
$board = round($_GET["board"]);
$auraid = round($_GET["auraid"]);
?> <table border="0" width="100%"> <?
if (!auth2($uname,$pword)) {
	echo "\n<tr><td>You must be <a href=\"login.php\">logged in</a> to view this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
?>
<tr><td colspan="7" align="center"><span style="font-size:250%;"><b>Aura Detail</b></span></td></tr>
<?php
$u = @mysql_fetch_array(mysql_query("SELECT `userid` FROM `users` WHERE `username` = '".$uname."'"));
$r = mysql_query("SELECT `boardid`,`topic`,`topicid`,`aurauser`,`postsec`,`aurasec`,`reason`,`action`,`aurabod` FROM `auraed` WHERE `auraid` = ".$auraid." AND `aurauser` = ".$u["userid"]." AND `action` > 0");
if (@mysql_num_rows($r) <= 0) {
echo "\n<tr><td>An invalid link was used to access this page.</td></tr>\n</table>";
include("/home/mediarch/foot.php");
exit;
}
?>
<tr><td colspan="7" align="center" class="lite"><i>
Return to: <a href="index.php" class="menu">Board List</a>
<?
if ($board) echo " | \n<a HREF=\"gentopic.php?board=".$board."\" class=\"menu\">Topic List</a>";
if ($topic) echo " | \n<a HREF=\"genmessage.php?board=".$board."&topic=".$topic."\" class=\"menu\">Message List</a>";
?> | <a href="aurahist.php<? echo querystring($board,$topic); ?>" class="menu">Aura History</a> | <a href="user.php<? echo querystring($board,$topic); ?>" class="menu">User Info Page</a>
</i></td></tr>
<?php
$a = @mysql_fetch_array($r);
$b = @mysql_fetch_array(mysql_query("SELECT `boardname` FROM `boards` WHERE `boardid` = ".$a["boardid"]));
$v = @mysql_fetch_array(mysql_query("SELECT `ruletitle` FROM `sos` WHERE `sosid` = ".$a["reason"]));
$u = @mysql_fetch_array(mysql_query("SELECT `username` FROM `users` WHERE `userid` = ".$a["aurauser"]));
switch ($a["action"]) {
	case 0: $ac = "No Action"; break;
	case 1: $ac = "+1 Aura"; break;
	case 2: $ac = "+3 Aura"; break;
	case 3: $ac = "+5 Aura"; break;
	case 4: $ac = "+10 Aura"; break;
	case 5: $ac = "-1 Aura"; break;
	case 6: $ac = "-2 Aura"; break;
	case 7: $ac = "-3 Aura"; break;
	case 8: $ac = "-5 Aura"; break;
	default: $ac = "";
}
?>
<tr><td class="cell2"><b>Board:</b> <a href="gentopic.php?board=<? echo $a["boardid"]; ?>"><? echo stripslashes($b["boardname"]); ?></a> | <b>Topic:</b> <? echo $a["topicid"]; ?> - <? echo stripslashes($a["topic"]); ?> | Aura ID: <? echo $auraid; ?></td></tr>
<tr><td class="cell2"><b>From:</b> <? echo $u["username"]; ?> | <b>Posted:</b> <? echo str_replace(" ","&nbsp;",gmdate("n/j/Y h:i:s A",($a["postsec"]+$time_offset))); ?></td></tr>
<tr><td class="cell2"><b>Moderated at:</b> <? echo str_replace(" ","&nbsp;",gmdate("n/j/Y h:i:s A",($a["aurasec"]+$time_offset))); ?> | <b>Reason:</b> <? echo $v["ruletitle"]; ?> |  <b>Action:</b> <? echo $ac; ?></td></tr>
<tr><td class="cell1"><? echo stripslashes($a["aurabod"]); ?></td></tr>

</table>
<?
include("/home/mediarch/foot.php");
?>