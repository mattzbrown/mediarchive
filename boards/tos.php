<?
$pagetitle="Message Board Terms of Service";
include("/home/mediarch/head.php");
echo $harsss;
?>
<table border=0 width=100%>
<tr>
<td align=center><font SIZE=6><b>Message Board Terms of Service</b></font></td></tr>
<tr>

<tr><td>

<font SIZE=3><b>ACCEPTANCE OF TERMS</b>
</font><br>

<?
echo "".$sitetitle." provides the services to you, the visitor, based on its Terms of Service outlined here. The latest TOS can always be found here at http://".$HTTP_HOST."".$SCRIPT_NAME.". When using the services provided by ".$sitetitle.", you are subject to these posted terms. Usage of the services 
on this site denotes acceptance of these terms. The TOS may be changed at any time and without direct notice to individual visitors, so it is recommended that you check back with this page at any time you have questions or concerns. <p>

<font SIZE=3><b>REGISTRATION REQUIREMENTS</b></font><br>

In order to view messages on the ".$sitetitle." message boards without user restrictions, no registration is required or necessary. In order to post messages on the boards, view boards with level restrictions, and use other advanced services, you must register with ".$sitetitle." using a valid e-mail address. Upon registration, an Activation Key in the form of a URL will be mailed to the address you provided. You must visit this URL using the web browser of your choice to activate the account. No posting privileges are granted until the account is activated, and inactive accounts may be deleted after 48 hours of creation. ".$sitetitle." does not require you to use your real name or other identification that can be easily traced to you, and the e-mail address you provide will be kept private.  In  order to register on ".$sitetitle.", registrants must be 13 years of age or older.  ".$sitetitle." does not knowingly collect any information from any users under 13 years, and if it is found that an underage user has fraudulently registered, their account will immediately be terminated.<p>

<font SIZE=3><b>CONTENT NOTICE</b></font><br>

By viewing the site content, you agree that all content on the ".$sitetitle." Message Boards is the responsibility of the person from which the content originated. You agree that neither ".$sitetitle." nor its sponsors or affiliates are responsible for all content that you personally post or upload. ".$sitetitle." does not directly control any content posted on the boards, and does not guarantee the truthfulness or quality of any content. You agree that while using the ".$sitetitle." message boards, you may be exposed to content that is offensive or objectionable, and that you will in no way hold ".$sitetitle." nor its sponsors or affiliates liable in any way, shape, or form for any harm or loss that may come to you or others as a result of viewing this content. ".$sitetitle." is not responsible for screening content before it is posted, although an offensive language filter is installed on the system that will reject certain posts that may contain certain words deemed offensive or used most often in an offensive way.<p>

<font SIZE=3><b>ACCOUNT RESPONSIBILITY</b></font><br>

Users are solely responsible for protecting their accounts from access by others.  You are strongly encouraged to select a hard-to-guess password and not re-use that password on any other sites where it may be read by the owners or adminstrators of that site.  <p>

While it is acceptable for users to maintain multiple accounts on ".$sitetitle.", ".$sitetitle." can and does track multiple shared accounts from a single or multiple computers as one account in terms of TOS violations. If the TOS is violated severely enough to warrant the banning of one account, all known accounts shared between a single or multiple users who use the same computer may also be banned for the actions of the violating account at the administrators' discretion. <p>

Because of this rule, it is highly recommended that board users do not share their accounts with others, nor share their computers used to access the site with others, as the actions of some other person could easily directly impact all known shared message board accounts. <p>

<font SIZE=3><b>PRIVACY AND RELEASE OF INFORMATION</b></font><br>

Under normal circumstances, ".$sitetitle." will never release your provided information to any third party without a court order requiring us to do so. However, in cases of certain severe and/or repeated TOS violations or illegal activities, we reserve the right to forward any and all known information
about you and your accounts to your ISP (including libraries, schools, and places of employment), e-mail service provider, your ISP account owner (if someone else is actually paying for it), and any parties whose copyright has clearly been infringed by your actions on the boards.<p>

<font SIZE=3><b>MEMBER CONDUCT</b></font><br>

You agree that you will not use this service to perform the following actions:

<ol>";
$sql="SELECT * FROM tos WHERE tosshow=1 ORDER BY tosid ASC";
$result=mysql_query($sql);
while ($myrow=@mysql_fetch_array($result)) {
echo "<li><b>".$myrow["ruletitle"]."</b></li><br>

".$myrow["rulebody"]."

";
}
echo "<li><b>Usernames, Profiles, and Forms</b></li><br>

Violating any of the above rules with a username, any part of the user profile (signature, quote, e-mail, IM), or via feedback forms (such as the Mark for Moderation function) is considered a severe violation.

</ol>

<font SIZE=3><b>TERMS VIOLATIONS</b></font><br>

Topics and message posts that violate the TOS will be deleted from the boards, and addtional penalties may be applied at the moderator's discretion.  Re-posting deleted violations (yours or those of others) is also considered a violation.<p>

Messages and topics may be removed at any time and for any reason at the sole discretion of ".$sitetitle." and its designated moderators.  User accounts may be warned, suspended, or revoked at any time and for any reason at the sole discretion of ".$sitetitle." and its designated moderators.  All determinations of what is &quot;acceptable&quot; and &quot;unacceptable&quot; content will be determined solely by ".$sitetitle." and whoever it designates as moderators. You agree that the decision of the moderators and administrators is final, and you may not legally contest their rulings.<p>

Intentional, repeated, or severe violations are cause for the banning of your account, all use of the boards from your IP address or your entire ISP, and ".$sitetitle." contacting your ISP or other relevant parties concerning your activities.<p>

</td></tr>

</table>";
include("/home/mediarch/foot.php");
?>





