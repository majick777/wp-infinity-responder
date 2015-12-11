<?php # Modified 07/15/2013 by Plugin Review Network ?>
<script language="javascript" type="text/javascript">
function showhidetagref() {
 if (document.getElementById('tagreference').style.display == 'none')
 {document.getElementById('tagreference').style.display = '';}
 else {document.getElementById('tagreference').style.display = 'none';}
}
function showtags(divid) {
  document.getElementById('tagsgeneral').style.display = 'none';
  document.getElementById('tagsresponder').style.display = 'none';
  document.getElementById('tagssubscriber').style.display = 'none';
  document.getElementById('tagscustomfields').style.display = 'none';
  document.getElementById('tagsdateandtime').style.display = 'none';
  document.getElementById('tagsextras').style.display = 'none';
  var tagid = 'tags'+divid;
  document.getElementById(tagid).style.display = '';
}
</script>

<center><a href="javascript:void(0);" style="text-decoration:none;" onclick="showhidetagref();">Show/Hide Tag Reference</a></center>

<center><div id="tagreference" style="display:none;">
 <table width="550" cellpadding="0" cellspacing="3" border="0">
   <tr>
      <td colspan="2" align="center">
          Replacement tags for messages and mailbursts. These tags are not case sensitive.
	   <table><tr>
	   <td><a href="javascript:void(0);" style="text-decoration:none;" onclick="showtags('general');">General</a></td><td width=10></td>
	   <td><a href="javascript:void(0);" style="text-decoration:none;" onclick="showtags('responder');">Responder</a></td><td width=10></td>
	   <td><a href="javascript:void(0);" style="text-decoration:none;" onclick="showtags('subscriber');">Subscriber</a></td><td width=10></td>
	   <td><a href="javascript:void(0);" style="text-decoration:none;" onclick="showtags('customfields');">Custom Fields</a></td><td width=10></td>
	   <td><a href="javascript:void(0);" style="text-decoration:none;" onclick="showtags('dateandtime');">Date and Time</a></td><td width=10></td>
	   <td><a href="javascript:void(0);" style="text-decoration:none;" onclick="showtags('extras');">Extras</a></td></tr>
	   </table>
      </td>
   </tr>

   <tr>
     <td colspan="2" align="center">
	   <div id="tagsgeneral">
	   <table>
	   <tr><td>%unsub_msg%</td><td width=20></td><td>Unsubscribe Message with Link</td><td>(<font color=#ee0000>Required</font>)</td></tr>
	   <tr><td>%unsub_link%</td><td width=20></td><td>Unsubscribe Link Only</td><td>(<font color=#ee0000>Alternative</font>)</tr>
	   <tr><td>%firstname%</td><td width=20></td><td>Subscriber's first name, case fixed.</td></tr>
	   <tr><td>%msg_subject%</td><td width=20></td><td>Subject of the message.</td></tr>
	   <tr><td>%signature%</td><td width=20></td><td>Signature Field (from config page)</td></tr>
	   <tr><td>%address%</td><td width=20></td><td>Address Field (from config page)</td></tr>
	   <tr><td>%RespDir%</td><td width=20></td><td>The directory of the responder program.</td></tr>
	   <tr><td>%SiteURL%</td><td width=20></td><td>URL of your site.</td></tr>
	   </table>
	   </div>

	  <div id="tagsresponder" style="display:none;">
	   <table>
	   <!-- TODO: Add Responder Signature Field -->
	   <!-- %resp_signature% - Responder's Signature -->
	   <tr><td>%resp_name%</td><td width=20></td><td>Responder's Name</td></tr>
	   <tr><td>%resp_desc%</td><td width=20></td><td>Responder's Description</td></tr>
	   <tr><td>%resp_ownername%</td><td width=20></td><td>Responder Owner's Name</td></tr>
	   <tr><td>%resp_owneremail%</td><td width=20></td><td>Responder Owner's Email</td></tr>
	   <tr><td>%resp_replyto%</td><td width=20></td><td>Responder's Reply-To Email</td></tr>
	   </table>
	   </div>

	   <div id="tagssubscriber" style="display:none;">
	   <table>
	   <tr><td>%subr_emailaddy%</td><td width=20></td><td>Subscriber's email address.</td></tr>
	   <tr><td>%subr_firstname%</td><td width=20></td><td>Subscriber's first name.</td></tr>
	   <tr><td>%subr_lastname%</td><td width=20></td><td>Subscriber's last name.</td></tr>
	   <tr><td>%subr_firstname_fix%</td><td width=20></td><td>Subscriber's first name, case fixed.</td></tr>
	   <tr><td>%subr_lastname_fix%</td><td width=20></td><td>Subscriber's last name, case fixed.</td></tr>
	   <tr><td>%subr_id%</td><td width=20></td><td>Numerical subscriber ID.</td></tr>
	   <tr><td>%subr_ipaddy%</td><td width=20></td><td>Subscriber's IP address.</td></tr>
	   <tr><td>%subr_referralsource%</td><td width=20></td><td>Referral source for this subscriber.</td></tr>
	   </table>
	   </div>

	   <div id="tagscustomfields" style="display:none;">
	   %cf_fieldname% where fieldname is the name of the field in the database.
	   <table>
	   <tr><td>%cf_income%</td><td width=20></td><td>Custom Field: Income</td></tr>
	   <tr><td>%cf_city%</td><td width=20></td><td>Custom Field: City</td></tr>
	   </table>
	   </div>

	   <div id="tagsdateandtime" style="display:none;">
	   <table>
	   <tr><td>%date_today%</td><td width=20></td><td>Today's Date</td></tr>
	   <tr><td>%date_yesterday%</td><td width=20></td><td>Yesterday's Date</td></tr>
	   <tr><td>%date_tomorrow%</td><td width=20></td><td>Tomorrow's Date</td></tr>
	   <tr><td>%next_monday%</td><td width=20></td><td>Next Monday's Date</td></tr>
	   <tr><td>%next_tuesday%</td><td width=20></td><td>Next Tuesday's Date</td></tr>
	   <tr><td>%next_wednesday%</td><td width=20></td><td>Next Wednesday's Date</td></tr>
	   <tr><td>%next_thursday%</td><td width=20></td><td>Next Thursday's Date</td></tr>
	   <tr><td>%next_friday%</td><td width=20></td><td>Next Friday's Date</td></tr>
	   <tr><td>%next_saturday%</td><td width=20></td><td>Next Saturday's Date</td></tr>
	   <tr><td>%next_sunday%</td><td width=20></td><td>Next Sunday's Date</td></tr>
	   </table>
	   </div>

	   <div id="tagsextras" style="display:none;">
	   <table>
	   <tr><td>%resp_optinredir%</td><td width=20></td><td>Responder's Opt-In Redirect URL</td></tr>
	   <tr><td>%resp_optoutredir%</td><td width=20></td><td>Responder's Opt-Out Redirect URL</td></tr>
	   <tr><td>%resp_optindisplay%</td><td width=20></td><td>Responder's Opt-In Confirmation Page</td></tr>
	   <tr><td>%resp_optoutdisplay%</td><td width=20></td><td>Responder's Opt-Out Confirmation Page</td></tr>
	   <tr><td><br></td></tr>
	   <tr><td>%Subr_JoinedMonthNum%</td><td width=20></td><td>Numerical month that subscriber subscribed.</td></tr>
	   <tr><td>%Subr_JoinedMonth%</td><td width=20></td><td>Textual month that subscriber subscribed.</td></tr>
	   <tr><td>%Subr_JoinedYear%</td><td width=20></td><td>Year that subscriber subscribed.</td></tr>
	   <tr><td>%Subr_JoinedDay%</td><td width=20></td><td>Day that subscriber subscribed</td></tr>
	   <tr><td>%Subr_LastActiveMonthNum%</td><td width=20></td><td>Numerical month of subscriber's last activity.</td></tr>
	   <tr><td>%Subr_LastActiveMonth%</td><td width=20></td><td>Textual month of subscriber's last activity.</td></tr>
	   <tr><td>%Subr_LastActiveYear%</td><td width=20></td><td>Year month of subscriber's last activity.</td></tr>
	   <tr><td>%Subr_LastActiveDay%</td><td width=20></td><td>Day month of subscriber's last activity.</td></tr>
	   </table>
	   </div>
	 </td>
   </tr>
 </table>
</div></center>