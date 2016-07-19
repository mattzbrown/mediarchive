<?
$pagetitle="404 Page Not Found";
include("/home/mediarch/head.php");
echo $harsss;

echo "<table border=\"0\" cellspacing=\"0\" width=\"100%\">

<tr><td align=\"center\"><font size=\"6\"><b>Error: Page Not Found</b></font></td></tr></table>

<font size=2>
You're reached this page due to an error while attempting to browse ".$sitetitle.".  The file you are looking
for does not exist.  <p>

If you have reached this page while linking from another site, you should inform
<b>that</b> site operator of this problem.  ".$sitetitle." has no control over other sites that link here.</p><p>

If you have reached this page while searching ".$sitetitle.", the adminstrator of the site has already been
notified via an automated system, so there is no need to send additional e-mails.</p><p>

You might want to try backing up and refreshing the previous page to make sure that the page you just 
came from has been properly updated.  If you are using AOL or another ISP that caches pages, you
may want to force your browser to bypass that cache (CTRL + F5 in Internet Explorer for Windows, 
Shift + Reload Button in Netscape for Windows, Option + Reload Button in Netscape for Mac).</p>

</font>";

include("/home/mediarch/foot.php");
?>