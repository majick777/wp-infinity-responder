<?php
# Modified 12/13/2013 by Plugin Review Network
# Modified by Infinity Responder development team: 2009-06-04
?>

<br />
<center>
<table width="550"><tr><td>
  <table width="550" bgcolor="#1EABDF" style="border: 1px solid #000000;" cellspacing="0" cellpadding="0">
    <tr>
       <td>
          <p align="center" style="font-size: 18px"><font color="#FFFFFF"><?php echo $heading; ?></font></p>
       </td>
    </tr>
    <tr><td>
       <center><font color="#FFFFFF">
          Deleting a message is irrevocable. Once done, it's gone!<br />
          You cannot delete messages from people's inbox, so those that
          have been sent are already sent and cannot be recalled.
       </font></center>
    </td></tr>
  </table>
  <table border="0" width="550" border="1" bgcolor="#F0F0F0" cellspacing="0" cellpadding="0" style="border: 1px solid #000000;"><tr><td>
     <center>
       <table>
       <tr><td colspan=2><br /></td></tr>
       <tr><td colspan=2>
          <strong>Subject:</strong><br />
          <?php echo $subject; ?>
       </td></tr>
       <tr><td colspan=2>
          <br />
          <strong>Text Version:</strong><br />
          <?php echo $text_msg; ?>
       </td></tr>
       <tr><td colspan=2>
          <br />
          <strong>HTML Version:</strong><br />
          <?php echo $html_msg; ?>
       </td></tr>
       <tr><td colspan=2>
            <hr style = "border: 0; background-color: #666666; color: #666666; height: 1px; width: 100%;" />
       </td></tr>
       <tr>
         <td colspan=2>
           <strong>Message progress: <?php echo $the_math['sent']; ?> / <?php echo $the_math['total']; ?> (<?php echo $the_math['percent']; ?>%)</strong><br />
         </td>
       </tr>
       <tr>
           <td width="400">
               Created on: <?php echo $timesent; ?><br />
               Sending on: <?php echo $time_to_send; ?><br />
           </td>
           <td width="150">
           		<!-- MOD Action to Wordpress Menu -->
               <center><FORM action="" method=POST>
                  <input type="hidden" name="page" value="infinityresponder">
                  <input type="hidden" name="subpage" value="mailbursts">
                  <input type="hidden" name="action" value="<?php echo $submit_action; ?>">
                  <input type="hidden" name="m_ID"   value="<?php echo $mail_id; ?>">
                  <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
                  <input class="button-primary" type="submit" name="submit" value="Confirm Delete!" alt="Confirm Delete!">
               </FORM></center>
           </td>
       </tr>
       </table>
     </center>
  </td></tr></table>
  <br />
  <!--  MOD Action to Wordpress Menu -->
  <FORM action="?page=infinityresponder&subpage=mailbursts" method=GET>
    <input type="hidden" name="page" value="infinityresponder">
    <input type="hidden" name="subpage" value="mailbursts">
    <input type="hidden" name="action" value="<?php echo $return_action; ?>">
    <input type="hidden" name="m_ID"   value="<?php echo $mail_id; ?>">
    <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
    <input class="button-secondary" type="submit" name="submit" value="<< Back to Mailbursts" alt="<< Back to Mailbursts">
  </FORM>
</td></tr></table>
</center>