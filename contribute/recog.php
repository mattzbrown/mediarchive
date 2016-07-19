<?
$pagetitle="Contributor Recognition";
include("/home/mediarch/head.php");
echo $harsss;
?>
<table border=0 cellspacing=0 width=100%>
<tr><td align=center><font size=6><b><i>Contributor Recognition</i></b></font><br></td></tr></table>
<?
if (($alpha=="num") || ($alpha=="A") || ($alpha=="B") || ($alpha=="C") || ($alpha=="D") || ($alpha=="E") || ($alpha=="F") || ($alpha=="G") || ($alpha=="H") || ($alpha=="I") || ($alpha=="J") || ($alpha=="K") || ($alpha=="L") || ($alpha=="M") || ($alpha=="N") || ($alpha=="O") || ($alpha=="P") || ($alpha=="Q") || ($alpha=="R") || ($alpha=="S") || ($alpha=="T") || ($alpha=="U") || ($alpha=="V") || ($alpha=="W") || ($alpha=="X") || ($alpha=="Y") || ($alpha=="Z")) {
	echo "<table CELLSPACING=0 CELLPADDING=1 WIDTH=100%>";
	if ($alpha=="num") {
		echo "<tr><td CLASS=DARK COLSPAN=2 ALIGN=CENTER>".$sitetitle." Contributors by Alpha: 0</td></tr>";
		$sql="SELECT * FROM contributor WHERE contribname NOT LIKE 'A%' AND contribname NOT LIKE 'B%' AND contribname NOT LIKE 'C%' AND contribname NOT LIKE 'D%' AND contribname NOT LIKE 'E%' AND contribname NOT LIKE 'F%' AND contribname NOT LIKE 'G%' AND contribname NOT LIKE 'H%' AND contribname NOT LIKE 'I%' AND contribname NOT LIKE 'J%' AND contribname NOT LIKE 'K%' AND contribname NOT LIKE 'L%' AND contribname NOT LIKE 'M%' AND contribname NOT LIKE 'N%' AND contribname NOT LIKE 'O%' AND contribname NOT LIKE 'P%' AND contribname NOT LIKE 'Q%' AND contribname NOT LIKE 'R%' AND contribname NOT LIKE 'S%' AND contribname NOT LIKE 'T%' AND contribname NOT LIKE 'U%' AND contribname NOT LIKE 'V%' AND contribname NOT LIKE 'W%' AND contribname NOT LIKE 'X%' AND contribname NOT LIKE 'Y%' AND contribname NOT LIKE 'Z%' ORDER BY contribname ASC";
	} else {
		echo "<tr><td CLASS=DARK COLSPAN=2 ALIGN=CENTER>".$sitetitle." Contributors by Alpha: ".strtoupper($alpha)."</td></tr>";
		$sql="SELECT * FROM contributor WHERE contribname LIKE '$alpha%' ORDER BY contribname ASC";
	}
$result=mysql_query($sql);
$revuser=" ";
while ($myrow=@mysql_fetch_array($result)) {
	$totalsize=0;
	$sql="SELECT * FROM contributed WHERE reviewer='".$myrow["contribname"]."' AND accepted>=1";
	$result2=mysql_query($sql);
	if (mysql_num_rows($result2)>=1) {
		$revuser.=$myrow["id"]." ";
	}
}
$revuser=trim($revuser);
$revuser=explode(" ",$revuser);
if (count($revuser)>0) {
	$half=ceil(count($revuser)/2);
	echo "<tr><td VALIGN=TOP WIDTH=50%>";
	while (list($key, $val) = each($revuser)) {
		if (($key>=0) && ($key<$half) && ($val)) {
			$sql="SELECT * FROM contributor WHERE id=$val";
			$result=mysql_query($sql);
			$myrow=@mysql_fetch_array($result);
			echo "<a HREF=\"recognition.php?id=$val\">".$myrow["contribname"]."</a>";
			if ($myrow["contribfull"]) { echo " (".stripslashes($myrow["contribfull"]).")"; }
			echo "<br>";
		}
	}
	echo "</td><td VALIGN=TOP WIDTH=50%>";
	reset($revuser);
	while (list($key, $val) = each($revuser)) {
		if (($key>=$half) && ($val)) {
			$sql="SELECT * FROM contributor WHERE id=$val";
			$result=mysql_query($sql);
			$myrow=@mysql_fetch_array($result);
			echo "<a HREF=\"recognition.php?id=$val\">".$myrow["contribname"]."</a>";
			if ($myrow["contribfull"]) { echo " (".stripslashes($myrow["contribfull"]).")"; }
			echo "<br>";
		}
	}
	echo "</td></tr>";
}
	echo "</table>";
	include("/home/mediarch/foot.php");
	exit;
}
?>
<table CELLSPACING=0 CELLPADDING=1 WIDTH=100%>
<tr><td COLSPAN=2 ALIGN=CENTER CLASS=DARK><? echo $sitetitle; ?> Contributors by Alpha</td></tr>

