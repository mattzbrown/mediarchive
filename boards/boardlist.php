<?php
$pagetitle="Board Listing";
include("/home/mediarch/head.php");
echo $harsss;
$topic = round($_GET["topic"]);
$board = round($_GET["board"]);
$id = round($_GET["id"]);
?> <table border="0" width="100%"> <?php
if (!auth2($uname,$pword)) {
	echo "\n<tr><td>You must be <a href=\"login.php\">logged in</a> to view this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$u = @mysql_fetch_array(mysql_query("SELECT `level` FROM `users` WHERE `username` = '".$uname."'"));
$bn = mysql_query("SELECT `name` FROM `boardcat` WHERE `cathide` = 0 AND `id` = ".$id);
if (@mysql_num_rows($bn) <= 0) {
	echo "\n<tr><td>An invalid link was used to access this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$bc = @mysql_fetch_array($bn);
?>
<tr><td colspan="5" align="center"><b><span style="font-size:250%;">Board Listing</span></b></td></tr>
<tr><td colspan="5" align="center" class="lite"><i>
Return to: <a href="index.php" class="menu">Board List</a>
<?php
if ($board) echo " | \n<a HREF=\"gentopic.php?board=".$board."\" class=\"menu\">Topic List</a>";
if ($topic) echo " | \n<a HREF=\"genmessage.php?board=".$board."&topic=".$topic."\" class=\"menu\">Message List</a>";
?> | <a href="bman.php<?= querystring($board,$topic) ?>" class="menu">Board Manager</a> | <a href="user.php<?= querystring($board,$topic) ?>" class="menu">User Info Page</a>
</i></td></tr>

<tr>
<td class="dark" align="center" width="60%">Board Title</td>
<td class="dark" align="center">Topics</td>
<td class="dark" align="center">Msgs</td>
<td class="dark" align="center">Last Post</td>
<td class="dark" align="center">Favorites</td>
</tr>
<tr><td class="lite" colspan="5"><? echo $bc["name"]; ?></td></tr>
<?php
$bf = mysql_query("SELECT `boardname`, `boardid`, `caption` FROM `boards` WHERE `type` = ".$id." ORDER BY `boardname` ASC");
while ($b = @mysql_fetch_array($bf)) {
	$bd=@mysql_fetch_array(mysql_query("SELECT `messsec` FROM `messages` WHERE `mesboard` = ".$b["boardid"]." ORDER BY `messsec` DESC LIMIT 0, 1"));
	echo "\t<tr>\n\t<td class=\"cell1\"><span style=\"font-size:120%;\"><b><a href=\"gentopic.php?board=".$b["boardid"]."\">".stripslashes($b["boardname"])."</a></b></span><br /><span style=\"font-size:80%;\">".stripslashes($b["caption"])."</span></td>\n\t<td class=\"cell1\">".@mysql_num_rows(mysql_query("SELECT `topicid` FROM `topics` WHERE `boardnum` = ".$b["boardid"]))."</td>\n\t<td class=\"cell1\">".@mysql_num_rows(mysql_query("SELECT `messageid` FROM `messages` WHERE `mesboard` = ".$b["boardid"]))."</td>\n\t<td class=\"cell1\">";
	if ($bd["messsec"]) echo str_replace(" ","&nbsp;",gmdate("n/d g:iA",($bd["messsec"]+$time_offset)));
	echo "</td>\n\t<td class=\"cell1\"><a href=\"addfav.php?board=".$b["boardid"]."&return=".$id."\">Add to Favorites</a></td>\n\t</tr>\n";
}
?>

</table> <?php
include("/home/mediarch/foot.php");
?>