<?php
# Modified 10/20/2013 by Plugin Review Network
# Modified by Infinity Responder development team: 2009-06-04
?>
   <tr>
      <td width="200">
         <input style="margin-bottom:10px;" name="add_email<?php echo $i; ?>" placeholder="Email Address..." size=30 maxlength=95 class="fields"><br>
         <center><b>Confirmation:</b> 
         <input type="checkbox" name="subconfirmation<?php echo $i; ?>" value="email" checked> Email 
         <input type="checkbox" name="subconfirmation<?php echo $i; ?>" value="auto"> Auto 
         <input type="checkbox" name="subconfirmation<?php echo $i; ?>" value="off"> Off </center>
      </td>
      <td width="200">
         <center>
          <input name="firstname<?php echo $i; ?>" placeholder="First Name..." size=20 maxlength=40 class="fields">
          <br>
          <input name="lastname<?php echo $i; ?>" placeholder="Last Name..." size=20 maxlength=40 class="fields">
         </center>
      </td>
		<td width="150">
		<center>
		 <?php ResponderPulldown("chosen_resp$i"); ?>
		</center>
	    <table cellpadding="0" cellspacing="0"><tr height="7"><td> </td></tr></table>
		HTML:
		 <input type="RADIO" name="send_html<?php echo $i; ?>" value="1" checked="checked">Yes
		 <input type="RADIO" name="send_html<?php echo $i; ?>" value="0"> No<br>
      </td>
   </tr>
   <tr><td colspan="3">
      <hr style = "border: 0; background-color: #666666; color: #666666; height: 1px; width: 100%;">
   </td></tr>
