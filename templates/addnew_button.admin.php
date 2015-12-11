<?php # Modified 06/16/2013 by Plugin Review Network ?>
<table>
   <tr>
      <td width="450">&nbsp;</td>
      <td width="100">
      	<!-- MOD Actionn to Wordpress Menu -->
         <form action="" method=POST>
            <input type="hidden" name="page" value="infinityresponder">
            <input type="hidden" name="subpage" value="admin">
            <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
            <input type="hidden" name="action" value="sub_addnew">
            <input class="button-primary" type="submit" name="Add"    value="Add Subscriber">
            <!-- MOD was class="butt" -->
         </form>
      </td>
   </tr>
</table>