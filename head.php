<?
$db=mysql_connect("localhost","mediarch_jay","qecsw5") or exit("<html>\n<head>\n<title>Error</title>\n</head><body>\nMySQL connection failed. Please wait for a few moments, as the error will be fixed shortly.</body>\n</html>");
mysql_select_db("mediarch_jay",$db);
// LEVEL DEFINITIONS
define("LEVEL_CLOSED",-4);
define("LEVEL_PENCLOSE",-3);
define("LEVEL_BANNED",-2);
define("LEVEL_SUSPEND",-1);
define("LEVEL_INACT",0);
define("LEVEL_PENREV",4);
define("LEVEL_WARNED",5);
define("LEVEL_PROV1",10);
define("LEVEL_PROV2",11);
define("LEVEL_NEW1",15);
define("LEVEL_NEW2",20);
define("LEVEL_NEW3",25);
define("LEVEL_REG",30);
define("LEVEL_VET",31);
define("LEVEL_LEGEND",32);
define("LEVEL_ELITE",33);
define("LEVEL_ICON",34);
define("LEVEL_IDOL",35);
define("LEVEL_NEWMOD",50);
define("LEVEL_GENMOD",51);
define("LEVEL_SPECMOD",52);
define("LEVEL_LEADMOD",53);
define("LEVEL_ADMIN",60);
$ops=mysql_fetch_array(mysql_query("SELECT `creyear`,`announcement`,`sitetitle` FROM `strings` LIMIT 0, 1"));
$creyear=$ops["creyear"];
$announcement=$ops["announcement"];
$sitetitle=$ops["sitetitle"];
if (!$creyear) {
	$creyear=date("Y");
	$result=mysql_query("UPDATE `strings` SET `creyear` = '".$creyear."'");
}
$curyear = date("Y");
function auth2($userid, $password) {
	$r=mysql_query("SELECT `username`, `userpass` FROM `users` WHERE `username` = '".$userid."'");
	if (@mysql_num_rows($r) >= 1) {
		$u = @mysql_fetch_array($r);
		if ($password == $u["userpass"]) return 1; else return 0;
	} else return 0;
}
function querystring($board,$topic) {
	$str = "";
	if (($board) || ($topic)) $str .= "?";
	if ($board) $str .= "board=".$board;
	if (($board) && ($topic)) $str .= "&";
	if ($topic) $str .= "topic=".$topic;
	return $str;
}
function querystring2($board,$topic) {
	$str = "";
	if (($board) || ($topic)) $str .= "&";
	if ($board) $str .= "board=".$board;
	if (($board) && ($topic)) $str .= "&";
	if ($topic) $str .= "topic=".$topic;
	return $str;
}
$uname="";
$pword="";
if (($auname) && ($apword)) {
	$uname=$_COOKIE["auname"];
	$pword=$_COOKIE["apword"];
}
if (($luname) && ($lpword)) {
	$uname=$_COOKIE["luname"];
	$pword=$_COOKIE["lpword"];
}
$authwa=auth2($uname,$pword);
if (!$authwa)
{
$custom=0;
$theme=1;
$barshow=1;
$time_offset=0;
} else if ($authwa) {
$datedate=date("n/j/Y H:i:s");
$timetime=time();
$result=mysql_query("UPDATE `users` SET `agent` = '".htmlentities($HTTP_USER_AGENT)."', `lastacip` = '".$REMOTE_ADDR."' WHERE `username` = '".$uname."'");
$newtime=time()-600;
if (auth2($luname,$lpword)) {
setcookie ("luname", $luname, time()+600, "/", $HTTP_HOST, 0);
setcookie ("lpword", $lpword, time()+600, "/", $HTTP_HOST, 0);
}
$myrow=@mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `username`='".$uname."'"));
$sql="SELECT * FROM protected WHERE userid='".$myrow["userid"]."'";
$result2=mysql_query($sql);
$protectsuspend=0;
if (mysql_num_rows($result2)>=1) {
while ($myrow2=@mysql_fetch_array($result2)) {
if ((eregi($myrow2["ip"]," ".$REMOTE_ADDR." ")<=0) && ($protectsuspend==0)) {
	$protectsuspend=1;
} else {
$protectsuspend=0;
}
}
}
if (($protectsuspend==1) && ($myrow["level"]>-1)) {
$sql="UPDATE users SET level='-1' WHERE username='$uname'";
$result=mysql_query($sql);
$sql="SELECT * FROM topics ORDER BY topicid DESC LIMIT 0, 1";
$result3=mysql_query($sql);
$myrow3=mysql_fetch_array($result3);
$topicid=$myrow3["topicid"]+1;
$sql="SELECT * FROM messages ORDER BY messageid DESC LIMIT 0, 1";
$result3=mysql_query($sql);
$myrow3=mysql_fetch_array($result3);
$messageid=$myrow3["messageid"]+1;
$time=time();
$datedate=date("n/j/Y h:i:s A");
$mess="<b>Username:</b> ".$myrow["username"]."<br />
<br />
<b>Signature:</b> ".$myrow["sig"]."<br />
<br />
<b>Quote:</b> ".$myrow["quote"]."<br />
<br />
<b>Public E-Mail Address:</b> ".$myrow["email2"]."<br />
<br />
<b>IM:</b> ";
if ($myrow["imtype"] == 1) {
$mess .= "AIM: ".$myrow["im"]."";
}
if ($myrow["imtype"] == 2) {
$mess .= "ICQ: ".$myrow["im"]."";
}
if ($myrow["imtype"] == 3) {
$mess .= "MSN: ".$myrow["im"]."";
}
if ($myrow["imtype"] == 4) {
$mess .= "YIM: ".$myrow["im"]."";
}
$mess .= "<br />";
$sql="INSERT INTO modded (boardid,topic,origtopic,topicid,messageid,modbod,modsec,moddate,postsec,postdate,moduser,modby,action,reason) VALUES ('98','Generated Message For ".$myrow["username"]."','1','$topicid','$messageid','$mess','$time','$datedate','$time','$datedate','".$myrow["userid"]."','".$myrow["userid"]."','10','10')";
$result=mysql_query($sql);
}
if ($myrow["defsec"]<$newtime) {
$sql="UPDATE users SET lastactivity='$datedate' WHERE username='$uname'";
$result=mysql_query($sql);
$sql="UPDATE users SET lastsec='$timetime' WHERE username='$uname'";
$result=mysql_query($sql);
}
$sql="UPDATE users SET defsec='$timetime' WHERE username='$uname'";
$result=mysql_query($sql);
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$userlevel=$myrow["level"];
$myuseid=$myrow["userid"];
$custom=$myrow["custom"];
$theme=$myrow["theme"];
$barshow=$myrow["barshow"];
$time_offset = ($myrow["timezone"]*3600);
}
$harsss="<html><head>\n<title>$sitetitle";
if ($pagetitle=="db contributor") {
$sql="SELECT * FROM contributor WHERE id='$id'";
$result2=mysql_query($sql);
$numrows=@mysql_num_rows($result2);
$my_row=@mysql_fetch_array($result2);
$sql="SELECT * FROM contributed WHERE reviewer='".$my_row["contribname"]."' AND accepted>=1";
$result=mysql_query($sql);
$numrows2=@mysql_num_rows($result);
if (($numrows>=1) && ($numrows2>=1)) {
	$pagetitle=$my_row["contribname"];
} else {
	$pagetitle="Contributor Recognition";
}
}
if ($pagetitle=="db review") {
$sql="SELECT * FROM contributed WHERE reviewid='$id' AND accepted>=1";
$result2=mysql_query($sql);
$numrows=@mysql_num_rows($result2);
$my_row=@mysql_fetch_array($result2);
if ($numrows>=1) {
	$pagetitle=stripslashes($my_row["name"])." - Reader Review";
} else {
	$pagetitle="Reader Review";
}
}
if ($pagetitle) {
$harsss.=": ".$pagetitle;
}
$harsss.="</title>\n";
if ($custom==0) {
$sql="SELECT * FROM styles WHERE styleid=$theme";
$results=mysql_query($sql);
$myrows=@mysql_fetch_array($results);
$harsss.="<link rel=\"stylesheet\" type=\"text/css\" href=\"/include/".$myrows["link"]."\" />\n";
} else if ($custom==1) {
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$harsss.="<style type=\"text/css\"><!--
body {margin-top: 0em; margin-right: 0em; margin-bottom: 0em; margin-left: 0em; font-family: ".$myrow["fontfamily"]."; background-color: ".$myrow["bodybgcolor"]."; color: ".$myrow["fontcolor"]."; }
a:link {color: ".$myrow["nlink"]."; }
a:visited {color: ".$myrow["nvisited"]."; }
a.MENU:link {text-decoration: underline; color: ".$myrow["link"]."; } 
a.MENU:visited {text-decoration: underline; color: ".$myrow["visited"]."; } 
a.MENU:active {text-decoration: underline; color: ".$myrow["active"]."; } 
a.MENU:hover {text-decoration: underline; color: ".$myrow["hover"]."; }
td {font-family: ".$myrow["fontfamily"]."; font-size: 80%; color: ".$myrow["fontcolor"]."; }
td.DARK {background: ".$myrow["cell1"]."; text-decoration: bold; font-size: 95%; color: ".$myrow["cell1f"]."; font-weight: bold; }
td.LITE {background: ".$myrow["cell2"]."; text-decoration: bold; font-size: 95%; color: ".$myrow["cell2f"]."; font-weight: bold; }
td.CELL1 {background: ".$myrow["cell4"]."; }
td.CELL2 {background: ".$myrow["cell3"]."; }
td.SYS {background: ".$myrow["sys"]."; }
td.DARKSYS {background: ".$myrow["darksys"]."; }
td.SHADE {background: ".$myrow["shade"]."; }
td.BAR {background: ".$myrow["bar"]."; color: ".$myrow["barf"]."; }
//--></style>\n";
}
$harsss.="<meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\" />\n</head><body>\n";
if ($barshow>=1) {
	$harsss.="<table border=0 cellspacing=0 cellpadding=0 width=100%>";
	if ($authwa) {
		$harsss.="\n<form method=\"get\" action=\"/jump.php\">";
	}
	$harsss.="<tr><td valign=\"top\" align=\"center\" class=\"bar\" height=\"27\"><b>\n<a href=\"/\" class=\"menu\">Home</a> | \n<a href=\"/contribute/\" class=\"menu\">Contribute</a> | \n<a href=\"/contests/\" class=\"menu\">Contests</a> | \n<a href=\"/games/\" class=\"menu\">Video Games</a> | \n<a href=\"/video/\" class=\"menu\">Movies & T.V</a> | \n<a href=\"/music/\" class=\"menu\">Music</a> | \n<a href=\"/lit/\" class=\"menu\">Books</a> | \n<a href=\"/misc/\" class=\"menu\">Other</a> | \n<a href=\"/boards/\" class=\"menu\">Boards</a>";
	if ($authwa) {
		$harsss.=" | </font></b>\n<select size=\"1\" name=\"boardchange\" onChange=\"location=options[selectedIndex].value;\">\n<option value=\"/boards/bman.php\" selected=\"selected\">Favorite Boards...</option>";
		$sql="SELECT * FROM boards WHERE boardlevel<=$userlevel ORDER BY boardname ASC";
		$result=mysql_query($sql);
		while ($myrow=@mysql_fetch_array($result)) {
			$sql="SELECT * FROM favorites WHERE userid=$myuseid AND boardid=".$myrow["boardid"]."";
			$result2=mysql_query($sql);
			$numrows2=@mysql_num_rows($result2);
			if ($numrows2>=1) {
				$myrow2=@mysql_fetch_array($result2);
				$harsss.="\n<option value=\"/boards/gentopic.php?board=".$myrow["boardid"]."\">".$myrow["boardname"]."</option>";
			}
		}
		$harsss.="\n<option value=\"/boards/bman.php\">Board Manager</option>\n</select>\n<noscript><input type=\"submit\" value=\"Go\" /></noscript>";
	} else if (!$authwa) {
		$harsss.="</font></b>";
	}
	if ($authwa) {
		$harsss.="\n</form>";
	}
	$harsss.="\n</td></tr></table>\n\n";
}
?>