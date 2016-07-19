<?
$pagetitle="Faction Information";
include("/home/mediarch/head.php");
echo $harsss."<table border=\"0\" width=\"100%\">\n";
$topic = round($_GET["topic"]);
$board = round($_GET["board"]);
if (!auth2($uname,$pword)) {
	echo "\n<tr><td>You must be <a href=\"login.php\">logged in</a> to view this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$u = @mysql_fetch_array(mysql_query("SELECT `faction`,`tempfaction`,`userid` FROM `users` WHERE `username` = '".$uname."'"));
if (($u["faction"] <= 0) && ($u["tempfaction"] <= 0)) {
	echo "\n<tr><td>You are not a member of a faction.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
if ($u["faction"] > 0) { $faction = $u["faction"]; $tmp = 0; } else if ($u["tempfaction"] > 0) { $faction = $u["tempfaction"]; $tmp = 1; }
$f = @mysql_fetch_array(mysql_query("SELECT `name`,`boardid` FROM `factions` WHERE `factionid` = ".$faction));
$b = @mysql_fetch_array(mysql_query("SELECT `boardname` FROM `boards` WHERE `boardid` = ".$f["boardid"]));
$mr = mysql_query("SELECT `username`,`userid`,`cookies`,`aura`,`rank` FROM `users` WHERE `faction` = ".$faction." ORDER BY `rank` DESC,`username` ASC");
?>
<tr><td align="center" colspan="3"><span style="font-size:250%;"><b>Faction Information</b></span></td></tr>
<tr><td colspan="3" align="center" class="lite"><i>
Return to: <a href="index.php" class="menu">Board List</a>
<?
if ($board) echo " | \n<a href=\"gentopic.php?board=".$board."\" class=\"menu\">Topic List</a>";
if ($topic) echo " | \n<a href=\"genmessage.php?board=".$board."&topic=".$topic."\" class=\"menu\">Message List</a>";
?> | <a href="user.php<?= querystring($board,$topic) ?>" class="menu">User Info Page</a>
</i></td></tr>

<tr><td class="dark" colspan="3">General Information</td></tr>
<tr><td width="30%"><b>Faction Name:</b></td><td><? echo stripslashes($f["name"]); if ($u["tempfaction"] > 0) echo " (Inactive)"; ?></td></tr>
<tr><td width="30%"><b>Faction Board:</b></td><td><a href="gentopic.php?board=<? echo $f["boardid"]; ?>"><? echo stripslashes($b["boardname"]); ?></a></td></tr>
<tr><td width="30%"><b>Faction Members:</b></td><td><? echo @mysql_num_rows($mr); ?></td></tr>
</table><table border="0" width="100%">
<tr><td class="dark" colspan="3">Members in <? echo stripslashes($f["name"]); ?></td></tr>
<tr><td class="lite">User Name</td><td class="lite">Karma</td><td class="lite">Aura</td></tr>
<?
while ($u = @mysql_fetch_array($mr)) {
	$g = 0;
	echo "\n<tr><td class=\"cell1\"><a href=\"whois.php?user=".$u["userid"].querystring2($board,$topic)."\">".$u["username"]."</a>";
	switch ($u["rank"]) {
		case 5: echo " (Leader)"; break;
	}
	echo "</td><td class=\"cell1\">".$u["cookies"]."</td><td class=\"cell1\">".$u["aura"]."&Aring;</td></tr>";
	$ir = mysql_query("SELECT `touser`,`sendtime` FROM `invitations` WHERE `factionid` = ".$faction." AND `tempfact` = ".$tmp." AND `fromuser` = ".$u["userid"]);
	if (@mysql_num_rows($ir) >= 1) {
		echo "<tr><td rowspan=\"".@mysql_num_rows($ir)."\" class=\"cell2\">Invitations Sent</td>";
		while ($i = @mysql_fetch_array($ir)) {
			$ub = @mysql_fetch_array(mysql_query("SELECT `username` FROM `users` WHERE `userid` = ".$i["touser"]));
			if ($g >= 1) echo "<tr>";
			echo "<td class=\"cell2\"><a href=\"whois.php?user=".$i["touser"].querystring2($board,$topic)."\">".$ub["username"]."</a></td><td class=\"cell2\">".str_replace(" ","&nbsp;",gmdate("n/j/Y h:i:s A",($i["sendtime"]+$time_offset)))."</td></tr>";
			$g++;
		}
	}
}
?>
</table>
<? include("/home/mediarch/foot.php"); ?>