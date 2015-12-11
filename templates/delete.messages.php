<?php
# Modified 07/04/2013 by Plugin Review Network
# Modified by Infinity Responder development team: 2009-06-04

     print "<br>\n";
     print "<font size=4 color=\"#1EABDF\"> \n";
     print "<center>Confirm Message Deletion</center> \n";
     print "</font> <br> \n";
     print "<center><table width=\"550\" bgcolor=\"#F0F0F0\" style=\"border: 1px solid #000000;\"> \n";
     print "<tr><td valign=\"top\" width=\"550\"><font size=3 color=\"#666666\">Subject:</font></td></tr> \n";
     print "<tr><td valign=\"top\" width=\"550\"><font size=3 color=\"#003300\">$DB_MsgSub</font> \n";
     print "<br> \n";
     print "<br><hr style = \"border: 0; background-color: #000000; color: #000000; height: 1px; width: 100%;\"> \n";
     print "</td>\n";
     print "</tr> \n";

     print "<tr><td valign=\"top\" width=\"550\"><font size=3 color=\"#666666\">Body Text:</font></td></tr> \n";
     print "<tr><td valign=\"top\" width=\"550\"><font size=3 color=\"#330033\"> ".nl2br($DB_MsgBodyText)." </font> \n";
     print "<br> \n";
     print "<br><hr style = \"border: 0; background-color: #000000; color: #000000; height: 1px; width: 100%;\"> \n";
     print "</td>\n";
     print "</tr> \n";

     print "<tr><td valign=\"top\" width=\"550\"><font size=3 color=\"#666666\">Body HTML:</font></td></tr> \n";
     print "<tr><td valign=\"top\" width=\"550\"><font size=3 color=\"#003300\"> ".nl2br(htmlentities($DB_MsgBodyHTML))." </font> \n";
     print "<br> \n";
     print "<br><hr style = \"border: 0; background-color: #000000; color: #000000; height: 1px; width: 100%;\"> \n";
     print "</td>\n";
     print "</tr> \n";

     print "<tr><td valign=\"top\" width=\"550\"><font size=3 color=\"#666666\">Send Delay:</font></td></tr> \n";
     print "<tr><td valign=\"top\" width=\"550\"><font size=3 color=\"#330033\"> \n";
         print "$T_months months, ";
         print "$T_weeks weeks, ";
         print "$T_days days, ";
         print "$T_hours hours, ";
         print "$T_minutes minutes.\n";
     print "</font></td> \n";
     print "</tr> \n";
     print "<tr><td valign=\"top\" width=\"550\"><font size=3 color=\"#666666\">Send On: (Optional)</font></td></tr> \n";
     print "<tr><td valign=\"top\" width=\"550\"><font size=3 color=\"#330033\"> \n";
     if ($DB_absDay != "") {print "$DB_absDay @ $DB_absHours hours : $DB_absMins mins.<br>\n";}
     else {print "Not set.";}
     print "</font></td> \n";
     print "</tr> \n";
     print "</table> \n";
     print "<br> \n";
     print "<table cellspacing=\"10\" border=0 width=\"100%\"> \n";
     print "<tr><td colspan=\"2\">\n";
     print "<font size=3 color=\"#666666\"> \n";
     print "<center>Delete this message?</center>\n";
     print "</font> \n";
     print "</td></tr>\n";
     print "<tr> \n";
     print "<td> \n";
     // MOD Action to Wordpress Menu
     print "<FORM action=\"\" method=GET> \n";
     print "<input type=\"hidden\" name=\"page\" value=\"infinityresponder\"> \n";
     print "<input type=\"hidden\" name=\"subpage\" value=\"messages\"> \n";
     print "<input type=\"hidden\" name=\"action\" value=\"do_delete\"> \n";
     print "<input type=\"hidden\" name=\"r_ID\"   value=\"$Responder_ID\"> \n";
     print "<input type=\"hidden\" name=\"MSG_ID\"  value=\"$M_ID\"> \n";
     print "<p align=\"right\"> \n";
     print "<input class=\"button-secondary\" type=\"submit\" name=\"Yes\" value=\"Yes\"> \n";
     print "</p> \n";
     print "</FORM> \n";
     print "</td> \n";
     print "<td> \n";
     // MOD Action to Wordpress Menu
     print "<FORM action=\"\" method=GET> \n";
     print "<input type=\"hidden\" name=\"page\" value=\"infinityresponder\"> \n";
     print "<input type=\"hidden\" name=\"subpage\" value=\"responders\"> \n";
     print "<input type=\"hidden\" name=\"action\" value=\"messages\"> \n";
     print "<input type=\"hidden\" name=\"r_ID\"   value=\"$Responder_ID\"> \n";
     print "<p align=\"left\"> \n";
     print "<input class=\"button-secondary\" type=\"submit\" name=\"No\" value=\"No\"> \n";
     print "</p> \n";
     print "</FORM> \n";
     print "</td> \n";
     print "</tr> \n";
     print "</table></center>\n";
?>
<!-- MOD Action to Wordpress Menu -->
<FORM action="" method=GET>
   <input type="hidden" name="page" value="infinityresponder">
   <input type="hidden" name="subpage" value="responders">
   <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
   <input type="hidden" name="action" value="messages">
   <input type="submit" name="Back"  class="button-secondary" value="<< Back to Messages" alt="<< Back to Messages">
</FORM>
