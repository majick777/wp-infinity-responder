<?php
# Modified 07/02/2013 by Plugin Review Network 
# Modified by Infinity Responder development team: 2009-06-04

   if ($alt) { $css_class = "row_color_1"; }
   else { $css_class = "row_color_2"; }

	# MOD Hack for directory variables clearing bug cause unknown
   	$infinityURL = WP_PLUGIN_URL."/wp-infinity-responder";
   	$pos = strpos($infinityURL,'/wp-content');
   	$chunks = str_split($infinityURL,$pos);
   	$siteURL = $chunks[0];
   	unset($chunks[0]);
   	$ResponderDirectory = implode('',$chunks);
?>

<table border="0" width="550" cellpadding="0" cellspacing="2" class="<?php echo $css_class; ?>">
 <tr>
   <td width="40" align="center"><font color="#000033" style="font-family: Arial;"><?php echo $DB_SubscriberID; ?></font></td>
   <td width="300"><font color="#000033" style="font-family: Arial;">
   <?php echo "<a href=\"javascript:void(0);\" style=\"text-decoration:none;\" onclick=\"showsubscriber('subscriber".$subscriberID."');\">"; ?>
   <?php echo $DB_EmailAddress; ?>
   </a></font><br />
   <?php if ($DB_IPaddy == '') {$DB_IPaddy = 'n/a';} if ($DB_ReferralSource == '') {$DB_ReferralSource = 'n/a';}
      echo "<div id=\"subscriber".$i."\" style=\"display:none;\">";
      echo "Firstname: ".$DB_FirstName." - Lastname: ".$DB_LastName."<br>";
      echo "IP: ".$DB_IPaddy." - Referrer: ".$DB_ReferralSource."<br>";
      echo "Sent: ".$DB_SentMsgs;
	  echo "</div>";
	?>
   </td>
   <td width="40" align="center">
   <?php if ($CanReceiveHTML == "1") {echo "<img src=\"".$siteURL.$ResponderDirectory."/images/tick.gif\">";}
   else {echo "<img src=\"".$siteURL.$ResponderDirectory."/images/cross.gif\">";} ?>
   <td width="30">
   	  <!-- MOD Action to Wordpress Menu -->
      <form action="" method=GET>
		 <input type="hidden" name="page" value="infinityresponder">
  	     <input type="hidden" name="subpage" value="admin">
         <input type="hidden" name="sub_ID" value="<?php echo $DB_SubscriberID; ?>">
         <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
         <input type="hidden" name="action" value="sub_edit">
         <input type="image" src="<?php echo $siteURL . $ResponderDirectory; ?>/images/users.gif" name="Edit" value="Edit" title="Edit Record">
      </form>
   </td>
   <td width="30">
   	  <!-- MOD Action to Wordpress Menu -->
      <form action="" method=GET>
		 <input type="hidden" name="page" value="infinityresponder">
  	     <input type="hidden" name="subpage" value="admin">
         <input type="hidden" name="sub_ID" value="<?php echo $DB_SubscriberID; ?>">
         <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
         <input type="hidden" name="action" value="sub_delete">
         <input type="image" src="<?php echo $siteURL . $ResponderDirectory; ?>/images/trash_del.gif" name="Delete" value="Del" title="Delete Subscriber">
      </form>
   </td>
 </tr>
</table>