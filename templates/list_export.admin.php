<?php # Modified 12/13/2013 by Plugin Review Network ?>
<table width="550" bgcolor="##1EABDF" cellpadding="0" cellspacing="3" style="border: 1px solid #000000;">
   <tr>
      <td>
         <p align="center" style="font-size: 18px"><font color="#FFFFFF">Export Subscribers</font></p>
      </td>
   </tr>
</table>

<FORM method="post"><table><tr>
  <table width="550" bgcolor="#F0F0F0" cellpadding="0" cellspacing="3" style="border: 1px solid #000000;">
   <tr>
      <td width="260" align="right" style="vertical-align:top;">
         <font size="3" color="#330000"><b>Export Subscribers From:</b><br></font>
      </td>
      <td width="30"></td>
      <td width="260" align="left">
         <?php ResponderPulldownSpecial('r_ID',$Responder_ID); ?>
      </td>
    </tr>
    <tr height="10"><td> </td></tr>
    <tr>
      <td width="260" align="right" style="vertical-align:top;">
         <font size="3" color="#330000"><b>Only Export Confirmed Subscribers?</b><br></font>
      </td>
      <td width="30"></td>
      <td width="260" align="left">
         <input type='checkbox' name='exportconfirmed' value='yes'> (Double Optin Responders Only)
      </td>
    </tr>
    <tr height="10"><td> </td></tr>
   <tr>
      <td colspan="3">
         <table align="right"><tr><td>
            <input type="hidden" name="page" value="infinityresponder">
            <input type="hidden" name="subpage" value="admin">
            <input type="hidden" name="action" value="list_export_do">
            <input class="button-primary" type="submit" name="Save" value="Export Subscriber(s)">
         </td></tr></table>
      </td>
   </tr>
</table>
</FORM>