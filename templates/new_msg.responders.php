<?php
   # Modified 04/29/2014 by Plugin Review Network
    print "<br><table width=100%><tr><td width=33% align=\"left\"> \n";
    // MOD action to Wordpress Menu
    print "<FORM action=\"\" method=GET> \n";
    print "<input type=\"hidden\" name=\"page\" value=\"infinityresponder\"> \n";
    print "<input type=\"hidden\" name=\"subpage\" value=\"responders\"> \n";
    print "<input type=\"hidden\" name=\"action\" value=\"list\"> \n";
    print "<input class=\"button-secondary\" type=\"submit\" name=\"back\"   value=\"<< Back to Responders\" alt=\"<< Back to Messages\" >  \n";
    print "</FORM>\n</td>";
    
    // MOD add refresh button
    print "<td width=33% align=\"center\">";
    print "<FORM action=\"\" method=GET> \n";
    print "<input type=\"hidden\" name=\"page\" value=\"infinityresponder\"> \n";
    print "<input type=\"hidden\" name=\"subpage\" value=\"responders\"> \n";
    print "<input type=\"hidden\" name=\"action\" value=\"messages\"> \n";
    print "<input type=\"hidden\" name=\"r_ID\" value=\"".$Responder_ID."\"> \n";
    print "<input class=\"button-secondary\" type=\"submit\" name=\"back\"   value=\"Refresh\" alt=\"Refresh\" >  \n";
    print "</FORM>\n</td>";
    
    print "<td width=33% align=\"right\">";
    // MOD action to Wordpress Menu
    print "<form action=\"\" method=GET> \n";
    print "<input type=\"hidden\" name=\"page\" value=\"infinityresponder\"> \n";
    print "<input type=\"hidden\" name=\"subpage\" value=\"messages\"> \n";
    print "<input type=\"hidden\" name=\"action\" value=\"create\"> \n";
    print "<input type=\"hidden\" name=\"r_ID\"   value=\"$Responder_ID\"> \n";
    print "<input class=\"button-primary\" type=\"submit\" name=\"submit\" value=\"Add New Message\"> \n";
    print "</form> \n";
    print "</td></tr></table> \n";
?>