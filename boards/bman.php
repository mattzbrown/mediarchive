<?
$pagetitle="Board Manager";
include("/home/mediarch/head.php");
echo $harsss;
$topic = round($_GET["topic"]);
$board = round($_GET["board"]);
?> <table border="0" width="100%"> <?php
if (!auth2($uname,$pword)) {
	echo "\n<tr><td>You must be <a href=\"login.php\">logged in</a> to view this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
?>
<tr><td colspan="5" align="center"><b><span style="font-size:250%;">Board Manager</span></b></td></tr>
<tr><td colspan="5" align="center" class="lite"><i>
Return to: <a href="index.php" class="menu">Board List</a>
<?php
if ($board) echo " | \n<a HREF=\"gentopic.php?board=".$board."\" class=\"menu\">Topic List</a>";
if ($topic) echo " | \n<a HREF=\"genmessage.php?board=".$board."&topic=".$topic."\" class=\"menu\">Message List</a>";
?> | <a href="user.php<?= querystring($board,$topic) ?>" class="menu">User Info Page</a>
</i></td></tr>
<?
$u = @mysql_fetch_array(mysql_query("SELECT `userid` FROM `users` WHERE `username` = '".$uname."'"));
if ($_GET["remove"]) {
mysql_query("DELETE FROM `favorites` WHERE `boardid` = ".$_GET["remove"]." AND `userid` = ".$u["userid"]);
$b = @mysql_fetch_array(mysql_query("SELECT `boardname` FROM `boards` WHERE `boardid` = ".$_GET["remove"]));
if ($b["boardname"]) echo "\n\n<tr><td align=\"center\" colspan=\"2\"><b>".stripslashes($b["boardname"])." was successfully deleted from your favorites.</b></td></tr>\n\n";
} else if ($_GET["clear"]) {
mysql_query("DELETE FROM `favorites` WHERE `userid` = ".$u["userid"]);
$dr = mysql_query("SELECT `boardid` FROM `boards` WHERE `default` = 1");
while ($b = @mysql_fetch_array($dr)) mysql_query("INSERT INTO `favorites` (`boardid`,`userid`) VALUES (".$b["boardid"].",".$u["userid"]."')");
echo "\n\n<tr><td align=\"center\" colspan=\"2\"><b>Your favorites have been returned to default.</b></td></tr>\n\n";
} else if ($_GET["def"]) {
$dr = mysql_query("SELECT `boardid` FROM `boards` WHERE `default` = 1");
while ($b = @mysql_fetch_array($dr)) {
mysql_query("DELETE FROM `favorites` WHERE `userid` = ".$u["userid"]." AND `boardid` = ".$b["boardid"]);
mysql_query("INSERT INTO `favorites` (`boardid`,`userid`) VALUES (".$b["boardid"].",".$u["userid"].")");
}
echo "\n\n<tr><td align=\"center\" colspan=\"2\"><b>The default boards have been added.</b></td></tr>\n\n";
} else if ($_GET["feat"] == 1) {
mysql_query("UPDATE `users` SET `featboard` = 1 WHERE `userid` = ".$u["userid"]);
echo "\n\n<tr><td align=\"center\" colspan=\"2\"><b>Today's featured boards have been added.</b></td></tr>\n\n";
} else if ($_GET["feat"] == 2) {
mysql_query("UPDATE `users` SET `featboard` = 0 WHERE `userid` = ".$u["userid"]);
echo "\n\n<tr><td align=\"center\" colspan=\"2\"><b>Today's featured boards have been removed.</b></td></tr>\n\n";
}

echo "<tr><td align=\"center\" colspan=\"2\">From this page, you can remove any of the boards you have listed in your favorites.</td></tr>";
$r=mysql_query("SELECT `id`,`capshow`,`name` FROM `boardcat` ORDER BY `id` ASC");
while ($bc=@mysql_fetch_array($r)) {
	$fv=0;
	$r2=mysql_query("SELECT `boardid` FROM `boards` WHERE `type`=".$bc["id"]." ORDER BY `boardname` ASC");
	while ($b=@mysql_fetch_array($r2)) {
		$ss=mysql_num_rows(mysql_query("SELECT `favid` FROM `favorites` WHERE `boardid` = ".$b["boardid"]." AND `userid` = ".$u["userid"]));
		if ($ss>=1) {
			$fv=1;
		}
	}
	if ($fv>=1) { 
		echo "\n\n<tr><td class=\"lite\" colspan=\"2\">".stripslashes($bc["name"])."</td></tr>\n";
		$r2=mysql_query("SELECT `boardid`, `boardname`, `caption` FROM `boards` WHERE `type`=".$bc["id"]." ORDER BY `boardname` ASC");
		while ($b=@mysql_fetch_array($r2)) {
			$ss=@mysql_num_rows(mysql_query("SELECT favid FROM `favorites` WHERE `boardid` = ".$b["boardid"]." AND `userid` = ".$u["userid"]));
			if ($ss >= 1) {
				$bd=@mysql_fetch_array(mysql_query("SELECT `messsec` FROM `messages` WHERE `mesboard` = ".$b["boardid"]." ORDER BY `messsec` DESC LIMIT 0, 1"));
				echo "\t<tr>\n\t<td class=\"cell1\"><span style=\"font-size:120%;\"><b><a href=\"gentopic.php?board=".$b["boardid"]."\">".stripslashes($b["boardname"])."</a></b></span></td>\n\t<td class=\"cell1\"><a href=\"".$PHP_SELF."?remove=".$b["boardid"].querystring2($board,$topic)."\">Remove</a></td>\n\t</tr>\n";
			}
		}
	}
}
$u = @mysql_fetch_array(mysql_query("SELECT `featboard` FROM `users` WHERE `username` = '".$uname."'"));
?>

<tr>
	<td class="lite" colspan="2">Available Options</td>
</tr><tr>
	<td class="cell1"><span style="font-size:120%;"><b>Clear all boards from my favorites and return to default</b></span></td>
	<td class="cell1"><a href="<? echo $PHP_SELF; ?>?clear=1<? echo querystring2($board,$topic); ?>">Clear All</a></td>
</tr><tr>
	<td class="cell1"><span style="font-size:120%;"><b>Add the Default Boards</b></span></td>
	<td class="cell1"><a href="<? echo $PHP_SELF; ?>?def=1<? echo querystring2($board,$topic); ?>">Add Defaults</a></td>
</tr> <?
$br=mysql_query("SELECT * FROM boardcat WHERE cathide=0 ORDER BY id ASC");
while ($bc=mysql_fetch_array($br)) {
echo "<tr>\n\t<td class=\"cell1\"><span style=\"font-size:120%;\"><b>List all ".stripslashes($bc["name"])."</b></span></td>\n\t<td class=\"cell1\"><a href=\"boardlist.php?id=".$bc["id"].querystring2($board,$topic)."\">List Boards</a></td>\n</tr>";
}
if ($u["featboard"] == 1) {
echo "<tr>\n\t<td class=\"cell1\"><span style=\"font-size:120%;\"><b>Remove Today's Featured Boards</b></span></td>\n\t<td class=\"cell1\"><a href=\"".$PHP_SELF."?feat=2".querystring2($board,$topic)."\">Remove List</a></td>\n</tr>";
} else {
echo "<tr>\n\t<td class=\"cell1\"><span style=\"font-size:120%;\"><b>Show Today's Featured Boards</b></span></td>\n\t<td class=\"cell1\"><a href=\"".$PHP_SELF."?feat=1".querystring2($board,$topic)."\">Add List</a></td>\n</tr>";
}
?>

</table>
<?
include("/home/mediarch/foot.php");
?>