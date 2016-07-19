<?
$pagetitle="Search";
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
$username=auth($uname,$pword);
if (!$username)
{
echo "<table border=0 width=100%>

<tr><td>You must be <a HREF=\"/boards/login.php\">logged in</a> to view this page.</td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}
$sql="SELECT * FROM users WHERE username='$uname'";
$result=mysql_query($sql);
$myrow=@mysql_fetch_array($result);
$userlevel=$myrow["level"];
$myuseid=$myrow["userid"];
if ($myrow["level"]<50) {
echo "<table border=0 width=100%>

<tr><td>You are not authorized to view this page.</td></tr>

</table>";
include("/home/mediarch/foot.php");
exit;
}
echo "<table border=0 width=100%>

<tr><td COLSPAN=4 align=center><FONT SIZE=6><B>Search</b></font></td></tr>

<tr><td COLSPAN=4 CLASS=LITE ALIGN=center><font SIZE=3><i>Return to: <a HREF=\"/boards/index.php\" CLASS=MENU>Board List</a>";
if ($board) { echo " | <a HREF=\"/boards/gentopic.php?board=$board\" CLASS=MENU>Topic List</a>"; }
if ($topic) { echo " | <a HREF=\"/boards/genmessage.php?board=$board&topic=$topic\" CLASS=MENU>Message List</a>";
}
echo " | <a HREF=\"index.php";
if ($board) {echo "?board=$board"; }
if ($topic) {echo "&topic=$topic"; }
echo "\" CLASS=MENU>Control Panel</a>";
echo "</i></font></td></tr>";
if ($post) {
if (($type!="name") && ($type!="id")) {
$type="name";
}
if (($area!="users") && ($area!="topics") && ($area!="messages")) {
$area="users";
}
$string=htmlentities($string);
echo "<TR><TD CLASS=DARK COLSPAN=4>Search Results for &quot;".stripslashes($string)."&quot;</td></tr>";
$string=explode(" ", $string);
$string=implode("%", $string);
if (strlen($string)>60) {
echo "<TR><TD CLASS=SYS COLSPAN=4>Search strings must be shorter than 60 characters.</td></tr>";
} else if ((strlen($string)<3) && ($type=="name")) {
echo "<TR><TD CLASS=SYS COLSPAN=4>Search strings must be longer than 3 characters.</td></tr>";
} else {
  if ($type=="id") {
    if ($area=="users") {
      echo "<tr>
	  <td CLASS=LITE ALIGN=center><i>User ID</i></td>
	  <td CLASS=LITE ALIGN=center><i>Username</i></td>
	  <td CLASS=LITE ALIGN=center><i>Karma</i></td>
	  <td CLASS=LITE ALIGN=center><i>Register Date</i></td></tr>";
      $sql="SELECT * FROM users WHERE userid='$string' LIMIT 0, 200";
      $result=mysql_query($sql);
      $numrows=mysql_num_rows($result);
      if ($numrows<=0) {
      echo "<TR><TD CLASS=SYS COLSPAN=4>No users matching your search ID were found.</td></tr>";
      }
      while ($myrow=@mysql_fetch_array($result)) {
        echo "<TR><TD CLASS=CELL1>".$myrow["userid"]."</td><TD CLASS=CELL1><A HREF=\"/boards/whois.php?user=".$myrow["userid"]."";
        if ($board) {echo "&board=$board"; }
        if ($topic) {echo "&topic=$topic"; }
        echo "\">".$myrow["username"]."</a></td><TD CLASS=CELL1>".$myrow["cookies"]."</td><TD CLASS=CELL1>".$myrow["regdate"]."</td></tr>";
      }
      $sql="SELECT * FROM users WHERE userid='$string'";
      $result=mysql_query($sql);
      $numrows=mysql_num_rows($result);
      if ($numrows>200) {
      echo "<TR><TD CLASS=SYS COLSPAN=4>Over 200 matching users were found.  You may want to narrow your search.</td></tr>";
      }
    } else if ($area=="topics") {
      echo "<tr>
	  <td CLASS=LITE ALIGN=center width=55%><i>Topic</i></td>
	  <td CLASS=LITE ALIGN=center><i>Created By</i></td>
	  <td CLASS=LITE ALIGN=center><i>Messages</i></td>
	  <td CLASS=LITE ALIGN=center><i>Last Post</i></td></tr>";
      $sql="SELECT * FROM topics WHERE topicid='$string' LIMIT 0, 200";
      $result=mysql_query($sql);
      $numrows=mysql_num_rows($result);
      if ($numrows<=0) {
      echo "<TR><TD CLASS=SYS COLSPAN=4>No topics matching your search ID were found.</td></tr>";
      }
      while ($myrow=@mysql_fetch_array($result)) {
        $boardid=$myrow["boardnum"];
        $sql="SELECT * FROM boards WHERE boardid=$boardid";
        $resultx=mysql_query($sql);
        $myrowx=@mysql_fetch_array($resultx);
        if ($myrowx["boardlevel"]<=$userlevel) {
        $topp=$myrow["topicid"];
        $sql="SELECT * FROM messages WHERE topic=$topp";
        $resultx=mysql_query($sql);
        $resultx=mysql_num_rows($resultx);
        echo "<TR><TD CLASS=CELL1><A HREF=\"/boards/genmessage.php?board=".$myrow["boardnum"]."&topic=".$myrow["topicid"]."\">".stripslashes($myrow["topicname"])."</a>";
		if ($myrow["closed"]==1) {
		echo "<img BORDER=0 SRC=\"/images/closed.gif\" HEIGHT=13 WIDTH=11 ALT=\"**CLOSED**\">";
		}
		echo "</td><TD CLASS=CELL1>".stripslashes($myrow["topicby"])."</td><TD CLASS=CELL1>$resultx</td><TD CLASS=CELL1>".$myrow["postdate"]."</td></tr>";
      }
      }
      $sql="SELECT * FROM topics WHERE topicid='$string'";
      $result=mysql_query($sql);
      $numrows=mysql_num_rows($result);
      if ($numrows>200) {
      echo "<TR><TD CLASS=SYS COLSPAN=4>Over 200 matching topics were found.  You may want to narrow your search.</td></tr>";
      }
    } else if ($area=="messages") {
      $sql="SELECT * FROM messages WHERE messageid='$string' LIMIT 0, 200";
      $result=mysql_query($sql);
      $numrows=mysql_num_rows($result);
      if ($numrows<=0) {
      echo "<TR><TD CLASS=SYS COLSPAN=4>No messages matching your search ID were found.</td></tr>";
      }
      while ($myrow=@mysql_fetch_array($result)) {
        $messby=$myrow["messby"];
        $boardd=$myrow["mesboard"];
        $sql="SELECT * FROM boards WHERE boardid=$boardd";
        $resultx=mysql_query($sql);
        $myrowx=@mysql_fetch_array($resultx);
        if ($myrowx["boardlevel"]<=$userlevel) {
        $topp=$myrow["topic"];
        $sql="SELECT * FROM topics WHERE topicid=$topp";
        $resultx=mysql_query($sql);
        $myrowx=@mysql_fetch_array($resultx);
        $sql="SELECT * FROM boards WHERE boardid='$boardd'";
        $resultq=mysql_query($sql);
        $myrowq=@mysql_fetch_array($resultq);
        $sql="SELECT * FROM users WHERE username='$messby'";
        $resulta=mysql_query($sql);
        $myrowa=@mysql_fetch_array($resulta);
        echo "<tr><td CLASS=CELL2 colspan=4><b>From:</b> <a HREF=\"/boards/whois.php?user=".$myrowa["userid"]."";
        if ($board) {echo "&board=$board"; }
        if ($topic) {echo "&topic=$topic"; }
        echo "\">".$myrowa["username"]."</a> | <b>Posted:</b> ".$myrow["postdate"]."</td></tr>
		<tr><td CLASS=CELL2 colspan=4><b>Board:</b> <a href=\"/boards/gentopic.php?board=".$myrowq["boardid"]."\">".stripslashes($myrowq["boardname"])."</a> | <b>Topic:</b> <a href=\"/boards/genmessage.php?board=".$myrowx["boardnum"]."&topic=".$myrowx["topicid"]."\">".stripslashes($myrowx["topicname"])."</a></td></tr>
		<tr><td CLASS=CELL1 colspan=4>".stripslashes($myrow["messbody"])."</td></tr>";
      }
      }
      $sql="SELECT * FROM messages WHERE messageid='$string'";
      $result=mysql_query($sql);
      $numrows=mysql_num_rows($result);
      if ($numrows>200) {
      echo "<TR><TD CLASS=SYS COLSPAN=4>Over 200 matching messages were found.  You may want to narrow your search.</td></tr>";
      }
    }
  } else if ($type=="name") {
    if ($area=="users") {
      echo "<tr>
	  <td CLASS=LITE ALIGN=center><i>User ID</i></td>
	  <td CLASS=LITE ALIGN=center><i>Username</i></td>
	  <td CLASS=LITE ALIGN=center><i>Karma</i></td>
	  <td CLASS=LITE ALIGN=center><i>Register Date</i></td></tr>";
      $sql="SELECT * FROM users WHERE username LIKE '%$string%' LIMIT 0, 200";
      $result=mysql_query($sql);
      $numrows=mysql_num_rows($result);
      if ($numrows<=0) {
      echo "<TR><TD CLASS=SYS COLSPAN=4>No users matching your search string were found.</td></tr>";
      }
      while ($myrow=@mysql_fetch_array($result)) {
        echo "<TR><TD CLASS=CELL1>".$myrow["userid"]."</td><TD CLASS=CELL1><A HREF=\"/boards/whois.php?user=".$myrow["userid"]."";
        if ($board) {echo "&board=$board"; }
        if ($topic) {echo "&topic=$topic"; }
        echo "\">".$myrow["username"]."</a></td><TD CLASS=CELL1>".$myrow["cookies"]."</td><TD CLASS=CELL1>".$myrow["regdate"]."</td></tr>";
      }
      $sql="SELECT * FROM users WHERE username LIKE '%$string%'";
      $result=mysql_query($sql);
      $numrows=mysql_num_rows($result);
      if ($numrows>200) {
      echo "<TR><TD CLASS=SYS COLSPAN=4>Over 200 matching users were found.  You may want to narrow your search.</td></tr>";
      }
    } else if ($area=="topics") {
      echo "<tr>
	  <td CLASS=LITE ALIGN=center width=55%><i>Topic</i></td>
	  <td CLASS=LITE ALIGN=center><i>Created By</i></td>
	  <td CLASS=LITE ALIGN=center><i>Messages</i></td>
	  <td CLASS=LITE ALIGN=center><i>Last Post</i></td></tr>";
      $sql="SELECT * FROM topics WHERE topicname LIKE '%$string%' LIMIT 0, 200";
      $result=mysql_query($sql);
      $numrows=mysql_num_rows($result);
      if ($numrows<=0) {
      echo "<TR><TD CLASS=SYS COLSPAN=4>No topics matching your search string were found.</td></tr>";
      }
      while ($myrow=@mysql_fetch_array($result)) {
        $boardid=$myrow["boardnum"];
        $sql="SELECT * FROM boards WHERE boardid=$boardid";
        $resultx=mysql_query($sql);
        $myrowx=@mysql_fetch_array($resultx);
        if ($myrowx["boardlevel"]<=$userlevel) {
        $topp=$myrow["topicid"];
        $sql="SELECT * FROM messages WHERE topic=$topp";
        $resultx=mysql_query($sql);
        $resultx=mysql_num_rows($resultx);
        echo "<TR><TD CLASS=CELL1><A HREF=\"/boards/genmessage.php?board=".$myrow["boardnum"]."&topic=".$myrow["topicid"]."\">".stripslashes($myrow["topicname"])."</a>";
		if ($myrow["closed"]==1) {
		echo "<img BORDER=0 SRC=\"/images/closed.gif\" HEIGHT=13 WIDTH=11 ALT=\"**CLOSED**\">";
		}
		echo "</td><TD CLASS=CELL1>".stripslashes($myrow["topicby"])."</td><TD CLASS=CELL1>$resultx</td><TD CLASS=CELL1>".$myrow["postdate"]."</td></tr>";
      }
      }
      $sql="SELECT * FROM topics WHERE topicname LIKE '%$string%'";
      $result=mysql_query($sql);
      $numrows=mysql_num_rows($result);
      if ($numrows>200) {
      echo "<TR><TD CLASS=SYS COLSPAN=4>Over 200 matching topics were found.  You may want to narrow your search.</td></tr>";
      }
    } else if ($area=="messages") {
      $sql="SELECT * FROM messages WHERE messbody LIKE '%$string%' LIMIT 0, 200";
      $result=mysql_query($sql);
      $numrows=mysql_num_rows($result);
      if ($numrows<=0) {
      echo "<TR><TD CLASS=SYS COLSPAN=4>No messages matching your search string were found.</td></tr>";
      }
      while ($myrow=@mysql_fetch_array($result)) {
        $messby=$myrow["messby"];
        $boardd=$myrow["mesboard"];
        $sql="SELECT * FROM boards WHERE boardid=$boardd";
        $resultx=mysql_query($sql);
        $myrowx=@mysql_fetch_array($resultx);
        if ($myrowx["boardlevel"]<=$userlevel) {
        $topp=$myrow["topic"];
        $sql="SELECT * FROM topics WHERE topicid=$topp";
        $resultx=mysql_query($sql);
        $myrowx=@mysql_fetch_array($resultx);
        $sql="SELECT * FROM boards WHERE boardid='$boardd'";
        $resultq=mysql_query($sql);
        $myrowq=@mysql_fetch_array($resultq);
        $sql="SELECT * FROM users WHERE username='$messby'";
        $resulta=mysql_query($sql);
        $myrowa=@mysql_fetch_array($resulta);
        echo "<tr><td CLASS=CELL2 colspan=4><b>From:</b> <a HREF=\"/boards/whois.php?user=".$myrowa["userid"]."";
        if ($board) {echo "&board=$board"; }
        if ($topic) {echo "&topic=$topic"; }
        echo "\">".$myrowa["username"]."</a> | <b>Posted:</b> ".$myrow["postdate"]."</td></tr>
<tr><td CLASS=CELL2 colspan=4><b>Board:</b> <a href=\"/boards/gentopic.php?board=".$myrowq["boardid"]."\">".stripslashes($myrowq["boardname"])."</a> | <b>Topic:</b> <a href=\"/boards/genmessage.php?board=".$myrowx["boardnum"]."&topic=".$myrowx["topicid"]."\">".stripslashes($myrowx["topicname"])."</a></td></tr>
<tr><td CLASS=CELL1 colspan=4>".stripslashes($myrow["messbody"])."</td></tr>";
      }
      }
      $sql="SELECT * FROM messages WHERE messbody LIKE '%$string%'";
      $result=mysql_query($sql);
      $numrows=mysql_num_rows($result);
      if ($numrows>200) {
      echo "<TR><TD CLASS=SYS COLSPAN=4>Over 200 matching messages were found.  You may want to narrow your search.</td></tr>";
      }
    }
  }
}
}
$string=explode("%", $string);
$string=implode(" ", $string);
echo "<form action=\"search.php";
if ($board) { echo "?board=$board"; }
if ($topic) { echo "&topic=$topic"; }
echo "\" method=\"POST\">
<TR><TD COLSPAN=4>Area to search: <SELECT NAME=\"area\" SIZE=1>";
if ($post) {
if ($area=="users") { echo "<OPTION VALUE=users>Users (Current)</option>"; } else 
if ($area=="topics") { echo "<OPTION VALUE=topics>Topics (Current)</option>"; } else
if ($area=="messages") { echo "<OPTION VALUE=messages>Messages (Current)</option>"; }
}
echo "<OPTION VALUE=users>Users</option>
<OPTION VALUE=topics>Topics</option>
<OPTION VALUE=messages>Messages</option>
</select><BR>
Type of search: <SELECT NAME=\"type\" SIZE=1>";
if ($post) {
if ($type=="id") { echo "<OPTION VALUE=id>Search by ID (Current)</option>"; } else 
if ($type=="name") { echo "<OPTION VALUE=name>Search by Text (Current)</option>"; }
}
echo "<OPTION VALUE=id>Search by ID</option>
<OPTION VALUE=name>Search By Text</option>
</select><BR>
Search String: <input type=\"text\" size=60 maxlength=60 name=\"string\" value=\"$string\" >
<input type=\"submit\" name=\"post\" value=\"Search\"></form></td></tr>

</table>";
include("/home/mediarch/foot.php");
?>
