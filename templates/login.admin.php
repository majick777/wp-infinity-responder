<?php
# Modified by Infinity Responder development team: 2009-06-04
?>

<center><br><br><br><br><br>
   <table width="300" bgcolor="#E7E7CE" style="border: 1px solid #000000;"><tr><td>
   <form action="admin.php" method=POST>
      <table align="center" width="360" cellspacing="2">
         <tr>
            <td colspan="2">
              <center>
                <p class="big_header">
                   Admin Control Panel Login
                </p>
              </center>
            </td>
         </tr>
         <tr>
            <td align="left"><font size="2" color="#000033"><b>Login: </b></font></td>
            <td align="right"><input type="text" name="login" size=35 maxlength=200 class="fields"></td>
         </tr>
         <tr>
            <td align="left"><font size="2" color="#000033"><b>Password: </b></font></td>
            <td align="right"><input type="password" name="pword" size=35 maxlength=200 class="fields"></td>
         </tr>
      </table>
      <table align="right">
         <tr>
            <td colspan="2">
              <input type="hidden" name="action" value="do_login">
              <input type="submit" name="Login"  value="Login" alt="Login" class="lo_b">
            </td>
         </tr>
      </table>
   </form><br><br><br>
   </td></tr></table>
</center>