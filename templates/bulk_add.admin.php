<?php
# Modified 12/13/2013 by Plugin Review Network
# Modified by Infinity Responder development team: 2009-06-04
?>

<table width="550" bgcolor="##1EABDF" cellpadding="0" cellspacing="3" style="border: 1px solid #000000;">
   <tr>
      <td>
         <p align="center" style="font-size: 18px"><font color="#FFFFFF">Add a List of Addresses</font></p>
      </td>
   </tr>
</table>
<!-- MOD Action to Wordpress Menu -->
<FORM action="" name="List_Adder" enctype="multipart/form-data" method="POST">
<table width="550" bgcolor="#F0F0F0" cellpadding="0" cellspacing="3" style="border: 1px solid #000000;">
   <tr>
      <td width="260" align="right" style="vertical-align:top;">
         <font size="3" color="#330000">Select Responder:<br></font>
      </td>
      <td width="30"></td>
      <td width="260" align="left">
         <?php ResponderPulldownSpecial('r_ID',$Responder_ID); ?>
      </td>
    </tr>
    <tr height="10"><td> </td></tr>
    <!-- TODO: Check if selected autoresponder is single or double optin? -->
    <tr>
 	   <td width="260" align="right" style="vertical-align:top;">
 		  <font size="3" color="#330000">Subscriber Confirmation:<br>
 		  <font size="2" color="#330000">(Double Optin Responders only)</font></font>
	   </td>
	   <td width="30"></td>
	   <td width="260" align="left">
		  <input type="radio" name="subconfirmation" value="email" checked="checked"> Send Confirmation Email<br>
		  <input type="radio" name="subconfirmation" value="auto"> Subscribe as Confirmed<br>
		  <input type="radio" name="subconfirmation" value="off"> Just Add to Responder
	   </td>
	</tr>
    <tr height="10"><td> </td></tr>
    <tr>
      <td width="260" align="right">
            <font size="3" color="#003300">
               HTML:
               </font>
        </td>
        <td width="30"></td>
        <td width="260" align="left">
          <font size="3" color="#003300">
             <input type="RADIO" name="h" value="1" checked="checked">Yes &nbsp;
             <input type="RADIO" name="h" value="0">No
          </font>
      </td>
   </tr>
   <tr height="10"><td> </td></tr>
       <tr>
         <td width="260" align="right">
               <font size="3" color="#003300">
                  Overwrite Existing Records?
                  </font>
           </td>
           <td width="30"></td>
           <td width="260" align="left">
             <font size="3" color="#003300">
                <input type="RADIO" name="overwrite" value="yes">Yes &nbsp;
                <input type="RADIO" name="overwrite" value="no" checked="checked">No
             </font>
         </td>
   </tr>
   <tr>
      <td colspan="3"><hr style = "border: 0; background-color: ##1EABDF; color: #666666; height: 1px; width: 100%;"></td>
   </tr>
   <tr>
      <td colspan="3">
         <center>
            <strong>Enter list of email addresses, separated by a new line...</strong><br>
            In addition, extra subscriber data can be added by using commas to separate...<br>
            For example, to add first name with email use: <em>john@doe.org,John</em><br>
            and to add first and last name use: <em>lois@lane.net,Lois,Lane</em><br><br>
            <textarea name="comma_list" rows="15" cols="95" class="text_area"></textarea><br>
            <b>Full Import/Export Record Format is:</b><br>
	    <em>email@emailaddress.com, Firstname, Lastname, HTML, Confirmed, IPAddress,<br>
	    ReferralSource, UniqueCode, SentMsgs, TimeJoined, RealTimeJoined, LastActivity</em><br>
            (HTML is 0 or 1, Confirmed also 0 or 1, and separate Sent Messages with | eg. 1|2|3|4)
         </center>
      </td>
   </tr>
   <tr>
      <td colspan="3"><hr style = "border: 0; background-color: ##1EABDF; color: #666666; height: 1px; width: 100%;"></td>
   </tr>
   <tr>
      <td colspan="3">
         <center><strong>And/or, upload a previously exported Infinity Responder CSV file (same format):</strong><br></center>
         <center><input type="file" name="load_file" size="80" maxlength="200" class="fields"></center>
      </td>
   </tr>
   <tr>
      <td colspan="3">
         <table align="right"><tr><td>
            <input type="hidden" name="page" value="infinityresponder">
            <input type="hidden" name="subpage" value="admin">
            <input type="hidden" name="action" value="bulk_add_do">
            <input class="button-primary" type="submit" name="Save" value="Import Subscriber(s)">
            <!-- MOD was class="save_b" -->
         </td></tr></table>
      </td>
   </tr>
</table>
</FORM>