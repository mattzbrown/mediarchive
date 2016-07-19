<?
$pagetitle="Moderation Detail";
include("/home/mediarch/head.php");
echo $harsss;
echo "<table border=0 width=100%>

<tr><td align=center><font SIZE=6>Moderation Detail</font></td></tr>";
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
if (!$username)
{
echo "<tr><td>You are not authorized to view this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=mysql_fetch_array($result);
$userid=$myrow["userid"];
$level=$myrow["level"];
if ($level<50)
{
echo "<tr><td>You are not authorized to view this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
$usern=$myrow["username"];
echo "<tr><td COLSPAN=2 CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"/boards/gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"/boards/genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo " | <a HREF=\"/boards/whois.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Whois Page</a> | 
<a HREF=\"modhist.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Moderation List</a> |
<a HREF=\"index.php?user=$user";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Control Panel</a>
</i></font></td></tr>";

$sql="SELECT * FROM modded WHERE modid=$modid AND moduser=$user";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$numrows=@mysql_num_rows($result);
if ($numrows<=0) {

echo "<tr><td>An invalid link was used to access this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
if ($level<60) {
$sql="SELECT * FROM modded WHERE modid=$modid AND moduser=$user AND action>0";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$numrows=@mysql_num_rows($result);
if ($numrows<=0) {

echo "<tr><td>An invalid link was used to access this page.</td></tr>
</table>
";
include("/home/mediarch/foot.php");
exit;
}
}
$sql="SELECT * FROM modded WHERE modid=$modid";
$result2=mysql_query($sql);
$myrow=@mysql_fetch_array($result2);
$reecont=$myrow["recontbody"];
if ((($myrow["recont"]==4) || ($myrow["recont"]==9)) && ($level>=60) && ($appealed)) {
	$moduser=$myrow["moduser"];
	$sql="SELECT * FROM users WHERE userid=$moduser";
	$resultc=mysql_query($sql);
	$myrowc=@mysql_fetch_array($resultc);
	if ($appealed=="Uphold") {
		$sql="UPDATE modded SET recont=7 WHERE modid=$modid";
		$resultcont=mysql_query($sql);
	} else if ($appealed=="Overturn") {
		$sql="UPDATE modded SET recont=5 WHERE modid=$modid";
		$resultcont=mysql_query($sql);
		if (($myrow["action"]>=7) && ($myrow["action"]<=8)) {
			$karma=$myrowc["cookies"]+10;
			$sql="UPDATE users SET cookies=$karma WHERE userid=$moduser";
			$resultcont=mysql_query($sql);
			if (($myrowc["level"]>=5) && ($myrowc["level"]<40)) {
				if ($karma<0) {
					$sql="UPDATE users SET level=6 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=0) && ($karma<10)) {
					$sql="UPDATE users SET level=15 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=10) && ($karma<20)) {
					$sql="UPDATE users SET level=20 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=20) && ($karma<40)) {
					$sql="UPDATE users SET level=25 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=40) && ($karma<75)) {
					$sql="UPDATE users SET level=30 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=75) && ($karma<120)) {
					$sql="UPDATE users SET level=31 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=120) && ($karma<150)) {
					$sql="UPDATE users SET level=32 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=150) && ($karma<200)) {
					$sql="UPDATE users SET level=33 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=200) && ($karma<250)) {
					$sql="UPDATE users SET level=34 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if ($karma>=250) {
					$sql="UPDATE users SET level=35 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				}
			}
		} else if (($myrow["action"]>=5) && ($myrow["action"]<=6)) {
			$karma=$myrowc["cookies"]+3;
			$sql="UPDATE users SET cookies=$karma WHERE userid=$moduser";
			$resultcont=mysql_query($sql);
			if (($myrowc["level"]>=6) && ($myrowc["level"]<40)) {
				if ($karma<0) {
					$sql="UPDATE users SET level=6 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=0) && ($karma<10)) {
					$sql="UPDATE users SET level=15 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=10) && ($karma<20)) {
					$sql="UPDATE users SET level=20 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=20) && ($karma<40)) {
					$sql="UPDATE users SET level=25 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=40) && ($karma<75)) {
					$sql="UPDATE users SET level=30 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=75) && ($karma<120)) {
					$sql="UPDATE users SET level=31 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=120) && ($karma<150)) {
					$sql="UPDATE users SET level=32 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=150) && ($karma<200)) {
					$sql="UPDATE users SET level=33 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=200) && ($karma<250)) {
					$sql="UPDATE users SET level=34 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if ($karma>=250) {
					$sql="UPDATE users SET level=35 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				}
			}
		}
		if (($myrow["action"]==3) || ($myrow["action"]==5) || ($myrow["action"]==7)) {
			$sql="UPDATE messages SET messbody='".addslashes($myrow["modbod"])."' WHERE messageid=".$myrow["messageid"]."";
			$resultcont=mysql_query($sql);
		} else if (($myrow["action"]==4) || ($myrow["action"]==6) || ($myrow["action"]==8)) {
			$sql="SELECT * FROM deleted WHERE topic=".$myrow["topicid"]." ORDER BY messsec DESC LIMIT 0,1";
			$resultls=mysql_query($sql);
			$myrowls=@mysql_fetch_array($resultls);
			$sql="SELECT * FROM deleted WHERE topic=".$myrow["topicid"]." ORDER BY messsec ASC LIMIT 0,1";
			$resultfs=mysql_query($sql);
			$myrowfs=@mysql_fetch_array($resultfs);
			$sql="INSERT INTO topics (topicid,topicname,boardnum,topicby,timesec,active,postdate,topicsec) VALUES ('".$myrow["topicid"]."','".addslashes($myrow["topic"])."','".$myrow["boardid"]."','".$myrowc["username"]."','".$myrowls["messsec"]."','1','".eregi_replace(" ","&nbsp;",date("n/j/Y H:i",$myrowls["messsec"]))."','".$myrowfs["messsec"]."')";
			$resultcont=mysql_query($sql);
			$sql="SELECT * FROM deleted WHERE topic=".$myrow["topicid"]."";
			$resulttop=mysql_query($sql);
			while ($myrowtop=@mysql_fetch_array($resulttop)) {
				$sql="INSERT INTO messages (messageid,topic,messby,messsec,messbody,mesboard,postdate) VALUES ('".$myrowtop["messageid"]."','".$myrowtop["topic"]."','".$myrowtop["messby"]."','".$myrowtop["messsec"]."','".addslashes($myrowtop["messbody"])."','".$myrowtop["mesboard"]."','".$myrowtop["postdate"]."')";
				$resultcont=mysql_query($sql);
			}
		}
	} else if (($appealed=="Relax To Notification") && ($myrow["action"]>=7) && ($myrow["action"]<=8)) {
		$karma=$myrowc["cookies"]+7;
		$sql="UPDATE users SET cookies=$karma WHERE userid=$moduser";
		$resultcont=mysql_query($sql);
		if (($myrowc["level"]>=5) && ($myrowc["level"]<40)) {
			if ($karma<0) {
				$sql="UPDATE users SET level=6 WHERE userid=$moduser";
				$resultcont=mysql_query($sql);
			} else if (($karma>=0) && ($karma<10)) {
				$sql="UPDATE users SET level=15 WHERE userid=$moduser";
				$resultcont=mysql_query($sql);
			} else if (($karma>=10) && ($karma<20)) {
				$sql="UPDATE users SET level=20 WHERE userid=$moduser";
				$resultcont=mysql_query($sql);
			} else if (($karma>=20) && ($karma<40)) {
				$sql="UPDATE users SET level=25 WHERE userid=$moduser";
				$resultcont=mysql_query($sql);
			} else if (($karma>=40) && ($karma<75)) {
				$sql="UPDATE users SET level=30 WHERE userid=$moduser";
				$resultcont=mysql_query($sql);
			} else if (($karma>=75) && ($karma<120)) {
				$sql="UPDATE users SET level=31 WHERE userid=$moduser";
				$resultcont=mysql_query($sql);
			} else if (($karma>=120) && ($karma<150)) {
				$sql="UPDATE users SET level=32 WHERE userid=$moduser";
				$resultcont=mysql_query($sql);
			} else if (($karma>=150) && ($karma<200)) {
				$sql="UPDATE users SET level=33 WHERE userid=$moduser";
				$resultcont=mysql_query($sql);
			} else if (($karma>=200) && ($karma<250)) {
				$sql="UPDATE users SET level=34 WHERE userid=$moduser";
				$resultcont=mysql_query($sql);
			} else if ($karma>=250) {
				$sql="UPDATE users SET level=35 WHERE userid=$moduser";
				$resultcont=mysql_query($sql);
			}
		}
		$sql="UPDATE modded SET recont=6 WHERE modid=$modid";
		$resultcont=mysql_query($sql);
	} else if (($appealed=="Relax To No Karma Loss") && ($myrow["action"]>=5) && ($myrow["action"]<=8)) {
		if (($myrow["action"]>=7) && ($myrow["action"]<=8)) {
			$karma=$myrowc["cookies"]+10;
			$sql="UPDATE users SET cookies=$karma WHERE userid=$moduser";
			$resultcont=mysql_query($sql);
			if (($myrowc["level"]>=5) && ($myrowc["level"]<40)) {
				if ($karma<0) {
					$sql="UPDATE users SET level=6 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=0) && ($karma<10)) {
					$sql="UPDATE users SET level=15 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=10) && ($karma<20)) {
					$sql="UPDATE users SET level=20 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=20) && ($karma<40)) {
					$sql="UPDATE users SET level=25 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=40) && ($karma<75)) {
					$sql="UPDATE users SET level=30 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=75) && ($karma<120)) {
					$sql="UPDATE users SET level=31 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=120) && ($karma<150)) {
					$sql="UPDATE users SET level=32 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=150) && ($karma<200)) {
					$sql="UPDATE users SET level=33 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=200) && ($karma<250)) {
					$sql="UPDATE users SET level=34 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if ($karma>=250) {
					$sql="UPDATE users SET level=35 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				}
			}
		} else if (($myrow["action"]>=5) && ($myrow["action"]<=6)) {
			$karma=$myrowc["cookies"]+3;
			$sql="UPDATE users SET cookies=$karma WHERE userid=$moduser";
			$resultcont=mysql_query($sql);
			if (($myrowc["level"]>=6) && ($myrowc["level"]<40)) {
				if ($karma<0) {
					$sql="UPDATE users SET level=6 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=0) && ($karma<10)) {
					$sql="UPDATE users SET level=15 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=10) && ($karma<20)) {
					$sql="UPDATE users SET level=20 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=20) && ($karma<40)) {
					$sql="UPDATE users SET level=25 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=40) && ($karma<75)) {
					$sql="UPDATE users SET level=30 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=75) && ($karma<120)) {
					$sql="UPDATE users SET level=31 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=120) && ($karma<150)) {
					$sql="UPDATE users SET level=32 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=150) && ($karma<200)) {
					$sql="UPDATE users SET level=33 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=200) && ($karma<250)) {
					$sql="UPDATE users SET level=34 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if ($karma>=250) {
					$sql="UPDATE users SET level=35 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				}
			}
		}
		$sql="UPDATE modded SET recont=6 WHERE modid=$modid";
		$resultcont=mysql_query($sql);
	}
} else if (($myrow["contest"]==0) && ($myrow["contbody"]) && (!$reecont) && ($submit) && ($message)) {
	$message=htmlentities($message);
	$message=nl2br($message);
	$message=addslashes($message);
	$sql="UPDATE modded SET recontbody='$message' WHERE modid=$modid";
	$resultcont=mysql_query($sql);
	$time=time();
	$date=date("n/j/Y h:i:s A");
} else if (($myrow["contest"]==1) && ($myrow["contbody"]) && ($submit=="Submit") && ($message) && ($resp>=1) && ($resp<=4)) {
	$moduser=$myrow["moduser"];
	$message=htmlentities($message);
	$message=nl2br($message);
	$message=addslashes($message);
	$sql="UPDATE modded SET recontbody='$message' WHERE modid=$modid";
	$resultcont=mysql_query($sql);
	$sql="SELECT * FROM users WHERE userid=$moduser";
	$resultc=mysql_query($sql);
	$myrowc=@mysql_fetch_array($resultc);
	if ($resp<=1) {
		$sql="UPDATE modded SET recont=3 WHERE modid=$modid";
		$resultcont=mysql_query($sql);
	} else if ($resp==2) {
		$sql="UPDATE modded SET recont=1 WHERE modid=$modid";
		$resultcont=mysql_query($sql);
		if (($myrow["action"]>=7) && ($myrow["action"]<=8)) {
			$karma=$myrowc["cookies"]+10;
			$sql="UPDATE users SET cookies=$karma WHERE userid=$moduser";
			$resultcont=mysql_query($sql);
			if (($myrowc["level"]>=5) && ($myrowc["level"]<40)) {
				if ($karma<0) {
					$sql="UPDATE users SET level=6 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=0) && ($karma<10)) {
					$sql="UPDATE users SET level=15 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=10) && ($karma<20)) {
					$sql="UPDATE users SET level=20 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=20) && ($karma<40)) {
					$sql="UPDATE users SET level=25 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=40) && ($karma<75)) {
					$sql="UPDATE users SET level=30 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=75) && ($karma<120)) {
					$sql="UPDATE users SET level=31 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=120) && ($karma<150)) {
					$sql="UPDATE users SET level=32 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=150) && ($karma<200)) {
					$sql="UPDATE users SET level=33 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=200) && ($karma<250)) {
					$sql="UPDATE users SET level=34 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if ($karma>=250) {
					$sql="UPDATE users SET level=35 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				}
			}
		} else if (($myrow["action"]>=5) && ($myrow["action"]<=6)) {
			$karma=$myrowc["cookies"]+3;
			$sql="UPDATE users SET cookies=$karma WHERE userid=$moduser";
			$resultcont=mysql_query($sql);
			if (($myrowc["level"]>=6) && ($myrowc["level"]<40)) {
				if ($karma<0) {
					$sql="UPDATE users SET level=6 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=0) && ($karma<10)) {
					$sql="UPDATE users SET level=15 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=10) && ($karma<20)) {
					$sql="UPDATE users SET level=20 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=20) && ($karma<40)) {
					$sql="UPDATE users SET level=25 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=40) && ($karma<75)) {
					$sql="UPDATE users SET level=30 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=75) && ($karma<120)) {
					$sql="UPDATE users SET level=31 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=120) && ($karma<150)) {
					$sql="UPDATE users SET level=32 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=150) && ($karma<200)) {
					$sql="UPDATE users SET level=33 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=200) && ($karma<250)) {
					$sql="UPDATE users SET level=34 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if ($karma>=250) {
					$sql="UPDATE users SET level=35 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				}
			}
		}
		if (($myrow["action"]==3) || ($myrow["action"]==5) || ($myrow["action"]==7)) {
			$sql="UPDATE messages SET messbody='".addslashes($myrow["modbod"])."' WHERE messageid=".$myrow["messageid"]."";
			$resultcont=mysql_query($sql);
		} else if (($myrow["action"]==4) || ($myrow["action"]==6) || ($myrow["action"]==8)) {
			$sql="SELECT * FROM deleted WHERE topic=".$myrow["topicid"]." ORDER BY messsec DESC LIMIT 0,1";
			$resultls=mysql_query($sql);
			$myrowls=@mysql_fetch_array($resultls);
			$sql="SELECT * FROM deleted WHERE topic=".$myrow["topicid"]." ORDER BY messsec ASC LIMIT 0,1";
			$resultfs=mysql_query($sql);
			$myrowfs=@mysql_fetch_array($resultfs);
			$sql="INSERT INTO topics (topicid,topicname,boardnum,topicby,timesec,active,postdate,topicsec) VALUES ('".$myrow["topicid"]."','".addslashes($myrow["topic"])."','".$myrow["boardid"]."','".$myrowc["username"]."','".$myrowls["messsec"]."','1','".eregi_replace(" ","&nbsp;",date("n/j/Y H:i",$myrowls["messsec"]))."','".$myrowfs["messsec"]."')";
			$resultcont=mysql_query($sql);
			$sql="SELECT * FROM deleted WHERE topic=".$myrow["topicid"]."";
			$resulttop=mysql_query($sql);
			while ($myrowtop=@mysql_fetch_array($resulttop)) {
				$sql="INSERT INTO messages (messageid,topic,messby,messsec,messbody,mesboard,postdate) VALUES ('".$myrowtop["messageid"]."','".$myrowtop["topic"]."','".$myrowtop["messby"]."','".$myrowtop["messsec"]."','".addslashes($myrowtop["messbody"])."','".$myrowtop["mesboard"]."','".$myrowtop["postdate"]."')";
				$resultcont=mysql_query($sql);
			}
		}
	} else if (($resp==3) && ($myrow["action"]>=7) && ($myrow["action"]<=8)) {
		$karma=$myrowc["cookies"]+7;
		$sql="UPDATE users SET cookies=$karma WHERE userid=$moduser";
		$resultcont=mysql_query($sql);
		if (($myrowc["level"]>=5) && ($myrowc["level"]<40)) {
			if ($karma<0) {
				$sql="UPDATE users SET level=6 WHERE userid=$moduser";
				$resultcont=mysql_query($sql);
			} else if (($karma>=0) && ($karma<10)) {
				$sql="UPDATE users SET level=15 WHERE userid=$moduser";
				$resultcont=mysql_query($sql);
			} else if (($karma>=10) && ($karma<20)) {
				$sql="UPDATE users SET level=20 WHERE userid=$moduser";
				$resultcont=mysql_query($sql);
			} else if (($karma>=20) && ($karma<40)) {
				$sql="UPDATE users SET level=25 WHERE userid=$moduser";
				$resultcont=mysql_query($sql);
			} else if (($karma>=40) && ($karma<75)) {
				$sql="UPDATE users SET level=30 WHERE userid=$moduser";
				$resultcont=mysql_query($sql);
			} else if (($karma>=75) && ($karma<120)) {
				$sql="UPDATE users SET level=31 WHERE userid=$moduser";
				$resultcont=mysql_query($sql);
			} else if (($karma>=120) && ($karma<150)) {
				$sql="UPDATE users SET level=32 WHERE userid=$moduser";
				$resultcont=mysql_query($sql);
			} else if (($karma>=150) && ($karma<200)) {
				$sql="UPDATE users SET level=33 WHERE userid=$moduser";
				$resultcont=mysql_query($sql);
			} else if (($karma>=200) && ($karma<250)) {
				$sql="UPDATE users SET level=34 WHERE userid=$moduser";
				$resultcont=mysql_query($sql);
			} else if ($karma>=250) {
				$sql="UPDATE users SET level=35 WHERE userid=$moduser";
				$resultcont=mysql_query($sql);
			}
		}
		$sql="UPDATE modded SET recont=2 WHERE modid=$modid";
		$resultcont=mysql_query($sql);
	} else if (($resp==4) && ($myrow["action"]>=5) && ($myrow["action"]<=8)) {
		if (($myrow["action"]>=7) && ($myrow["action"]<=8)) {
			$karma=$myrowc["cookies"]+10;
			$sql="UPDATE users SET cookies=$karma WHERE userid=$moduser";
			$resultcont=mysql_query($sql);
			if (($myrowc["level"]>=5) && ($myrowc["level"]<40)) {
				if ($karma<0) {
					$sql="UPDATE users SET level=6 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=0) && ($karma<10)) {
					$sql="UPDATE users SET level=15 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=10) && ($karma<20)) {
					$sql="UPDATE users SET level=20 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=20) && ($karma<40)) {
					$sql="UPDATE users SET level=25 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=40) && ($karma<75)) {
					$sql="UPDATE users SET level=30 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=75) && ($karma<120)) {
					$sql="UPDATE users SET level=31 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=120) && ($karma<150)) {
					$sql="UPDATE users SET level=32 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=150) && ($karma<200)) {
					$sql="UPDATE users SET level=33 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=200) && ($karma<250)) {
					$sql="UPDATE users SET level=34 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if ($karma>=250) {
					$sql="UPDATE users SET level=35 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				}
			}
		} else if (($myrow["action"]>=5) && ($myrow["action"]<=6)) {
			$karma=$myrowc["cookies"]+3;
			$sql="UPDATE users SET cookies=$karma WHERE userid=$moduser";
			$resultcont=mysql_query($sql);
			if (($myrowc["level"]>=6) && ($myrowc["level"]<40)) {
				if ($karma<0) {
					$sql="UPDATE users SET level=6 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=0) && ($karma<10)) {
					$sql="UPDATE users SET level=15 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=10) && ($karma<20)) {
					$sql="UPDATE users SET level=20 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=20) && ($karma<40)) {
					$sql="UPDATE users SET level=25 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=40) && ($karma<75)) {
					$sql="UPDATE users SET level=30 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=75) && ($karma<120)) {
					$sql="UPDATE users SET level=31 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=120) && ($karma<150)) {
					$sql="UPDATE users SET level=32 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=150) && ($karma<200)) {
					$sql="UPDATE users SET level=33 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if (($karma>=200) && ($karma<250)) {
					$sql="UPDATE users SET level=34 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				} else if ($karma>=250) {
					$sql="UPDATE users SET level=35 WHERE userid=$moduser";
					$resultcont=mysql_query($sql);
				}
			}
		}
		$sql="UPDATE modded SET recont=2 WHERE modid=$modid";
		$resultcont=mysql_query($sql);
	}
	$time=time();
	$date=date("n/j/Y h:i:s A");
} else if (($myrow["contest"]==1) && ($myrow["contbody"]) && ($submit=="Contest Abuse")) {
	$sql="UPDATE modded SET recont='8' WHERE modid=$modid";
	$resultcont=mysql_query($sql);
} else if (($myrow["contest"]==1) && ($myrow["contbody"]) && ($submit=="Forward To Admin")) {
	$sql="UPDATE modded SET recont='9' WHERE modid=$modid";
	$resultcont=mysql_query($sql);
	$time=time();
	$sql="UPDATE modded SET appealsec=$time WHERE modid=$modid";
	$resultcont=mysql_query($sql);
}
$numrows=mysql_num_rows($result2);
$moduser=$myrow["moduser"];
$modby=$myrow["modby"];
$boardid=$myrow["boardid"];
$sql="SELECT * FROM users WHERE userid=$modby";
$resultc=mysql_query($sql);
$myrowc=@mysql_fetch_array($resultc);
$sql="SELECT * FROM users WHERE userid=$moduser";
$resulto=mysql_query($sql);
$myrowo=@mysql_fetch_array($resulto);
$sql="SELECT * FROM boards WHERE boardid=$boardid";
$resultx=mysql_query($sql);
$myrowx=@mysql_fetch_array($resultx);
$boardn=$myrowx["boardname"];
$reason=$myrow["reason"];
$sql="SELECT * FROM tos WHERE tosid=$reason";
$resultre=mysql_query($sql);
$myrowre=@mysql_fetch_array($resultre);


echo "<tr><td CLASS=CELL2><b>Board:</b> $boardn | <b>Topic:</b> ".$myrow["topicid"]." - ".stripslashes($myrow["topic"])." | Moderation ID: $modid</font></td></tr>
<tr><td CLASS=CELL2><b>From:</b> ".$myrowo["username"]." | <b>Posted:</b> ".$myrow["postdate"]." | <b>Moderated by:</b> <a href=\"mods.php?user=".$myrowc["userid"]."";
if ($board) {echo "&board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\">".$myrowc["username"]."</a></font></td></tr>
<tr><td CLASS=CELL2><b>Moderated at:</b> ".$myrow["moddate"]." | <b>Reason:</b> ".$myrowre["ruletitle"]." |  <b>Action:</b> ";
if ($myrow["action"]==0) {
echo "No Action";
} else if ($myrow["action"]==1) {
echo "Topic Closed";
} else if ($myrow["action"]==2) {
echo "Topic Moved";
} else if ($myrow["action"]==3) {
echo "Message Deleted";
} else if ($myrow["action"]==4) {
echo "Topic Deleted";
} else if ($myrow["action"]==5) {
echo "Notified (Msg)";
} else if ($myrow["action"]==6) {
echo "Notified (Top)";
} else if ($myrow["action"]==7) {
echo "Warned (Msg)";
} else if ($myrow["action"]==8) {
echo "Warned (Top)";
} else if ($myrow["action"]==9) {
echo "Suspended (Msg)";
} else if ($myrow["action"]==10) {
echo "Suspended (Top)";
} else if ($myrow["action"]==11) {
echo "Banned (Msg)";
} else if ($myrow["action"]==12) {
echo "Banned (Top)";
}
echo "</font></td></tr>
<tr><td CLASS=CELL1>".stripslashes($myrow["modbod"])."</font></td></tr>
<tr><td><br>";
$sql="SELECT * FROM modded WHERE modid=$modid";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
if ((($myrow["recont"]==4) || ($myrow["recont"]==9)) && ($level>=60)) {
	echo "<p>This user has sent the following comments:</td></tr><tr><td CLASS=CELL1><font Size=2>".stripslashes($myrow["contbody"])."</font></td></tr>";
	if ($myrow["recontbody"]) {
		echo "<tr><td><br>The moderator responded with the following:</td></tr><tr><td CLASS=CELL1><font Size=2>".stripslashes($myrow["recontbody"])."</font></td></tr>";
	}
	echo "<form ACTION=\"moddetl.php?user=$user&modid=$modid";
	if ($board) {echo "&board=$board"; }
	if ($topic) {echo "&topic=$topic"; }
	echo "\" METHOD=POST><tr><td><p><input type=\"submit\" value=\"Uphold\" name=\"appealed\">";
	if (($myrow["action"]>=7) && ($myrow["action"]<=8)) { echo "<input type=\"submit\" value=\"Relax To Notification\" name=\"appealed\">"; }
	if (($myrow["action"]>=5) && ($myrow["action"]<=8)) { echo "<input type=\"submit\" value=\"Relax To No Karma Loss\" name=\"appealed\">"; }
	echo "<input type=\"submit\" value=\"Overturn\" name=\"appealed\"></form><form ACTION=\"generate.php?modid=$modid";
	if ($board) {echo "&board=$board"; }
	if ($topic) {echo "&topic=$topic"; }
	echo "\" METHOD=POST><input type=\"submit\" value=\"Generate Message From Contest\" name=\"post\"></td></tr></form>";
} else if (($myrow["recont"]==9) && ($level>=60)) {

} else if ($modby!=$userid) {
	if ($myrow["contbody"]) {
		echo "<p>This user has sent the following comments:</td></tr><tr><td CLASS=CELL1><font Size=2>".stripslashes($myrow["contbody"])."</font></td></tr>";
	}
	if ($myrow["recontbody"]){
		echo "<tr><td><br>The moderator responded with the following:</td></tr><tr><td CLASS=CELL1><font Size=2>".stripslashes($myrow["recontbody"])."</font></td></tr>";
	}
} else if ($modby==$userid) {
	if (($myrow["contest"]==0) && ($myrow["contbody"])) {
		echo "<p>This user has accepted the moderation, and has sent the following comments:</td></tr><tr><td CLASS=CELL1><font Size=2>".stripslashes($myrow["contbody"])."</font></td></tr>";
		if ($myrow["recontbody"]) {
			echo "<tr><td><br>You responded with the following:</td></tr><tr><td CLASS=CELL1><font Size=2>".stripslashes($myrow["recontbody"])."</font></td></tr>";
		} else {
			echo "<tr><td><br>Since this user has left a comment for this moderation, you can reply to it:<br><form ACTION=\"moddetl.php?user=$user&modid=$modid";
			if ($board) {echo "&board=$board"; }
			if ($topic) {echo "&topic=$topic"; }
			echo "\" METHOD=POST>Comments:<br><textarea cols=\"60\" rows=\"5\" name=\"message\" WRAP=\"virtual\"></textarea><input type=\"submit\" value=\"Submit\" name=\"submit\"></td></tr></form>";
		}
	} else if (($myrow["contest"]==1) && ($myrow["contbody"])) {
		echo "<p>This user has contested this moderation on the grounds that it was not a TOS violation, and has sent the following comments:</td></tr><tr><td CLASS=CELL1><font Size=2>".stripslashes($myrow["contbody"])."</font></td></tr>";
		if ($myrow["recont"]<=0) {
			echo "<tr><td><br>This user has contested this moderation on grounds that it was not a TOS violation. You, as a moderator, are requred to respond to these contests and decide whether or not the moderation was fair or not:<br><form ACTION=\"moddetl.php?user=$user&modid=$modid";
			if ($board) {echo "&board=$board"; }
			if ($topic) {echo "&topic=$topic"; }
			echo "\" METHOD=POST>Select Response Type: <br><select NAME=\"resp\" size=1><option VALUE=1 SELECTED>Uphold this moderation on the grounds that it was a valid TOS violation</option>";
			if (($myrow["action"]>=7) && ($myrow["action"]<=8)) { echo "<option VALUE=3>Relax to notification</option>"; }
			if (($myrow["action"]>=5) && ($myrow["action"]<=8)) { echo "<option VALUE=4>Relax to no karma loss</option>"; }
			echo "<option VALUE=2>Overturn this moderation on the grounds that it was not a valid TOS violation</option></select><br>Comments/Arguments:<br><textarea cols=\"60\" rows=\"5\" name=\"message\" WRAP=\"virtual\"></textarea><br><input type=\"submit\" value=\"Submit\" name=\"submit\"><input type=\"submit\" value=\"Contest Abuse\" name=\"submit\"><input type=\"submit\" value=\"Forward To Admin\" name=\"submit\"></td></tr></form>";
		} else if ($myrow["recont"]==1) {
			echo "<tr><td><br>You agreed that this moderation was not a TOS violation, and responded with the following:</td></tr><tr><td CLASS=CELL1><font Size=2>".stripslashes($myrow["recontbody"])."</font></td></tr>";
		} else if ($myrow["recont"]==2) {
			echo "<tr><td><br>You decided that this moderation was a TOS violation but decided it was too harsh, and responded with the following:</td></tr><tr><td CLASS=CELL1><font Size=2>".stripslashes($myrow["recontbody"])."</font></td></tr>";
		} else if ($myrow["recont"]==3) {
			echo "<tr><td><br>You disagreed, and upheld this moderation on the grounds that it was a TOS violation, and responded with the following:</td></tr><tr><td CLASS=CELL1><font Size=2>".stripslashes($myrow["recontbody"])."</font></td></tr>";
		} else if (($myrow["recont"]>=4) && ($myrow["recont"]<=7)) {
			echo "<tr><td><br>You disagreed, and upheld this moderation on the grounds that it was a TOS violation, and responded with the following:</td></tr><tr><td CLASS=CELL1><font Size=2>".stripslashes($myrow["recontbody"])."</font></td></tr>";
			if ($myrow["recont"]==4) {
				echo "<tr><td><br>This user has disagreed with your decision, and appealed this moderation to an administrator.</td></tr>";
			} else if ($myrow["recont"]==5) {
				echo "<tr><td><br>An administrator has reviewed this contest, and decided that this moderation was not a TOS violation.</td></tr>";
			} else if ($myrow["recont"]==6) {
				echo "<tr><td><br>An administrator has reviewed this contest, and decided that while still a TOS violation, this moderation was too harsh.</td></tr>";
			} else if ($myrow["recont"]==7) {
				echo "<tr><td><br>An administrator has reviewed this contest, and agreed that the moderation will stand as originally given. This user will not be able to contest any more messages until this moderation is cleared from his/her record.</td></tr>";
			}
		} else if ($myrow["recont"]==8) {
			echo "<tr><td><br>You have reviewed this contest, and determined it as being abuse of the contest system. This user will not be able to contest any more messages until this moderation is cleared from his/her record.</td></tr>";
		} else if ($myrow["recont"]==9) {
			echo "<tr><td><br>You have reviewed this contest, and have forwarded it to an administrator for further review.</td></tr>";
		}
	}
}
echo "</table>";
include("/home/mediarch/foot.php");
?>