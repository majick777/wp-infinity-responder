<?php
# Modified 04/19/2014 by Plugin Review Network
# Modified by Infinity Responder development team: 2009-06-04

   if ($alt) { $css_class = "row_color_1"; }
   else { $css_class = "row_color_2"; }
?>

<table border="0" width="550" cellpadding="0" cellspacing="0" class="<?php echo $css_class; ?>">
   <tr>
      <td width="30" align="center"><font style="font-size:11pt;"><?php echo $DB_ResponderID; ?></font></td>
      <td width="220"><font style="font-size:11pt;">
      <?php if ($DB_Enabled == '0') { echo $DB_ResponderName; }
      		elseif ($DB_Enabled == '1') { echo '<font style="font-weight:bold;">'.$DB_ResponderName.'</font>'; } ?>
      </font><br>
      <font style="font-size:8pt;">&quot;<?php echo $DB_OwnerName; ?>&quot; &lt;<?php echo $DB_OwnerEmail; ?>&gt;</font>
      </td>
      <td width="40" align="center"><font style="font-size:11pt;"><?php echo $User_Count; ?></font></td>
      <td width="40" align="center"><font style="font-size:11pt;"><?php echo $Pending_User_Count; ?></font></td>
       <td width="40" align="center"><font style="font-size:11pt;"><?php echo $Message_Count; ?></font></td>
      <td width="30">
         <center>
            <!-- MOD Action Links to Wordpress Menu -->
            <a href="admin.php?page=infinityresponder&subpage=mailbursts&action=list&r_ID=<?php echo $DB_ResponderID; ?>">
            <img border="0" src="<?php echo $siteURL . $ResponderDirectory; ?>/images/email_env.gif" name="Bursts" title="Mailbursts">
            </a>
         </center>
      </td>
      <td width="30">
         <center>
         	<!-- MOD Action Links to Wordpress Menu -->
            <a href="admin.php?page=infinityresponder&subpage=responders&action=messages&r_ID=<?php echo $DB_ResponderID; ?>">
            <img border="0" src="<?php echo $siteURL . $ResponderDirectory; ?>/images/messages.gif" name="Messages" title="Messages">
            </a>
         </center>
      </td>
      <td width="30">
         <center>
            <!-- MOD Action Links to Wordpress Menu -->
            <a href="admin.php?page=infinityresponder&subpage=responders&action=update&r_ID=<?php echo $DB_ResponderID; ?>">
            <img border="0" src="<?php echo $siteURL . $ResponderDirectory; ?>/images/settings.gif" name="Settings" title="Settings">
            </a>
         </center>
      </td>
	  <td width="30">
	           <center>
	           	   <!-- MOD Action Links to Wordpress Menu -->
	              <a href="admin.php?page=infinityresponder&subpage=admin&action=edit_users&r_ID=<?php echo $DB_ResponderID; ?>">
	                 <img border="0" src="<?php echo $siteURL . $ResponderDirectory; ?>/images/users.gif" name="Subscribers" title="Subscribers">
	              </a>
	           </center>
      </td>
      <td width="30">
	           <center>
	           	  <!-- MOD Action Links to Wordpress Menu -->
	              <a href="admin.php?page=infinityresponder&subpage=admin&action=Form_Gen&r_ID=<?php echo $DB_ResponderID; ?>">
	              <img border="0" src="<?php echo $siteURL . $ResponderDirectory; ?>/images/form_gen.gif" name="Form Generator" title="Form Generator">
	              </a>
	           </center>
      </td>
      <td>
         <center>
               	<!-- MOD Action Links to Wordpress Menu -->
                     <?php if ($DB_Enabled == '0') { ?>
                     	<a href="admin.php?page=infinityresponder&subpage=responders&action=activate&r_ID=<?php echo $DB_ResponderID; ?>">
                         <img border="0" src="<?php echo $siteURL . $ResponderDirectory; ?>/images/play.gif" name="Play" title="Play">
                     <?php } elseif ($DB_Enabled == '1') { ?>
                     	 <a href="admin.php?page=infinityresponder&subpage=responders&action=pause&r_ID=<?php echo $DB_ResponderID; ?>">
                         <img border="0" src="<?php echo $siteURL . $ResponderDirectory; ?>/images/pause.gif" name="Activate" title="Activate">
                      <?php } ?>                     
                  </a>
         </center>
     </td>      
      <td width="30">
         <center>
         	<!-- MOD Action Links to Wordpress Menu -->
            <a href="admin.php?page=infinityresponder&subpage=responders&action=erase&r_ID=<?php echo $DB_ResponderID; ?>">
               <img border="0" src="<?php echo $siteURL . $ResponderDirectory; ?>/images/trash_del.gif" name="Del" title="Delete">
            </a>
         </center>
      </td>
   </tr>
</table>