<?
$pagetitle="db contributor";
include("/home/mediarch/head.php");
echo $harsss;
$sql="SELECT * FROM contributor WHERE id='$id'";
$result2=mysql_query($sql);
$my_row=@mysql_fetch_array($result2);
$sql="SELECT * FROM contributed WHERE reviewer='".$my_row["contribname"]."' AND accepted>=1";
$result=mysql_query($sql);
$numrows2=@mysql_num_rows($result);
if ($numrows2<=0) {
echo "<table border=0 width=100%>
<tr><td>An invalid link was used to access this page.</td></tr>
	</table>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM contributor WHERE id='$id'";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$name=$myrow["contribname"];
echo "<table border=0 cellspacing=0 width=100%>
<tr><td align=center><font size=7><b><i>".$myrow["contribname"]."</i></b></font><br></td></tr>
</table>";
if (($myrow["contribweb"]) || ($myrow["contribemail"]) || ($myrow["contribfull"])) {
echo "<table CELLSPACING=0 CELLPADDING=1 WIDTH=100%>
<tr><td COLSPAN=2 ALIGN=CENTER CLASS=DARK>Contributor Information</td></tr>";
if ($myrow["contribfull"]) { echo "<tr><td><b>Full Name:</b></td><td>".stripslashes($myrow["contribfull"])."</td></tr>"; }
if ($myrow["contribemail"]) { echo "<tr><td><b>E-mail Address:</b></td><td>".stripslashes(str_replace("@","<img HEIGHT=17 WIDTH=13 ALIGN=absbottom SRC=\"/images/at.gif\" ALT=\"_at_\">",str_replace(".","<img HEIGHT=18 WIDTH=4 ALIGN=absbottom SRC=\"/images/dot.gif\" ALT=\"_dot_\">",$myrow["contribemail"])))."</td></tr>"; }
if ($myrow["contribweb"]) { echo "<tr><td><b>Web Site:</b></td><td><a HREF=\"".stripslashes($myrow["contribweb"])."\">".stripslashes($myrow["contribweb"])."</a></td></tr>"; }
echo "</table><br>";
}
echo "<table CELLSPACING=0 CELLPADDING=1 WIDTH=100%>
<tr><td COLSPAN=3 ALIGN=CENTER CLASS=DARK>Contributed Reviews</td></tr>";
$color=0;
$sql="SELECT * FROM contributed WHERE reviewer='$name' AND accepted>=1 AND genre=1 ORDER BY name ASC";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
if ($numrows>=1) {
	echo "<tr><td COLSPAN=3 CLASS=LITE><i>Movies & TV</i></td></tr>";
while ($myrow=@mysql_fetch_array($result)) {
	$color=$color+1;
	if (($color%2)==0) {
		echo "<tr><td CLASS=SHADE>".stripslashes($myrow["name"])."</td><td CLASS=SHADE><a HREF=\"review.php?id=".$myrow["reviewid"]."\">".stripslashes($myrow["synopsis"])."</a></td><td CLASS=SHADE><b>".$myrow["rating"]."/10</b></td></tr>";
	} else {
		echo "<tr><td>".stripslashes($myrow["name"])."</td><td><a HREF=\"review.php?id=".$myrow["reviewid"]."\">".stripslashes($myrow["synopsis"])."</a></td><td><b>".$myrow["rating"]."/10</b></td></tr>";
	}
}
}
$sql="SELECT * FROM contributed WHERE reviewer='$name' AND accepted>=1 AND genre=2 ORDER BY name ASC";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
if ($numrows>=1) {
	echo "<tr><td COLSPAN=3 CLASS=LITE><i>Video Games</i></td></tr>";
while ($myrow=@mysql_fetch_array($result)) {
	$color=$color+1;
	if (($color%2)==0) {
		echo "<tr><td CLASS=SHADE>".stripslashes($myrow["name"])."</td><td CLASS=SHADE><a HREF=\"review.php?id=".$myrow["reviewid"]."\">".stripslashes($myrow["synopsis"])."</a></td><td CLASS=SHADE><b>".$myrow["rating"]."/10</b></td></tr>";
	} else {
		echo "<tr><td>".stripslashes($myrow["name"])."</td><td><a HREF=\"review.php?id=".$myrow["reviewid"]."\">".stripslashes($myrow["synopsis"])."</a></td><td><b>".$myrow["rating"]."/10</b></td></tr>";
	}
}
}
$sql="SELECT * FROM contributed WHERE reviewer='$name' AND accepted>=1 AND genre=3 ORDER BY name ASC";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
if ($numrows>=1) {
	echo "<tr><td COLSPAN=3 CLASS=LITE><i>Books</i></td></tr>";
while ($myrow=@mysql_fetch_array($result)) {
	$color=$color+1;
	if (($color%2)==0) {
		echo "<tr><td CLASS=SHADE>".stripslashes($myrow["name"])."</td><td CLASS=SHADE><a HREF=\"review.php?id=".$myrow["reviewid"]."\">".stripslashes($myrow["synopsis"])."</a></td><td CLASS=SHADE><b>".$myrow["rating"]."/10</b></td></tr>";
	} else {
		echo "<tr><td>".stripslashes($myrow["name"])."</td><td><a HREF=\"review.php?id=".$myrow["reviewid"]."\">".stripslashes($myrow["synopsis"])."</a></td><td><b>".$myrow["rating"]."/10</b></td></tr>";
	}
}
}
$sql="SELECT * FROM contributed WHERE reviewer='$name' AND accepted>=1 AND genre=4 ORDER BY name ASC";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
if ($numrows>=1) {
	echo "<tr><td COLSPAN=3 CLASS=LITE><i>Music</i></td></tr>";
while ($myrow=@mysql_fetch_array($result)) {
	$color=$color+1;
	if (($color%2)==0) {
		echo "<tr><td CLASS=SHADE>".stripslashes($myrow["name"])."</td><td CLASS=SHADE><a HREF=\"review.php?id=".$myrow["reviewid"]."\">".stripslashes($myrow["synopsis"])."</a></td><td CLASS=SHADE><b>".$myrow["rating"]."/10</b></td></tr>";
	} else {
		echo "<tr><td>".stripslashes($myrow["name"])."</td><td><a HREF=\"review.php?id=".$myrow["reviewid"]."\">".stripslashes($myrow["synopsis"])."</a></td><td><b>".$myrow["rating"]."/10</b></td></tr>";
	}
}
}
$sql="SELECT * FROM contributed WHERE reviewer='$name' AND accepted>=1 AND genre=5 ORDER BY name ASC";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
if ($numrows>=1) {
	echo "<tr><td COLSPAN=3 CLASS=LITE><i>Other</i></td></tr>";
while ($myrow=@mysql_fetch_array($result)) {
	$color=$color+1;
	if (($color%2)==0) {
		echo "<tr><td CLASS=SHADE>".stripslashes($myrow["name"])."</td><td CLASS=SHADE><a HREF=\"review.php?id=".$myrow["reviewid"]."\">".stripslashes($myrow["synopsis"])."</a></td><td CLASS=SHADE><b>".$myrow["rating"]."/10</b></td></tr>";
	} else {
		echo "<tr><td>".stripslashes($myrow["name"])."</td><td><a HREF=\"review.php?id=".$myrow["reviewid"]."\">".stripslashes($myrow["synopsis"])."</a></td><td><b>".$myrow["rating"]."/10</b></td></tr>";
	}
}
}
$sql="SELECT * FROM contributed WHERE reviewer='$name' AND accepted>=1";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
while ($myrow=@mysql_fetch_array($result)) {
$totalsize=$totalsize+strlen($myrow["review"]);
}
$totalsize=ceil($totalsize/1024);
echo "</table><br>
<table CELLSPACING=0 CELLPADDING=1 WIDTH=100%>
<tr><td COLSPAN=2 ALIGN=CENTER CLASS=DARK>Contribution Summary</td></tr>
<tr><td><b>Reviews Contributed:</b></td><td>".$numrows." (".$totalsize."KB)</td></tr>
</table>";
include("/home/mediarch/foot.php");
?>