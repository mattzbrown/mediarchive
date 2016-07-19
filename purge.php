<?
include("/home/mediarch/head.php");

$time=time()-86400;
$sql="SELECT * FROM users WHERE level>5 AND defsec>=$time";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$username=$myrow["username"];
$sql2="SELECT * FROM messages WHERE messby='$username'";
$result2=mysql_query($sql2);
$result2=@mysql_num_rows($result2);
if ($result2) {
$karma=$myrow["cookies"]+1;
$userid=$myrow["userid"];
$sql3="UPDATE users SET cookies=$karma WHERE userid=$userid";
$result3=mysql_query($sql3);
}
}


$time=time()-172800;
$sql="SELECT * FROM users WHERE level=-3 AND closedate<=$time";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$userid=$myrow["userid"];
$sql="UPDATE users SET level=-4 WHERE userid=$userid";
$resultx=mysql_query($sql);
}

$time=time()-172800;
$sql="SELECT * FROM users WHERE level<=10 AND level>=6 AND cookies>0 AND regsec<=$time";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$userid=$myrow["userid"];
$sqlxx="UPDATE users SET level=15 WHERE userid=$userid";
$resultxx=mysql_query($sqlxx);
}
$time=time()-86400;
$sql="SELECT * FROM users WHERE level=11 AND cookies>0 AND regsec<=$time";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$userid=$myrow["userid"];
$sqlxx="UPDATE users SET level=15 WHERE userid=$userid";
$resultxx=mysql_query($sqlxx);
}
$sql="SELECT * FROM users WHERE cookies>=10 AND cookies<20 AND level<40 AND level>5";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$userid=$myrow["userid"];
$sqlxx="UPDATE users SET level=20 WHERE userid=$userid";
$resultxx=mysql_query($sqlxx);
}
$sql="SELECT * FROM users WHERE cookies>=20 AND cookies<40 AND level<40 AND level>5";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$userid=$myrow["userid"];
$sqlxx="UPDATE users SET level=25 WHERE userid=$userid";
$resultxx=mysql_query($sqlxx);
}
$sql="SELECT * FROM users WHERE cookies>=40 AND cookies<75 AND level<40 AND level>5";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$userid=$myrow["userid"];
$sqlxx="UPDATE users SET level=30 WHERE userid=$userid";
$resultxx=mysql_query($sqlxx);
}
$sql="SELECT * FROM users WHERE cookies>=75 AND cookies<120 AND level<40 AND level>5";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$userid=$myrow["userid"];
$sqlxx="UPDATE users SET level=31 WHERE userid=$userid";
$resultxx=mysql_query($sqlxx);
}
$sql="SELECT * FROM users WHERE cookies>=120 AND cookies<150 AND level<40 AND level>5";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$userid=$myrow["userid"];
$sqlxx="UPDATE users SET level=32 WHERE userid=$userid";
$resultxx=mysql_query($sqlxx);
}
$sql="SELECT * FROM users WHERE cookies>=150 AND cookies<200 AND level<40 AND level>5";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$userid=$myrow["userid"];
$sqlxxl="UPDATE users SET level=33 WHERE userid=$userid";
$resultxx=mysql_query($sqlxx);
}
$sql="SELECT * FROM users WHERE cookies>=200 AND cookies<250 AND level<40 AND level>5";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$userid=$myrow["userid"];
$sqlxx="UPDATE users SET level=34  WHERE userid=$userid";
$resultxx=mysql_query($sqlxx);
}
$sql="SELECT * FROM users WHERE cookies>=250 AND level<40 AND level>5";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$userid=$myrow["userid"];
$sqlxx="UPDATE users SET level=35 WHERE userid=$userid";
$resultxx=mysql_query($sqlxx);
}
$sql="SELECT * FROM users WHERE level=5";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$useriddd=$myrow["userid"];
$karma=$myrow["cookies"];
$time=time()-172800;
$sql="SELECT * FROM modded WHERE action<=8 AND action>=7 AND moduser=$useriddd ORDER BY modsec DESC LIMIT 0,1";
$result2=mysql_query($sql);
$myrow2=@mysql_fetch_array($result2);
if ($myrow2["modsec"]<=$time) {
if ($karma<10) {
$sql="UPDATE users SET level=15 WHERE userid=$useriddd";
$result=mysql_query($sql);
} else if (($karma>=10) && ($karma<20)) {
$sql="UPDATE users SET level=20 WHERE userid=$useriddd";
$result=mysql_query($sql);
} else if (($karma>=20) && ($karma<40)) {
$sql="UPDATE users SET level=25 WHERE userid=$useriddd";
$result=mysql_query($sql);
} else if (($karma>=40) && ($karma<75)) {
$sql="UPDATE users SET level=30 WHERE userid=$useriddd";
$result=mysql_query($sql);
} else if (($karma>=75) && ($karma<120)) {
$sql="UPDATE users SET level=31 WHERE userid=$useriddd";
$result=mysql_query($sql);
} else if (($karma>=120) && ($karma<150)) {
$sql="UPDATE users SET level=32 WHERE userid=$useriddd";
$result=mysql_query($sql);
} else if (($karma>=150) && ($karma<200)) {
$sql="UPDATE users SET level=33 WHERE userid=$useriddd";
$result=mysql_query($sql);
} else if (($karma>=200) && ($karma<250)) {
$sql="UPDATE users SET level=34 WHERE userid=$useriddd";
$result=mysql_query($sql);
} else if ($karma>=250) {
$sql="UPDATE users SET level=35 WHERE userid=$useriddd";
$result=mysql_query($sql);
}
}
}
$time=time()-2592000;
$sql="SELECT * FROM users WHERE lastsec<=$time AND level>=0 AND level<=11";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$userna=$myrow["username"];
$userid=$myrow["userid"];
$sql="SELECT * FROM messages WHERE messby='$userna'";
$result2=mysql_query($sql);
$numrows2=@mysql_num_rows($result2);
if ($numrows2<=0) {
$sql="DELETE FROM users WHERE username='$userna'";
$result3=mysql_query($sql);
$sql="DELETE FROM usermap WHERE userid1='$userid'";
$result3=mysql_query($sql);
$sql="DELETE FROM usermap WHERE userid2='$userid'";
$result3=mysql_query($sql);
$sql="DELETE FROM favorites WHERE userid='$userid'";
$result3=mysql_query($sql);
}
}
$time=time()-7776000;
$sql="SELECT * FROM users WHERE lastsec<=$time AND level==15";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$userna=$myrow["username"];
$userid=$myrow["userid"];
$sql="SELECT * FROM messages WHERE messby='$userna'";
$result2=mysql_query($sql);
$numrows2=@mysql_num_rows($result2);
if ($numrows2<=0) {
$sql="DELETE FROM users WHERE username='$userna'";
$result3=mysql_query($sql);
$sql="DELETE FROM usermap WHERE userid1='$userid'";
$result3=mysql_query($sql);
$sql="DELETE FROM usermap WHERE userid2='$userid'";
$result3=mysql_query($sql);
$sql="DELETE FROM favorites WHERE userid='$userid'";
$result3=mysql_query($sql);
}
}
$time=time()-15552000;
$sql="SELECT * FROM users WHERE lastsec<=$time AND level==20";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$userna=$myrow["username"];
$userid=$myrow["userid"];
$sql="SELECT * FROM messages WHERE messby='$userna'";
$result2=mysql_query($sql);
$numrows2=@mysql_num_rows($result2);
if ($numrows2<=0) {
$sql="DELETE FROM users WHERE username='$userna'";
$result3=mysql_query($sql);
$sql="DELETE FROM usermap WHERE userid1='$userid'";
$result3=mysql_query($sql);
$sql="DELETE FROM usermap WHERE userid2='$userid'";
$result3=mysql_query($sql);
$sql="DELETE FROM favorites WHERE userid='$userid'";
$result3=mysql_query($sql);
}
}
$time=time()-2592000;
$sql="SELECT * FROM users WHERE lastsec<=$time AND level==-2";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$userna=$myrow["username"];
$userid=$myrow["userid"];
$email=$myrow["regemail"];
$sql="SELECT * FROM messages WHERE messby='$userna'";
$result2=mysql_query($sql);
$numrows2=@mysql_num_rows($result2);
if ($numrows2<=0) {
$sql="INSERT INTO banned (username, email) VALUES ('$userna', '$email')";
$result3=mysql_query($sql);
$sql="DELETE FROM users WHERE username='$userna'";
$result3=mysql_query($sql);
$sql="DELETE FROM usermap WHERE userid1='$userid'";
$result3=mysql_query($sql);
$sql="DELETE FROM usermap WHERE userid2='$userid'";
$result3=mysql_query($sql);
$sql="DELETE FROM favorites WHERE userid='$userid'";
$result3=mysql_query($sql);
}
}
$time=time()-2592000;
$sql="SELECT * FROM users WHERE lastsec<=$time AND level==-4";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$userna=$myrow["username"];
$userid=$myrow["userid"];
$email=$myrow["regemail"];
$sql="SELECT * FROM messages WHERE messby='$userna'";
$result2=mysql_query($sql);
$numrows2=@mysql_num_rows($result2);
if ($numrows2<=0) {
$sql="INSERT INTO banned (username, email) VALUES ('$userna', '$email')";
$result3=mysql_query($sql);
$sql="DELETE FROM users WHERE username='$userna'";
$result3=mysql_query($sql);
$sql="DELETE FROM usermap WHERE userid1='$userid'";
$result3=mysql_query($sql);
$sql="DELETE FROM usermap WHERE userid2='$userid'";
$result3=mysql_query($sql);
$sql="DELETE FROM favorites WHERE userid='$userid'";
$result3=mysql_query($sql);
}
}
$time=time()-172800;
$sql="DELETE FROM badlogin WHERE date<=$time";
$result=mysql_query($sql);
$sql="DELETE FROM systemnot WHERE `read`=1";
$result=mysql_query($sql);
$time=time()-1209600;
$sql="DELETE FROM systemnot WHERE sentsec<$time";
$time=time()-5184000;
$sql="DELETE FROM usermap WHERE date<$time";
$result=mysql_query($sql);
$time=time()-2592000;
$sql="DELETE FROM metamod WHERE date<$time";
$result=mysql_query($sql);
$time=time()-1296000;
$sql="DELETE FROM modded WHERE modsec<=$time AND action<=3";
$result=mysql_query($sql);
$time=time()-2592000;
$sql="DELETE FROM modded WHERE modsec<=$time AND action>=4 AND action<=9";
$result=mysql_query($sql);
$sql="SELECT * FROM boards WHERE boardid<>199";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$boardnum=$myrow["boardid"];
$sql="SELECT * FROM messages WHERE mesboard=$boardnum";
$result2=mysql_query($sql);
if (mysql_num_rows($result2)<100) {
$time=time()-2592000;
$sql="SELECT * FROM topics WHERE boardnum=$boardnum AND timesec<=$time";
$result3=mysql_query($sql);
while ($myrow2=@mysql_fetch_array($result3)) {
$topic=$myrow2["topicid"];
$sql="DELETE FROM topics WHERE topicid=$topic";
$result4=mysql_query($sql);
$sql="DELETE FROM messages WHERE topic=$topic";
$result4=mysql_query($sql);
}
}
if ((mysql_num_rows($result2)>=100) && (mysql_num_rows($result2)<250)) {
$time=time()-1728000;
$sql="SELECT * FROM topics WHERE boardnum=$boardnum AND timesec<=$time";
$result3=mysql_query($sql);
while ($myrow2=@mysql_fetch_array($result3)) {
$topic=$myrow2["topicid"];
$sql="DELETE FROM topics WHERE topicid=$topic";
$result4=mysql_query($sql);
$sql="DELETE FROM messages WHERE topic=$topic";
$result4=mysql_query($sql);
}
}
if ((mysql_num_rows($result2)>=250) && (mysql_num_rows($result2)<500)) {
$time=time()-1296000;
$sql="SELECT * FROM topics WHERE boardnum=$boardnum AND timesec<=$time";
$result3=mysql_query($sql);
while ($myrow2=@mysql_fetch_array($result3)) {
$topic=$myrow2["topicid"];
$sql="DELETE FROM topics WHERE topicid=$topic";
$result4=mysql_query($sql);
$sql="DELETE FROM messages WHERE topic=$topic";
$result4=mysql_query($sql);
}
}
if ((mysql_num_rows($result2)>=500) && (mysql_num_rows($result2)<1000)) {
$time=time()-1036800;
$sql="SELECT * FROM topics WHERE boardnum=$boardnum AND timesec<=$time";
$result3=mysql_query($sql);
while ($myrow2=@mysql_fetch_array($result3)) {
$topic=$myrow2["topicid"];
$sql="DELETE FROM topics WHERE topicid=$topic";
$result4=mysql_query($sql);
$sql="DELETE FROM messages WHERE topic=$topic";
$result4=mysql_query($sql);
}
}
if ((mysql_num_rows($result2)>=1000) && (mysql_num_rows($result2)<2500)) {
$time=time()-864000;
$sql="SELECT * FROM topics WHERE boardnum=$boardnum AND timesec<=$time";
$result3=mysql_query($sql);
while ($myrow2=@mysql_fetch_array($result3)) {
$topic=$myrow2["topicid"];
$sql="DELETE FROM topics WHERE topicid=$topic";
$result4=mysql_query($sql);
$sql="DELETE FROM messages WHERE topic=$topic";
$result4=mysql_query($sql);
}
}
if ((mysql_num_rows($result2)>=2500) && (mysql_num_rows($result2)<5000)) {
$time=time()-604800;
$sql="SELECT * FROM topics WHERE boardnum=$boardnum AND timesec<=$time";
$result3=mysql_query($sql);
while ($myrow2=@mysql_fetch_array($result3)) {
$topic=$myrow2["topicid"];
$sql="DELETE FROM topics WHERE topicid=$topic";
$result4=mysql_query($sql);
$sql="DELETE FROM messages WHERE topic=$topic";
$result4=mysql_query($sql);
}
}
if ((mysql_num_rows($result2)>=5000) && (mysql_num_rows($result2)<7500)) {
$time=time()-518400;
$sql="SELECT * FROM topics WHERE boardnum=$boardnum AND timesec<=$time";
$result3=mysql_query($sql);
while ($myrow2=@mysql_fetch_array($result3)) {
$topic=$myrow2["topicid"];
$sql="DELETE FROM topics WHERE topicid=$topic";
$result4=mysql_query($sql);
$sql="DELETE FROM messages WHERE topic=$topic";
$result4=mysql_query($sql);
}
}
if ((mysql_num_rows($result2)>=7500) && (mysql_num_rows($result2)<10000)) {
$time=time()-432000;
$sql="SELECT * FROM topics WHERE boardnum=$boardnum AND timesec<=$time";
$result3=mysql_query($sql);
while ($myrow2=@mysql_fetch_array($result3)) {
$topic=$myrow2["topicid"];
$sql="DELETE FROM topics WHERE topicid=$topic";
$result4=mysql_query($sql);
$sql="DELETE FROM messages WHERE topic=$topic";
$result4=mysql_query($sql);
}
}
if ((mysql_num_rows($result2)>=10000) && (mysql_num_rows($result2)<12500)) {
$time=time()-345600;
$sql="SELECT * FROM topics WHERE boardnum=$boardnum AND timesec<=$time";
$result3=mysql_query($sql);
while ($myrow2=@mysql_fetch_array($result3)) {
$topic=$myrow2["topicid"];
$sql="DELETE FROM topics WHERE topicid=$topic";
$result4=mysql_query($sql);
$sql="DELETE FROM messages WHERE topic=$topic";
$result4=mysql_query($sql);
}
}
if ((mysql_num_rows($result2)>=12500) && (mysql_num_rows($result2)<15000)) {
$time=time()-259200;
$sql="SELECT * FROM topics WHERE boardnum=$boardnum AND timesec<=$time";
$result3=mysql_query($sql);
while ($myrow2=@mysql_fetch_array($result3)) {
$topic=$myrow2["topicid"];
$sql="DELETE FROM topics WHERE topicid=$topic";
$result4=mysql_query($sql);
$sql="DELETE FROM messages WHERE topic=$topic";
$result4=mysql_query($sql);
}
}
if ((mysql_num_rows($result2)>=15000) && (mysql_num_rows($result2)<30000)) {
$time=time()-172800;
$sql="SELECT * FROM topics WHERE boardnum=$boardnum AND timesec<=$time";
$result3=mysql_query($sql);
while ($myrow2=@mysql_fetch_array($result3)) {
$topic=$myrow2["topicid"];
$sql="DELETE FROM topics WHERE topicid=$topic";
$result4=mysql_query($sql);
$sql="DELETE FROM messages WHERE topic=$topic";
$result4=mysql_query($sql);
}
}
if ((mysql_num_rows($result2)>=30000) && (mysql_num_rows($result2)<50000)) {
$time=time()-86400;
$sql="SELECT * FROM topics WHERE boardnum=$boardnum AND timesec<=$time";
$result3=mysql_query($sql);
while ($myrow2=@mysql_fetch_array($result3)) {
$topic=$myrow2["topicid"];
$sql="DELETE FROM topics WHERE topicid=$topic";
$result4=mysql_query($sql);
$sql="DELETE FROM messages WHERE topic=$topic";
$result4=mysql_query($sql);
}
}
if (mysql_num_rows($result2)>=50000) {
$time=time()-43200;
$sql="SELECT * FROM topics WHERE boardnum=$boardnum AND timesec<=$time";
$result3=mysql_query($sql);
while ($myrow2=@mysql_fetch_array($result3)) {
$topic=$myrow2["topicid"];
$sql="DELETE FROM topics WHERE topicid=$topic";
$result4=mysql_query($sql);
$sql="DELETE FROM messages WHERE topic=$topic";
$result4=mysql_query($sql);
}
}
}
$ar=" ";
$featnum=rand(2,10);
$sql="SELECT * FROM boardcat WHERE cathide=0";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
$sql="SELECT * FROM boards WHERE `type`=".$myrow["id"];
$result2=mysql_query($sql);
while ($myrow2=@mysql_fetch_array($result2)) {
$ar.=$myrow2["boardid"]." ";
}
}
$ar=trim($ar);
$ar=explode(" ",$ar);
$c=0;
if (count($ar)>=$featnum) {
$sql="DELETE FROM featured";
$result=mysql_query($sql);
while ($c<=$featnum) {
$c=$c+1;
$f=$ar[rand(1,count($ar))];
$sql="SELECT * FROM featured WHERE boardid=$f";
$result=mysql_query($sql);
$numrows=@mysql_num_rows($result);
if ($numrows<=0) {
$sql="INSERT INTO featured (boardid) VALUES ('$f')";
$result=mysql_query($sql);
}
}
}
?>
