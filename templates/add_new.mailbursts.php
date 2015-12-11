<?php # Modified 04/29/2014 by Plugin Review Network ?>
<br />
<center>
<div style="width:550px">
     <div style="width:33%; float: left;">
     	<!-- MOD Action to Wordpress Menu -->
        <FORM action="" method=GET>
           <input type="hidden" name="page" value="infinityresponder">
           <input type="hidden" name="subpage" value="responders">
           <input type="hidden" name="action" value="<?php echo $return_action; ?>">
           <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
           <input class="button-secondary" type="submit" name="submit" value="<< Back" alt="<< Back">
        </FORM>
     </div>
     <div style="width:33%; float: left;">
     	<!-- MOD Action to Wordpress Menu -->
        <FORM action="" method=GET>
           <input type="hidden" name="page" value="infinityresponder">
           <input type="hidden" name="subpage" value="mailburts">
           <input type="hidden" name="action" value="list">
           <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
           <input class="button-secondary" type="submit" name="submit" value="Refresh" alt="Refresh">
        </FORM>
     </div>
     <div style="width:33%; float: right;">
     	<!-- MOD Action to Wordpress Menu -->
        <FORM action="" method=GET>
           <input type="hidden" name="page" value="infinityresponder">
           <input type="hidden" name="subpage" value="mailbursts">
           <input type="hidden" name="action" value="<?php echo $submit_action; ?>">
           <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
           <input class="button-primary" type="submit" name="submit" value="Create Mailburst" alt="Create Burst">
        </FORM>
     </div>
</div>
</center>
