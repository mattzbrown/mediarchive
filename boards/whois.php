<?
$pagetitle="Whois";
include("/home/mediarch/head.php");
echo $harsss;
$topic = round($_GET["topic"]);
$board = round($_GET["board"]);
$user = round($_GET["user"]);
?> <table border="0" width="100%"> <?
if (!auth2($uname,$pword)) {
	echo "\n<tr><td>Only <a href=\"login.php\">logged in</a> users can view another user's whois page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$b = @mysql_fetch_array(mysql_query("SELECT `level` FROM `users` WHERE `username` = '".$uname."'"));
$r = mysql_query("SELECT `username`,`userid`,`faction`,`level`,`regsec`,`lastsec`,`sig`,`quote`,`agent`,`email2`,`email`,`regemail`,`lastacip`,`regip`,`im`,`imtype`,`cookies`,`aura`,`contribid`,`modcat` FROM `users` WHERE `userid` = ".$user);
if (@mysql_num_rows($r) <= 0) {
	echo "\n<tr><td>An invalid link was used to access this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$u = @mysql_fetch_array($r);
$l = @mysql_fetch_array(mysql_query("SELECT `level`, `leveltitle`, `leveldesc` FROM `levels` WHERE `level` = ".$u["level"]));
$f = @mysql_fetch_array(mysql_query("SELECT `factionid`,`name` FROM `factions` WHERE `factionid` = ".$u["faction"]));
if (($u["level"] == LEVEL_NEWMOD) || ($u["level"] == LEVEL_SPECMOD)) $t = @mysql_fetch_array(mysql_query("SELECT `name` FROM `boardcat` WHERE `id` = ".$u["modcat"]));
$cr = mysql_query("SELECT `id`,`contribname` FROM `contributor` WHERE `id` = ".$u["contribid"]);
$ce = @mysql_num_rows($cr);
$c = @mysql_fetch_array($cr);
$cn = @mysql_num_rows(mysql_query("SELECT `reviewid` FROM `contributed` WHERE `reviewer` = '".$c["contribname"]."' AND accepted >= 1"));
$e = 0;
$d = 0;
function shadebar1() {
	global $e;
	$e++;
	$str = "";
	if (($e % 2) == 1) $str = " class=\"shade\""; 
	return $str;
}
function shadebar2() {
	global $d;
	$d++;
	$str = "";
	if (($d % 2) == 1) $str = " class=\"shade\""; 
	return $str;
}
?>
<tr><td colspan="3" align="center"><span style="font-size:250%;"><b>User Information</b></span></td></tr>
<tr><td colspan="3" align="center" class="lite"><i>
Return to: <a href="index.php" class="menu">Board List</a>
<?
if ($board) echo " | \n<a href=\"gentopic.php?board=".$board."\" class=\"menu\">Topic List</a>";
if ($topic) echo " | \n<a href=\"genmessage.php?board=".$board."&topic=".$topic."\" class=\"menu\">Message List</a>";
?>
</i></td></tr>
<tr><td colspan="2" class="dark" align="center">Current Information for <? echo $u["username"]; ?></td></tr>

<tr><td<? echo shadebar1(); ?> width="30%"><b>User Name</b></td><td<? echo shadebar2(); ?> WIDTH=70%><? echo $u["username"]; ?></td></tr>
<tr><td<? echo shadebar1(); ?>><b>User ID</b></td><td<? echo shadebar2(); ?>><? echo $u["userid"]; ?></td></tr>
<tr><td<? echo shadebar1(); ?>><b>Board User Level</b></td><td<? echo shadebar2(); ?>><b><? echo $l["level"]; ?>: <? echo $l["leveltitle"]; ?></b><br /><? echo $l["leveldesc"]; ?></td></tr>
<tr><td<? echo shadebar1(); ?>><b>Faction</b></td><td<? echo shadebar2(); ?>><? if ($f["name"]) echo "<a href=\"faction.php?faction=".$f["factionid"].querystring2($board,$topic)."\">".stripslashes($f["name"])."</a>"; ?></td></tr>
<tr><td<? echo shadebar1(); ?>><b>Account Created</b></td><td<? echo shadebar2(); ?>><? echo str_replace(" ","&nbsp;",gmdate("n/j/Y h:i:s A",($u["regsec"]+$time_offset))); ?></td></tr>
<tr><td<? echo shadebar1(); ?>><b>Last Login</b></td><td<? echo shadebar2(); ?>><? echo str_replace(" ","&nbsp;",gmdate("n/j/Y h:i:s A",($u["lastsec"]+$time_offset))); ?></td></tr>
<? if ($b["level"] >= LEVEL_ADMIN) { ?>
<tr><td<? echo shadebar1(); ?>><b>Registered IP</b></td><td<? echo shadebar2(); ?>><a href="http://ws.arin.net/cgi-bin/whois.pl?queryinput=<? echo $u["regip"]; ?>"><? echo $u["regip"]; ?></a></td></tr>
<tr><td<? echo shadebar1(); ?>><b>Last IP</b></td><td<? echo shadebar2(); ?>><a href="http://ws.arin.net/cgi-bin/whois.pl?queryinput=<? echo $u["lastacip"]; ?>"><? echo $u["lastacip"]; ?></a></td></tr>
<tr><td<? echo shadebar1(); ?>><b>User Agent</b></td><td<? echo shadebar2(); ?>><? echo $u["agent"]; ?></td></tr>
<? } ?>
<tr><td<? echo shadebar1(); ?>><b>Signature</b></td><td<? echo shadebar2(); ?>><? echo $u["sig"]; ?></td></tr>
<tr><td<? echo shadebar1(); ?>><b>Quote</b></td><td<? echo shadebar2(); ?>><? echo $u["quote"]; ?><br /></td></tr>
<tr><td<? echo shadebar1(); ?>><b>Public E-Mail Address</b></td><td<? echo shadebar2(); ?>><? echo $u["email2"]; ?></td></tr>
<? if ($b["level"] >= LEVEL_ADMIN) { ?>
<tr><td<? echo shadebar1(); ?>><b>Private E-Mail Address</b></td><td<? echo shadebar2(); ?>><? echo $u["email"]; ?></td></tr>
<tr><td<? echo shadebar1(); ?>><b>Registered E-Mail Address</b></td><td<? echo shadebar2(); ?>><? echo $u["regemail"]; ?></td></tr>
<? } ?>
<tr><td<? echo shadebar1(); ?>><b>Instant Messaging</b></td><td<? echo shadebar2(); ?>><? switch ($u["imtype"]) { case 1: echo "AIM: "; break; case 2: echo "ICQ: "; break; case 3: echo "MSN: "; break; case 4: echo "YIM: "; }?><? echo $u["im"]; ?></td></tr>
<? if (($u["level"] == LEVEL_NEWMOD) || ($u["level"] == LEVEL_SPECMOD)) { ?><tr><td<? echo shadebar1(); ?>><b>Moderator Category</b></td><td<? echo shadebar2(); ?>><? echo $t["name"]; ?></td></tr><? } ?>
<? if ($b["level"] >= LEVEL_NEWMOD) { ?>
<tr><td<? echo shadebar1(); ?>><b>Active Messages Posted</b></td><td<? echo shadebar2(); ?>><? echo @mysql_num_rows(mysql_query("SELECT `messageid` FROM `messages` WHERE `messby` = '".$u["username"]."'")); ?></td></tr>
<tr><td<? echo shadebar1(); ?>><b>Moderated Messages</b></td><td<? echo shadebar2(); ?>><? echo @mysql_num_rows(mysql_query("SELECT `modid` FROM `modded` WHERE `moduser` = '".$u["userid"]."' AND `action` > 0")); ?></td></tr>
<? } ?>
<tr><td<? echo shadebar1(); ?>><b>Karma</b></td><td<? echo shadebar2(); ?>><? echo $u["cookies"]; ?></td></tr>
<tr><td<? echo shadebar1(); ?>><b>Aura</b></td><td<? echo shadebar2(); ?>><? echo $u["aura"]; ?>&Aring;</td></tr>
<? if (($ce >=1) && ($cn >= 1)) { ?>
<tr><td<? echo shadebar1(); ?>><b>Contributor Page</b></td><td<? echo shadebar2(); ?>><a href="/contribute/recognition.php?id=<? echo $c["id"]; ?>">Click Here</a></td></tr>
<tr><td<? echo shadebar1(); ?>><b>Contribution Points</b></td><td<? echo shadebar2(); ?>><? echo $cn; ?></td></tr>
<? } ?>
<? if ($b["level"] >= LEVEL_NEWMOD) { ?>
<tr><td colspan="2" class="dark" align="center">Other Information and Options</td></tr>
<tr><td align="center" colspan="2">
<? if ($b["level"] >= LEVEL_ADMIN) echo "<a href=\"/boardadm/special.php?user=".$user.querystring2($board,$topic)."\">Edit User Level</a><br />"; ?>
<a href="/boardadm/usernote.php?user=<? echo $user.querystring2($board,$topic); ?>">View System Notifications</a><br />
<a href="/boardadm/modhist.php?user=<? echo $user.querystring2($board,$topic); ?>">View Moderated Messages</a><br />
<a href="/boardadm/posthist.php?user=<? echo $user.querystring2($board,$topic); ?>">View Posted Messages</a><br />
<? if (($b["level"] >= LEVEL_ADMIN) && ($u["level"] >= LEVEL_NEWMOD)) echo "<a href=\"/boardadm/mods.php?user=".$user.querystring2($board,$topic)."\">View Moderations By This Moderator</a><br />"; ?>
<a href="/boardadm/generate.php?user=<? echo $user.querystring2($board,$topic); ?>">Generate Message From Profile</a><br />
<a href="/boardadm/send.php?user=<? echo $user.querystring2($board,$topic); ?>">Send This User a System Notification</a><br />
<a href="/boardadm/usermap.php?user=<? echo $user.querystring2($board,$topic); ?>">View Usermap</a><br />
</td></tr><? } ?>
</table>
<?
include("/home/mediarch/foot.php");
?>