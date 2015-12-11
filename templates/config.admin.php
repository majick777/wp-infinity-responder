<?php
    # Modified 06/13/2013 by Plugin Review Network
    print "<br>\n";
    // MOD Action to Wordpress Menu
    print "<FORM action=\"\" method=GET> \n";
    print "<input type=\"hidden\" name=\"page\" value=\"infinityresponder\"> \n";
    print "<input type=\"hidden\" name=\"subpage\" value=\"admin\"> \n";
    print "<input type=\"hidden\" name=\"action\" value=\"configure\"> \n";
    print "<input type=\"hidden\" name=\"r_ID\"   value=\"$Responder_ID\"> \n";
    print "<input class=\"button-secondary\" type=\"submit\" name=\"submit\" value=\"Config\" alt=\"Config\">\n";
    print "</FORM> \n";
?>