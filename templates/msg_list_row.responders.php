<?php
# Modified 07/15/2013 by Plugin Review Network
# Modified by Infinity Responder development team: 2009-06-04

   if ($alt) { $css_class = "row_color_1"; }
   else { $css_class = "row_color_2"; }
?>

<table border=0 width="550" cellpadding="0" cellspacing="2" class="<?php echo $css_class; ?>">
   <tr>
      <td width="300"><?php echo $DB_MsgSub; ?></td>
      <td width="200" align="center">
         <?php
         # MOD for minimized display
         $timing = array();
         if ($T_months > 0) {if ($T_months == 1) {$timing[] = "$T_months month";} else {$timing[] = "$T_months months";} }
         if ($T_weeks > 0) {if ($T_weeks == 1) {$timing[] = "$T_weeks week";} else {$timing[] = "$T_weeks weeks";} }
         if ($T_days > 0) {if ($T_days == 1) {$timing[] = "$T_days day";} else {$timing[] = "$T_days days";} }
         if ($T_hours > 0) {if ($T_hours == 1) {$timing[] = "$T_hours hour";} else {$timing[] = "$T_hours hours";} }
         if ($T_minutes > 0) {if ($T_minutes == 1) {$timing[] = "$T_minutes minute";} else {$timing[] = "$T_minutes minutes";} }
         if (($T_months == 0) && ($T_weeks == 0) && ($T_days == 0) && ($T_hours == 0) && ($T_minutes == 0)) {$printtiming = "Immediate";}
         else {$printtiming = implode(", ",$timing);}
         print $printtiming.".";
         ?>
      </td>
      <td width="18">
      	 <!-- MOD Action to Wordpress Menu -->
         <FORM action="" method=GET>
            <input type="hidden" name="page" value="infinityresponder">
  	        <input type="hidden" name="subpage" value="messages">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
            <input type="hidden" name="MSG_ID" value="<?php echo $M_ID; ?>">
            <input type="image" src="<?php echo $siteURL . $ResponderDirectory; ?>/images/pen_edit.gif" name="Edit" value="Edit">
         </FORM>
      </td>
      <td width="18">
      	 <!-- MOD Action to Wordpress Menu -->
         <FORM action="" method=GET>
            <input type="hidden" name="page" value="infinityresponder">
  	        <input type="hidden" name="subpage" value="messages">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
            <input type="hidden" name="MSG_ID" value="<?php echo $M_ID; ?>">
            <input type="image" src="<?php echo $siteURL . $ResponderDirectory; ?>/images/trash_del.gif" name="Del" value="Delete">
         </FORM>
      </td>
   </tr>
</table>
