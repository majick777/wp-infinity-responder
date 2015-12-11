<?php
# Modified 12/14/2013 by Plugin Review Network
# Modified by Infinity Responder development team: 2009-06-04

      if ($DB_OptMethod == "Single") {
           $opt_1 = "CHECKED";
           $opt_2 = "";
      }
      else {
           $opt_1 = "";
           $opt_2 = "CHECKED";
      }
      // include_once('popup_js.php');
?>

<table border="0" cellpadding="5">
   <tr>
      <td width="550">
      <?php # MOD removed this <A HREF="#responder_msgs"><< Zoom down to the responders messages >></A> ?>
      </td>
      <td>
         <!-- <a href="manual.html#editresps2" onclick="return popper('manual.html#editresps2')">Help</a> -->
      </td>
   </tr>
</table>

<?php
      print "<br> \n";
      print "<center> \n";
      print "<table width=\"550\"><tr><td> \n";
      print "<table width=\"100%\" bgcolor=\"#1EABDF\" style=\"border: 1px solid #000000;\"><tr><td> \n";
      print "<p align=\"center\" style=\"font-size: 18px\"><font color=\"#FFFFFF\">Edit Responder</font></p>\n";
      print "</td></tr></table> \n";
      print "<center> \n";
      print "<table width=\"100%\" bgcolor=\"#F0F0F0\" style=\"border: 1px solid #000000;\"><tr><td> \n";
      print "<center> \n";
      print "<table border=\"0\"> \n";
      print "<tr><td width=\"200\"> \n";
      // MOD Action to Wordpress Menu
      print "<FORM action=\"\" method=POST> \n";
      print "<font size=2><strong>Responder Name:</strong></font></td> \n";
      print "<td><input name=\"Resp_Name\" size=45 maxlength=250 class=\"fields\" value=\"$DB_ResponderName\"></td>\n";
      print "</tr> \n";
      print "<tr><td width=\"200\"><font size=2><strong>Opt In Method:</strong></font></td> \n";
      print "<td align=\"center\">\n";
      print "<table><tr><td width=70>";
      print "<input type=\"radio\" name=\"OptMethod\" value=\"Single\" $opt_1> Single \n";
      print "</td><td width=30></td><td width=70>";
      print "<input type=\"radio\" name=\"OptMethod\" value=\"Double\" $opt_2> Double\n";
      print "</td></tr></table>";
      print "</td>\n";
      print "</tr>\n";
      print "<tr><td width=\"200\"><font size=2><strong>From Name:</strong></font></td> \n";
      print "<td><input name=\"Owner_Name\" size=45 maxlength=97 value=\"$DB_OwnerName\" class=\"fields\"></td>\n";
      print "</tr> \n";
      print "<tr><td width=\"200\"><font size=2><strong>From Email:</strong></font></td>\n";
      print "<td><input name=\"Owner_Email\" size=45 maxlength=100 value=\"$DB_OwnerEmail\" class=\"fields\"></td>\n";
      print "</tr> \n";
      print "<tr><td width=\"200\"><font size=2><strong>Reply-to Email:</strong></font></td> \n";
      print "<td><input name=\"Reply_To\" size=45 maxlength=100 value=\"$DB_ReplyToEmail\" class=\"fields\"></td> \n";
      print "</tr> \n";
      print "<tr> \n";
	  print "<tr><td width=\"200\"><font size=2><strong>Notify Owner on Sub/Unsub:</strong></font></td> \n";
      print "<td align=\"center\">\n";
      print "<table><tr><td width=70>";
      if ($DB_NotifyOnSub == 1) {
         print "    <input type=\"RADIO\" name=\"NotifyOwner\" value=\"1\" checked> Yes \n";
         print "</td><td width=30></td><td width=70>";
         print "    <input type=\"RADIO\" name=\"NotifyOwner\" value=\"0\"> No\n";
      } else {
         print "    <input type=\"RADIO\" name=\"NotifyOwner\" value=\"1\"> Yes \n";
         print "</td><td width=30></td><td width=70>";
         print "    <input type=\"RADIO\" name=\"NotifyOwner\" value=\"0\" checked> No\n";
      }
      print "</td></tr></table>";
      print "</td>\n";
      print "</tr>\n";
      print "<td colspan=\"2\"> \n";
      print "<br> \n";
      print "<font size=2><strong>Responder Description:</strong></font> --- <em>[Note: Supports HTML]</em><br> \n";
      print "<textarea name=\"Resp_Desc\" rows=7 cols=90 class=\"html_area\">$DB_ResponderDesc</textarea> \n";
      print "<br><br></td> \n";
      print "</tr> \n";
      print "<tr><td width=\"200\"><font size=2><strong>Opt-In Redirect URL:</strong></font></td> \n";
      print "<td><input name=\"OptInRedir\" size=45 maxlength=100 value=\"$DB_OptInRedir\" class=\"fields\"></td>\n";
      print "</tr> \n";
      print "<tr><td width=\"200\"><font size=2><strong>Opt-Out Redirect URL:</strong></font></td> \n";
      print "<td><input name=\"OptOutRedir\" size=45 maxlength=100 value=\"$DB_OptOutRedir\" class=\"fields\"></td>\n";
      print "</tr> \n";
      print "<tr> \n";
      print "<td colspan=\"2\"> \n";
      print "<br> \n";
      print "<font size=2><strong>Opt-In Confirmation Page:</strong></font> --- <em>[Note: Supports HTML]</em><br> \n";
      print "<textarea name=\"OptInDisplay\" rows=7 cols=90 class=\"html_area\">".stripslashes($DB_OptInDisplay)."</textarea> \n";
      print "</td> \n";
      print "</tr> \n";
      print "<tr> \n";
      print "<td colspan=\"2\"> \n";
      print "<br> \n";
      print "<font size=2><strong>Opt-Out Confirmation Page:</strong></font> --- <em>[Note: Supports HTML]</em><br> \n";
      print "<textarea name=\"OptOutDisplay\" rows=7 cols=90 class=\"html_area\">".stripslashes($DB_OptOutDisplay)."</textarea> \n";
      print "</td> \n";
      print "</tr> \n";
      print "<tr> \n";
      print "<td colspan=\"2\">\n";
      print "<input type=\"hidden\" name=\"action\" value=\"do_update\"> \n";
      print "<input type=\"hidden\" name=\"r_ID\"   value=\"$Responder_ID\"> \n";
      print "<p align=\"right\"> \n";
      print "<input type=\"hidden\" name=\"page\" value=\"infinityresponder\"> \n";
      print "<input type=\"hidden\" name=\"subpage\" value=\"responders\"> \n";
      print "<input class=\"button-primary\" type=\"submit\" name=\"Save\" value=\"Save Responder\" alt=\"Save\">  \n";
      // MOD was class=\"save_b\"
      print "</p> \n";
      print "</td> \n";
      print "</tr> \n";
      print "</td></tr></table> \n";
      print "</center> \n";
      print "</FORM> \n";
      print "</td></tr></table> \n";
      print "</center> \n";
      print "<br> \n";
      print "</td></tr></table> \n";
      print "<table width=\"100%\"><tr> \n";
      print "<td width=\"200\"> \n";
      // MOD Action to Wordpress Menu
      print "<FORM action=\"\" method=GET> \n";
      print "<input type=\"hidden\" name=\"page\" value=\"infinityresponder\"> \n";
      print "<input type=\"hidden\" name=\"subpage\" value=\"responders\"> \n";
      print "<input type=\"hidden\" name=\"action\" value=\"list\"> \n";
      print "<input type=\"submit\" name=\"back\"   value=\"<< Back to Responders\" alt=\"<< Back to Responders\" class=\"b_b\">  \n";
      print "</FORM> \n";
      print "</td> \n";
      print "<td width=\"200\">\n";
      // MOD Action to Wordpress Menu
      print "<FORM action=\"\" method=GET>\n";
      print "<input type=\"hidden\" name=\"page\" value=\"infinityresponder\"> \n";
      print "<input type=\"hidden\" name=\"subpage\" value=\"admin\"> \n";
      print "<input type=\"hidden\" name=\"action\"     value=\"custom_stuff\">\n";
      print "<input type=\"hidden\" name=\"r_ID\"       value=\"$Responder_ID\">\n";
      print "<input type=\"submit\" name=\"submit\"     value=\"Custom Field Data\">\n";
      print "</FORM>\n";
      print "</td>\n";
      print "<td width=\"80\"> \n";
      // MOD Action to Wordpress Menu
      print "<FORM action=\"\" method=POST> \n";
      print "<input type=\"hidden\" name=\"page\" value=\"infinityresponder\"> \n";
      print "<input type=\"hidden\" name=\"subpage\" value=\"responders\"> \n";
      print "<input type=\"hidden\" name=\"action\" value=\"POP3\"> \n";
      print "<input type=\"hidden\" name=\"r_ID\"   value=\"$Responder_ID\"> \n";
      print "<input type=\"submit\" name=\"POP3\" value=\"POP3\" alt=\"POP3\"> \n";
      print "</FORM> \n";
      print "</td> \n";
      print "</tr></table> \n";
      print "</center> \n";
?>
