<?php
   # Modified 06/16/2013 by Plugin Review Network
   if ($alt) { $css_class = "row_color_1"; }
   else { $css_class = "row_color_2"; }
?>

<table border=0 width="550" cellpadding="0" cellspacing="2" class="<?php echo $css_class; ?>"><tr>
   <td width="40"><font color="#330000"><?php echo $DB_ResponderID; ?></font></td>
   <td width="335"><font color="#000033"><?php echo $DB_ResponderName; ?></font></td>
   <td width="100"><font color="#000033"><?php echo $User_Count; ?></font></td>
   <td width="75">
      <form action="" method=POST>
         <input type="hidden" name="page" value="infinityresponder">
  	     <input type="hidden" name="subpage" value="admin">
         <input type="hidden" name="r_ID"   value="<?php echo $DB_ResponderID; ?>">
         <input type="hidden" name="action" value="edit_users">
         <input class="button-secondary" type="submit" name="submit" value="Edit Users">
         <!-- MOD was class="butt" -->
      </form>
   </td>
</tr></table>
