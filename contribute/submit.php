<?
$pagetitle="Review Submission";
include("/home/mediarch/head.php");
echo $harsss;
?>

<table border=0 cellspacing=2 width=100%>
<tr><td COLSPAN=2 align=center><font SIZE=6 FACE=Arial><b>Reader Review</b></font></td></tr>
<?
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
if (!$username) {
echo "<TR><TD CLASS=DARK><B>Not Logged In</B></TD></TR><TR><TD>To submit reviews and become a contributor to ".$sitetitle.", you must first <a HREF=\"/boards/register.php\">Register</a> for the boards. If you have already registered, then you must first <a HREF=\"/boards/login.php\">Log In</a>.</TD></TR></table>";

include("/home/mediarch/foot.php");
	exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$contribid=$myrow["contribid"];
$sql="SELECT * FROM contributor WHERE id='$contribid' ORDER BY id ASC LIMIT 0,1";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$cname=$myrow["contribname"];
$numrows=@mysql_num_rows($result);
if ($numrows>=1) {
if ($message) {
$message2=str_replace("
"," ",$message);
$message2=explode(" ",$message2);
}
if (($step) && ($genre>=1) && ($genre<=5) && (strlen($game)<=60) && (strlen($oneline)<=150) && (strlen($message)<=51200) && ($game) && ($oneline) && ($message) && ($score>=1) && ($score<=10) && (count($message2)>=250)) {
$sql="INSERT INTO contributed (genre,name,synopsis,reviewer,review,rating,date,accepted) VALUES ('$genre','".addslashes(htmlentities($game))."','".addslashes(htmlentities($oneline))."','".$myrow["contribname"]."','".addslashes(eregi_replace("&lt;b&gt;", "<b>", eregi_replace("&lt;/b&gt;", "</b>", eregi_replace("&lt;i&gt;", "<i>", eregi_replace("&lt;/i&gt;", "</i>", nl2br(htmlentities($message)))))))."','".floor($score)."','".time()."','0')";
$result=mysql_query($sql);
echo "<TR><TD CLASS=DARK><font size=3>Submission Accepted</td></tr><tr><td>Congratualtions on submitting a review to ".$sitetitle."! It will be reviewed by an administrator, and if it is up to ".$sitetitle."'s standards, it will be posted. Thank you very much.
</TD></TR>
</TABLE>";
include("/home/mediarch/foot.php");
exit;
} else if (($step) && (($genre<1) || ($genre>5))) {
echo "<tr><td colspan=2 align=center><b>There was an error submitting your review:</b> You did not select a genre.</td></tr>";
} else if (($step) && (!$game)) {
echo "<tr><td colspan=2 align=center><b>There was an error submitting your review:</b> You did not input the item to be reviewed.</td></tr>";
} else if (($step) && (!$oneline)) {
echo "<tr><td colspan=2 align=center><b>There was an error submitting your review:</b> You did not input a synopsis.</td></tr>";
} else if (($step) && (!$message)) {
echo "<tr><td colspan=2 align=center><b>There was an error submitting your review:</b> You did not input a review.</td></tr>";
} else if (($step) && (strlen($message)>51200)) {
echo "<tr><td colspan=2 align=center><b>There was an error submitting your review:</b> The maximum size for a review is 50KB (51200 characters). Your review is ".$strlen($message)." characters long.</td></tr>";
} else if (($step) && (($score<1) || ($score>10))) {
echo "<tr><td colspan=2 align=center><b>There was an error submitting your review:</b> The rating you entered is invalid.</td></tr>";
} else if (($step) && (count($message2)<250)) {
echo "<tr><td colspan=2 align=center><b>There was an error submitting your review:</b> The minimum amount of words for a review is 250. Your review is ".count($message2)." words long.</td></tr>";
}
	echo "<TR><TD COLSPAN=2 CLASS=DARK ALIGN=CENTER>Submission Guidelines</TD></TR>
<TR><TD COLSPAN=2><FONT SIZE=2 FACE=Arial>In order for your review to be accepted and posted, please follow the following guidelines:<BR>
<UL><LI>You must provide your name or an alias and a valid e-mail address (which will be displayed on your contributor page).</LI>
    <LI>Create a one-line synopsis of your review (like an introductory sentence) under 150 letters long, and give the game an integer score from 1 to 10 (0 being worst, 10 being best).</LI>
    <LI>Your review must be original work, contain no spoilers, and be free of offensive language.</LI>
    <LI>The only HTML markup texts allowed are the bold and italic tags (&lt;B&gt;,&lt;/B&gt;,&lt;I&gt;,&lt;/I&gt;), but you <I>cannot</I> use these in the synopsis.</LI>
    <LI>In your review text, <B>do <i>not</i> include anything but the review!</B>  This means no graphics, no signatures, no codes, no name/email/web site and so on.  Just the review, please!</LI>
    <LI>Reviews that simply bash a game are not accepted.  If you don't like a game, explain why, don't just make fun of it.</LI>
    <LI>Reviews under <B>250</B> words in length will not be posted.</LI>
    <LI>Once an item has over 30 Reader Reviews, no more will likely be accepted.</LI></UL>

</FONT></TD></TR>

<FORM ACTION=\"submit.php\" METHOD=POST>


<TR><TD COLSPAN=2 CLASS=DARK ALIGN=CENTER>Game to be Reviewed</FONT></TD></TR>
<TR><TD>Contributor Name</TD><TD><B>$usrname</B></TD></TR>
<TR><TD COLSPAN=2>Please specify exactly which genre you are writing a review for:</TD></TR>
<TR><TD>Genre of Item</TD>
    <TD>
<select name=\"genre\" size=\"1\">
<option value=\"0\" SELECTED>- Select One -</option>
<option value=\"1\">Movies & TV</option>
<option value=\"2\">Video Game</option>
<option value=\"3\">Book</option>
<option value=\"4\">Music</option>
<option value=\"5\">Other</option>
</select>
</TD></TR>
<TR><TD>Item's Name</TD>
<TD><input type=\"text\" size=\"60\" maxlength=\"60\" name=\"game\" value=\"$game\"></TD></TR>


<TR><TD COLSPAN=2 CLASS=DARK ALIGN=CENTER>Your Review</TD></TR>
<TR><TD COLSPAN=2>Enter your review text and score below.</TD></TR>
<TR><TD>Synopsis:<BR>(A one-line introduction)</TD>
    <TD><input type=\"text\" size=\"60\" maxlength=\"150\" name=\"oneline\" value=\"$oneline\"></TD></TR>
<TR><TD>Your Score:<BR>(Between 1 and 10, NO fractions)</TD>
    <TD><input type=\"text\" size=\"2\" maxlength=\"2\" name=\"score\" value=\"$score\"></TD></TR>
<TR><TD>Review:</TD>
    <TD><textarea cols=\"60\" rows=\"20\" name=\"message\" WRAP=\"virtual\">".stripslashes($message)."</textarea></TD></TR>

<TR><TD COLSPAN=2 ALIGN=CENTER><input type=\"submit\" value=\"Submit Review\" name=\"step\"><input type=\"reset\" value=\"Reset\" name=\"reset\"></TD></TR>

</FORM>

</TABLE>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM contributor WHERE contribname='$usrname'";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$numrows=@mysql_num_rows($result);
if ($numrows<=0) {
	echo "<TR><TD CLASS=DARK>Not Registered</TD></TR><TR><TD>To submit reviews to ".$sitetitle.", you must register for both a board username, and a contributor username. If you have not registered for a board username, you may do so <a HREF=\"/boards/register.php>here</a>. Or, if you have already registered for a board username, you can register for a contributor username <a HREF=\"register.php\">here</a>.</TD></TR></table>";
include("/home/mediarch/foot.php");
}
?>
