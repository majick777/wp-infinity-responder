<?php
# Modified 12/14/2013 by Plugin Review Network
# Modified by Infinity Responder development team: 2009-06-04

   // include_once('popup_js.php');
?>

<table width="550" cellpadding="0" cellspacing="5" bgcolor="#1EABDF" style="border: 1px solid #000000;">
   <tr>
      <td>
         <p align="center" style="font-size: 18px"><font color="#FFFFFF">Responder Subscription Forms</font></p>
      </td>
   </tr>
</table><br>
      	 <!-- MOD Action to Wordpress Menu -->
         <FORM action="" method=GET>
		    <input type="hidden" name="page" value="infinityresponder">
     		<input type="hidden" name="subpage" value="admin">
            <input type="hidden" name="action" value="custom_codeit">
            <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
            <input class="button-secondary" type="submit" name="submit" value="Custom Fields Form">
         </FORM>
<br />

<?php

print "<font size=\"3\" color=\"#003300\">Here are your subscription forms for that Responder ID:</font><br><br>\n";
     
$form1 = '<center><form class="ir_form" action="'.site_url().'/" method=GET>
<input type="hidden" name="infresp" value="subscribe">
<input type="hidden" name="r" value="'.$Responder_ID.'">
<input type="hidden" name="a" value="sub">
<input type="hidden" name="ref" value="subform">
<input type="hidden" name="h" value="1">
<table class="ir_table" cellspacing="10" bgcolor="#F0F0F0" style="border: 1px solid #C0C0C0;">
<tr><td class="ir_table_cell" align="center"><input class="ir_name" type="text" name="f" style="background-color:#FFFFFF;" size=21 maxlength=50 placeholder="Your Name..."></td></tr>
<tr><td class="ir_table_cell" align="center"><input class="ir_email" type="text" name="e" style="background-color:#FFFFFF;" size=21 maxlength=100 placeholder="Your Email..."></td></tr>
<tr><td class="ir_table_call" align="center"><input class="ir_submit" type="submit" class="ir_submit" name="submit" value="Subscribe Now"></td></tr>
</table></form></center>';

