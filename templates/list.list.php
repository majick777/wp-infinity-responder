<?php
# Modified 06/16/2013 by Plugin Review Network 
# Modified by Infinity Responder development team: 2009-06-04

       print "<br><center>\n";
       print "<table border=0 width=\"560\" cellpadding=8 style=\"border: 1px solid #000000;\">\n";
       print "<tr><td width=\"460\" bgcolor=\"#1EABDF\">";
       print "<font size=4 color=\"#F0F0F0\">Name:</font> <font color=\"#FFFFFF\">$DB_ResponderName</font></td>\n";
       print "<td valign=\"middle\" width=\"60\" bgcolor=\"#1EABDF\"><center>\n";
       		// MOD Action to Wordpress Menu
            print "<form action=\"\" method=GET>\n";
            print "<input type=\"hidden\" name=\"page\" value=\"infinityresponder\"> \n";
            print "<input type=\"hidden\" name=\"subpage\" value=\"list\"> \n";
            print "<input type=\"hidden\" name=\"action\" value=\"subscribe\">\n";
            print "<input type=\"hidden\" name=\"r_ID\" value=\"$DB_ResponderID\">\n";
            print "<br><input class=\"button-secondary\" type=\"image\" src=\"$siteURL$ResponderDirectory/images/red-join.gif\" name=\"submit\" value=\"Subscribe\">\n";
            print "</form>\n";
       print "</center></td></tr>\n";
       print "<tr><td colspan=\"2\" bgcolor=\"#F0F0F0\"><font size=4 color=\"#003300\">Reply to:</font> <A HREF=\"mailto:$DB_ReplyToEmail$antispam?subject=Question about $DB_ResponderName\">$DB_ReplyToEmail$antispam</A></td></tr>\n";
       print "<tr><td colspan=\"2\" bgcolor=\"#F0F0F0\"><font size=4 color=\"#003300\">Owner:</font> <A HREF=\"mailto:$DB_OwnerEmail$antispam?subject=Question about $DB_ResponderName\">$DB_OwnerName</A></td></tr>\n";
       print "<tr><td colspan=\"2\" bgcolor=\"#1EABDF\"><img src=\"$siteURL$ResponderDirectory/images/resp-spacer3.gif\" border=0 height=\"1\" width=\"500\"><br>";
       print "<font size=4 color=\"#FFFFFF\"><strong>Description:</strong></font><br><font color=\"#FFFFFF\">$DB_ResponderDesc<br><br></font></td></tr>\n";

       if ($antispam != "") {
          print "<tr><td colspan=\"2\"><font size=2 color=\"#330000\"><strong>Note:</strong> In order to use these addresses you will have to remove \"$antispam\" from the end of the address first.";
          print "This is to make it harder for spammers to harvest the addresses on this page.</font></td></tr>\n";
       }
       print "</table></center>\n";
?>