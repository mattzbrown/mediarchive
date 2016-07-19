<?
$pagetitle="User Preferences";
include("/home/mediarch/head.php");
echo $harsss;
$topic = round($_GET["topic"]);
$board = round($_GET["board"]);
$topicpage = round($_POST["topicpage"]);
$topicsort = round($_POST["topicsort"]);
$messagepage = round($_POST["messagepage"]);
$messagesort = round($_POST["messagesort"]);
$showbar = round($_POST["showbar"]);
if (($_POST["timezone"] != -3.5) && ($_POST["timezone"] != 3.5) && ($_POST["timezone"] != 4.5) && ($_POST["timezone"] != 5.5) && ($_POST["timezone"] != 5.75) && ($_POST["timezone"] != 6.5) && ($_POST["timezone"] != 9.5)) $timezone = round($_POST["timezone"]); else $timezone = $_POST["timezone"];
$post = $_POST["post"];
?> <table border="0" width="100%"> <?
if (!auth2($uname,$pword)) {
	echo "\n<tr><td>You must be <a href=\"login.php\">logged in</a> to view this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$u=@mysql_fetch_array(mysql_query("SELECT `userid`, `level` FROM `users` WHERE `username` = '".$uname."'"));
if ($u["level"] < LEVEL_INACT) {
	echo "\n<tr><td>You are not authorized to view this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
?>
<tr><td colspan="4" align="center"><span style="font-size:250%;"><b>Message Display Settings</b></span></td></tr>
<tr><td colspan="4" align="center" class="lite"><i>
Return to: <a href="index.php" class="menu">Board List</a>
<?
if ($board) echo " | \n<a HREF=\"gentopic.php?board=".$board."\" class=\"menu\">Topic List</a>";
if ($topic) echo " | \n<a HREF=\"genmessage.php?board=".$board."&topic=".$topic."\" class=\"menu\">Message List</a>";
?> | <a href="user.php<?= querystring($board,$topic) ?>" class="menu">User Info Page</a>
<?

if ($post) {
	if ($topicpage < 0) $topicpage=0; if ($topicpage > 4) $topicpage=4;
	if ($topicsort < 0) $topicsort=0; if ($topicsort > 3) $topicsort=3;
	if ($messagepage < 0) $messagepage=0; if ($messagepage > 5) $messagepage=5;
	if ($messagesort < 0) $messagesort=0; if ($messagesort > 1) $messagesort=1;
	if ($showbar <= 1) $showbar=0; if ($showbar >= 2) $showbar=1;
	if ($timezone < -12) $timezone=-12; if ($timezone > 13) $timezone=13;
	mysql_query("UPDATE `users` SET `topicpage` = ".$topicpage.", `topicsort` = '".$topicsort."', `messagepage` = '".$messagepage."', `messagesort` = '".$messagesort."', `timezone` = '".$timezone."', `barshow` = '".$showbar."' WHERE `userid` = '".$u["userid"]."'");
	echo "\n\n<tr><td colspan=\"2\" align=\"center\"><b>Your user preferences have been successfully updated.</b></td></tr>\n\n";
}
$u=@mysql_fetch_array(mysql_query("SELECT `username`, `messagepage`, `messagesort`, `topicpage`, `topicsort`, `barshow`, `timezone` FROM `users` WHERE `userid` = ".$u["userid"]."'"));
?>
<tr><td class="dark" align="center" colspan="2">Change User Settings for <? echo $u["username"]; ?></td></tr>

<form action="<? echo $PHP_SELF.querystring($board,$topic); ?>" method="post">

<tr><td><b>Topics Per Page</b></td>
<td><select name="topicpage">
	<option value="0"<? if ($u["topicpage"] == 0) echo " selected=\"selected\""; ?>>10</option>
	<option value="1"<? if ($u["topicpage"] == 1) echo " selected=\"selected\""; ?>>20</option>
	<option value="2"<? if ($u["topicpage"] == 2) echo " selected=\"selected\""; ?>>30</option>
	<option value="3"<? if ($u["topicpage"] == 3) echo " selected=\"selected\""; ?>>40</option>
	<option value="4"<? if ($u["topicpage"] == 4) echo " selected=\"selected\""; ?>>50</option>
</select></td></tr>

<tr><td><b>Topic Sort Order</b></td>
<td><select name="topicsort">
	<option value="0"<? if ($u["topicsort"] == 0) echo " selected=\"selected\""; ?>>By First Post, Oldest First</option>
	<option value="1"<? if ($u["topicsort"] == 1) echo " selected=\"selected\""; ?>>By First Post, Newest First</option>
	<option value="2"<? if ($u["topicsort"] == 2) echo " selected=\"selected\""; ?>>By Last Post, Oldest First</option>
	<option value="3"<? if ($u["topicsort"] == 3) echo " selected=\"selected\""; ?>>By Last Post, Newest First</option>
</select></td></tr>

<tr><td><b>Messages Per Page</b></td>
<td><select name="messagepage">
	<option value="0"<? if ($u["messagepage"] == 0) echo " selected=\"selected\""; ?>>10</option>
	<option value="1"<? if ($u["messagepage"] == 1) echo " selected=\"selected\""; ?>>20</option>
	<option value="2"<? if ($u["messagepage"] == 2) echo " selected=\"selected\""; ?>>30</option>
	<option value="3"<? if ($u["messagepage"] == 3) echo " selected=\"selected\""; ?>>40</option>
	<option value="4"<? if ($u["messagepage"] == 4) echo " selected=\"selected\""; ?>>50</option>
	<option value="5"<? if ($u["messagepage"] == 5) echo " selected=\"selected\""; ?>>100</option>
</select></td></tr>

<tr><td><b>Message Sort Order</b></td>
<td><select name="messagesort">
	<option value="0"<? if ($u["messagesort"] == 0) echo " selected=\"selected\""; ?>>Oldest First</option>
	<option value="1"<? if ($u["messagesort"] == 1) echo " selected=\"selected\""; ?>>Newest First</option>
</select></td></tr>

<tr><td><b>Time Zone</b></td>
<td><select name="timezone">
	<option value="-12"<? if ($u["timezone"] == -12) echo " selected=\"selected\""; ?>>(GMT -12:00) International Date Line West</option>
	<option value="-11"<? if ($u["timezone"] == -11) echo " selected=\"selected\""; ?>>(GMT -11:00) Midway Island, Samoa</option>
	<option value="-10"<? if ($u["timezone"] == -10) echo " selected=\"selected\""; ?>>(GMT -10:00) Hawaii</option>
	<option value="-9"<? if ($u["timezone"] == -9) echo " selected=\"selected\""; ?>>(GMT -9:00) Alaska</option>
	<option value="-8"<? if ($u["timezone"] == -8) echo " selected=\"selected\""; ?>>(GMT -8:00) Pacific Time (US & Canada); Tijuana</option>
	<option value="-7"<? if ($u["timezone"] == -7) echo " selected=\"selected\""; ?>>(GMT -7:00) Mountain Time (US & Canada); Arizona, Chihuahua, La Paz, Mazatlan</option>
	<option value="-6"<? if ($u["timezone"] == -6) echo " selected=\"selected\""; ?>>(GMT -6:00) Central Time (US & Canada); Guadalajara, Mexico City, Monterrey, Saskatchewan</option>
	<option value="-5"<? if ($u["timezone"] == -5) echo " selected=\"selected\""; ?>>(GMT -5:00) Eastern Time (US & Canada); Bogota, Indiana, Lima, Quito</option>
	<option value="-4"<? if ($u["timezone"] == -4) echo " selected=\"selected\""; ?>>(GMT -4:00) Atlantic Time (Canada); Caracas, La Paz, Santiago</option>
	<option value="-3.5"<? if ($u["timezone"] == -3.5) echo " selected=\"selected\""; ?>>(GMT -3:30) Newfoundland</option>
	<option value="-3"<? if ($u["timezone"] == -3) echo " selected=\"selected\""; ?>>(GMT -3:00) Brasilia, Buenos Aires, Georgetown, Greenland</option>
	<option value="-2"<? if ($u["timezone"] == -2) echo " selected=\"selected\""; ?>>(GMT -2:00) Mid-Atlantic</option>
	<option value="-1"<? if ($u["timezone"] == -1) echo " selected=\"selected\""; ?>>(GMT -1:00) Azores, Cape Verde Islands</option>
	<option value="0"<? if ($u["timezone"] == 0) echo " selected=\"selected\""; ?>>(GMT) Greenwich Mean Time: Casablanca, Dublin, Edinburgh, Lisbon, London, Monrovia</option>
	<option value="1"<? if ($u["timezone"] == 1) echo " selected=\"selected\""; ?>>(GMT +1:00) Amsterdam, Berlin, Bern, Madrid, Paris, Rome, Stockholm, Vienna, West Central Africa</option>
	<option value="2"<? if ($u["timezone"] == 2) echo " selected=\"selected\""; ?>>(GMT +2:00) Athens, Cairo, Helsinki, Istanbul, Jerusalem</option>
	<option value="3"<? if ($u["timezone"] == 3) echo " selected=\"selected\""; ?>>(GMT +3:00) Baghdad, Kuwait, Moscow, Nairobi, St. Petersburg</option>
	<option value="3.5"<? if ($u["timezone"] == 3.5) echo " selected=\"selected\""; ?>>(GMT +3:30) Tehran</option>
	<option value="4"<? if ($u["timezone"] == 4) echo " selected=\"selected\""; ?>>(GMT +4:00) Abu Dhabi, Baku, Muscat, Tbilisi, Yerevan</option>
	<option value="4.5"<? if ($u["timezone"] == 4.5) echo " selected=\"selected\""; ?>>(GMT +4:30) Kabul</option>
	<option value="5"<? if ($u["timezone"] == 5) echo " selected=\"selected\""; ?>>(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
	<option value="5.5"<? if ($u["timezone"] == 5.5) echo " selected=\"selected\""; ?>>(GMT +5:30) Chennai, Kolkata, Mumbai, New Delhi</option>
	<option value="5.75"<? if ($u["timezone"] == 5.75) echo " selected=\"selected\""; ?>>(GMT +5:45) Kathmandu</option>
	<option value="6"<? if ($u["timezone"] == 6) echo " selected=\"selected\""; ?>>(GMT +6:00) Almaty, Astana, Dhaka, Novosibirsk, Sri Jayawardenepura</option>
	<option value="6.5"<? if ($u["timezone"] == 6.5) echo " selected=\"selected\""; ?>>(GMT +6:50) Rangoon</option>
	<option value="7"<? if ($u["timezone"] == 7) echo " selected=\"selected\""; ?>>(GMT +7:00) Bangkok, Hanoi, Jakarta, Krasnoyarsk</option>
	<option value="8"<? if ($u["timezone"] == 8) echo " selected=\"selected\""; ?>>(GMT +8:00) Beijing, Hong Kong, Irkutsk, Kuala Lumpur, Perth, Singapore, Taipei</option>
	<option value="9"<? if ($u["timezone"] == 9) echo " selected=\"selected\""; ?>>(GMT +9:00) Osaka, Sapporo, Seoul, Tokyo, Yakutsk</option>
	<option value="9.5"<? if ($u["timezone"] == 9.5) echo " selected=\"selected\""; ?>>(GMT +9:30) Adelaide, Darwin</option>
	<option value="10"<? if ($u["timezone"] == 10) echo " selected=\"selected\""; ?>>(GMT +10:00) Brisbane, Canberra, Guam, Hobart, Sydney, Vladivostok</option>
	<option value="11"<? if ($u["timezone"] == 11) echo " selected=\"selected\""; ?>>(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
	<option value="12"<? if ($u["timezone"] == 12) echo " selected=\"selected\""; ?>>(GMT +12:00) Auckland, Fiji, Kamchatka, Marshall Islands, Wellington</option>
	<option value="13"<? if ($u["timezone"] == 13) echo " selected=\"selected\""; ?>>(GMT +13:00) Nuku'alofa</option>
</select></td></tr>

<tr><td><b>Top Navigation Bar</b></td>
<td>
	<input type="radio" name="showbar" value="2"<? if ($u["barshow"] >= 1) echo " checked=\"checked\""; ?> />Yes
	<input type="radio" name="showbar" value="1"<? if ($u["barshow"] <= 0) echo " checked=\"checked\""; ?> />No
</td></tr>

<tr><td align="center" colspan="2">
	<input type="submit" value="Make Changes" name="post" />
	<input type="reset" value="Reset" name="reset" />
</td></tr>

</form>

</table>
<?
include("/home/mediarch/foot.php");
?>