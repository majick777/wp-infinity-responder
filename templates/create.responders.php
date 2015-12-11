<?php
# Modified 12/13/2013 by Plugin Review Network
# Modified by Infinity Responder development team: 2009-06-04

      // include_once('popup_js.php');
?>

<table border="0" cellpadding="5">
   <tr>
      <td width="500">
         &nbsp;
      </td>
      <td>
         <a href="manual.html#editresps2" onclick="return popper('manual.html#editresps2')">Help</a>
      </td>
   </tr>
</table>

<?php
      print "<center> \n";
      print "<table width=\"550\"><tr><td> \n";
      print "<table width=\"100%\" bgcolor=\"#1EABDF\" style=\"border: 1px solid #000000;\"><tr><td> \n";
      print "<p align=\"center\" style=\"font-size: 18px\"><font color=\"#FFFFFF\">Create a Responder</font></p>\n";
      print "</td></tr></table> \n";
      print "<center> \n";
      print "<table width=\"100%\" bgcolor=\"#F0F0F0\" style=\"border: 1px solid #000000;\"><tr><td> \n";
      print "<center> \n";
      print "<table border=\"0\"> \n";
      print "<tr><td width=\"200\"> \n";
      // MOD Action to Wordpress Menu
      print "<FORM action=\"\" method=POST> \n";
      print "<font size=2><strong>Responder Name:</strong></font></td> \n";
      print "<td><input name=\"Resp_Name\" size=45 maxlength=250 class=\"fields\"></td>\n";
      print "</tr> \n";
      print "<tr><td width=\"200\"><font size=2><strong>Opt In Method:</strong></font></td> \n";
      print "<td align=\"center\">\n";
      print "<table><tr><td width=70>";
      print "<input type=\"radio\" name=\"OptMethod\" value=\"Single\"> Single \n";
      print "</td><td width=30></td><td width=70>";
      print "<input type=\"radio\" name=\"OptMethod\" value=\"Double\" CHECKED> Double\n";
      print "</td></tr></table>";
      print "</td>\n";
      print "</tr>\n";
      print "<tr><td width=\"200\"><font size=2><strong>From Name:</strong></font></td> \n";
      print "<td><input name=\"Owner_Name\" size=45 maxlength=95 class=\"fields\"></td>\n";
      print "</tr> \n";
      print "<tr><td width=\"200\"><font size=2><strong>From Email:</strong></font></td>\n";
      print "<td><input name=\"Owner_Email\" size=45 maxlength=95 class=\"fields\"></td>\n";
      print "</tr> \n";
      print "<tr><td width=\"200\"><font size=2><strong>Reply-to Email:</strong></font></td> \n";
      print "<td><input name=\"Reply_To\" size=45 maxlength=95 class=\"fields\"></td> \n";
      print "</tr> \n";
      // TODO: Notification Specific Email
      // print "<tr><td width=\"200\"><font size=2><strong>Notifications Email:</strong></font></td> \n";
	  // print "<td><input name=\"Notify_Email\" size=45 maxlength=95 class=\"fields\"></td> \n";
      // print "</tr> \n";
      print "<tr><td width=\"200\"><font size=2><strong>Notify on Sub/Unsub:</strong></font></td> \n";
	  print "<td align=\"center\">\n";
	  print "<table><tr><td width=70>";
	  print "<input type=\"RADIO\" name=\"NotifyOwner\" value=\"1\"> Yes \n";
	  print "</td><td width=30></td><td width=70>";
	  print "<input type=\"RADIO\" name=\"NotifyOwner\" value=\"0\" checked> No\n";
	  print "</td></tr></table>";
	  print "</td>\n";
      print "</tr>\n";
      print "<tr> \n";
      print "<td colspan=\"2\" align=\"center\"> \n";
      print "<br> \n";
      print "<font size=2><strong>Responder Description:</strong></font> --- <em>[Note: Supports HTML]</em><br> \n";
      print "<textarea name=\"Resp_Desc\" rows=3 cols=82 class=\"html_area\"></textarea> \n";
      print "<br><br></td> \n";
      print "</tr> \n";
      print "<tr><td width=\"200\"><font size=2><strong>Opt-In Redirect URL:</strong></font></td> \n";
      print "<td><input name=OptInRedir size=45 maxlength=95 class=\"fields\"></td>\n";
      print "</tr> \n";
      print "<tr><td width=\"200\"><font size=2><strong>Opt-Out Redirect URL:</strong></font></td> \n";
      print "<td><input name=OptOutRedir size=45 maxlength=95 class=\"fields\"></td>\n";
      print "</tr> \n";
      print "<tr> \n";
      print "<td colspan=\"2\" align=\"center\"> \n";
      print "<br> \n";
      print "<font size=2><strong>Opt-In Confirmation Page:</strong></font> --- <em>[Note: Supports HTML]</em><br> \n";
      print "<textarea name=\"OptInDisplay\" rows=7 cols=82 class=\"html_area\"></textarea> \n";
      print "</td> \n";
      print "</tr> \n";
      print "<tr> \n";
      print "<td colspan=\"2\" align=\"center\"> \n";
      print "<br> \n";
      print "<font size=2><strong>Opt-Out Confirmation Page:</strong></font> --- <em>[Note: Supports HTML]</em><br> \n";
      print "<textarea name=\"OptOutDisplay\" rows=7 cols=82 class=\"html_area\"></textarea> \n";
      print "</td> \n";
      print "</tr> \n";
      print "<tr> \n";
      print "<td colspan=\"2\"> \n";
      print "<input type=\"hidden\" name=\"page\" value=\"infinityresponder\"> \n";
      print "<input type=\"hidden\" name=\"subpage\" value=\"responders\"> \n";
      print "<input type=\"hidden\" name=\"action\" value=\"do_create\"> \n";
      print "<p align=\"right\"> \n";
      print "<input class=\"button-primary\" type=\"submit\" name=\"Save\" value=\"Create Responder\" alt=\"Create Responder\">\n";
      // MOD was class="save_b"
      print "</p> \n";
      print "</td> \n";
      print "</tr> \n";
      print "</td></tr></table> \n";
      print "</center> \n";
      print "</FORM> \n";
      print "</td></tr></table> \n";
      print "</center> \n";
      print "<br> \n";
      print "<table width=\"100%\"><tr> \n";
      print "<td width=\"200\"> \n";
      // MOD Action to Wordpress Menu
      print "<FORM action=\"\" method=GET> \n";
	  print "<input type=\"hidden\" name=\"page\" value=\"infinityresponder\"> \n";
      print "<input type=\"hidden\" name=\"subpage\" value=\"responders\"> \n";
      print "<input type=\"hidden\" name=\"action\" value=\"list\"> \n";
      print "<input class=\"button-secondary\" type=\"submit\" name=\"Back\" value=\"<< Back to Responders\" alt=\"Back to Responders\">  \n";
      // MOD was class=\"b_b\"
      print "</FORM> \n";
      print "</td> \n";
      print "<td width=\"220\"> \n";
      print "</td> \n";
      print "</tr></table> \n";
      print "</td></tr></table> \n";
      print "</center> \n";
?>