<?
$pagetitle="Message Board Meta-Moderation";
include("/home/mediarch/head.php");
echo $harsss;
?> <table border="0" width="100%"> <?
if (!auth2($uname,$pword)) {
	echo "\n<tr><td>You must be <a href=\"login.php\">logged in</a> to view this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
$u=@mysql_fetch_array(mysql_query("SELECT `userid`, `username`, `level`, `topicpage`, `topicsort` FROM `users` WHERE `username` = '".$uname."'"));
if ($u["level"] < LEVEL_NEW2) {
	echo "\n<tr><td>You are not authorized to view this page.</td></tr>\n</table>";
	include("/home/mediarch/foot.php");
	exit;
}
?>
<tr><td align="center"><span style="font-size:250%;"><b>Message Board Meta-Moderation</b></span></td></tr>

<tr><td>

<p>You now have the ability to let the <? echo $sitetitle; ?> moderation team know how they're doing by judging recently moderated messages.  On the following screen, you will see a message recently marked for moderation, as well as the action taken on that message.  From there, you can select whether or not the moderator in question acted fairly in accordance with the Terms of Service.</p>
<p>The messages you see on the next page may be very offensive, so if you find yourself offended easily, please don't participate in this program.</p>
<p>Please remember that it is the duty of each moderator to uphold the <a href="tos.php">Terms of Service</a>, so any message that violates the TOS <i>should</i> be deleted, even if you aren't personally offended by it.  Keep this in mind as you rate the moderations you see. You will be shown the messages in pretty much the same fashion as the moderators see them, so take that into account as well.</p>

<p>Each moderator has the choice of taking one of the following actions against a user:
<ul>
<li><b>No Action</b>: Do nothing, the message is allowed within the TOS.</li>
<li><b>Delete Message/Topic</b>: Remove the message (or topic) from the boards, no action against the user.</li>
<li><b>Notify User</b>: Remove the message (or topic) from the boards, notify the user of the violation.</li>
<li><b>Warn User</b>: Remove the message (or topic) from the boards, drop the user to Level 5 for 48 hours.</li>
<li><b>Suspend User</b>: Remove the message (or topic) from the boards, drop the user to Level -1 until reviewed.</li>
<li><b>Revoke User</b>: Remove the message (or topic) from the boards, revoke the user's posting priviliges.</li>
</ul>

<p>Thank you in advance for participating in this review program.  This will hopefully let the moderators know exactly what kind of job they are doing, which should result in better message boards for everyone.</p>

<a href="metamod.php">Click here to proceed with meta-moderation</a>.

</td></tr>

</table>

<?
include("/home/mediarch/foot.php");
?>