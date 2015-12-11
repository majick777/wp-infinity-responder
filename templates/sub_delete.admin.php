<?php
# Modified 10/15/2013 by Plugin Review Network
# Modified by Infinity Responder development team: 2009-06-04

   if ($DB_Confirmed == "1") { $conf = "Yes"; }
   else { $conf = "No"; }
?>

<br>
<center>
<table border="0" width="550" cellspacing="5" cellpadding="0" bgcolor="#1EABDF" style="border: 1px solid #000000;">
   <tr>
      <td>
         <center><font color="#FFFFFF" style="font-size: 18px">Confirm Delete Subscriber</font></center>
      </td>
   </tr>
</table>
<table width="550" bgcolor="#F0F0F0" style="border: 1px solid #000000;">
   <tr>
      <td width="100"><font color="#666666">Subscriber ID: </font></td>
      <td width="450"><font color="#003300"><?php echo $DB_SubscriberID; ?></font></td>
   </tr>
   <tr>
      <td width="100"><font color="#666666">Subscribed To: </font></td>
      <td width="450"><font color="#330033"><?php echo $DB_ResponderName; ?></font></td>
   </tr>
   <tr>
      <td width="100"><font color="#666666">Email Address: </font></td>
      <td width="450"><font color="#330033"><?php echo $DB_EmailAddress; ?></font></td>
   </tr>
   <tr>
      <td width="100"><font color="#666666">Name: </font></td>
      <td width="450"><font color="#330033"><?php echo "$DB_FirstName $DB_LastName"; ?></font></td>
   </tr>
   <tr>
      <td width="100"><font color="#666666">IP address: </font></td>
      <td width="450"><font color="#330033"><?php echo $DB_IPaddy; ?></font></td>
   </tr>
   <tr>
      <td width="100"><font color="#666666">Confirmed: </font></td>
      <td width="450"><font color="#003300"><?php echo $conf; ?></font></td>
   </tr>
   <tr>
      <td width="100"><font color="#666666">Referral Source: </font></td>
      <td width="450"><font color="#003300"><?php echo $DB_ReferralSource; ?></font></td>
   </tr>
   <tr>
      <td width="100"><font color="#666666">Unique Code: </font></td>
      <td width="450"><font color="#003300"><?php echo $DB_UniqueCode; ?></font></td>
   </tr>
   <tr>
      <td width="100"><font color="#666666">HTML Email: </font></td>
      <td width="450"><font color="#003300"><?php echo $HTMLstr; ?></font></td>
   </tr>
   <tr>
      <td width="100"><font color="#666666">Joined: </font><br></td>
      <td width="450"><font color="#003300"><?php echo $JoinedStr; ?></font><br></td>
   </tr>
   <tr>
      <td width="100"><font color="#666666">Last Activity: </font><br></td>
      <td width="450"><font color="#003300"><?php echo $LastActStr; ?></font><br></td>
   </tr>
</table>

<table width="550" cellpadding="0" cellspacing="0" border="0">
   <tr>
      <td colspan="2">
         <br />
         <center><font size=4 color="#666666">Delete this subscriber?</font></center>
      </td>
   </tr>
   <tr>
      <td>
         <table align="right" cellpadding="10" cellspacing="0"><tr><td>
         	<!-- MOD Action to Wordpress Menu -->
            <FORM action="" method=GET>
               <input type="hidden" name="page" value="infinityresponder">
  	           <input type="hidden" name="subpage" value="admin">
               <input type="hidden" name="action" value="sub_delete_do">
               <input type="hidden" name="sub_ID" value="<?php echo $Subscriber_ID; ?>">
               <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
               <input class="button-secondary" type="submit" name="Yes"    value="Yes">
            </FORM>
         </td></tr></table>
      </td>
      <td>
         <table align="left" cellpadding="10" cellspacing="0"><tr><td>
         	<!-- MOD Action to Wordpress Menu -->
            <FORM action="" method=GET>
               <input type="hidden" name="page" value="infinityresponder">
  	           <input type="hidden" name="subpage" value="admin">
               <input type="hidden" name="action" value="edit_users">
               <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
               <input class="button-secondary" type="submit" name="No"     value="No">
            </FORM>
         </td></tr></table>
      </td>
   </tr>
</table>
