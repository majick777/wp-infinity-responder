<?php
# Modified 04/29/2014 by Plugin Review Network
# Modified by Infinity Responder development team: 2009-06-04
?>

<table width="550" border="0"><tr><td>
  <table width="550" bgcolor="#1EABDF" style="border: 1px solid #000000;"><tr><td>
     <p align="center" style="font-size: 18px">
        <font color="#FFFFFF"><?php echo $heading; ?></font>
     </p>
  </td></tr></table>
  <!-- MOD Action to Wordpress Menu -->
  <FORM action="" method=POST<?php if ($config['tinyMCE'] == '3') {echo ' onsubmit="editor.post();"';} ?>>
  <table border="0" width="550" bgcolor="#F0F0F0" style="border: 1px solid #000000;"><tr><td>
     <center>
       <table>
       <tr><td>
          <table align="right" cellpadding="0" cellspacing="0" border="0"><tr>
             <td>
                <a href="manual.html#createburst" onclick="return popper('manual.html#createburst')">Help</a>
             </td>
             <td width="50">
                &nbsp;
             </td>
          </tr></table>
       </td></tr>
       <tr><td align="center">
          <strong>Message Subject:</strong><br>
          <input name="subj" size=80 maxlength=250 value="<?php echo $subject; ?>" class="fields">
       </td></tr>
       <tr><td colspan="2">
	   	  <?php include('tagref.php'); ?>
	      </td></tr>
   	   <tr><td colspan="2"><br /></td></tr>
       <tr><td align="center">
          <br>
          <strong>Message Body: Text Version</strong>  &nbsp; <br>
          <textarea name="bodytext" rows=20 cols=80 class="text_area"><?php echo $text_msg; ?></textarea>
       </td></tr>
       <tr><td align="center">
          <br>
          <strong>Message Body: HTML Version</strong> &nbsp; <br>
          <textarea name="bodyhtml" id="bodyhtml" rows=20 cols=80 class="html_area"><?php echo $html_msg; ?></textarea>
          <?php if ($config['tinyMCE'] == '0') {echo '<div align="right">(For pasted plain text.) Convert Line Breaks to &lt;br&gt; Tags? <input type="checkbox" name="convertlinebreaks" value="yes">';} ?>
       </td></tr>
       <tr><td colspan=2>
            <hr style = "border: 0; background-color: #666666; color: #666666; height: 1px; width: 100%;" />
       </td></tr>
       <tr>
          <td colspan="2">
             <strong>Start Sending on:</strong>
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
          </td>
       </tr>
       <tr><td colspan=2>
            <hr style = "border: 0; background-color: #666666; color: #666666; height: 1px; width: 100%;" />
       </td></tr>
       </table>
     </center>
     <table align="right"><tr><td>
       <input type="hidden" name="page" value="infinityresponder">
       <input type="hidden" name="subpage" value="mailbursts">
       <input type="hidden" name="action" value="<?php echo $submit_action; ?>">
       <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
       <input class="button-primary" type="submit" name="submit" value="Save and Send" alt="Save and Send">
     </td></tr></table>
  </td></tr></table>
  </FORM>
  <br>
  <!-- MOD Action to Wordpress Menu -->
  <FORM action="" method=GET>
    <input type="hidden" name="page" value="infinityresponder">
    <input type="hidden" name="subpage" value="mailbursts">
    <input type="hidden" name="action" value="<?php echo $return_action; ?>">
    <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
    <input class="button-secondary" type="submit" name="submit" value="<< Back to Mailbursts" alt="<< Back">
  </FORM>
</td></tr></table>
