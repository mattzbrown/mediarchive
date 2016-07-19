<?
$pagetitle="Online Users";
include("/home/mediarch/head.php");
echo $harsss;
$topic = round($_GET["topic"]);
$board = round($_GET["board"]);
?> <table border="0" width="100%"> <?
if (!auth2($uname,$pword)) {
	echo "\n<tr><td>You must be <a href=\"login.php\">logged in</a> to view this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
?>
<tr><td colspan="6" align="center"><span style="font-size:250%;"><b>Online Users</b></span></td></tr>
<tr><td colspan="6" align="center" class="lite"><i>
Return to: <a href="index.php" class="menu">Board List</a>
<?
if ($board) echo " | \n<a HREF=\"gentopic.php?board=".$board."\" class=\"menu\">Topic List</a>";
if ($topic) echo " | \n<a HREF=\"genmessage.php?board=".$board."&topic=".$topic."\" class=\"menu\">Message List</a>";
?> | <a href="userlist.php<?= querystring($board,$topic) ?>" class="menu">User Directory</a> | <a href="user.php<?= querystring($board,$topic) ?>" class="menu">User Info Page</a>
</i></td></tr>

<tr>
<td class="dark">User ID</td>
<td class="dark">User Name</td>
<td class="dark">User Level</td>
<td class="dark">Karma</td>
<td class="dark">Aura</td>
<td class="dark">Idle Time</td>
</tr>
<?
$r=mysql_query("SELECT `level`,`username`,`userid`,`cookies`,`aura`,`defsec` FROM `users` WHERE `defsec` >= ".(time()-600)." ORDER BY `userid` ASC");
while ($u=@mysql_fetch_array($r)) {
$l = @mysql_fetch_array(mysql_query("SELECT `leveltitle` FROM `levels` WHERE `level` = ".$u["level"]));
$min = (time()-$u["defsec"])/60;
$sec = ($min - floor($min))*60;
echo "<tr>\n<td class=\"cell1\">".$u["userid"]."</td>\n<td class=\"cell1\"><a href=\"whois.php?user=".$u["userid"].querystring2($board,$topic)."\">".$u["username"]."</a></td>\n<td class=\"cell1\">".$l["leveltitle"]."</td>\n<td class=\"cell1\">".$u["cookies"]."</td>\n<td class=\"cell1\">".$u["aura"]."&Aring;</td>\n<td class=\"cell1\">".floor($min).":"; if ($sec < 10) echo "0"; echo round($sec)."</td>\n</tr>";
}
?>
<tr><td class="lite" colspan="6"><i>Currently online users: <? echo @mysql_num_rows($r); ?></i></td></tr>

</table>
<?
include("/home/mediarch/foot.php");
?>