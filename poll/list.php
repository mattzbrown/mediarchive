<?
$pagetitle="Poll of the Day";
include("/home/mediarch/head.php");
echo $harsss;
echo "<table border=0 width=100%>
<tr><td COLSPAN=3 align=center><font SIZE=6 FACE=Arial><b>Previous Polls</b></font></td></tr>";
if (!$page) {
$page=0;
}
$pages=$page*30;
$sql="SELECT * FROM pollques ORDER BY pollid DESC LIMIT $pages,30";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
echo "<tr>
<td><font FACE=Arial SIZE=2>".$myrow["date"]."</font></td>
<td><font FACE=Arial SIZE=2><a HREF=\"index.php?poll=".$myrow["pollid"]."\">".stripslashes(stripslashes($myrow["val"]))."</a></font></td>
</tr>
";
}
$sql="SELECT * FROM pollques";
$result=mysql_query($sql);
$numberoftopics=mysql_num_rows($result);
$numberoftopics=$numberoftopics/30;
$maxpages=ceil($numberoftopics);
$maxpages1=$maxpages-1;
$maxpages2=$maxpages-2;
if (mysql_num_rows($result)>30)
{
echo "<tr><td COLSPAN=3 align=center><font SIZE=3 FACE=Arial><b>";
$previouspage=$page-1;
$nextpage=$page+1;
$pagex=$page+1;
if ($page>0) echo "<a HREF=\"list.php?page=".$previouspage."\">Next 30</a>";
if (($page>0) && ($page<$maxpages1)) echo " ";
if ($page<$maxpages1) echo "<a HREF=\"list.php?page=".$nextpage."\">Previous 30</a>";
echo "</b></font></td></tr>";
}

echo "</table>";
include("/home/mediarch/foot.php");
?>



