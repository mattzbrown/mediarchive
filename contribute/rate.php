<?
$pagetitle="Review Rating";
include("/home/mediarch/head.php");
echo $harsss;
$sql="SELECT * FROM contributed WHERE reviewid='$id' AND accepted>=1";
$result2=mysql_query($sql);
$numrows=@mysql_num_rows($result2);
$my_row=@mysql_fetch_array($result2);
if (($numrows<=0) || (($rate!="Yes") && ($rate!="No"))) {
echo "<table border=0 width=100%>
<tr><td>An invalid link was used to access this page.</td></tr>
	</table>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM contributed WHERE reviewid='$id' AND accepted>=1";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
if ($rate=="Yes") {
$newyes=$myrow["yes"]+1;
$sql="UPDATE contributed SET yes='$newyes' WHERE reviewid='$id'";
$result=mysql_query($sql);
} else if ($rate=="No") {
$newno=$myrow["no"]+1;
$sql="UPDATE contributed SET no='$newno' WHERE reviewid='$id'";
$result=mysql_query($sql);
}
?>
<table border=0 width=100%>
<tr><td align=center><font size=6><b>Review Rating</b></font><br></td></tr>
<tr><td>Thank you for your feedback! Your rating has been accepted, and will be added to the ratings for this review.</td></tr>
</table>
<?
include("/home/mediarch/foot.php");
?>