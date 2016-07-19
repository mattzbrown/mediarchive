<?
$pagetitle="User Preferences";
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
function varcheck($val) {
$val=htmlentities($val);
$val=@str_replace("!", "&", $val);
$val=@str_replace("$", "&", $val);
$val=@str_replace("%", "&", $val);
$val=@str_replace("'", "&", $val);
$val=@str_replace("(", "&", $val);
$val=@str_replace(")", "&", $val);
$val=@str_replace("*", "&", $val);
$val=@str_replace("+", "&", $val);
$val=@str_replace(",", "&", $val);
$val=@str_replace(".", "&", $val);
$val=@str_replace("/", "&", $val);
$val=@str_replace(":", "&", $val);
$val=@str_replace(";", "&", $val);
$val=@str_replace("=", "&", $val);
$val=@str_replace("?", "&", $val);
$val=@str_replace("@", "&", $val);
$val=@str_replace("[", "&", $val);
$val=@str_replace("]", "&", $val);
$val=@str_replace("^", "&", $val);
$val=@str_replace("_", "&", $val);
$val=@str_replace("`", "&", $val);
$val=@str_replace("{", "&", $val);
$val=@str_replace("}", "&", $val);
$val=@str_replace("|", "&", $val);
$val=@str_replace("~", "&", $val);
$val=@str_replace("\\", "&", $val);
if ((eregi("&",$val)>=1) || (strlen($val)>20) || (!$val)) {
	return 0;
} else {
	return 1;
}
}
$username=auth($uname,$pword);
if (!$username)
{
echo "<table border=0 width=100%>

<tr><td>You must be <a HREF=\index.php\">logged in</a> to view this page.</td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
if ($myrow["level"]<0)
{
echo "<table border=0 width=100%>

<tr><td>You are not authorized to view this page.</td></tr>
</table>

";
include("/home/mediarch/foot.php");
exit;
}
echo "<table border=1 cellspacing=0 width=100%>
<tr><td COLSPAN=3 align=center><font SIZE=6><b>Theme Settings</b></font></td></tr>";

echo "<tr><td COLSPAN=2 CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo " | <a HREF=\"user.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\" CLASS=MENU>User Info Page</a>";
echo "</i></font></td></tr>";
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$userid=$myrow["userid"];
if ($pre) {
$sql="SELECT * FROM styles WHERE styleid=$pre";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
}
if (($post) && ((($type==1) && ($pre)) || (($type==2)))) {
	if (($type==1) && ($pre) && ($numrows)) {
		$sql="UPDATE users SET custom=0 WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET theme='".$pre."' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET bodybgcolor='' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET fontfamily='' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET fontcolor='' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET nlink='' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET nvisited='' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET link='' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET visited='' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET active='' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET hover='' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET cell1='' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET cell1f='' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET cell2='' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET cell2f='' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET cell3='' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET cell4='' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET sys='' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET shade='' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET darksys='' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET bar='' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET barf='' WHERE userid=$userid";
		$result=mysql_query($sql);
		echo "<tr><td COLSPAN=2 ALIGN=CENTER><b>Your user preferences have been successfully updated.</b></td></tr>";
	} else if (($type==1) && ($pre) && (!$numrows)) {
		echo "<tr><td COLSPAN=2 ALIGN=CENTER><b>There were errors updating your preferences:</b><br> The theme you entered is invalid.</td></tr>";
	} else if (($type==2) && (varcheck($bodybgcolor)>=1) && (varcheck($fontfamily)>=1) && (varcheck($fontcolor)>=1) && (varcheck($nlink)>=1) && (varcheck($nvisited)>=1) && (varcheck($link)>=1) && (varcheck($visited)>=1) && (varcheck($active)>=1) && (varcheck($hover)>=1) && (varcheck($cell1)>=1) && (varcheck($cell1f)>=1) && (varcheck($cell2)>=1) && (varcheck($cell2f)>=1) && (varcheck($cell3)>=1) && (varcheck($cell4)>=1) && (varcheck($sys)>=1) && (varcheck($shade)>=1) && (varcheck($darksys)>=1) && (varcheck($bar)>=1) && (varcheck($barf)>=1)) 	{
		$sql="UPDATE users SET custom=1 WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET theme=0 WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET bodybgcolor='$bodybgcolor' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET fontfamily='$fontfamily' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET fontcolor='$fontcolor' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET nlink='$nlink' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET nvisited='$nvisited' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET link='$link' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET visited='$visited' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET active='$active' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET hover='$hover' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET cell1='$cell1' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET cell1f='$cell1f' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET cell2='$cell2' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET cell2f='$cell2f' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET cell3='$cell3' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET cell4='$cell4' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET sys='$sys' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET shade='$shade' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET darksys='$darksys' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET bar='$bar' WHERE userid=$userid";
		$result=mysql_query($sql);
		$sql="UPDATE users SET barf='$barf' WHERE userid=$userid";
		$result=mysql_query($sql);
		echo "<tr><td COLSPAN=2 ALIGN=CENTER><b>Your user preferences have been successfully updated.</b></td></tr>";
	} else if (($type==2) && ((varcheck($bodybgcolor)<=0) || (varcheck($fontfamily)<=0) || (varcheck($fontcolor)<=0) || (varcheck($nlink)<=0) || (varcheck($nvisited)<=0) || (varcheck($link)<=0) || (varcheck($visited)<=0) || (varcheck($active)<=0) || (varcheck($hover)<=0) || (varcheck($cell1)<=0) || (varcheck($cell1f)<=0) || (varcheck($cell2)<=0) || (varcheck($cell2f)<=0) || (varcheck($cell3)<=0) || (varcheck($cell4)<=0) || (varcheck($sys)<=0) || (varcheck($shade)<=0) || (varcheck($darksys)<=0) || (varcheck($bar)<=0) || (varcheck($barf)<=0))) {
		echo "<tr><td COLSPAN=2 ALIGN=CENTER><b>There were errors updating your preferences:</b><br> One of the custom values you entered is either blank, too long, or contains illegal characters. The maximum length for a value is 20, and the only allowed characters are letters a-z, numbers 0-9, the number sign (#), and hyphens (-).</td></tr>";
		}
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
echo "
<tr><td COLSPAN=2 CLASS=DARK ALIGN=CENTER><font SIZE=3>Change User Settings for ".$myrow["username"]."</font></td></tr>

";

$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);

echo "<form ACTION=\"pref4.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" METHOD=POST>

<tr><td COLSPAN=2 CLASS=LITE ALIGN=center><i>Theme Type</i></td></tr>
<tr><td><input type=\"radio\" name=\"type\" value=\"1\"";
if ($myrow["custom"]==0) { echo " checked"; }
echo " /> Premade Theme</td><td><select name=pre size=6>";
$sql="SELECT * FROM styles WHERE styleid=".$myrow["theme"]."";
$result2=mysql_query($sql);
$myrow2=@mysql_fetch_array($result2);
if ($myrow["custom"]==0) {
echo "<option value=\"".$myrow2["styleid"]."\">".$myrow2["name"]." (Current)</option>
";
}
$sql="SELECT * FROM styles ORDER BY styleid ASC";
$result2=mysql_query($sql);
while ($myrow2=@mysql_fetch_array($result2)) {
echo "<option value=\"".$myrow2["styleid"]."\">".$myrow2["name"]."</option>
";
}
echo "</select></td></tr>
<tr><td COLSPAN=2><input type=\"radio\" name=\"type\" value=\"2\"";
if ($myrow["custom"]==1) { echo " checked"; }
echo " /> Custom Theme</td></tr>
<tr><td COLSPAN=2 CLASS=LITE ALIGN=center><i>Custom Theme</i></td></tr>
</table>
<table border=0 cellspacing=0 cellpadding=0 width=100%>
<tr><td width=60%>
<table border=1 cellspacing=0 width=100%>
<tr><td>Main Background Color</td><td><input type=\"text\" name=\"bodybgcolor\" size=\"20\" maxlength=\"20\" value=\"".$myrow["bodybgcolor"]."\" /></td></tr>
<tr><td>Main Font Face</td><td><input type=\"text\" name=\"fontfamily\" size=\"20\" maxlength=\"20\" value=\"".$myrow["fontfamily"]."\" /></td></tr>
<tr><td>Main Font Color</td><td><input type=\"text\" name=\"fontcolor\" size=\"20\" maxlength=\"20\" value=\"".$myrow["fontcolor"]."\" /></td></tr>
<tr><td>Normal Link Color</td><td><input type=\"text\" name=\"nlink\" size=\"20\" maxlength=\"20\" value=\"".$myrow["nlink"]."\" /></td></tr>
<tr><td>Visited Link Color</td><td><input type=\"text\" name=\"nvisited\" size=\"20\" maxlength=\"20\" value=\"".$myrow["nvisited"]."\" /></td></tr>
<tr><td>Normal Menu Link Color</td><td><input type=\"text\" name=\"link\" size=\"20\" maxlength=\"20\" value=\"".$myrow["link"]."\" /></td></tr>
<tr><td>Visited Menu Link Color</td><td><input type=\"text\" name=\"visited\" size=\"20\" maxlength=\"20\" value=\"".$myrow["visited"]."\" /></td></tr>
<tr><td>Active Menu Link Color</td><td><input type=\"text\" name=\"active\" size=\"20\" maxlength=\"20\" value=\"".$myrow["active"]."\" /></td></tr>
<tr><td>Hover Menu Link Color</td><td><input type=\"text\" name=\"hover\" size=\"20\" maxlength=\"20\" value=\"".$myrow["hover"]."\" /></td></tr>
<tr><td>Cell 1 Background Color</td><td><input type=\"text\" name=\"cell1\" size=\"20\" maxlength=\"20\" value=\"".$myrow["cell1"]."\" /></td></tr>
<tr><td>Cell 1 Font Color</td><td><input type=\"text\" name=\"cell1f\" size=\"20\" maxlength=\"20\" value=\"".$myrow["cell1f"]."\" /></td></tr>
<tr><td>Cell 2 Background Color</td><td><input type=\"text\" name=\"cell2\" size=\"20\" maxlength=\"20\" value=\"".$myrow["cell2"]."\" /></td></tr>
<tr><td>Cell 2 Font Color</td><td><input type=\"text\" name=\"cell2f\" size=\"20\" maxlength=\"20\" value=\"".$myrow["cell2f"]."\" /></td></tr>
<tr><td>Cell 3 Background Color</td><td><input type=\"text\" name=\"cell3\" size=\"20\" maxlength=\"20\" value=\"".$myrow["cell3"]."\" /></td></tr>
<tr><td>Cell 4 Background Color</td><td><input type=\"text\" name=\"cell4\" size=\"20\" maxlength=\"20\" value=\"".$myrow["cell4"]."\" /></td></tr>
<tr><td>System Background Color</td><td><input type=\"text\" name=\"sys\" size=\"20\" maxlength=\"20\" value=\"".$myrow["sys"]."\" /></td></tr>
<tr><td>Dark System Background Color</td><td><input type=\"text\" name=\"darksys\" size=\"20\" maxlength=\"20\" value=\"".$myrow["darksys"]."\" /></td></tr>
<tr><td>Shade Background Color</td><td><input type=\"text\" name=\"shade\" size=\"20\" maxlength=\"20\" value=\"".$myrow["shade"]."\" /></td></tr>
<tr><td>Top Navigation Bar Background Color</td><td><input type=\"text\" name=\"bar\" size=\"20\" maxlength=\"20\" value=\"".$myrow["bar"]."\" /></td></tr>
<tr><td>Top Navigation Bar Font Color</td><td><input type=\"text\" name=\"barf\" size=\"20\" maxlength=\"20\" value=\"".$myrow["barf"]."\" /></td></tr>
</table></td><td valign=top><table border=1 cellspacing=0 width=100%>
<tr><td CLASS=DARK>Cell 1</td></tr>
<tr><td CLASS=LITE>Cell 2</td></tr>
<tr><td CLASS=CELL2>Cell 3</td></tr>
<tr><td CLASS=CELL1>Cell 4</td></tr>
<tr><td CLASS=SYS>System</td></tr>
<tr><td CLASS=DARKSYS>Dark System</td></tr>
<tr><td CLASS=SHADE>Shade</td></tr>
<tr><td>Normal Text</td></tr>
<tr><td><a href=\"pref4.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">Normal Link</a></td></tr>
<tr><td CLASS=DARK><a CLASS=MENU href=\"pref4.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\">Menu Link</a></td></tr>
</table></td></tr>
</table>
<table border=1 cellspacing=0 width=100%>

<tr><td ALIGN=CENTER COLSPAN=2><input type=\"submit\" value=\"Make Changes\" name=\"post\"><input type=\"reset\" value=\"Reset\" name=\"reset\">
</td></tr>
</form>

</table>
";
include("/home/mediarch/foot.php");
?>