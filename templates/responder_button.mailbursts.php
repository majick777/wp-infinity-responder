<?php # Modified 06/20/2013 by Plugin Review Network ?>
<br />
<table cellpadding="0" cellspacing="0" border="0">
   <tr>
      <td>
      	 <!-- MOD Action to Wordpress Menu -->
         <form action="" method=GET>
            <input type="hidden" name="page" value="infinityresponder">
  	        <input type="hidden" name="subpage" value="responders">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="r_ID"   value="<?php echo $DB_ResponderID; ?>">
            <input class="button-secondary" type="submit" name="submit" value="Edit Messages">
            <!-- MOD was  class="butt" -->
         </form>
      </td>
      <td width="510">
         &nbsp;
      </td>
      <td>
         <a href="manual.html#mailbursts" onclick="return popper('manual.html#mailbursts')">Help</a>
      </td>
   </tr>
</table>