<tr><td COLSPAN=2 ALIGN=CENTER><a HREF="recog.php?alpha=num">0</a> <a HREF="recog.php?alpha=A">A</a> <a HREF="recog.php?alpha=B">B</a> <a HREF="recog.php?alpha=C">C</a> <a HREF="recog.php?alpha=D">D</a> <a HREF="recog.php?alpha=E">E</a> <a HREF="recog.php?alpha=F">F</a> <a HREF="recog.php?alpha=G">G</a> <a HREF="recog.php?alpha=H">H</a> <a HREF="recog.php?alpha=I">I</a> <a HREF="recog.php?alpha=J">J</a> <a HREF="recog.php?alpha=K">K</a> <a HREF="recog.php?alpha=L">L</a> <a HREF="recog.php?alpha=M">M</a> <a HREF="recog.php?alpha=N">N</a> <a HREF="recog.php?alpha=O">O</a> <a HREF="recog.php?alpha=P">P</a> <a HREF="recog.php?alpha=Q">Q</a> <a HREF="recog.php?alpha=R">R</a> <a HREF="recog.php?alpha=S">S</a> <a HREF="recog.php?alpha=T">T</a> <a HREF="recog.php?alpha=U">U</a> <a HREF="recog.php?alpha=V">V</a> <a HREF="recog.php?alpha=W">W</a> <a HREF="recog.php?alpha=X">X</a> <a HREF="recog.php?alpha=Y">Y</a> <a HREF="recog.php?alpha=Z">Z</a> </td></tr>
<tr><td COLSPAN=2 ALIGN=CENTER CLASS=DARK>Most Prolific Review Contributors (Over 10KB)</td></tr>
<?
$sql="SELECT * FROM contributor ORDER BY contribname ASC";
$result=mysql_query($sql);
$revuser=" ";
while ($myrow=@mysql_fetch_array($result)) {
	$totalsize=0;
	$sql="SELECT * FROM contributed WHERE reviewer='".$myrow["contribname"]."' AND accepted>=1";
	$result2=mysql_query($sql);
	while ($myrow2=@mysql_fetch_array($result2)) {
		$totalsize=$totalsize+strlen($myrow2["review"]);
	}
	if ($totalsize>=10240) {
		$revuser.=$myrow["id"]." ";
	}
}
$revuser=trim($revuser);
$revuser=explode(" ",$revuser);
if (count($revuser)>0) {
	$half=ceil(count($revuser)/2);
	echo "<tr><td VALIGN=TOP WIDTH=50%>";
	while (list($key, $val) = each($revuser)) {
		if (($key>=0) && ($key<$half) && ($val)) {
			$sql="SELECT * FROM contributor WHERE id=$val";
			$result=mysql_query($sql);
			$myrow=@mysql_fetch_array($result);
			echo "<a HREF=\"recognition.php?id=$val\">".$myrow["contribname"]."</a>";
			if ($myrow["contribfull"]) { echo " (".stripslashes($myrow["contribfull"]).")"; }
			echo "<br>";
		}
	}
	echo "</td><td VALIGN=TOP WIDTH=50%>";
	reset($revuser);
	while (list($key, $val) = each($revuser)) {
		if (($key>=$half) && ($val)) {
			$sql="SELECT * FROM contributor WHERE id=$val";
			$result=mysql_query($sql);
			$myrow=@mysql_fetch_array($result);
			echo "<a HREF=\"recognition.php?id=$val\">".$myrow["contribname"]."</a>";
			if ($myrow["contribfull"]) { echo " (".stripslashes($myrow["contribfull"]).")"; }
			echo "<br>";
		}
	}
	echo "</td></tr>";
}
?>
</table>
<?
include("/home/mediarch/foot.php");
?>