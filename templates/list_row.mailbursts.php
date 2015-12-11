<?php
# Modified 04/20/2014 by Plugin Review Network
# Modified by Infinity Responder development team: 2009-06-04

   if ($alt) { $css_class = "row_color_1"; }
   else { $css_class = "row_color_2"; }
?>

<table border=0 width="550" cellpadding="0" cellspacing="2" class="<?php echo $css_class; ?>">
   <tr>
      <td width="250">
      	 <?php 
      	 if ($status == 'Active') {echo "<font style='font-weight:bold;'>".$data['Subject']."<font>";}
      	 else {echo $data['Subject'];} ?>
      </td>
      <td width="130" align="center">
      	 <font style="font-size:8pt;">
         <?php if ($ready == 'yes') {echo $timetosend;}
         else {echo "<font style='font-weight:bold;'>".$timetosend."</font>";} ?>
         </font>
      </td>
      <td width="80" align="center">
      	 <?php if ( ($the_math['sent'] > 0) && ($the_math['sent'] == $the_math['total']) ) {
      	 	echo $the_math['sent']." / ".$the_math['total'];}
      	 	else {echo "<font style='font-weight:bold;'>".$the_math['sent']." / ".$the_math['total']."</font>";}
      	 ?>
      </td>      
      <td width="30">
         <!-- MOD Action to Wordpress Menu -->
         <FORM action="" method=GET>
            <input type="hidden" name="page" value="infinityresponder">
     		<input type="hidden" name="subpage" value="mailbursts">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
            <input type="hidden" name="m_ID"   value="<?php echo $data['Mail_ID']; ?>">
            <input type="image" src="<?php echo $siteURL . $ResponderDirectory; ?>/images/pen_edit.gif" name="Edit" value="Edit" title="Edit">
         </FORM>
      </td>
      <td width="30">
           <!-- MOD Action to Wordpress Menu -->
           <FORM action="" method=GET>
             <input type="hidden" name="page" value="infinityresponder">
     	     <input type="hidden" name="subpage" value="mailbursts">
             <input type="hidden" name="action" value="pause">
             <input type="hidden" name="m_ID"  value="<?php echo $data['Mail_ID']; ?>">
             <input type="hidden" name="r_ID"  value="<?php echo $Responder_ID; ?>">
             <?php if ($status == 'Paused') { ?>
             	<input type="image" src="<?php echo $siteURL . $ResponderDirectory; ?>/images/play.gif" name="Activate" value="Activate">
             <?php } elseif ($status == 'Active') { ?>
             	<input type="image" src="<?php echo $siteURL . $ResponderDirectory; ?>/images/pause.gif" name="Pause" value="Pause" title="Pause">
             <?php } ?>
           </FORM>
      </td>
      <td width="30">
      	  <!-- MOD Action to Wordpress Menu -->
         <FORM action="" method=GET>
            <input type="hidden" name="page" value="infinityresponder">
     		<input type="hidden" name="subpage" value="mailbursts">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="m_ID"   value="<?php echo $data['Mail_ID']; ?>">
            <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
            <input type="image" src="<?php echo $siteURL . $ResponderDirectory; ?>/images/trash_del.gif" name="Del" value="Delete" title="Delete">
         </FORM>
      </td>
   </tr>
</table>
