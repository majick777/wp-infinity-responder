<?php # Modified 06/13/2013 by Plugin Review Network ?>
<br />
<table cellpadding="0" cellspacing="0" border="0" align="right">
   <tr>
      <td>
      <!-- MOD Action to Wordpress Menu -->
        <FORM action="" method=POST>
           <?php unassigned_addy_pulldown(); ?>
           <input type="hidden" name="page" value="infinityresponder">
           <input type="hidden" name="subpage" value="bouncers">
           <input type="hidden" name="b_ID"   value="<?php echo $bouncer_id; ?>">
           <input type="hidden" name="action" value="create">
           <input class="button-primary" type="submit" name="addb"   value="Add Bouncer" alt="Add Bouncer">
        </FORM>
      </td>
   </tr>
</table>
