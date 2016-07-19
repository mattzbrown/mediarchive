<?
$pagetitle="Moderation Detail";
include("/home/mediarch/head.php");
echo $harsss;
echo "<table border=0 width=100%>

<tr><td CLASS=TL align=center><font SIZE=6>Moderation Detail</font></td></tr>";
function auth($userid, $password) {
$sql="SELECT username FROM users WHERE username='$userid' AND userpass='$password'";
$result=mysql_query($sql);
if(!mysql_num_rows($result)) return 0;
else {
$query_data=mysql_fetch_row($result);
return $query_data[0];
}
}
$username=auth($uname,$pword);
if (!$username)
{
echo "<tr><td>You are not authorized to view this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$userid=$myrow["userid"];
$level=$myrow["level"];
$usern=$myrow["username"];
echo "<tr><td COLSPAN=2 CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo " | <a HREF=\"user.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>User Info Page</a> | 
<a HREF=\"modhist.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Moderation List</a>
</i></font></td></tr>";

$sql="SELECT * FROM modded WHERE modid=$modid AND moduser=$userid AND action>0";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$numrows=@mysql_num_rows($result);
if ($numrows<=0) {

echo "<tr><td>An invalid link was used to access this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;

}
$sql="SELECT * FROM modded WHERE recont>=7 AND recont<=8 AND moduser=$userid";
$result=mysql_query($sql);
$killcont=@mysql_num_rows($result);
$sql="SELECT * FROM modded WHERE modid=$modid";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
if (($appeal) && ($myrow["action"]>=5) && ($myrow["action"]<=8) && ($myrow["recont"]==3) && ($level>0) && ($killcont<=0)) {
$time2=time()-604800;
if (($myrow["action"]>=3) && ($myrow["action"]<=4) && ($myrow["modsec"]<$time)) {
break 5;
}
$sql="UPDATE modded SET recont=4 WHERE modid=$modid";
$resultcont=mysql_query($sql);
$time=time();
$sql="UPDATE modded SET appealsec=$time WHERE modid=$modid";
$resultcont=mysql_query($sql);
} else if (($accept) && ($myrow["action"]>=5) && ($myrow["action"]<=8) && ($myrow["recont"]==3) && ($level>0) && ($killcont<=0)) {
$time2=time()-604800;
if (($myrow["action"]>=3) && ($myrow["action"]<=4) && ($myrow["modsec"]<$time)) {
break 5;
}
$sql="UPDATE modded SET contest=0 WHERE modid=$modid";
$resultcont=mysql_query($sql);
$sql="UPDATE modded SET recont=0 WHERE modid=$modid";
$resultcont=mysql_query($sql);
} else if (($myrow["contest"]==0) && (!($myrow["contbody"])) && ($myrow["action"]<=8) && ($myrow["action"]>=3) && ($resp>=1) && ($resp<=2) && ($message) && ($level>0) && ($killcont<=0)) {
$message=htmlentities($message);
$message=nl2br($message);
$message=addslashes($message);
$sql="UPDATE modded SET contbody='$message' WHERE modid=$modid";
$resultcont=mysql_query($sql);
if ($resp==2) {
$sql="UPDATE modded SET contest=1 WHERE modid=$modid";
$resultcont=mysql_query($sql);
}
$time=time();
$sql="UPDATE modded SET contsec=$time WHERE modid=$modid";
$resultcont=mysql_query($sql);
}
$numrows=mysql_num_rows($result);
$moduser=$myrow["moduser"];
$modby=$myrow["modby"];
$boardid=$myrow["boardid"];
$sql="SELECT * FROM users WHERE userid=$moduser";
$resulto=mysql_query($sql);
$myrowo=@mysql_fetch_array($resulto);
$sql="SELECT * FROM boards WHERE boardid=$boardid";
$resultx=mysql_query($sql);
$myrowx=@mysql_fetch_array($resultx);
$boardn=$myrowx["boardname"];

$reason=$myrow["reason"];
$sql="SELECT * FROM tos WHERE tosid=$reason";
$resultre=mysql_query($sql);
$myrowre=@mysql_fetch_array($resultre);

echo "<tr><td CLASS=CELL2><b>Board:</b> $boardn | <b>Topic:</b> ".$myrow["topicid"]." - ".stripslashes($myrow["topic"])." | Moderation ID: $modid</font></td></tr>
<tr><td CLASS=CELL2><b>From:</b> ".$myrowo["username"]." | <b>Posted:</b> ".str_replace(" ","&nbsp;",gmdate("n/j/Y h:i:s A",($myrow["postsec"]+$time_offset)))."</font></td></tr>
<tr><td CLASS=CELL2><b>Moderated at:</b> ".str_replace(" ","&nbsp;",gmdate("n/j/Y h:i:s A",($myrow["modsec"]+$time_offset)))." | <b>Reason:</b> ".$myrowre["ruletitle"]." |  <b>Action:</b> ";
if ($myrow["action"]==1) {
echo "Topic Closed";
} else if ($myrow["action"]==2) {
echo "Topic Moved";
} else if ($myrow["action"]==3) {
echo "Message Deleted";
} else if ($myrow["action"]==4) {
echo "Topic Deleted";
} else if ($myrow["action"]==5) {
echo "Notified (Msg)";
} else if ($myrow["action"]==6) {
echo "Notified (Top)";
} else if ($myrow["action"]==7) {
echo "Warned (Msg)";
} else if ($myrow["action"]==8) {
echo "Warned (Top)";
} else if ($myrow["action"]==9) {
echo "Suspended (Msg)";
} else if ($myrow["action"]==10) {
echo "Suspended (Top)";
} else if ($myrow["action"]==11) {
echo "Banned (Msg)";
} else if ($myrow["action"]==12) {
echo "Banned (Top)";
}
echo "</font></td></tr>
<tr><td CLASS=CELL1>".stripslashes($myrow["modbod"])."</font></td></tr>
<tr><td>
<br>Your message was found to be violating the following section of the TOS:</td></tr>";
$reason=$myrow["reason"];
$sql="SELECT * FROM tos WHERE tosid=$reason";
$resultre=mysql_query($sql);
$myrowre=@mysql_fetch_array($resultre);
echo "<tr><td CLASS=CELL1><font Size=2>
<b>".$myrowre["ruletitle"]."</b><br>

".$myrowre["rulebody"]."
</font></td></tr>
<tr><td><br>";
$sql="SELECT * FROM modded WHERE modid=$modid";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
if ($myrow["action"]==1) {
echo "This topic was closed with <b>No Karma Loss</b>.  It is considered a minor or administrative moderation.";
} else if ($myrow["action"]==2) {
echo "This topic was moved with <b>No Karma Loss</b>.  It is considered a minor or administrative moderation.";
} else if ($myrow["action"]==3) {
echo "This message was deleted with <b>No Karma Loss</b>.  It is considered a minor or administrative moderation.";
} else if ($myrow["action"]==4) {
echo "This message was deleted with <b>No Karma Loss</b>.  It is considered a minor or administrative moderation.";
} else if ($myrow["action"]==5) {
echo "This message was deleted with a <b>Notification</b>.  It is considered a major moderation and comes with a loss of 3 karma.";
} else if ($myrow["action"]==6) {
echo "This message was deleted with a <b>Notification</b>.  It is considered a major moderation and comes with a loss of 3 karma.";
} else if ($myrow["action"]==7) {
echo "This message was deleted with a <b>Warning</b>.  It is considered a major moderation and comes with a loss of 10 karma. Your account will be restored in 48 hours to its original status.";
} else if ($myrow["action"]==8) {
echo "This message was deleted with a <b>Warning</b>.  It is considered a major moderation and comes with a loss of 10 karma. Your account will be restored in 48 hours to its original status.";
} else if ($myrow["action"]==9) {
echo "This message was deleted with a <b>Suspension</b>.  It is considered a major infraction. Your account will be reviewed within the next 24 hours.";
} else if ($myrow["action"]==10) {
echo "This message was deleted with a <b>Suspension</b>.  It is considered a major infraction. Your account will be reviewed within the next 24 hours.";
} else if ($myrow["action"]==11) {
echo "This message was deleted with a <b>Banning</b>.  It is considered a major infraction. Bans are <b>permanent</b>, and will not be overturned.";
} else if ($myrow["action"]==12) {
echo "This message was deleted with a <b>Banning</b>.  It is considered a major infraction. Bans are <b>permanent</b>, and will not be overturned.";
}
if ($killcont>=1) {
echo "<p>Since you currently have a failed admin appeal or contest abuse in your history, you cannot contest messages.</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
if ($level<=0) {
echo "<p>Since your account is either suspended, banned, or closed, you cannot contest messages.</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
if (($myrow["contest"]==0) && ($myrow["contbody"])) {
echo "<p>You have sent the following comments:</td></tr>
<tr><td CLASS=CELL1><font Size=2>".stripslashes($myrow["contbody"])."</font></td></tr>";
if (($myrow["recontbody"]) && ($myrow["recont"]==0)) {
echo "<tr><td><br>The moderator responded with the following:</td></tr>
<tr><td CLASS=CELL1><font Size=2>".stripslashes($myrow["recontbody"])."</font></td></tr>";
}
}
if ($myrow["contest"]==1) {
echo "<p>You have sent the following comments:</td></tr>
<tr><td CLASS=CELL1><font Size=2>".stripslashes($myrow["contbody"])."</font></td></tr>";
if ($myrow["recont"]==0) {
echo "<tr><td><br>You have already contested this moderation on the grounds that it was not a TOS violation.  It has not yet been
reviewed by a moderator.</td></tr>";
} else if ($myrow["recont"]==1) {
echo "<tr><td><br>The moderator responded with the following:</td></tr>

<tr><td CLASS=CELL1><font Size=2>".stripslashes($myrow["recontbody"])."</font></td></tr>
<tr><td><br>This moderator has reviewed this contest, and agreed that the message was not a TOS violation.  Any lost karma
has been restored, and when possible, the message and/or topic was restored to the boards.</td></tr>";
} else if ($myrow["recont"]==2) {
echo "<tr><td><br>The moderator responded with the following:</td></tr>

<tr><td CLASS=CELL1><font Size=2>".stripslashes($myrow["recontbody"])."</font></td></tr>
<tr><td><br>This moderator has reviewed this contest, and agreed that the moderation, while a TOS violation, was too harsh. Partial or full karma has been restored to your account, but the moderation still stands as it was given.</td></tr>";
} else if ($myrow["recont"]==3) {
echo "<tr><td><br>The moderator responded with the following:</td></tr>

<tr><td CLASS=CELL1><font Size=2>".stripslashes($myrow["recontbody"])."</font></td></tr>
<tr><td><br>This moderator has reviewed this contest, and agreed that the moderation will stand as originally given.";
if ($myrow["action"]<=4) {
echo "<p>Since this moderation was deleted with no karma loss, it cannot be appealed.";
} else if (($myrow["action"]>=5) && ($myrow["action"]<=8)) {
echo "<form ACTION=\"moddetl.php?modid=$modid";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" METHOD=POST>
<p>You may appeal this decision to an administrator, who can make a final call.  However, the administrator
is more than likely to agree with the moderator, and if your appeal fails, you will not be able to contest any
additional moderations until this one is cleared from your history.
<p><input type=\"submit\" value=\"Appeal to Administrator\" name=\"appeal\">
<input type=\"submit\" value=\"Accept the Moderation\" name=\"accept\">
</td></tr>
</form>";
} 
echo "</td></tr>";
} else if ($myrow["recont"]==4) {
echo "<tr><td><br>The moderator responded with the following:</td></tr>

<tr><td CLASS=CELL1><font Size=2>".stripslashes($myrow["recontbody"])."</font></td></tr>
<tr><td><br>You have already appealed this moderation to an administrator on the grounds that it was not a TOS violation.  It has not yet been
reviewed.</td></tr>"; 
} else if ($myrow["recont"]==5) {
echo "<tr><td><br>The moderator responded with the following:</td></tr>

<tr><td CLASS=CELL1><font Size=2>".stripslashes($myrow["recontbody"])."</font></td></tr>
<tr><td><br>An administrator has reviewed this contest, and agreed that the message was not a TOS violation. Any lost karma
has been restored, and when possible, the message and/or topic was restored to the boards.</td></tr>"; 
} else if ($myrow["recont"]==6) {
echo "<tr><td><br>The moderator responded with the following:</td></tr>

<tr><td CLASS=CELL1><font Size=2>".stripslashes($myrow["recontbody"])."</font></td></tr>
<tr><td><br>An admnistrator has reviewed this contest, and agreed that the moderation, while a TOS violation, was too harsh. Partial or full karma has been restored to your account, but the moderation still stands as it was given.</td></tr>";
} else if ($myrow["recont"]==7) {
echo "<tr><td><br>The moderator responded with the following:</td></tr>

<tr><td CLASS=CELL1><font Size=2>".stripslashes($myrow["recontbody"])."</font></td></tr>
<tr><td><br>An administrator has reviewed this contest, and agreed that the moderation will stand as originally given.";
} else if ($myrow["recont"]==8) {
echo "<tr><td><br>This contest was determined to be an abuse of the moderation contest system. You will not be able to contest any further moderations until this one is cleared from your history, assuming your account is still active.</td></tr>";
} else if ($myrow["recont"]==9) {
echo "<tr><td><br>This contest has been forwarded to an administrator for further review.</td></tr>";
}
}
$time=time()-604800;
if (($myrow["contest"] <= 0) && ($myrow["action"]>=3) && ($myrow["action"]<=4) && ($myrow["modsec"]<$time)) {
echo "<p>This moderation is over seven days old; it can no longer be contested.</td></tr>
</table>";
include("/home/mediarch/foot.php");
exit;
}
if (($myrow["contest"]==0) && ($myrow["action"]<=8) && ($myrow["action"]>=3) && (!$myrow["contbody"])) {
echo "<p>You have the ability to contest this moderation if you do not feel that it was a TOS violation, or that the 
moderation was too harsh.  The moderator who deleted your message will review the moderation and respond to your 
contest within 48 hours.  If the moderator does not respond in that time, it is automatically forwarded to the
administrator.  You are advised to include comments for the moderator to make your case.  You can also send a 
comment about the moderation if you don't want to contest it.<p>
If you are contesting a moderation, and not merely sending a comment, don't bother with any of the following:
<ul><li><b>Saying, &quot;I didn't know it was a TOS Violation&quot;.</b>  Well, now you do.  
Ignorance of the rules is no excuse, especially considering how prominently they're
displayed.</li>

<li><b>Complaining that the TOS is too strict.</b>  It was strict before you signed
up, and you agreed to follow all rules when you signed up, not just the ones you find convenient.</li>
<li><b>Saying, &quot;I've seen other people get away with it.&quot;</b>  The actions of others
do not dictate your own.  The only concern here is your own violation, not those of others.</li>
<li><b>Apologizing or admitting you broke the rules for whatever reason.</b>  It
doesn't matter if you're sorry, or that someone drove you to it, or that you were
having a bad day.  That's not what this form is to be used for.</li>
<li><b>Saying, &quot;I didn't post that, it was my brother/cousin/dog/a hacker&quot;.</b>  You
are responsible for controlling your own account.  If you re-use passwords on other
sites or accidentally leave your account logged in on a public computer, you're 
just begging for trouble.  Additionally, so many people have used that same excuse
in the past when they clearly posted it themselves that it's hardly even believable.</li>
<li><b>Making abusive comments.</b>  This is a quick and easy way to get your account banned.</li>
</ul>

<form ACTION=\"moddetl.php?modid=$modid";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" METHOD=POST>
Select Response Type: <br><select NAME=\"resp\" size=1>
<option VALUE=1 SELECTED>This was a fair moderation, but I would like to send a comment to the moderator.</option>
<option VALUE=2>My message/topic did not violate the TOS, and should not have been deleted.</option></select><br>
Comments/Arguments:<br>
<textarea cols=\"60\" rows=\"5\" name=\"message\" WRAP=\"virtual\"></textarea>
<input type=\"submit\" value=\"Submit\" name=\"Submit\">
</td></tr>
</form>";
}
if ($myrow["action"]==1) {
echo "<p>Since this moderation was deleted with a topic closure, it cannot be contested.</td></tr>";
}
if (($myrow["action"]==9) || ($myrow["action"]==10)) {
echo "<p>This moderation caused your account to be <b>Suspended</b>. It cannot be contested.</td></tr>";
}
if (($myrow["action"]==11) || ($myrow["action"]==12)) {
echo "<p>This moderation caused your account to be <b>Banned</b>. Bans are <b>permanent</b>, and cannot be contested.</td></tr>";
}
if ($myrow["action"]==2) {
echo "<p>Since this moderation was deleted with a topic movement, it cannot be contested.</td></tr>";
}
echo "</table>";
include("/home/mediarch/foot.php");
?>