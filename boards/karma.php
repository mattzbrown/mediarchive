<?
$pagetitle="Highest Karma Users";
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
<tr><td colspan="3" align="center"><span style="font-size:250%;"><b>Highest Karma Users</b></span></td></tr>
<tr><td colspan="3" align="center" class="lite"><i>
Return to: <a href="index.php" class="menu">Board List</a>
<?
if ($board) echo " | \n<a HREF=\"gentopic.php?board=".$board."\" class=\"menu\">Topic List</a>";
if ($topic) echo " | \n<a HREF=\"genmessage.php?board=".$board."&topic=".$topic."\" class=\"menu\">Message List</a>";
?> | <a href="user.php<?= querystring($board,$topic) ?>" class="menu">User Info Page</a>
</i></td></tr>
<tr><td class="dark">User</td><td class="dark">Karma</td><td class="dark">Date Joined</td></tr>
<?
$r=mysql_query("SELECT `username`, `cookies`, `regsec`, `userid` FROM `users` ORDER BY `cookies` DESC, `regsec` ASC LIMIT 0, 50");
$n=0;
while ($u=@mysql_fetch_array($r)) {
		$n++;
		echo "<tr>\n\t<td class=\"cell1\"><a href=\"whois.php?user=".$u["userid"].querystring2($board,$topic)."\">".$u["username"]."</a></td>\n\t<td class=\"cell1\">".$u["cookies"]."</td>\n\t<td class=\"cell1\">".str_replace(" ","&nbsp;",gmdate("n/j/Y h:i:s A",($u["regsec"]+$time_offset)))."</td></tr>";
}
?>
</table>
<?
include("/home/mediarch/foot.php");
?>