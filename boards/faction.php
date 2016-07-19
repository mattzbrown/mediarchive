<?
$pagetitle="Faction Information";
include("/home/mediarch/head.php");
echo $harsss."<table border=\"0\" width=\"100%\">\n";
$topic = round($_GET["topic"]);
$board = round($_GET["board"]);
$faction = round($_GET["faction"]);
if (!auth2($uname,$pword)) {
	echo "\n<tr><td>You must be <a href=\"login.php\">logged in</a> to view this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$fr = mysql_query("SELECT `name`,`boardid` FROM `factions` WHERE `factionid` = ".$faction);
if (@mysql_num_rows($fr) <= 0) {
	echo "\n<tr><td>An invalid link was used to access this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$f = @mysql_fetch_array($fr);
$b = @mysql_fetch_array(mysql_query("SELECT `boardname` FROM `boards` WHERE `boardid` = ".$f["boardid"]));
$mr = mysql_query("SELECT `username`,`userid`,`cookies`,`aura`,`rank` FROM `users` WHERE `faction` = ".$faction." ORDER BY `rank` DESC,`username` ASC");
?>
<tr><td align="center" colspan="3"><span style="font-size:250%;"><b>Faction Information</b></span></td></tr>
<tr><td colspan="3" align="center" class="lite"><i>
Return to: <a href="index.php" class="menu">Board List</a>
<?
if ($board) echo " | \n<a href=\"gentopic.php?board=".$board."\" class=\"menu\">Topic List</a>";
if ($topic) echo " | \n<a href=\"genmessage.php?board=".$board."&topic=".$topic."\" class=\"menu\">Message List</a>";
?>
</i></td></tr>
<tr><td class="dark" colspan="3">General Information</td></tr>
<tr><td width="30%"><b>Faction Name:</b></td><td><? echo stripslashes($f["name"]); ?></td></tr>
<tr><td width="30%"><b>Faction Board:</b></td><td><a href="gentopic.php?board=<? echo $f["boardid"]; ?>"><? echo stripslashes($b["boardname"]); ?></a></td></tr>
<tr><td width="30%"><b>Faction Members:</b></td><td><? echo @mysql_num_rows($mr); ?></td></tr>
</table><table border="0" width="100%">
<tr><td class="dark" colspan="3">Members in <? echo stripslashes($f["name"]); ?></td></tr>
<tr><td class="lite">User Name</td><td class="lite">Karma</td><td class="lite">Aura</td></tr>
<? while ($u = @mysql_fetch_array($mr)) {
	echo "\n<tr><td class=\"cell1\"><a href=\"whois.php?user=".$u["userid"].querystring2($board,$topic)."\">".$u["username"]."</a>";
	switch ($u["rank"]) {
		case 5: echo " (Leader)"; break;
	}
	echo "</td><td class=\"cell1\">".$u["cookies"]."</td><td class=\"cell1\">".$u["aura"]."&Aring;</td></tr>";
} ?>
</table>
<? include("/home/mediarch/foot.php"); ?>