<?php
# Modified 04/15/2014 by Plugin Review Network
# Modified by Infinity Responder development team: 2009-06-04
?>

<br />
<table width="550" border="0"><tr><td>
  <table width="550" bgcolor="#1EABDF" style="border: 1px solid #000000;">
    <tr><td>
       <p align="center" style="font-size: 18px; margin: 3px;">
          <font color="#FFFFFF"><?php echo $heading; ?></font>
       </p>
    </td></tr>
    <tr><td>
       <center><font color="#F0F0F0">
          Reminder: Editing a message will only affect those yet to be sent.
       </font></center>
    </td></tr>
  </table>
  <!-- MOD Action to Wordpress Menu -->
  <FORM action="" method=POST<?php if ($config['tinyMCE'] == '3') {echo ' onsubmit="editor.post();"';} ?>>
  <table border="0" width="550" bgcolor="#F0F0F0" style="border: 1px solid #000000;"><tr><td>
     <center>
       <table>
       <tr><td colspan="2">
          <table align="right" cellpadding="0" cellspacing="0" border="0"><tr>
             <td>
                <a href="manual.html#editbursts" onclick="return popper('manual.html#editbursts')">Help</a>
             </td>
             <td width="50">
                &nbsp;
             </td>
             <td>
                <a href="tagref.html" onclick="return popper('tagref.html')">Tag Reference</a>
             </td>
          </tr></table>
       </td></tr>
       <tr><td colspan=2>
          <strong>Subject:</strong><br />
          <center>
          <input name="subj" size=80 maxlength=250 value="<?php echo $subject; ?>" class="fields">
          </center>
       </td></tr>
       <tr><td colspan=2>
          <br />
          <strong>Body: Text Version</strong><br />
          <center>
          <textarea name="bodytext" rows=20 cols=80 class="text_area"><?php echo $text_msg; ?></textarea>
          </center>
       </td></tr>
       <tr><td colspan=2>
          <br />
          <strong>Body: HTML Version</strong><br />
          <center>
          <textarea name="bodyhtml" id="bodyhtml" rows=20 cols=80 class="html_area"><?php echo $html_msg; ?></textarea>
          </center>
       </td></tr>
       <tr>
          <td colspan="2">
             <strong>Start sending on:</strong>
             <select name="send_month" class="fields">
                <?php echo $month_to_send; ?>

                <option<?php if ($month_to_send == "january")   { echo " SELECTED"; } ?> value="January">January</option>\n";
                <option<?php if ($month_to_send == "february")  { echo " SELECTED"; } ?> value="February">February</option>\n";
                <option<?php if ($month_to_send == "march")     { echo " SELECTED"; } ?> value="March">March</option>\n";
                <option<?php if ($month_to_send == "april")     { echo " SELECTED"; } ?> value="April">April</option>\n";
                <option<?php if ($month_to_send == "may")       { echo " SELECTED"; } ?> value="May">May</option>\n";
                <option<?php if ($month_to_send == "june")      { echo " SELECTED"; } ?> value="June">June</option>\n";
                <option<?php if ($month_to_send == "july")      { echo " SELECTED"; } ?> value="July">July</option>\n";
                <option<?php if ($month_to_send == "august")    { echo " SELECTED"; } ?> value="August">August</option>\n";
                <option<?php if ($month_to_send == "september") { echo " SELECTED"; } ?> value="September">September</option>\n";
                <option<?php if ($month_to_send == "october")   { echo " SELECTED"; } ?> value="October">October</option>\n";
                <option<?php if ($month_to_send == "november")  { echo " SELECTED"; } ?> value="November">November</option>\n";
                <option<?php if ($month_to_send == "december")  { echo " SELECTED"; } ?> value="December">December</option>\n";
             </select>
             <select name="send_day" class="fields">
                <?php echo $month_to_send; ?>

                <?php
                for ($i=1; $i <= 31; $i++) {
                     $selected = "";
                     if ($i == $day_to_send) {
                          $selected = " SELECTED";
                     }
                     print "<option$selected value=\"$i\">$i</option>\n";
                }
                ?>
             </select>
             <select name="send_year" class="fields">
                <?php
                for ($i=$this_year; $i <= ($this_year+10); $i++) {
                     $selected = "";
                     if ($i == $year_to_send) {
                          $selected = " SELECTED";
                     }
                     print "<option$selected value=\"$i\">$i</option>\n";
                }
                ?>
             </select>
             &nbsp; at &nbsp;
             <select name="send_hour" class="fields">
                <?php
                for ($i=0; $i <= 23; $i++) {
                     $selected = "";
                     if ($i == $hour_to_send) {
                          $selected = " SELECTED";
                     }
                     print "<option$selected value=\"$i\">$i</option>\n";
                }
                ?>
             </select>
             :
             <select name="send_min" class="fields">
                <?php
                for ($i=0; $i <= 59; $i++) {
                     $selected = "";
                     if ($i == $min_to_send) {
                          $selected = " SELECTED";
                     }
                     print "<option$selected value=\"$i\">$i</option>\n";
                }
                ?>
             </select>
             o'clock.
          </td>
       </tr>
       <tr><td colspan=2>
            <hr style = "border: 0; background-color: #666666; color: #666666; height: 1px; width: 100%;" />
       </td></tr>
       <tr>
           <td width="50%">
               <center>
               <input type="hidden" name="page" value="infinityresponder">
     		   <input type="hidden" name="subpage" value="mailbursts">
               <input type="hidden" name="action" value="do_edit">
               <input type="hidden" name="m_ID"   value="<?php echo $mail_id; ?>">
               <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
               <input class="button-primary" type="submit" name="submit" value="Save Changes" alt="Save Changes">
               </center>
               </FORM>
           </td>
           <td width="50%">
               <center>
               <!-- MOD Action to Wordpress Menu -->
               <FORM action="" method=GET>
               <input type="hidden" name="page" value="infinityresponder">
     		   <input type="hidden" name="subpage" value="mailbursts">
               <input type="hidden" name="action" value="delete">
               <input type="hidden" name="m_ID"   value="<?php echo $mail_id; ?>">
               <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
               <input class="button-secondary" type="submit" name="submit" value="Delete Message" alt="Delete Message">
               </FORM>
               </center>
           </td>
       </tr>
       <tr><td colspan=2>
            <hr style = "border: 0; background-color: #666666; color: #666666; height: 1px; width: 100%;" />
       </td></tr>
       <tr>
         <td>
           Created on: <br />
           <?php echo $timesent; ?><br />
           <br />
         </td>
         <td>
           <center>
           Message status: <strong><?php echo $status; ?></strong><br />
           <!-- MOD Action to Wordpress Menu -->
           <FORM action="" method=GET>
             <input type="hidden" name="page" value="infinityresponder">
     		 <input type="hidden" name="subpage" value="mailbursts">
             <input type="hidden" name="action" value="pause">
             <input type="hidden" name="m_ID"   value="<?php echo $mail_id; ?>">
             <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
             <input class="button-secondary" type="submit" name="submit" value="Toggle Status" alt="Toggle Status">
           </FORM></center>
         </td>
       </tr>
       <tr>
         <td colspan=2>
           <strong>Message progress: <?php echo $the_math['sent']; ?> / <?php echo $the_math['total']; ?> (<?php echo $the_math['percent']; ?>%)</strong>
         </td>
       </tr>
       </table>
     </center>
  </td></tr></table>
  <br />
  <!-- MOD Action to Wordpress Menu -->
  <FORM action="" method=GET>
    <input type="hidden" name="page" value="infinityresponder">
    <input type="hidden" name="subpage" value="mailbursts">
    <input type="hidden" name="page" value="infinityresponder">
    <input type="hidden" name="subpage" value="mailbursts">
    <input type="hidden" name="action" value="<?php echo $return_action; ?>">
    <?php if ($mail_id > 0) { ?>
       <input type="hidden" name="m_ID" value="<?php echo $mail_id; ?>">
    <?php } ?>
    <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
    <input class="button-secondary" type="submit" name="submit" value="<< Back to Mailbursts" alt="<< Back to Mailbursts">
  </FORM>
</td></tr></table>
