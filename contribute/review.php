<?
$pagetitle="db review";
include("/home/mediarch/head.php");
echo $harsss;
$sql="SELECT * FROM contributed WHERE reviewid='$id' AND accepted>=1";
$result2=mysql_query($sql);
$numrows=@mysql_num_rows($result2);
$my_row=@mysql_fetch_array($result2);
if ($numrows<=0) {
echo "<table border=\"0\" width=\"100%\"><tr><td>An invalid link was used to access this page.</td></tr></table>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM contributed WHERE reviewid='$id' AND accepted>=1";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$name=$myrow["reviewer"];
$sql="SELECT * FROM contributor WHERE contribname='$name'";
$result=mysql_query($sql);
$myrow2=@mysql_fetch_array($result);
echo "<table border=0 cellspacing=0 width=100%>
<tr ><td width=100% CLASS=DARK align=center><b>";
if ($myrow["genre"]==1) { echo "<a href=\"/video/\" class=\"menu\">Movies & TV</a>";
} else if ($myrow["genre"]==2) { echo "<a href=\"/games/\" class=\"menu\">Video Games</a>";
} else if ($myrow["genre"]==3) { echo "<a href=\"/lit/\" class=\"menu\">Books</a>";
} else if ($myrow["genre"]==4) { echo "<a href=\"/music/\" class=\"menu\">Music</a>";
} else if ($myrow["genre"]==5) { echo "<a href=\"/misc/\" class=\"menu\">Other</a>";
}
echo "</b></td></tr><tr><td align=\"center\"><font size=\"";
if (strlen($myrow["name"])>=25) { echo "6"; } else { echo "7"; }
echo "\"><b><i>".stripslashes($myrow["name"])."</i></b></font><br /></td></tr><tr><tr><td class=\"dark\" align=\"center\"><font size=\"+1\"><b>Reader Review</b></font></td></tr></table><table border=\"0\" cellspacing=\"0\" width=\"100%\"><tr><td colspan=\"3\" class=\"lite\"><i>Review by <a class=\"menu\" href=\"recognition.php?id=".$myrow2["id"]."\">".$myrow2["contribname"]."</a></i></td></tr><tr><td>&nbsp;</td><td width=\"100%\">".stripslashes($myrow["review"])."</td><td>&nbsp;</td></tr></table><table border=\"0\" cellspacing=\"0\" width=\"100%\"><tr><td class=\"lite\"><i>Reviewer's Score: ".$myrow["rating"]." / 10, Originally Posted on ".date("n/j/Y",$myrow["date"])."</i></td>";
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
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
if (($username) && ($myrow["level"]>=60)) {
echo "<td align=\"right\" class=\"lite\"><i><a href=\"delrev.php?id=$id\" class=\"menu\">Delete</a></i></td></tr><tr><td align=\"center\" colspan=\"2\">";
} else {
echo "</tr><tr><td align=\"center\">";
}
echo "<form target=\"_blank\" method=\"post\" action=\"rate.php\"><b>Rate this review:</b> Did you find this review helpful and/or informative?<input type=\"hidden\" name=\"id\" value=\"".$id."\"><input type=\"submit\" name=\"rate\" value=\"Yes\"><input type=\"submit\" name=\"rate\" value=\"No\"></form></td></tr></table>";
include("/home/mediarch/foot.php");
?>