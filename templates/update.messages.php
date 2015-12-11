<?php
# Modified 04/16/2014 by Plugin Review Network
# Modified by Infinity Responder development team: 2009-06-04
?>

<center>
<!-- MOD Action to Wordpress Menu -->
<FORM action="" method=POST<?php if ($config['tinyMCE'] == '3') {echo 'onsubmit="editor.post();"';} ?>>
<table width="550" cellpadding="0" cellspacing="5" bgcolor="#1EABDF" style="border: 1px solid #000000;">
   <tr>
      <td>
         <p align="center" style="font-size: 18px"><font color="#FFFFFF">Edit Message</font></p>
      </td>
   </tr>
</table>
<table border="0" cellpadding="0" cellspacing="5" width="550" bgcolor="#F0F0F0" style="border: 1px solid #000000;">
   <tr>
      <td colspan="2">
        <table align="right" cellpadding="0" cellspacing="0" border="0"><tr>
           <td>
              <a href="manual.html#editrespmsgs" onclick="return popper('manual.html#editrespmsgs')">Help</a>
           </td>
           <td width="50">
              &nbsp;
           </td>
        </tr></table>
      </td>
   </tr>
   <tr>
      <td colspan="2" align="center">
         <strong>Message Subject:</strong> <em>[Supports Tags]</em><br>
         <input name="subj" size=80 maxlength=250 class="fields" value="<?php echo $DB_MsgSub; ?>">
      </td>
   </tr>
  <tr><td colspan="2">
  	<?php include('tagref.php'); ?>
  </td></tr>
  <tr><td colspan="2"><br /></td></tr>
   <tr>
      <td colspan="2" align="center">
         <strong>Message Body: Text Version</strong>  &nbsp;<br>
         <textarea name="bodytext" rows=20 cols=80class="text_area"><?php echo $DB_MsgBodyText; ?></textarea>
      </td>
   </tr>
   <tr><td colspan="2"><br /></td></tr>
   <tr>
      <td colspan="2" align="center">
         <strong>Message Body: HTML Version</strong> &nbsp;<br>
         <textarea name="bodyhtml" id="bodyhtml" rows=20 cols=80class="html_area"><?php echo $DB_MsgBodyHTML; ?></textarea>
      </td>
   </tr>
   <tr><td colspan="2"><br /></td></tr>
   <tr>
      <td colspan="2" align="center">
         <table cellpadding="0" cellspacing="0" border="0">
            <tr>
               <td align="center"><font color="#000000" size="2"><b>Sequential Timing Delay:</b></font></td>
            </tr>
            <tr>
               <td align="center"><font color="#000000" size="2">Months: <input name="months" size=2 maxlength=20 value="<?php echo $T_months; ?>" class="fields" style="width:20px;">
			  Weeks: <input name="weeks" size=2 maxlength=20 value="<?php echo $T_weeks; ?>" class="fields" style="width:20px;">
			  Days: <input name="days" size=2 maxlength=20 value="<?php echo $T_days; ?>" class="fields" style="width:20px;">
			  Hours: <input name="hours" size=2 maxlength=20 value="<?php echo $T_hours; ?>" class="fields" style="width:20px;">
              Minutes: <input name="min" size=2 maxlength=20 value="<?php echo $T_minutes; ?>" class="fields" style="width:20px;"></td>
            </tr>
            <tr>
               <td><br /><hr style = "border: 0; background-color: #000000; color: #000000; height: 1px; width: 100%;"><br /></td>
            </tr>
            <tr>
               <td align="center">
                  <font color="#000000" size="2"><b>Absolute Timing: (Optional)</b></font><br>
                  <font color="#000000" size="2">Select the day and time to run (after the run after time above has expired). Use military time.</font>
                  <br /><br />
               </td>
            </tr>
            <tr>
               <td align="center"><font color="#000000" size="2">Day:
                  <select name="abs_day" class="fields">
                     <option value="">None</option>
                     <option value="Sunday"<?php echo $absday['Sunday']; ?>>Sunday</option>
                     <option value="Monday"<?php echo $absday['Monday']; ?>>Monday</option>
                     <option value="Tuesday"<?php echo $absday['Tuesday']; ?>>Tuesday</option>
                     <option value="Wednesday"<?php echo $absday['Wednesday']; ?>>Wednesday</option>
                     <option value="Thursday"<?php echo $absday['Thursday']; ?>>Thursday</option>
                     <option value="Friday"<?php echo $absday['Friday']; ?>>Friday</option>
                     <option value="Saturday"<?php echo $absday['Saturday']; ?>>Saturday</option>
                  </select>
               @ Hours:
                  <select name="abs_hours" class="fields">
                  <?php
                     for ($i=0; $i <= 23; $i++) {
                        $selected = "";
                        if ($i == $DB_absHours) {
                           $selected = " SELECTED";
                        }
                        print "<option$selected value=\"$i\">$i</option>\n";
                     }
                  ?>
                  </select>
               Minutes:
                  <select name="abs_min" class="fields">
                  <?php
                     for ($i=0; $i <= 59; $i++) {
                        $selected = "";
                        if ($i == $DB_absMins) {
                           $selected = " SELECTED";
                        }
                        print "<option$selected value=\"$i\">$i</option>\n";
                     }
                  ?>
                  </select>
               </td>
            </tr>
         </table>
      </td>
   </tr>
   <tr>
      <td colspan="2"><br /><hr style = "border: 0; background-color: #000000; color: #000000; height: 1px; width: 100%;"></td>
   </tr>
   <tr>
      <td colspan="2">
         <table align="right" cellpadding="0" cellspacing="0" border="0">
            <tr>
               <td>
                  <input type="hidden" name="page" value="infinityresponder">
  	              <input type="hidden" name="subpage" value="messages">
                  <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
                  <input type="hidden" name="MSG_ID" value="<?php echo $M_ID; ?>">
                  <input type="hidden" name="action" value="do_update">
                  <input class="button-primary" type="submit" name="Save"   value="Save Message" alt="Save">
               </td>
            </tr>
         </table>
      </td>
   </tr>
</table>
</FORM>
</center>
<br>
<!-- MOD Action to Wordpress Menu -->
<FORM action="" method=GET>
   <input type="hidden" name="page" value="infinityresponder">
   <input type="hidden" name="subpage" value="responders">
   <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
   <input type="hidden" name="action" value="messages">
   <input type="submit" name="Back"   value="<< Back to Messages" alt="<< Back to Messages">
</FORM>
