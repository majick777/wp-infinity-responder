<?php # Modified 06/16/2013 by Plugin Review Network ?>
<div style="width:550px">
     <div style="width:50%; float: left;">
     	<!-- MOD Action to Wordpress Menu -->
        <FORM action="" method=GET>
           <input type="hidden" name="page" value="infinityresponder">
           <input type="hidden" name="subpage" value="admin">
           <input type="hidden" name="action" value="<?php echo $return_action; ?>">
           <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
           <input type="hidden" name="sub_ID" value="<?php echo $Subscriber_ID; ?>">
           <input class="button-secondary" type="submit" name="back"   value="<< Back" alt="<< Back">
        </FORM>
     </div>
     <div style="width:50%; float: right;">
     </div>
</div>
</center>
