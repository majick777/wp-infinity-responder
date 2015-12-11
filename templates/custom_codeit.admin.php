<?php
# Modified 12/13/2013 by Plugin Review Network
# Modified by Infinity Responder development team: 2009-06-04

if ($display_it == TRUE) {
     print "<br><b>Standard Field Names:</b><br>";
     print "f = first name, l = last name, e = email, ref = reference<br>";
     print "h = html, r = responder ID, a = action (sub/unsub)<br><br>";
     print "<b>Custom Field Names:</b><br>";
     print "cf_streetaddress_1, cf_streetaddress_2, cf_city, cf_state, cf_zipcode<br>";
     print "cf_homephone,  cf_hours, cf_best_contact_time<br>";
     print "cf_reason, cf_income, cf_interest, cf_other_offers<br><br>";     

     print "<b>Here's an example custom subscription form for that Responder ID:</b></font><br><br>\n";
     print "<center>\n";
     print "<br>\n";
     print "<form action=\"/?infresp=subscribe\" method=\"POST\"> \n";
     print "<input type=\"hidden\" name=\"r\" value=\"$Responder_ID\"> \n";
     print "<input type=\"hidden\" name=\"h\" value=\"1\"> \n";
     print "<input type=\"hidden\" name=\"a\" value=\"sub\"> \n";
     print "<input type=\"hidden\" name=\"ref\" value=\"customform\"> \n";
     print "<table width=\"365\" border=\"0\" cellspacing=\"10\" cellpadding=\"0\" bgcolor=\"#F0F0F0\" style=\"border: 1px solid #C0C0C0;\"> \n";
     print "<tr> \n";
     print "  <td colspan=\"2\" bgcolor=\"#3399ff\"> \n";
     print "      <font size=\"2\" color=\"#eae4fc face=\"Tahoma, Arial, Helvetica, sans-serif\"> \n";
     print "         <strong>Your Information:</strong> \n";
     print "      </font> \n";
     print "  </td> \n";
     print "</tr> \n";
     print "<tr> \n";
     print "  <td colspan=\"2\"> \n";
     print "    <strong> \n";
     print "      <font color=\"#003366\" face=\"arial\" size=\"2\"> \n";
     print "          Your Name (First, Last) \n";
     print "      </font> \n";
     print "    </strong> \n";
     print "    <br> \n";
     print "    <input type=\"text\" name=\"f\" size=20 maxlength=60> \n";
     print "    <input type=\"text\" name=\"l\" size=23 maxlength=60> \n";
     print "  </td> \n";
     print "</tr> \n";
     print "<tr> \n";
     print "  <td colspan=\"2\"> \n";
     print "    <strong> \n";
     print "      <font color=\"#003366\" face=\"arial\" size=\"2\"> \n";
     print "        Street Address Line 1: \n";
     print "      </font> \n";
     print "    </strong> \n";
     print "    <br> \n";
     print "    <input maxlength=\"95\" size=\"45\" name=\"cf_streetaddress_1\"> \n";
     print "  </td> \n";
     print "</tr> \n";
     print "<tr> \n";
     print "  <td colspan=\"2\"> \n";
     print "    <strong> \n";
     print "      <font color=\"#003366\" face=\"arial\" size=\"2\"> \n";
     print "          Street Address Line 2: \n";
     print "      </font> \n";
     print "    </strong> \n";
     print "    <br> \n";
     print "    <input maxlength=\"95\" size=\"45\" name=\"cf_streetaddress_2\"> \n";
     print "  </td> \n";
     print "</tr> \n";
     print "<tr> \n";
     print "   <td colspan=\"2\"> \n";
     print "     <strong> \n";
     print "      <font color=\"#003366\" face=\"arial\" size=\"2\"> \n";
     print "          City: \n";
     print "      </font> \n";
     print "     </strong> \n";
     print "     <br> \n";
     print "     <input maxlength=\"95\" size=\"45\" name=\"cf_city\"> \n";
     print "   </td> \n";
     print "</tr> \n";
     print "<tr> \n";
     print "   <td> \n";
     print "     <strong> \n";
     print "      <font color=\"#003366\" face=\"arial\" size=\"2\"> \n";
     print "          State: \n";
     print "      </font> \n";
     print "     </strong> \n";
     print "     <br> \n";
     print "     <select name=\"cf_state\"> \n";
     print "       <option value=\"al\">AL</option> \n";
     print "       <option value=\"ak\">AK</option> \n";
     print "       <option value=\"az\">AZ</option> \n";
     print "       <option value=\"ar\">AR</option> \n";
     print "       <option value=\"ca\">CA</option> \n";
     print "       <option value=\"co\">CO</option> \n";
     print "       <option value=\"ct\">CT</option> \n";
     print "       <option value=\"de\">DE</option> \n";
     print "       <option value=\"dc\">DC</option> \n";
     print "       <option value=\"fl\">FL</option> \n";
     print "       <option value=\"ga\">GA</option> \n";
     print "       <option value=\"hi\">HI</option> \n";
     print "       <option value=\"id\">ID</option> \n";
     print "       <option value=\"il\">IL</option> \n";
     print "       <option value=\"in\">IN</option> \n";
     print "       <option value=\"ia\">IA</option> \n";
     print "       <option value=\"ks\">KS</option> \n";
     print "       <option value=\"ky\">KY</option> \n";
     print "       <option value=\"la\">LA</option> \n";
     print "       <option value=\"me\">ME</option> \n";
     print "       <option value=\"md\">MD</option> \n";
     print "       <option value=\"ma\">MA</option> \n";
     print "       <option value=\"mi\">MI</option> \n";
     print "       <option value=\"mn\">MN</option> \n";
     print "       <option value=\"ms\">MS</option> \n";
     print "       <option value=\"mo\">MO</option> \n";
     print "       <option value=\"mt\">MT</option> \n";
     print "       <option value=\"ne\">NE</option> \n";
     print "       <option value=\"nv\">NV</option> \n";
     print "       <option value=\"nh\">NH</option> \n";
     print "       <option value=\"nj\">NJ</option> \n";
     print "       <option value=\"nm\">NM</option> \n";
     print "       <option value=\"ny\">NY</option> \n";
     print "       <option value=\"nc\">NC</option> \n";
     print "       <option value=\"nd\">ND</option> \n";
     print "       <option value=\"oh\">OH</option> \n";
     print "       <option value=\"ok\">OK</option> \n";
     print "       <option value=\"or\">OR</option> \n";
     print "       <option value=\"pa\">PA</option> \n";
     print "       <option value=\"ri\">RI</option> \n";
     print "       <option value=\"sc\">SC</option> \n";
     print "       <option value=\"sd\">SD</option> \n";
     print "       <option value=\"tn\">TN</option> \n";
     print "       <option value=\"tx\">TX</option> \n";
     print "       <option value=\"ut\">UT</option> \n";
     print "       <option value=\"vt\">VT</option> \n";
     print "       <option value=\"va\">VA</option> \n";
     print "       <option value=\"wa\">WA</option> \n";
     print "       <option value=\"wi\">WI</option> \n";
     print "       <option value=\"wv\">WV</option> \n";
     print "       <option value=\"wy\">WY</option> \n";
     print "     </select> \n";
     print "   </td> \n";
     print "   <td> \n";
     print "     <strong> \n";
     print "      <font color=\"#003366\" face=\"arial\" size=\"2\"> \n";
     print "          Zipcode: \n";
     print "      </font> \n";
     print "     </strong> \n";
     print "     <br> \n";
     print "     <input maxlength=\"14\" size=\"15\" name=\"cf_zipcode\"> </font></td> \n";
     print "</tr> \n";
     print "<tr> \n";
     print "   <td colspan=\"2\"> \n";
     print "     <strong> \n";
     print "      <font color=\"#003366\" face=\"arial\" size=\"2\"> \n";
     print "          Home Phone: (ie: 999-555-1234): \n";
     print "      </font> \n";
     print "     </strong> \n";
     print "     <br> \n";
     print "     <input maxlength=\"20\" size=\"15\" name=\"cf_homephone\"> -  \n";
     print "   </td> \n";
     print "</tr> \n";

     print "<tr> \n";
     print "  <td colspan=\"2\"> \n";
     print "    <strong> \n";
     print "      <font color=\"#003366\" face=\"arial\" size=\"2\"> \n";
     print "        Reason: \n";
     print "      </font> \n";
     print "    </strong> \n";
     print "    <br> \n";
     print "    <input maxlength=\"99\" size=\"45\" name=\"cf_reason\"> \n";
     print "  </td> \n";
     print "</tr> \n";
     print "<tr> \n";
     print "  <td colspan=\"2\"> \n";
     print "    <strong> \n";
     print "      <font color=\"#003366\" face=\"arial\" size=\"2\"> \n";
     print "        Income: \n";
     print "      </font> \n";
     print "    </strong> \n";
     print "    <br> \n";
     print "    <input maxlength=\"99\" size=\"45\" name=\"cf_income\"> \n";
     print "  </td> \n";
     print "</tr> \n";
     print "<tr> \n";
     print "  <td colspan=\"2\"> \n";
     print "    <strong> \n";
     print "      <font color=\"#003366\" face=\"arial\" size=\"2\"> \n";
     print "        Interest: \n";
     print "      </font> \n";
     print "    </strong> \n";
     print "    <br> \n";
     print "    <input maxlength=\"99\" size=\"45\" name=\"cf_interest\"> \n";
     print "  </td> \n";
     print "</tr> \n";
     print "<tr> \n";
     print "  <td colspan=\"2\"> \n";
     print "    <strong> \n";
     print "      <font color=\"#003366\" face=\"arial\" size=\"2\"> \n";
     print "        Hours: \n";
     print "      </font> \n";
     print "    </strong> \n";
     print "    <br> \n";
     print "    <input maxlength=\"99\" size=\"45\" name=\"cf_hours\"> \n";
     print "  </td> \n";
     print "</tr> \n";

     print "<tr> \n";
     print "   <td colspan=\"2\"> \n";
     print "     <strong> \n";
     print "      <font color=\"#003366\" face=\"arial\" size=\"2\"> \n";
     print "          Email Address  \n";
     print "      </font> \n";
     print "      <font color=\"#003366\" size=\"1\" face=\"arial\"> \n";
     print "          (Required for Confirmation) \n";
     print "      </font> \n";
     print "     </strong> \n";
     print "     <br> \n";
     print "     <input type=\"text\" name=\"e\" size=45 maxlength=50><br> \n";
     print "   </td> \n";
     print "</tr> \n";
     print "<tr> \n";
     print "   <td colspan=\"2\"> \n";
     print "     <strong> \n";
     print "      <font color=\"#003366\" face=\"arial\" size=\"2\"> \n";
     print "          Best Time To Contact You? \n";
     print "      </font> \n";
     print "     </strong> \n";
     print "     <br> \n";
     print "     <select name=\"cf_best_contact_time\"> \n";
     print "         <option value=\"Early morning (before 8am)\">Early morning (before 8am) \n";
     print "         <option value=\"Morning (8am to 11am)\">Morning (8am to 11am) \n";
     print "         <option value=\"Noon (11am to 1pm)\">Noon (11am to 1pm) \n";
     print "         <option value=\"Afternoon (1pm to 3pm)\" SELECTED>Afternoon (1pm to 3pm) \n";
     print "         <option value=\"Late afternoon (3pm to 6pm)\">Late afternoon (3pm to 6pm) \n";
     print "         <option value=\"Evening (6pm to 8pm)\">Evening (6pm to 8pm) \n";
     print "         <option value=\"Night-time (8pm to 10pm)\">Night-time (8pm to 10pm) \n";
     print "         <option value=\"Late night (10pm to midnight)\">Late night (10pm to midnight) \n";
     print "     </select> \n";
     print "</tr> \n";
     print "</table> \n";
     print "<font color=\"#003366\" face=\"Tahoma, Arial, Helvetica, sans-serif\" size=\"1\"> \n";
     print "  I want to receive additional free offers. \n";
     print "</font> \n";
     print "<input checked=\"checked\" type=\"checkbox\" name=\"cf_other_offers\" value=\"1\"> \n";
     print "<input id=\"submit\" type=\"submit\" value=\"Submit\"> \n";
     print "</form> \n";
     print "</center> \n";

     print "<br><hr style = \"border: 0; background-color: #666666; color: #666666; height: 1px; width: 100%;\"><br>\n";
     print "<b>Example HTML Code:</b><br><br>\n";

     print "&lt;form action=\"/?infresp=subscribe\" method=\"post\"&gt; <br>\n";
     print "&lt;input type=\"hidden\" name=\"r\" value=\"$Responder_ID\"&gt; <br>\n";
     print "&lt;input type=\"hidden\" name=\"h\" value=\"1\"&gt; <br>\n";
     print "&lt;input type=\"hidden\" name=\"a\" value=\"sub\"&gt; <br>\n";
     print "&lt;input type=\"hidden\" name=\"ref\" value=\"customform\"&gt; <br>\n";
     print "&lt;table width=\"365\" border=\"0\" cellspacing=\"6\" cellpadding=\"0\" style=\"border: 1px solid #000000;\"&gt; <br>\n";
     print "&lt;tr&gt; <br>\n";
     print "  &lt;td colspan=\"2\" bgcolor=\"#3399ff\"&gt; <br>\n";
     print "      &lt;font size=\"2\" color=\"#eae4fc face=\"Tahoma, Arial, Helvetica, sans-serif\"&gt; <br>\n";
     print "         &lt;strong&gt;Your Information:&lt;/strong&gt; <br>\n";
     print "      &lt;/font&gt; <br>\n";
     print "  &lt;/td&gt; <br>\n";
     print "&lt;/tr&gt; <br>\n";
     print "&lt;tr&gt; <br>\n";
     print "  &lt;td colspan=\"2\"&gt; <br>\n";
     print "    &lt;strong&gt; <br>\n";
     print "      &lt;font color=\"#003366\" face=\"arial\" size=\"2\"&gt; <br>\n";
     print "          Your Name (First, Last) <br>\n";
     print "      &lt;/font&gt; <br>\n";
     print "    &lt;/strong&gt; <br>\n";
     print "    &lt;br&gt; <br>\n";
     print "    &lt;input type=\"text\" name=\"f\" size=20 maxlength=60&gt; <br>\n";
     print "    &lt;input type=\"text\" name=\"l\" size=23 maxlength=60&gt; <br>\n";
     print "  &lt;/td&gt; <br>\n";
     print "&lt;/tr&gt; <br>\n";
     print "&lt;tr&gt; <br>\n";
     print "  &lt;td colspan=\"2\"&gt; <br>\n";
     print "    &lt;strong&gt; <br>\n";
     print "      &lt;font color=\"#003366\" face=\"arial\" size=\"2\"&gt; <br>\n";
     print "        Street Address Line 1: <br>\n";
     print "      &lt;/font&gt; <br>\n";
     print "    &lt;/strong&gt; <br>\n";
     print "    &lt;br&gt; <br>\n";
     print "    &lt;input maxlength=\"95\" size=\"45\" name=\"cf_streetaddress_1\"&gt; <br>\n";
     print "  &lt;/td&gt; <br>\n";
     print "&lt;/tr&gt; <br>\n";
     print "&lt;tr&gt; <br>\n";
     print "  &lt;td colspan=\"2\"&gt; <br>\n";
     print "    &lt;strong&gt; <br>\n";
     print "      &lt;font color=\"#003366\" face=\"arial\" size=\"2\"&gt; <br>\n";
     print "          Street Address Line 2: <br>\n";
     print "      &lt;/font&gt; <br>\n";
     print "    &lt;/strong&gt; <br>\n";
     print "    &lt;br&gt; <br>\n";
     print "    &lt;input maxlength=\"95\" size=\"45\" name=\"cf_streetaddress_2\"&gt; <br>\n";
     print "  &lt;/td&gt; <br>\n";
     print "&lt;/tr&gt; <br>\n";
     print "&lt;tr&gt; <br>\n";
     print "   &lt;td colspan=\"2\"&gt; <br>\n";
     print "     &lt;strong&gt; <br>\n";
     print "      &lt;font color=\"#003366\" face=\"arial\" size=\"2\"&gt; <br>\n";
     print "          City: <br>\n";
     print "      &lt;/font&gt; <br>\n";
     print "     &lt;/strong&gt; <br>\n";
     print "     &lt;br&gt; <br>\n";
     print "     &lt;input maxlength=\"95\" size=\"45\" name=\"cf_city\"&gt; <br>\n";
     print "   &lt;/td&gt; <br>\n";
     print "&lt;/tr&gt; <br>\n";
     print "&lt;tr&gt; <br>\n";
     print "   &lt;td&gt; <br>\n";
     print "     &lt;strong&gt; <br>\n";
     print "      &lt;font color=\"#003366\" face=\"arial\" size=\"2\"&gt; <br>\n";
     print "          State: <br>\n";
     print "      &lt;/font&gt; <br>\n";
     print "     &lt;/strong&gt; <br>\n";
     print "     &lt;br&gt; <br>\n";
     print "     &lt;select name=\"cf_state\"&gt; <br>\n";
     print "       &lt;option value=\"al\"&gt;AL&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"ak\"&gt;AK&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"az\"&gt;AZ&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"ar\"&gt;AR&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"ca\"&gt;CA&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"co\"&gt;CO&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"ct\"&gt;CT&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"de\"&gt;DE&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"dc\"&gt;DC&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"fl\"&gt;FL&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"ga\"&gt;GA&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"hi\"&gt;HI&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"id\"&gt;ID&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"il\"&gt;IL&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"in\"&gt;IN&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"ia\"&gt;IA&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"ks\"&gt;KS&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"ky\"&gt;KY&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"la\"&gt;LA&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"me\"&gt;ME&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"md\"&gt;MD&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"ma\"&gt;MA&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"mi\"&gt;MI&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"mn\"&gt;MN&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"ms\"&gt;MS&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"mo\"&gt;MO&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"mt\"&gt;MT&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"ne\"&gt;NE&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"nv\"&gt;NV&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"nh\"&gt;NH&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"nj\"&gt;NJ&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"nm\"&gt;NM&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"ny\"&gt;NY&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"nc\"&gt;NC&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"nd\"&gt;ND&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"oh\"&gt;OH&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"ok\"&gt;OK&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"or\"&gt;OR&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"pa\"&gt;PA&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"ri\"&gt;RI&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"sc\"&gt;SC&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"sd\"&gt;SD&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"tn\"&gt;TN&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"tx\"&gt;TX&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"ut\"&gt;UT&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"vt\"&gt;VT&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"va\"&gt;VA&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"wa\"&gt;WA&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"wi\"&gt;WI&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"wv\"&gt;WV&lt;/option&gt; <br>\n";
     print "       &lt;option value=\"wy\"&gt;WY&lt;/option&gt; <br>\n";
     print "     &lt;/select&gt; <br>\n";
     print "   &lt;/td&gt; <br>\n";
     print "   &lt;td&gt; <br>\n";
     print "     &lt;strong&gt; <br>\n";
     print "      &lt;font color=\"#003366\" face=\"arial\" size=\"2\"&gt; <br>\n";
     print "          Zipcode: <br>\n";
     print "      &lt;/font&gt; <br>\n";
     print "     &lt;/strong&gt; <br>\n";
     print "     &lt;br&gt; <br>\n";
     print "     &lt;input maxlength=\"14\" size=\"15\" name=\"cf_zipcode\"&gt; &lt;/font&gt;&lt;/td&gt; <br>\n";
     print "&lt;/tr&gt; <br>\n";
     print "&lt;tr&gt; <br>\n";
     print "   &lt;td colspan=\"2\"&gt; <br>\n";
     print "     &lt;strong&gt; <br>\n";
     print "      &lt;font color=\"#003366\" face=\"arial\" size=\"2\"&gt; <br>\n";
     print "          Home Phone: (ie: 999-555-1234): <br>\n";
     print "      &lt;/font&gt; <br>\n";
     print "     &lt;/strong&gt; <br>\n";
     print "     &lt;br&gt; <br>\n";
     print "     &lt;input maxlength=\"20\" size=\"15\" name=\"cf_homephone\"&gt; -  <br>\n";
     print "   &lt;/td&gt; <br>\n";
     print "&lt;/tr&gt; <br>\n";

     print "&lt;tr&gt; <br>\n";
     print "  &lt;td colspan=\"2\"&gt; <br>\n";
     print "    &lt;strong&gt; <br>\n";
     print "      &lt;font color=\"#003366\" face=\"arial\" size=\"2\"&gt; <br>\n";
     print "        Reason: <br>\n";
     print "      &lt;/font&gt; <br>\n";
     print "    &lt;/strong&gt; <br>\n";
     print "    &lt;br&gt; <br>\n";
     print "    &lt;input maxlength=\"99\" size=\"45\" name=\"cf_reason\"&gt; <br>\n";
     print "  &lt;/td&gt; <br>\n";
     print "&lt;/tr&gt; <br>\n";
     print "&lt;tr&gt; <br>\n";
     print "  &lt;td colspan=\"2\"&gt; <br>\n";
     print "    &lt;strong&gt; <br>\n";
     print "      &lt;font color=\"#003366\" face=\"arial\" size=\"2\"&gt; <br>\n";
     print "        Income: <br>\n";
     print "      &lt;/font&gt; <br>\n";
     print "    &lt;/strong&gt; <br>\n";
     print "    &lt;br&gt; <br>\n";
     print "    &lt;input maxlength=\"99\" size=\"45\" name=\"cf_income\"&gt; <br>\n";
     print "  &lt;/td&gt; <br>\n";
     print "&lt;/tr&gt; <br>\n";
     print "&lt;tr&gt; <br>\n";
     print "  &lt;td colspan=\"2\"&gt; <br>\n";
     print "    &lt;strong&gt; <br>\n";
     print "      &lt;font color=\"#003366\" face=\"arial\" size=\"2\"&gt; <br>\n";
     print "        Interest: <br>\n";
     print "      &lt;/font&gt; <br>\n";
     print "    &lt;/strong&gt; <br>\n";
     print "    &lt;br&gt; <br>\n";
     print "    &lt;input maxlength=\"99\" size=\"45\" name=\"cf_interest\"&gt; <br>\n";
     print "  &lt;/td&gt; <br>\n";
     print "&lt;/tr&gt; <br>\n";
     print "&lt;tr&gt; <br>\n";
     print "  &lt;td colspan=\"2\"&gt; <br>\n";
     print "    &lt;strong&gt; <br>\n";
     print "      &lt;font color=\"#003366\" face=\"arial\" size=\"2\"&gt; <br>\n";
     print "        Hours: <br>\n";
     print "      &lt;/font&gt; <br>\n";
     print "    &lt;/strong&gt; <br>\n";
     print "    &lt;br&gt; <br>\n";
     print "    &lt;input maxlength=\"99\" size=\"45\" name=\"cf_hours\"&gt; <br>\n";
     print "  &lt;/td&gt; <br>\n";
     print "&lt;/tr&gt; <br>\n";

     print "&lt;tr&gt; <br>\n";
     print "   &lt;td colspan=\"2\"&gt; <br>\n";
     print "     &lt;strong&gt; <br>\n";
     print "      &lt;font color=\"#003366\" face=\"arial\" size=\"2\"&gt; <br>\n";
     print "          Email Address  <br>\n";
     print "      &lt;/font&gt; <br>\n";
     print "      &lt;font color=\"#003366\" size=\"1\" face=\"arial\"&gt; <br>\n";
     print "          (Required for Confirmation) <br>\n";
     print "      &lt;/font&gt; <br>\n";
     print "     &lt;/strong&gt; <br>\n";
     print "     &lt;br&gt; <br>\n";
     print "     &lt;input type=\"text\" name=\"e\" size=45 maxlength=50&gt;&lt;br&gt; <br>\n";
     print "   &lt;/td&gt; <br>\n";
     print "&lt;/tr&gt; <br>\n";
     print "&lt;tr&gt; <br>\n";
     print "   &lt;td colspan=\"2\"&gt; <br>\n";
     print "     &lt;strong&gt; <br>\n";
     print "      &lt;font color=\"#003366\" face=\"arial\" size=\"2\"&gt; <br>\n";
     print "          Best Time To Contact You? <br>\n";
     print "      &lt;/font&gt; <br>\n";
     print "     &lt;/strong&gt; <br>\n";
     print "     &lt;br&gt; <br>\n";
     print "     &lt;select name=\"cf_best_contact_time\"&gt; <br>\n";
     print "         &lt;option value=\"Early morning (before 8am)\"&gt;Early morning (before 8am) <br>\n";
     print "         &lt;option value=\"Morning (8am to 11am)\"&gt;Morning (8am to 11am) <br>\n";
     print "         &lt;option value=\"Noon (11am to 1pm)\"&gt;Noon (11am to 1pm) <br>\n";
     print "         &lt;option value=\"Afternoon (1pm to 3pm)\" SELECTED&gt;Afternoon (1pm to 3pm) <br>\n";
     print "         &lt;option value=\"Late afternoon (3pm to 6pm)\"&gt;Late afternoon (3pm to 6pm) <br>\n";
     print "         &lt;option value=\"Evening (6pm to 8pm)\"&gt;Evening (6pm to 8pm) <br>\n";
     print "         &lt;option value=\"Night-time (8pm to 10pm)\"&gt;Night-time (8pm to 10pm) <br>\n";
     print "         &lt;option value=\"Late night (10pm to midnight)\"&gt;Late night (10pm to midnight) <br>\n";
     print "     &lt;/select&gt; <br>\n";
     print "&lt;/tr&gt; <br>\n";
     print "&lt;/table&gt; <br>\n";
     print "&lt;font color=\"#003366\" face=\"Tahoma, Arial, Helvetica, sans-serif\" size=\"1\"&gt; <br>\n";
     print "  I want to receive additional free offers. <br>\n";
     print "&lt;/font&gt; <br>\n";
     print "&lt;input checked=\"checked\" type=\"checkbox\" name=\"cf_other_offers\" value=\"1\"&gt; <br>\n";
     print "&lt;input id=\"submit\" type=\"submit\" value=\"Submit\"&gt; <br>\n";
     print "&lt;/form&gt; <br>\n";
     #print "<br>\n";
     $display_it = TRUE;
}
?>