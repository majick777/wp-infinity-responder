<?php
# Modified 06/13/2013 by Plugin Review Network
# Modified by Infinity Responder development team: 2009-06-04

   if ($alt) { $css_class = "row_color_1"; }
   else { $css_class = "row_color_2"; }
?>

<table border="0" width="550" cellpadding="0" cellspacing="2" class="<?php echo $css_class; ?>">
   <tr>
      <td width="40">
         <center>
         <?php
            if ($data['Enabled'] == 1) {
               print "<img src=\"$siteURL$ResponderDirectory/images/checkmark.gif\" border=\"0\">\n";
            }
         ?>
         </center>
      </td>
      <td width="230"><?php echo $data['EmailAddy']; ?></td>
      <td width="200"><?php echo $data['username']; ?></td>
      <td width="40">
         <center>
            <!-- MOD Action to Wordpress Menu -->
            <form action="" method=GET>
               <input type="hidden" name="page" value="infinityresponder">
     		   <input type="hidden" name="subpage" value="bouncers">
               <input type="hidden" name="action" value="edit">
               <input type="hidden" name="b_ID"   value="<?php echo $data['BouncerID']; ?>">
               <input type="image" src="<?php echo $siteURL . $ResponderDirectory; ?>/images/pen_edit.gif" name="Edit" value="Edit">
            </form>
         </center>
      </td>
      <td width="40">
         <center>
         	<!-- MOD Action to Wordpress Menu -->
            <form action="" method=GET>
               <input type="hidden" name="page" value="infinityresponder">
     		   <input type="hidden" name="subpage" value="bouncers">
               <input type="hidden" name="action" value="delete">
               <input type="hidden" name="b_ID"   value="<?php echo $data['BouncerID']; ?>">
               <input type="image" src="<?php echo $siteURL . $ResponderDirectory; ?>/images/trash_del.gif" name="Del" value="Delete">
            </form>
         </center>
      </td>
   </tr>
</table>
