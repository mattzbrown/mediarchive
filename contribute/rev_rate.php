<?
$pagetitle="Review Ratings";
include("/home/mediarch/head.php");
echo $harsss;
?>

<table border=0 cellspacing=2 width=100%>
<tr><td COLSPAN=2 align=center><font SIZE=6 FACE=Arial><b>Review Ratings</b></font></td></tr>
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
$numrows=@mysql_num_rows($result);
if ($numrows<=0) {
	echo "<TR><TD CLASS=DARK>Not Registered</TD></TR><TR><TD>To submit reviews to ".$sitetitle.", you must register for both a board username, and a contributor username. If you have not registered for a board username, you may do so <a HREF=\"/boards/register.php>here</a>. Or, if you have already registered for a board username, you can register for a contributor username <a HREF=\"register.php\">here</a>.</TD></TR></table>";
include("/home/mediarch/foot.php");
exit;
}
echo "<tr><td COLSPAN=3 CLASS=DARK ALIGN=CENTER><b>Review Ratings for ".$myrow["contribname"]."</b></td></tr>";

$name=$myrow["contribname"];
$color=0;
$sql="SELECT * FROM contributed WHERE reviewer='$name' AND accepted>=1 AND genre=1 ORDER BY name ASC";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
if ($numrows>=1) {
	echo "<tr><td COLSPAN=3 CLASS=LITE><i>Movies & TV</i></td></tr>";
while ($myrow=@mysql_fetch_array($result)) {
	$color=$color+1;
	$total=$myrow["yes"]+$myrow["no"];
	if ($total>0) {
		$rating=$myrow["yes"]/$total;
		$rating=$rating*100;
		$rating=round($rating);
	}
	echo "<tr><td>".stripslashes($myrow["name"])."</td><td><b>";
	if ($total>0) {
		echo $rating."% (".$total.")";
	} else {
		echo "N/A";
	}
	echo "</b></td></tr>";
}
}
$sql="SELECT * FROM contributed WHERE reviewer='$name' AND accepted>=1 AND genre=2 ORDER BY name ASC";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
if ($numrows>=1) {
	echo "<tr><td COLSPAN=3 CLASS=LITE><i>Video Games</i></td></tr>";
while ($myrow=@mysql_fetch_array($result)) {
	$color=$color+1;
	$total=$myrow["yes"]+$myrow["no"];
	if ($total>0) {
		$rating=$myrow["yes"]/$total;
		$rating=$rating*100;
		$rating=round($rating);
	}
	echo "<tr><td>".stripslashes($myrow["name"])."</td><td><b>";
	if ($total>0) {
		echo $rating."% (".$total.")";
	} else {
		echo "N/A";
	}
	echo "</b></td></tr>";
}
}
$sql="SELECT * FROM contributed WHERE reviewer='$name' AND accepted>=1 AND genre=3 ORDER BY name ASC";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
if ($numrows>=1) {
	echo "<tr><td COLSPAN=3 CLASS=LITE><i>Books</i></td></tr>";
while ($myrow=@mysql_fetch_array($result)) {
	$color=$color+1;
	$total=$myrow["yes"]+$myrow["no"];
	if ($total>0) {
		$rating=$myrow["yes"]/$total;
		$rating=$rating*100;
		$rating=round($rating);
	}
	echo "<tr><td>".stripslashes($myrow["name"])."</td><td><b>";
	if ($total>0) {
		echo $rating."% (".$total.")";
	} else {
		echo "N/A";
	}
	echo "</b></td></tr>";
}
}
$sql="SELECT * FROM contributed WHERE reviewer='$name' AND accepted>=1 AND genre=4 ORDER BY name ASC";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
if ($numrows>=1) {
	echo "<tr><td COLSPAN=3 CLASS=LITE><i>Music</i></td></tr>";
while ($myrow=@mysql_fetch_array($result)) {
	$color=$color+1;
	$total=$myrow["yes"]+$myrow["no"];
	if ($total>0) {
		$rating=$myrow["yes"]/$total;
		$rating=$rating*100;
		$rating=round($rating);
	}
	echo "<tr><td>".stripslashes($myrow["name"])."</td><td><b>";
	if ($total>0) {
		echo $rating."% (".$total.")";
	} else {
		echo "N/A";
	}
	echo "</b></td></tr>";
}
}
$sql="SELECT * FROM contributed WHERE reviewer='$name' AND accepted>=1 AND genre=5 ORDER BY name ASC";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
if ($numrows>=1) {
	echo "<tr><td COLSPAN=3 CLASS=LITE><i>Other</i></td></tr>";
while ($myrow=@mysql_fetch_array($result)) {
	$color=$color+1;
	$total=$myrow["yes"]+$myrow["no"];
	if ($total>0) {
		$rating=$myrow["yes"]/$total;
		$rating=$rating*100;
		$rating=round($rating);
	}
	echo "<tr><td>".stripslashes($myrow["name"])."</td><td><b>";
	if ($total>0) {
		echo $rating."% (".$total.")";
	} else {
		echo "N/A";
	}
	echo "</b></td></tr>";
}
}
echo "<tr><td COLSPAN=3><b>Reminder:</b> These ratings are to be taken with a pillar of salt. Despite our best efforts
to weed them out, people are still managing to vote-stuff, making it difficult to treat the ratings too seriously.
Still, people wanted them, so here they are!</td></tr></table>";
include("/home/mediarch/foot.php");
?>