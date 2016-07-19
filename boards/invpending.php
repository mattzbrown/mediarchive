<?
$pagetitle="Faction Invitations";
include("/home/mediarch/head.php");
echo $harsss."<table border=\"0\" width=\"100%\">\n";
$topic = round($_GET["topic"]);
$board = round($_GET["board"]);
$yes = $_POST["accept"];
$no = $_POST["reject"];
$id = round($_POST["id"]);
if (!auth2($uname,$pword)) {
	echo "\n<tr><td>You must be <a href=\"login.php\">logged in</a> to view this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
?>
<tr><td align="center"><span style="font-size:250%;"><b>Faction Invitations</b></span></td></tr>
<?
$u = @mysql_fetch_array(mysql_query("SELECT `faction`,`tempfaction`,`userid`,`username` FROM `users` WHERE `username` = '".$uname."'"));
if (($u["faction"] > 0) || ($u["tempfaction"] > 0)) {
	echo "\n<tr><td>You are already a member of a faction, you cannot join another.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
if (($yes) && ($id)) {
	$check = mysql_query("SELECT `factionid`,`tempfact` FROM `invitations` WHERE `invid` = ".$id." AND `touser` = ".$u["userid"]);
	if (@mysql_num_rows($check) >= 1) {
		$ii = @mysql_fetch_array($check);
		if ($ii["tempfact"] >= 1) {
			$un = @mysql_num_rows(mysql_query("SELECT `userid` FROM `users` WHERE `tempfaction` = ".$ii["factionid"]));
			if ($un >= 4) {
				$f = @mysql_fetch_array(mysql_query("SELECT `name`,`board` FROM `tempfactions` WHERE `tfid` = ".$ii["factionid"]));
				while (@mysql_num_rows(mysql_query("SELECT `boardid` FROM `boards` WHERE `boardid` = ".(1000+$i))) >= 1) $i++;
				mysql_query("INSERT INTO `boards` (`boardid`,`boardname`,`boardlevel`,`type`,`topiclevel`,`messlevel`,`default`) VALUES (".(1000+$i).",'".$f["board"]."',5,7,5,5,0)");
				mysql_query("INSERT INTO `factions` (`name`,`boardid`) VALUES ('".$f["name"]."',".(1000+$i).")");
				$ff = @mysql_fetch_array(mysql_query("SELECT `factionid` FROM `factions` WHERE `name` = '".$f["name"]."'"));				mysql_query("UPDATE `users` SET `faction` = ".$ff["factionid"].", `rank` = 1 WHERE `userid` = ".$u["userid"]);
				mysql_query("UPDATE `users` SET `faction` = ".$ff["factionid"]." WHERE `tempfaction` = ".$ii["factionid"]);
				mysql_query("UPDATE `users` SET `tempfaction` = 0 WHERE `tempfaction` = ".$ii["factionid"]);
				mysql_query("UPDATE `invitations` SET `factionid` = ".$ff["factionid"].", `tempfact` = 0 WHERE `factionid` = ".$ii["factionid"]);
				mysql_query("DELETE FROM `tempfactions` WHERE `tfid` = ".$ii["factionid"]);
				$uf = mysql_query("SELECT `userid` FROM `users` WHERE `faction` = ".$ff["factionid"]);
				while ($ub = @mysql_fetch_array($uf)) {
					mysql_query("INSERT INTO `favorites` (`userid`,`boardid`) VALUES (".$ub["userid"].",".($num_chk["boardid"]+$i).")");
					if ($ub["userid"] != $u["userid"]) mysql_query("INSERT INTO `systemnot` (`sysbod`,`sendto`,`sentfrom`,`sentsec`) VALUES ('User ".$u["username"]." has joined your faction, and, upon his/her recruitment, your faction was activated. Your faction\'s personal message board has been created, and automatically inserted into your favorites.',".$ub["userid"].",".$u["userid"].",".time().")");
				}
				mysql_query("DELETE FROM `invitations` WHERE `invid` = ".$id);
				if (@mysql_num_rows($uf) >= 10) mysql_query("DELETE FROM `invitations` WHERE `factionid` = ".$ff["factionid"]." AND `tempfact` = 0");
				echo "\n\n<meta http-equiv=\"refresh\" content=\"10; URL=user.php".querystring($board,$topic)."\" />\n\n<tr><td>You have accepted the invitation to join ".stripslashes($f["name"]).". Upon your recruitment, the faction was activated. You will be returned to the user info page in 10 seconds. If not, you can click <a href=\"user.php".querystring($board,$topic)."\">here</a>.</td></tr>\n\n</table>";
				include("/home/mediarch/foot.php");
				exit;
			} else {
				$f = @mysql_fetch_array(mysql_query("SELECT `name` FROM `tempfactions` WHERE `tfid` = ".$ii["factionid"]));
				mysql_query("UPDATE `users` SET `tempfaction` = ".$ii["factionid"].", `rank` = 1 WHERE `userid` = ".$u["userid"]);
				mysql_query("DELETE FROM `invitations` WHERE `invid` = ".$id);
				$uf = mysql_query("SELECT `userid` FROM `users` WHERE `tempfaction` = ".$ii["factionid"]);
				while ($ub = @mysql_fetch_array($uf)) {
					if ($ub["userid"] != $u["userid"]) mysql_query("INSERT INTO `systemnot` (`sysbod`,`sendto`,`sentfrom`,`sentsec`) VALUES ('User ".$u["username"]." has joined your faction, but your faction has not been activated yet. At the time of receival of this message, your faction has ".($un+1)." members.',".$ub["userid"].",".$u["userid"].",".time().")");
				}
				if (@mysql_num_rows($uf) >= 10) mysql_query("DELETE FROM `invitations` WHERE `factionid` = ".$f["factionid"]." AND `tempfact` = 1");
				echo "\n\n<meta http-equiv=\"refresh\" content=\"10; URL=user.php".querystring($board,$topic)."\" />\n\n<tr><td>You have accepted the invitation to join ".stripslashes($f["name"]).", but it is currently inactive and does not have enough users to be activated. You will be informed via sysnote if your faction has been activated or not. You will be returned to the user info page in 10 seconds. If not, you can click <a href=\"user.php".querystring($board,$topic)."\">here</a>.</td></tr>\n\n</table>";
				include("/home/mediarch/foot.php");
				exit;
			}
		} else if ($ii["tempfact"] <= 0) {
			$ff = @mysql_fetch_array(mysql_query("SELECT `factionid`,`boardid` FROM `factions` WHERE `factionid` = ".$ii["factionid"]));
			mysql_query("UPDATE `users` SET `faction` = ".$ff["factionid"].", `rank` = 1 WHERE `userid` = ".$u["userid"]);
			mysql_query("INSERT INTO `favorites` (`userid`,`boardid`) VALUES (".$u["userid"].",".$ff["boardid"].")");
			mysql_query("DELETE FROM `invitations` WHERE `invid` = ".$id);
			$un = @mysql_num_rows(mysql_query("SELECT `userid` FROM `users` WHERE `faction` = ".$ff["factionid"]));
			$uf = mysql_query("SELECT `userid` FROM `users` WHERE `faction` = ".$ff["factionid"]);
			while ($ub = @mysql_fetch_array($uf)) {
				if ($ub["userid"] != $u["userid"]) mysql_query("INSERT INTO `systemnot` (`sysbod`,`sendto`,`sentfrom`,`sentsec`) VALUES ('User ".$u["username"]." has joined your faction. At the time of receival of this message, your faction has ".$un." members.',".$ub["userid"].",".$u["userid"].",".time().")");
			}
			if (@mysql_num_rows($uf) >= 10) mysql_query("DELETE FROM `invitations` WHERE `factionid` = ".$ff["factionid"]." AND `tempfact` = 0");
			echo "\n\n<meta http-equiv=\"refresh\" content=\"10; URL=user.php".querystring($board,$topic)."\" />\n\n<tr><td>You have accepted the invitation to join ".stripslashes($f["name"]).", and have joined that faction. You will be returned to the user info page in 10 seconds. If not, you can click <a href=\"user.php".querystring($board,$topic)."\">here</a>.</td></tr>\n\n</table>";
				include("/home/mediarch/foot.php");
				exit;
		}
	}
}
?>
<tr><td align="center" class="lite"><i>
Return to: <a href="index.php" class="menu">Board List</a>
<?
if ($board) echo " | \n<a HREF=\"gentopic.php?board=".$board."\" class=\"menu\">Topic List</a>";
if ($topic) echo " | \n<a HREF=\"genmessage.php?board=".$board."&topic=".$topic."\" class=\"menu\">Message List</a>";
?> | <a href="user.php<?= querystring($board,$topic) ?>" class="menu">User Info Page</a>
</i></td></tr>

<?
$t = 0;
$i = 0;
if (($no) && ($id)) {
	$check = mysql_query("SELECT `factionid`,`fromuser` FROM `invitations` WHERE `invid` = ".$id." AND `touser` = ".$u["userid"]);
	if (@mysql_num_rows($check) >= 1) {
		$i = @mysql_fetch_array($check);
		mysql_query("INSERT INTO `systemnot` (`sysbod`,`sendto`,`sentfrom`,`sentsec`) VALUES ('User ".$u["username"]." has rejected your invitation to join your faction.',".$i["fromuser"].",".$u["userid"].",".time().")");
		$f = @mysql_fetch_array(mysql_query("SELECT `name` FROM `factions` WHERE `factionid` = ".$i["factionid"]));
		mysql_query("DELETE FROM `invitations` WHERE `invid` = ".$id);
		echo "<tr><td><b>You have rejected the invitation to join ".stripslashes($f["name"])."</td></tr>";
	}
}
mysql_query("UPDATE `invitations` SET `invread` = 1 WHERE `touser` = ".$u["userid"]);
$r = mysql_query("SELECT `sendtime`,`factionid`,`fromuser`,`invid` FROM `invitations` WHERE `touser` = ".$u["userid"]." ORDER BY `invid` ASC");
while ($i = @mysql_fetch_array($r)) {
	$ub = @mysql_fetch_array(mysql_query("SELECT `username`, `userid` FROM `users` WHERE `userid` = ".$i["fromuser"]));
	$f = @mysql_fetch_array(mysql_query("SELECT `name`,`factionid` FROM `factions` WHERE `factionid` = ".$i["factionid"]));
	if (!$f["factionid"]) { $f = @mysql_fetch_array(mysql_query("SELECT `name` FROM `tempfactions` WHERE `tfid` = ".$i["factionid"])); $t = 1; }
	echo "\n<tr><td class=\"cell2\"><b>Invitiation Received:</b> ".str_replace(" ","&nbsp;",gmdate("n/j/Y h:i:s A",($i["sendtime"]+$time_offset)))."</td></tr>\n<form action=\"".$PHP_SELF.querystring($board,$topic)."\" method=\"post\">\n<tr><td class=\"cell1\">User <a href=\"whois.php?user=".$ub["userid"].querystring2($board,$topic)."\">".$ub["username"]."</a> has sent you an invitation to join ";
	if ($t = 1) echo stripslashes($f["name"]); else echo "<a href=\"faction.php?faction=".$i["factionid"].querystring2($board,$topic)."\">".stripslashes($f["name"])."</a>";
	echo ".<br /><input type=\"hidden\" name=\"id\" value=\"".$i["invid"]."\" /><br /><input type=\"submit\" name=\"accept\" value=\"Accept\" /><input type=\"submit\" name=\"reject\" value=\"Reject\" /></td></tr>\n</form>\n";
}
?>
</table>
<? include("/home/mediarch/foot.php"); ?>