<?
$pagetitle="Meta-Moderation";
include("/home/mediarch/head.php");
echo $harsss;
$rate = round($_POST["rate"]);
$modid = round($_POST["modid"]);
$post = $_POST["post"];
?> <table border="0" width="100%"> <?
if (!auth2($uname,$pword)) {
	echo "\n<tr><td>You must be <a href=\"login.php\">logged in</a> to view this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$u=@mysql_fetch_array(mysql_query("SELECT `userid`, `level` FROM `users` WHERE `username` = '".$uname."'"));
if ($u["level"] < LEVEL_NEW2) {
	echo "\n<tr><td>You are not authorized to view this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
?>
<tr><td align="center"><span style="font-size:250%;"><b>Message Board Meta-Moderation</b></span></td></tr>
<?
if (@mysql_num_rows(mysql_query("SELECT `modid` FROM `modded`")) <= 0) {
echo "\n<tr><td>There are currently no moderated messages, meta-moderation is not possible.</td></tr>\n</table>";
include("/home/mediarch/foot.php");
exit;
}
$mod_exist = mysql_query("SELECT `modby` FROM `modded` WHERE `modid` = ".$modid);
if (@mysql_num_rows($mod_exist) >= 1) {
	if (($rate >= 1) && ($rate <= 5)) {
		$m = @mysql_fetch_array($mod_exist);
		switch ($rate) {
			case 1: $op = -2; break;
			case 2: $op = -1; break;
			case 3: $op = 0; break;
			case 4: $op = 1; break;
			case 5: $op = 2; break;
			default: $op = 0;
		}
		mysql_query("INSERT INTO `metamod` (`modid`,`modby`,`userid`,`op`,`date`) VALUES (".$modid.",".$m["modby"].",".$u["userid"].",".$op.",".time().")");
	}
	echo "<tr><td>Your opinion has been entered into the database. Thank you for participating!<br />\nYou can <a href=\"".$PHP_SELF."\">Meta-Moderate some more</a> or <a href=\"index.php\">return to the Main Board listing</a>.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$first = @mysql_fetch_array(mysql_query("SELECT `modid` FROM `modded` ORDER BY `modid` ASC LIMIT 0,1"));
$last = @mysql_fetch_array(mysql_query("SELECT `modid` FROM `modded` ORDER BY `modid` DESC LIMIT 0,1"));
$mod_exist = mysql_query("SELECT `modid` FROM `modded` WHERE `modid` = ".rand($first["modid"], $last["modid"]));
while (@mysql_num_rows($mod_exist) <= 0) $mod_exist = mysql_query("SELECT `modid` FROM `modded` WHERE `modid` = ".rand($first["modid"], $last["modid"]));
$x = @mysql_fetch_array($mod_exist);
$m = @mysql_fetch_array(mysql_query("SELECT `modid`,`postsec`,`modsec`,`modbod`,`boardid`,`topic`,`reason`,`action`,`moduser` FROM `modded` WHERE `modid` = ".$x["modid"]));
$ub = @mysql_fetch_array(mysql_query("SELECT `username` FROM `users` WHERE `userid` = ".$m["moduser"]));
$b = @mysql_fetch_array(mysql_query("SELECT `boardname` FROM `boards` WHERE `boardid` = ".$m["boardid"]));
$v = @mysql_fetch_array(mysql_query("SELECT `ruletitle` FROM `tos` WHERE `tosid` = ".$m["reason"]));
$rk=mysql_query("SELECT `modsec`,`reason` FROM `modded` WHERE `moduser` = ".$m["moduser"]." AND `action` >= 3 AND `action` <= 4 ORDER BY `modsec` ASC");
$rn=mysql_query("SELECT `modsec`,`reason` FROM `modded` WHERE `moduser` = ".$m["moduser"]." AND `action` >= 5 AND `action` <= 6 ORDER BY `modsec` ASC");
$rw=mysql_query("SELECT `modsec`,`reason` FROM `modded` WHERE `moduser` = ".$m["moduser"]." AND `action` >= 7 AND `action` <= 8 ORDER BY `modsec` ASC");
$act_array=array("No Action","Message Deleted","Topic Deleted","User Notified","User Warned","User Suspended","User Banned");
switch ($m["action"]) {
	case 0: case 1: case 2: $replace_key = 0; break;
	case 3: $replace_key = 1; break;
	case 4: $replace_key = 2; break;
	case 5: case 6: $replace_key = 3; break;
	case 7: case 8: $replace_key = 4; break;
	case 9: case 10: $replace_key = 5; break;
	case 11: case 12: $replace_key = 6; break;
	default: $replace_key = 0;
}
$act_array[$replace_key] = "<b><u>".$act_array[$replace_key]."</u></b>";
?>
<tr><td class="cell2"><b>Posted:</b> <? echo str_replace(" ","&nbsp;",gmdate("n/j/Y h:i:s A",($m["postsec"]+$time_offset))); ?> | <b>Moderated:</b> <? echo str_replace(" ","&nbsp;",gmdate("n/j/Y h:i:s A",($m["modsec"]+$time_offset))); ?></td></tr>
<tr><td class="cell2"><b>Board:</b> <? echo $b["boardname"]; ?> | <b>Topic:</b> <? echo $m["topic"]; ?></td></tr>
<tr><td class="cell1"><? echo $m["modbod"]; ?></td></tr>
<tr><td class="cell2"><b>Reason for Moderation:</b> <? echo $v["ruletitle"]; ?></td></tr>
<tr><td class="cell2"><b>Active Messages:</b> <? echo @mysql_num_rows(mysql_query("SELECT `messageid` FROM `messages` WHERE `messby` = '".$ub["username"]."'")); ?></a> | <b>Moderated Messages:</b> <? echo @mysql_num_rows(mysql_query("SELECT `modid` FROM `modded` WHERE `moduser` = ".$m["moduser"]." AND `action` > 0")); ?></a></td></tr>
<?
while ($k = @mysql_fetch_array($rk)) {
	$v = @mysql_fetch_array(mysql_query("SELECT `ruletitle` FROM `tos` WHERE `tosid` = ".$k["reason"]));
	echo "<tr><td class=\"sys\">This user received a <b>deletion</b> on ".str_replace(" ","&nbsp;",gmdate("n/j/Y h:i:s A",($k["modsec"]+$time_offset)))." for <b>".$v["ruletitle"]."</b></td></tr>";
}
while ($n = @mysql_fetch_array($rn)) {
	$v = @mysql_fetch_array(mysql_query("SELECT `ruletitle` FROM `tos` WHERE `tosid` = ".$n["reason"]));
	echo "<tr><td class=\"sys\">This user received a <b>notification</b> on ".str_replace(" ","&nbsp;",gmdate("n/j/Y h:i:s A",($n["modsec"]+$time_offset)))." for <b>".$v["ruletitle"]."</b></td></tr>";
}
while ($w = @mysql_fetch_array($rw)) {
	$v = @mysql_fetch_array(mysql_query("SELECT `ruletitle` FROM `tos` WHERE `tosid` = ".$w["reason"]));
	echo "<tr><td class=\"sys\">This user received a <b>warning</b> on ".str_replace(" ","&nbsp;",gmdate("n/j/Y h:i:s A",($w["modsec"]+$time_offset)))." for <b>".$v["ruletitle"]."</b></td></tr>";
}
?>
<tr><td class="darksys" align="center">Action taken in order of severity:<br />
<? echo implode(" -&gt; ",$act_array); ?>
</td></tr>
<tr><td><b>Do you feel that this was a fair moderation?</b><br />
Judge this moderation, taking into account the message itself as well as the prior number of moderations for this user.
<form action="<? echo $PHP_SELF; ?>" method="post">
<input type="hidden" name="modid" value="<? echo $m["modid"]; ?>" />
<select name="rate">

<option value="9" selected="selected">--Select One Below--</option>
<? if ($m["action"]<11) echo "<option value=\"1\">Very lenient</option>\n<option value=\"2\">Slightly lenient</option>\n"; ?>
<option value="3">Fair</option>
<? if ($m["action"]>0) echo "<option value=\"4\">Slightly harsh</option>\n<option value=\"5\">Very harsh</option>\n"; ?>
<option value="9">Not enough information</option>

</select>

<input type="submit" name="post" value="Submit Your Opinion" />

</td></tr>

</table>
<? include("/home/mediarch/foot.php"); ?>