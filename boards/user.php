<?
$pagetitle="User Information Page";
include("/home/mediarch/head.php");
echo $harsss;
$topic = round($_GET["topic"]);
$board = round($_GET["board"]);
?> <table border="0" cellspacing="0" width="100%"> <?
if (!auth2($uname,$pword)) {
	echo "\n<tr><td>You must be <a href=\"login.php\">logged in</a> to view this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
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
<?
$u = @mysql_fetch_array(mysql_query("SELECT `username`,`userid`,`faction`,`tempfaction`,`level`,`regsec`,`lastsec`,`email`,`email2`,`im`,`imtype`,`sig`,`quote`,`contribid`,`cookies`,`aura` FROM `users` WHERE `username` = '".$uname."'"));
$l = @mysql_fetch_array(mysql_query("SELECT `level`, `leveltitle`, `leveldesc` FROM `levels` WHERE `level` = ".$u["level"]));

if ($u["faction"] > 0) $f = @mysql_fetch_array(mysql_query("SELECT `name` FROM `factions` WHERE `factionid` = ".$u["faction"]));
else if ($u["tempfaction"] > 0) $f = @mysql_fetch_array(mysql_query("SELECT `name` FROM `tempfactions` WHERE `tfid` = ".$u["tempfaction"]));
$cr = mysql_query("SELECT `id`,`contribname` FROM `contributor` WHERE `id` = ".$u["contribid"]);
$ce = @mysql_num_rows($cr);
$c = @mysql_fetch_array($cr);
$cn = @mysql_num_rows(mysql_query("SELECT `reviewid` FROM `contributed` WHERE `reviewer` = '".$c["contribname"]."' AND accepted >= 1"));
?>
<tr><td colspan="2" class="dark" align="center">Current Information for <? echo $u["username"]; ?></td></tr>

<tr><td<? echo shadebar1(); ?> width="30%"><b>User Name</b></td><td<? echo shadebar2(); ?> width="70%"><? echo $u["username"]; ?></td></tr>
<tr><td<? echo shadebar1(); ?>><b>User ID</b></td><td<? echo shadebar2(); ?>><? echo $u["userid"]; ?></td></tr>
<tr><td<? echo shadebar1(); ?>><b>User Level</b></td><td<? echo shadebar2(); ?>><b><? echo $l["level"]; ?>: <? echo $l["leveltitle"]; ?></b><br /><? echo $l["leveldesc"]; ?></td></tr>
<tr><td<? echo shadebar1(); ?>><b>Faction</b></td><td<? echo shadebar2(); ?>><? echo stripslashes($f["name"]); if ($u["tempfaction"] > 0) echo " (Inactive)"; ?></td></tr>
<tr><td<? echo shadebar1(); ?>><b>Account Created</b></td><td<? echo shadebar2(); ?>><? echo str_replace(" ","&nbsp;",gmdate("n/j/Y h:i:s A",($u["regsec"]+$time_offset))); ?></td></tr>
<tr><td<? echo shadebar1(); ?>><b>Last Login</b></td><td<? echo shadebar2(); ?>><? echo str_replace(" ","&nbsp;",gmdate("n/j/Y h:i:s A",($u["lastsec"]+$time_offset))); ?></td></tr>
<tr><td<? echo shadebar1(); ?>><b>Private E-Mail Address</b></td><td<? echo shadebar2(); ?>><? echo $u["email"]; ?></td></tr>
<tr><td<? echo shadebar1(); ?>><b>Public E-Mail Address</b></td><td<? echo shadebar2(); ?>><? echo $u["email2"]; ?></td></tr>
<tr><td<? echo shadebar1(); ?>><b>IM</b></td><td<? echo shadebar2(); ?>><? switch ($u["imtype"]) { case 1: echo "AIM: "; break; case 2: echo "ICQ: "; break; case 3: echo "MSN: "; break; case 4: echo "YIM: "; }?><? echo $u["im"]; ?></td></tr>
<tr><td<? echo shadebar1(); ?>><b>Signature</b></td><td<? echo shadebar2(); ?>><? echo $u["sig"]; ?></td></tr>
<tr><td<? echo shadebar1(); ?>><b>Quote</b></td><td<? echo shadebar2(); ?>><? echo $u["quote"]; ?></td></tr>
<tr><td<? echo shadebar1(); ?>><b>Active Messages Posted</b></td><td<? echo shadebar2(); ?>><? echo @mysql_num_rows(mysql_query("SELECT `messageid` FROM `messages` WHERE `messby` = '".$u["username"]."'")); ?></td></tr>
<tr><td<? echo shadebar1(); ?>><b>Moderated Messages</b></td><td<? echo shadebar2(); ?>><? echo @mysql_num_rows(mysql_query("SELECT `modid` FROM `modded` WHERE `moduser` = '".$u["userid"]."' AND `action` > 0")); ?></td></tr>
<tr><td<? echo shadebar1(); ?>><b>Karma</b></td><td<? echo shadebar2(); ?>><? echo $u["cookies"]; ?></td></tr>
<tr><td<? echo shadebar1(); ?>><b>Aura</b></td><td<? echo shadebar2(); ?>><? echo $u["aura"]; ?>&Aring;</td></tr>
<tr><td<? echo shadebar1(); ?>><b>Contributor Status</b></td><td<? echo shadebar2(); ?>><? if ($ce > 0) { if ($cn <= 0) echo "Registered, No Posted Works"; else echo "<a href=\"../contribute/recognition.php?id=".$c["id"]."\">Contributor Page</a>"; echo "</td></tr>\n<tr><td ".shadebar1()."><b>Contribution Points</b></td><td ".shadebar2().">".$cn; } else echo "Not Registered"; ?></td></tr>
</table><table border="0" cellspacing="0" width="100%">
<tr><td class="dark" align="center" width="50%">Other User Information</td><td class="dark" align="center" width="50%">General Board Information</td></tr>
<tr><td width="50%" valign="top" align="center">
<a href="usernote.php<? echo querystring($board,$topic); ?>">System Notifications</a><br />
<a href="modhist.php<? echo querystring($board,$topic); ?>">Moderated Message History</a><br />
<a href="aurahist.php<? echo querystring($board,$topic); ?>">Aura History</a><br />
<? if ($u["level"] >= LEVEL_NEW3) echo "<a href=\"myposts.php".querystring($board,$topic)."\">Posted Message List</a><br />"; ?>
<a href="pref5.php<? echo querystring($board,$topic); ?>">Aura Purchases</a><br />
</td><td width="50%" valign="top" align="center">
<a href="karma.php<? echo querystring($board,$topic); ?>">Highest Karma Users</a><br />
<a href="banned.php<? echo querystring($board,$topic); ?>">Banned User List</a><br />
<a href="onlineusers.php<? echo querystring($board,$topic); ?>">Online Users</a><br />
<a href="userlist.php<? echo querystring($board,$topic); ?>">User Directory</a><br />
<a href="stats.php<? echo querystring($board,$topic); ?>"><? echo $sitetitle; ?> Message Board Statistics</a><br />
</td></tr>
<tr><td class="dark" align="center" width="50%">User Options</td><td class="dark" align="center" width="50%">Faction Options</td></tr>
<tr><td width="50%" valign="top" align="center">
<? if ($u["level"] == LEVEL_INACT) echo "<a href=\"react.php".querystring($board,$topic)."\">Re-Send Activation Key</a><br />"; ?>
<? if ($u["level"] > LEVEL_SUSPEND) {  ?> <a href="pref1.php<? echo querystring($board,$topic) ?>">Change Display Settings</a><br />
<? if ($u["level"] >= LEVEL_WARNED) echo "<a href=\"pref2.php".querystring($board,$topic)."\">Change Signature, Quote, E-Mail, and IM</a><br />"; ?>
<a href="pref3.php<? echo querystring($board,$topic); ?>">Change Password</a><br />
<a href="pref4.php<? echo querystring($board,$topic); ?>">Change Theme</a><br />
<a href="pref6.php<? echo querystring($board,$topic); ?>">Purchase Items With Aura</a><br />
<a href="bman.php<? echo querystring($board,$topic); ?>">Board Manager</a><br />
<? if ($ce <= 0) echo "<a href=\"/contribute/register.php\">Register Contributor Name</a><br />";
if ($u["level"] >= LEVEL_NEW1) echo "<a href=\"close.php".querystring($board,$topic)."\">Close This Account</a><br />";
if ($u["level"] == LEVEL_PENCLOSE) echo "<a href=\"restore.php".querystring($board,$topic)."\">Restore This Account</a><br />";
if (($u["level"] == LEVEL_INACT) || ($u["level"] == LEVEL_CLOSED)) echo "<a href=\"delacct.php".querystring($board,$topic)."\">Delete This Account</a><br />"; ?>
</td><td width="50%" valign="top" align="center">
<? } if ($u["level"] >= LEVEL_WARNED) { if (($u["faction"] > 0) || ($u["tempfaction"] > 0)) { ?>
<a href="myfact.php<? echo querystring($board,$topic); ?>">Faction Information</a><br />
<a href="leave.php<? echo querystring($board,$topic); ?>">Leave Current Faction</a><br />
<a href="invite.php<? echo querystring($board,$topic); ?>">Invite Users To Faction</a><br />
<? } else { 
if ($u["level"] >= LEVEL_NEW2) echo "<a href=\"newfact.php".querystring($board,$topic)."\">Create New Faction</a><br />"; ?>
<a href="invpending.php<? echo querystring($board,$topic); ?>">Faction Invitations</a><br />
<? } } ?>
</td></tr>

</table>
<?
include("/home/mediarch/foot.php");
?>