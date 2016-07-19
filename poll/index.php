<?
$pagetitle="Poll of the Day";
include("/home/mediarch/head.php");
echo $harsss;
$sql="SELECT * FROM pollques ORDER BY pollid DESC LIMIT 0, 1";
$result=mysql_query($sql);
$result=@mysql_fetch_array($result);
$lastpoll=$myrow["pollid"];
if (!$poll) {
$poll=$lastpoll;
}
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
$sql="SELECT * FROM pollsel WHERE `order`=$opt AND pollid=$poll";
$resultd=mysql_query($sql);
$resultd=@mysql_num_rows($resultd);
$sql="SELECT * FROM pollques ORDER BY pollid DESC LIMIT 0, 1";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$lastp=$myrow["pollid"];
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$uuname=$myrow["username"];
$sql="SELECT * FROM pollsel WHERE pollid=$poll ORDER BY `order` DESC LIMIT 0, 1";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$lastop=$myrow["order"];
echo "<table border=0 width=100%>
<tr><td COLSPAN=4 align=center><font SIZE=6 FACE=Arial><b>Poll of the Day</b></font></td></tr>
<tr><td COLSPAN=4 align=center><font SIZE=4 FACE=Arial><b>";
$sql="SELECT * FROM pollques WHERE pollid=$poll";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
echo "".stripslashes(stripslashes($myrow["val"]))."</b></font></td></tr>";
if (($submit) && ($opt) && ($opt>0) && ($opt<=$lastop) && ($lastp==$poll)) {
if ($username) {
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$useid=$myrow["userid"];
$sql="SELECT * FROM polluser WHERE userid='$useid'";
$result=mysql_query($sql);
$result=@mysql_num_rows($result);
if ($result) {
echo "
<tr><td align=center colspan=4><font SIZE=3><b>A vote from this registered user ($uuname) has already been submitted. One vote per user, sorry!</b></font></td></tr>";
} else if ((!$result) && ($resultd)) {
$sql="SELECT * FROM pollsel WHERE `order`=$opt AND pollid=$poll";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$votess=$myrow["votes"]+1;
$sql="UPDATE pollsel SET `votes`=$votess WHERE `order`=$opt AND `pollid`=$poll";
$result=mysql_query($sql);
$sql="INSERT INTO polluser (pollid,userid) VALUES ('$poll','$useid')";
$result=mysql_query($sql);
$sql="INSERT INTO pollip (pollid,ip) VALUES ('$poll','$REMOTE_ADDR')";
$result=mysql_query($sql);
echo "
<tr><td align=center colspan=4><font SIZE=3><b>Vote Submitted</b></font></td></tr>";
}
} else if (!$username) {
$sql="SELECT * FROM pollip WHERE ip='$REMOTE_ADDR'";
$result=mysql_query($sql);
$result=@mysql_num_rows($result);
if ($result) {
echo "
<tr><td align=center colspan=4><font SIZE=3><b>A vote from this IP address has already been submitted. To avoid this, <a href=\"register.php\">register</a> a message board account.</b></font></td></tr>";
} else if ((!$result) && ($resultd)) {
$sql="SELECT * FROM pollsel WHERE `order`=$opt AND pollid=$poll";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$votess=$myrow["votes"]+1;
$sql="UPDATE pollsel SET `votes`=$votess WHERE `order`=$opt AND `pollid`=$poll";
$result=mysql_query($sql);
$sql="INSERT INTO pollip (pollid,ip) VALUES ('$poll','$REMOTE_ADDR')";
$result=mysql_query($sql);
echo "
<tr><td align=center colspan=4><font SIZE=3><b>Vote Submitted</b></font></td></tr>";
}
}
}
$sql="SELECT * FROM pollsel WHERE pollid=$poll";
$result=mysql_query($sql);
$totalvotes=0;
while ($myrow=@mysql_fetch_array($result)) {
$totalvotes=$totalvotes+$myrow["votes"];
}
$sql="SELECT * FROM pollsel WHERE pollid=$poll ORDER BY pollselid ASC";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
if ($myrow["votes"]>0) {
$percent=$myrow["votes"]/$totalvotes;
$percent2=$percent*100;
$percent4=$percent2*5;
$percent4=round($percent4);
} else {
$percent=0;
$percent2=0;
$percent4=0;
}
$percent3=number_format($percent2, "2", ".", "");
echo "<tr><td width=45%><font SIZE=2 FACE=Arial><b>".$myrow["val"]."</b></font></td><td width=10%><font SIZE=2 FACE=Arial><b>".$percent3."%</b></font></td><td width=500><img SRC=\"pollbar.gif\" WIDTH=".$percent4." HEIGHT=25></td><td width=10%><font SIZE=2 FACE=Arial><b>".$myrow["votes"]."</b></font></td></tr>";
}
echo "<tr><td COLSPAN=3><font SIZE=2 FACE=Arial><b>TOTAL VOTES</b></font></td><td><font SIZE=2 FACE=Arial><b>$totalvotes</b></font></td></tr>

<tr><td COLSPAN=4 align=center><font SIZE=3 FACE=Arial><b>";
$sql="SELECT * FROM pollques ORDER BY pollid DESC LIMIT 0, 1";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$lastpoll=$myrow["pollid"];
$prevpoll=$poll-1;
$nextpoll=$poll+1;
if ($poll>1) {
echo "<a HREF=\"index.php?poll=$prevpoll\">Previous Poll</a> | ";
}
echo "<a HREF=\"list.php\">List of All Polls</a>";
if ($poll<$lastpoll) {
echo " | <a HREF=\"index.php?poll=$nextpoll\">Next Poll</a>";
}

echo "<tr><td COLSPAN=4 align=center><font SIZE=2 FACE=Arial><b>Discuss today's poll and previous polls on the <a HREF=\"/boards/gentopic.php?board=3\">Poll of the Day</a> Message Board.</b></font></td></tr>

</table>
";
include("/home/mediarch/foot.php");
?>
