<?php
# Modified 06/13/2013 by Plugin Review Network
      print "<br><table border=\"0\" cellspacing=\"0\" width=\"100%\">\n";
      print "<tr>\n";
      print "<td width=\"50%\"> \n";
      if ($SearchCount > 0) {
        print "<p align=\"left\">\n";
        // MOD Action to Wordpress Menu
        print "<form action=\"\" method=GET>\n";
        print "<input type=\"hidden\" name=\"page\" value=\"infinityresponder\"> \n";
        print "<input type=\"hidden\" name=\"subpage\" value=\"admin\"> \n";
        print "<input type=\"hidden\" name=\"action\" value=\"edit_users\">\n";
        print "<input type=\"hidden\" name=\"r_ID\" value=\"$Responder_ID\">\n";
        print "<input type=\"hidden\" name=\"Search_Count\" value=\"$Search_Count_BackStr\">\n";
        print "<input class=\"button-secondary\" type=\"submit\" name=\"Previous\" value=\"<< Previous Page\">\n";
        print "</form>\n";
        print "</p>\n";
      }
      print "</td>\n";
      print "<td align=\"right\" width=\"50%\">\n";
      if (($SearchCount + (mysql_num_rows($DB_search_result) - 1)) < $Max_Results_Count) {
        print "<p align=\"right\">\n";
        // MOD Action to Wordpress Menu
        print "<form action=\"\" method=GET>\n";
        print "<input type=\"hidden\" name=\"page\" value=\"infinityresponder\">";
        print "<input type=\"hidden\" name=\"subpage\" value=\"admin\">";
        print "<input type=\"hidden\" name=\"action\" value=\"edit_users\">\n";
        print "<input type=\"hidden\" name=\"r_ID\" value=\"$Responder_ID\">\n";
        print "<input type=\"hidden\" name=\"Search_Count\" value=\"$Search_Count_ForwardStr\">\n";
        print "<input class=\"button-secondary\" type=\"submit\" name=\"Next\" value=\"Next Page >>\">\n";
        print "</form>\n";
        print "</p>\n";
      }
      print "</td> \n";
      print "</tr> \n";
      print "</table> \n";
?>