$form2 = '<center><form class="ir_form" action="'.site_url().'/" method=GET>
<input type="hidden" name="infresp" value="subscribe">
<input type="hidden" name="r" value="'.$Responder_ID.'">
<input type="hidden" name="a" value="sub">
<input type="hidden" name="ref" value="subform">
<input type="hidden" name="h" value="1">
<table class="ir_table" cellspacing="10" bgcolor="#F0F0F0" style="border: 1px solid #C0C0C0;">
<tr><td class="ir_table_cell" align="center"><input class="ir_name" type="text" name="f" style="background-color:#FFFFFF;" size=21 maxlength=50 placeholder="Your Name..."></td></tr>
<tr><td class="ir_table_cell" align="center"><input class="ir_email" type="text" name="e" style="background-color:#FFFFFF;" size=21 maxlength=100 placeholder="Your Email..."></td></tr>
<tr><td class="ir_table_call" align="center"><input class="ir_submit" type="image" class="ir_submit" name="submit" src="'.$siteURL.$ResponderDirectory.'/images/subscribe.png" value="Subscribe Now"></td></tr>
</table></form></center>';

     print '<table><tr><td><b>New Style:</b><br><br>'.$form1.'</td><td width=40></td>';
     print '<td><b>HTML Code:</b><br><textarea style="width:350px;height:150px;">'.$form1.'</textarea></td></tr>';
     print '<tr height=30><td> </td></tr>';
     print '<table><tr><td><b>New Style with Image Button:</b><br><br>'.$form2.'</td><td width=40></td>';
     print '<td><b>HTML Code:</b><br><textarea style="width:350px;height:150px;">'.$form1.'</textarea></td></tr>';
     print '</table><br>';

     print '<b>CSS styles for the above forms are available with the following classes:</b><br>';
     print '.ir_form .ir_table .ir_table_cell .ir_name .ir_email .ir_submit<br>';
     
     print "<br><hr style = \"border: 0; background-color: #666666; color: #666666; height: 1px; width: 100%;\">\n";
     print "<b>Old Style Form:</b><br><br>\n";
     print "<center>\n";
     print "<table cellspacing=\"10\" bgcolor=\"#F0F0F0\" style=\"border: 1px solid #000000;\"><tr><td>\n";
     print "<form action=\"$siteURL$ResponderDirectory/s.php\" method=GET>\n";
     print "<strong><font color=\"#666666\">Your name (First, Last):</font></strong><br>\n";
     print "<input type=\"text\" name=\"f\" style=\"background-color : #FFFFFF\" size=11 maxlength=40> \n";
     print "<input type=\"text\" name=\"l\" style=\"background-color : #FFFFFF\" size=11 maxlength=40>\n";
     print "<br><br>\n";
     print "<strong><font color=\"#666666\">Email address:</font></strong><br>\n";
     print "<input type=\"text\" name=\"e\" style=\"background-color : #FFFFFF\" size=20 maxlength=50>\n";
     print "<input type=\"image\" src=\"$siteURL$ResponderDirectory/images/go-button.gif\" name=\"submit\" value=\"Submit\"><br>\n";
     print "<input type=\"hidden\" name=\"r\"   value=\"$Responder_ID\">\n";
     print "<input type=\"hidden\" name=\"a\"   value=\"sub\">\n";
     print "<input type=\"hidden\" name=\"ref\" value=\"none\">\n";
     print "<br>\n";
     print "<font color=\"#003300\">HTML: <input type=\"RADIO\" name=\"h\" value=\"1\">Yes &nbsp;\n";
     print "<input type=\"RADIO\" name=\"h\" value=\"0\" checked=\"checked\">No<br>\n";
     print "</font></form>\n";
     print "</td></tr></table>\n";
     print "</center>\n";
     
     print "<br><b>HTML Code:</b><br><br>\n";
     print "&lt;center&gt;<br>\n";
     print "&lt;table cellspacing=\"10\" bgcolor=\"#F0F0F0\" style=\"border: 1px solid #000000;\"&gt;&lt;tr&gt;&lt;td&gt;<br>\n";
     print "&lt;form action=\"$siteURL$ResponderDirectory/s.php\" method=GET&gt;<br>\n";
     print "&lt;strong&gt;&lt;font color=\"#666666\"&gt;Your name (First, Last):&lt;/font&gt;&lt;/strong&gt;&lt;br&gt;<br>\n";
     print "&lt;input type=\"text\" name=\"f\" style=\"background-color : #FFFFFF\" size=11 maxlength=40&gt; <br>\n";
     print "&lt;input type=\"text\" name=\"l\" style=\"background-color : #FFFFFF\" size=11 maxlength=40&gt;<br>\n";
     print "&lt;br&gt;&lt;br&gt;<br>\n";
     print "&lt;strong&gt;&lt;font color=\"#666666\"&gt;Email address:&lt;/font&gt;&lt;/strong&gt;&lt;br&gt;<br>\n";
     print "&lt;input type=\"text\" name=\"e\" style=\"background-color : #FFFFFF\" size=20 maxlength=50&gt;<br>\n";
     print "&lt;input type=\"image\" src=\"$siteURL$ResponderDirectory/images/go-button.gif\" name=\"submit\" value=\"Submit\"&gt;&lt;br&gt;<br>\n";
     print "&lt;input type=\"hidden\" name=\"r\"   value=\"$Responder_ID\"&gt;<br>\n";
     print "&lt;input type=\"hidden\" name=\"a\"   value=\"sub\"&gt;<br>\n";
     print "&lt;input type=\"hidden\" name=\"ref\" value=\"none\"&gt;<br>\n";
     print "&lt;br&gt;<br>\n";
     print "&lt;font color=\"#003300\"&gt;HTML: &lt;input type=\"RADIO\" name=\"h\" value=\"1\"&gt;Yes &nbsp;<br>\n";
     print "&lt;input type=\"RADIO\" name=\"h\" value=\"0\" checked=\"checked\"&gt;No&lt;br&gt;<br>\n";
     print "&lt;/font&gt;&lt;/form&gt;<br>\n";
     print "&lt;/td&gt;&lt;/tr&gt;&lt;/table&gt;<br>\n";
     print "&lt;/center&gt;<br>\n";
          
?>