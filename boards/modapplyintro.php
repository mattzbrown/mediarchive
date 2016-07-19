<?
$pagetitle="Moderator Application Introduction";
include("/home/mediarch/head.php");
echo $harsss;
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
echo "<table border=0 width=100%>

<tr><td>You must be <a HREF=\"login.php\">logged in</a> to view this page.</td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM options WHERE opid='8'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
if ($myrow["val"]==0) {
echo "<table border=0 cellspacing=2 width=100%>
<tr><td>Moderator applications are currently <b>closed</b>.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$karma=$myrow["cookies"];
?>
<table border=0 width=100%>
<tr><td Colspan=2 align=center><font SIZE=6><b>Moderator Application Introduction</b></font></td></tr>


<tr><td COLSPAN=2><font Size=2>

<? echo "So, you want to be a ".$sitetitle." Message Board moderator?  What are you thinking?<p>

Seriously, you are about to apply for a thankless, unpaid job that will leave thousands
of users hating you for no other reason than the fact that you're trying to make the boards
a better place.<p>

The primary function of a moderator is to enforce the message board TOS by taking action on 
messages marked for moderation by other ".$sitetitle." users.<p>";
?>

The position of moderator is strictly voluntary. There are no monetary rewards and no benefits. 
On the other hand, moderators do not have to keep any set schedule, and may moderate as much or 
as little as they please. There is no minimum requirement for time worked or messages handled, 
so long as you're able to help reduce the overall amount of messages regularly. Of course, 
the more you can help out, the happier everyone will be. <p>

The minimum requirements for being a moderator are:

<ul><?
$sql="SELECT * FROM options WHERE opid='9'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
echo "<li>Karma of ".$myrow["val"]." or higher</li>";
?><li>No recent serious moderations (notifications or warnings)</li>
<li>Good history of marking TOS violations for moderation (but not violation hunting)</li>
<li>A clean usermap (i.e. no account or computer sharing with banned users)</li>
</ul>

Other recommendations:
<ul><li>Relatively clean moderation history (the shorter, the better)</li>
<li>Strong command of the English language (i.e. good spelling and grammar, good knowledge of slang and colloquialisms)</li>
<li>Large amount of time spent on boards</li>
<li>Good reputation as a board user</li>

<li>Good general knowledge of popular games(to be able to better moderate the gaming boards)</li>
<li>A strong understanding of the TOS, and the willingness to enforce it as it stands</li></ul>

This time around, new moderators will be restricted to handling marked messages
from a specific category of the boards for their first several months.  You 
must only list <b>one category</b> as your area of interest, and new 
moderators will be assigned by the following categories:
<ul>
<?
$sql="SELECT * FROM boardcat WHERE cathide=0 ORDER BY id ASC";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$c=$c+1;
echo "<li>".$myrow["name"]."</li>";
}
?>
<li>Other</li></ul>

The only way to be considered for a moderator position is to apply using the form linked below.<p>

Sending an e-mail asking to be a moderator regardless of circumstances ensures that you will 
not be selected. Posting a message on the boards asking to be a moderator ensures that you will 
not be selected. Asking any of the current moderators for tips or help to become a moderator 
ensures that you will not be selected. <p>
<?
$sql="SELECT * FROM options WHERE opid='9'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
if ($myrow["val"]>$karma) {
echo "You need a karma of at least ".$myrow["val"]." to apply.";
} else if ($myrow["val"]<=$karma) {
echo "<a HREF=\"modapply.php\">Apply to be a Message Board Moderator here.</a>";
}
?>
</font></td></tr>

</table>
<?
include("/home/mediarch/foot.php");
?>







