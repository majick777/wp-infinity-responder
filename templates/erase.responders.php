<?php
# Modified 12/14/2013 by Plugin Review Network
# Modified by Infinity Responder development team: 2009-06-04

    if ($DB_NotifyOnSub == 1) { $notify = "Yes"; }
       else { $notify = "No"; }
?>

<center>
<table width="550">
 <tr>
  <td align="center">
   <font size=4 color="#1EABDF">Confirm Responder Deletion</font>
   <br /><br />
   <table width="550" bgcolor="#F0F0F0" style="border: 1px solid #000000;">
      <tr>
         <td width="200"><font size=3 color="#666666">Responder Name: </font></td>
         <td width="350"><font size=3 color="#003300"><?php echo $DB_ResponderName; ?></font></td>
      </tr>
      <tr>
         <td width="200"><font size=3 color="#666666">Opt-In Level: </font><br></td>
         <td width="350"><font size=3 color="#003300"><?php echo $DB_OptMethod; ?></font><br></td>
      </tr>
      <tr>
         <td width="200"><font size=3 color="#666666">Notify Owner on Sub/Unsub: </font><br></td>
         <td width="350"><font size=3 color="#003300"><?php echo $notify; ?></font><br></td>
      </tr>
      <tr>
         <td width="200"><font size=3 color="#666666">Responder Desc: </font></td>
         <td width="350"><font size=3 color="#330033"><?php echo $DB_ResponderDesc; ?></font></td>
      </tr>
      <tr>
         <td width="200"><font size=3 color="#666666">Owner Name: </font></td>
         <td width="350"><font size=3 color="#003300"><?php echo $DB_OwnerName; ?></font></td>
      </tr>
      <tr>
         <td width="200"><font size=3 color="#666666">Owner Email: </font></td>
         <td width="350"><font size=3 color="#330033"><?php echo $DB_OwnerEmail; ?></font></td>
      </tr>
      <tr>
         <td width="200"><font size=3 color="#666666">Reply-To Email: </font><br></td>
         <td width="350"><font size=3 color="#003300"><?php echo $DB_ReplyToEmail; ?></font><br></td>
      </tr>
      <tr>
         <td width="200"><font size=3 color="#666666">Opt-In Redirect: </font><br></td>
         <td width="350"><font size=3 color="#003300"><?php echo $DB_OptInRedir; ?></font><br></td>
      </tr>
      <tr>
         <td width="200"><font size=3 color="#666666">Opt-Out Redirect: </font><br></td>
         <td width="350"><font size=3 color="#003300"><?php echo $DB_OptOutRedir; ?></font><br></td>
      </tr>
      <tr>
         <td width="200"><font size=3 color="#666666">Opt-In Conf Msg: </font><br></td>
         <td width="350"><font size=3 color="#003300"><?php echo stripslashes($DB_OptInDisplay); ?></font><br></td>
      </tr>
      <tr>
         <td width="200"><font size=3 color="#666666">Opt-Out Conf Msg: </font><br></td>
         <td width="350"><font size=3 color="#003300"><?php echo stripslashes($DB_OptOutDisplay); ?></font><br></td>
      </tr>
   </table>
   <table width="550" cellpadding="0" cellspacing="0" border="0">
      <tr>
         <td colspan="2">
            <br />
            <center><font size=3 color="#666666">Are you sure you want to delete this responder?</font></center>
         </td>
      </tr>
      <tr>
         <td>
            <table align="right" cellpadding="10" cellspacing="0"><tr><td>
            <!-- MOD Action to Wordpress Menu -->
               <FORM action="" method=GET>
                  <input type="hidden" name="page" value="infinityresponder">
     		      <input type="hidden" name="subpage" value="responders">
                  <input type="hidden" name="action" value="do_erase">
                  <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
                  <input class="button-secondary" type="submit" name="Yes"    value="Yes">
                  <!-- MOD was class="butt" -->
               </FORM>
            </td></tr></table>
         </td>
         <td>
            <table align="left" cellpadding="10" cellspacing="0"><tr><td>
            	<!-- MOD Action to Wordpress Menu -->
               <FORM action="" method=GET>
                  <input type="hidden" name="page" value="infinityresponder">
     		      <input type="hidden" name="subpage" value="responders">
                  <input type="hidden" name="action" value="list">
                  <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
                  <input class="button-secondary" type="submit" name="No"     value="No">
                  <!-- MOD was class="butt" -->
               </FORM>
            </td></tr></table>
         </td>
      </tr>
   </table>
  </td>
 </tr>
</table>
</center>
