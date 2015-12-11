<?php
# Modified 07/15/2013 by Plugin Review Network
# ------------------------------------------------
# License and copyright:
# See license.txt for license information.
# ------------------------------------------------

if (!function_exists('add_action')) {die();}
include('config.php');

# MOD new tables include WP prefix
global $table_prefix;
$infrespsubscribers = $table_prefix.'InfResp_subscribers';
$infrespcustomfields = $table_prefix.'InfResp_customfields';
$infrespblacklist = $table_prefix.'InfResp_blacklist';

# Grab passed
$Responder_ID = MakeSafe($_REQUEST['r_ID']);
$Message_ID   = MakeSafe($_REQUEST['m_ID']);
$action = strtolower(MakeSafe($_REQUEST['action']));

# Not logged in?
// if (!($Is_Auth = User_Auth())) {admin_redirect();}
# MOD now capability check
if (!current_user_can('manage_options')) {admin_redirect();}

# Top template
$help_section = "blacklist";
include('templates/open.page.php');
// include('templates/controlpanel.php');

echo '<table width="550">';
echo '<tr bgcolor="#1EABDF" height="54"><td align="center"><font color="#FFFFFF" style="font-size:18px;">Blacklist Controls</font></td></tr>';
echo '<tr><td>';

# Set address
$address = MakeSafe($_REQUEST['address']);

# Process actions
if (($action == "add") && (isEmail($address))) {
	$query = "SELECT * FROM ".$infrespblacklist." WHERE EmailAddress = '$address'";
	$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());
	if (mysql_num_rows($DB_result) > 0) {
		print "<br /><center><strong>That address is already in the blacklist!</strong></center><br />\n";
		inf_resp_message_box('That address is already in the blacklist!');
	}
	else {
		$query = "INSERT INTO ".$infrespblacklist." (EmailAddress) VALUES ('$address')";
		$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());
		// print "<br /><center><strong>Address added!</strong></center><br />\n";
		inf_resp_message_box('Address blacklisted!');

		# Remove from subscriber and custom fields tables
		$query = "DELETE FROM ".$infrespsubscribers." WHERE EmailAddress = '$address'";
		$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());
		$query = "DELETE FROM ".$infrespcustomfields." WHERE email_attached = '$address'";
		$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());
	}

	# Back button
	// $return_action = "list";
	// include('templates/back_button.blacklist.php');
}
elseif (($action == "remove") && (isEmail($address))) {
	# Delete from blacklist
	$query = "DELETE FROM ".$infrespblacklist." WHERE EmailAddress = '$address'";
	$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());

	inf_resp_message_box('Address unblacklisted!');
	# Print msg
	// print "<br /><center><strong>Address deleted!</strong></center><br />\n";	
	# Back button
	// $return_action = "list";
	// include('templates/back_button.blacklist.php');
}
# MOD to display in all cases anyway
// else {
	$query = "SELECT * FROM ".$infrespblacklist;
	$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());
	if (mysql_num_rows($DB_result) > 0) {
		# Remove address box
		print "<center>\n";
		# MOD Action to Wordpress Menu
		print "<FORM action=\"?page=infinityresponder&subpage=blacklist\" method=POST> \n";
		print "<select name=\"address\" size=\"10\">\n";
		while ($result = mysql_fetch_assoc($DB_result)) {
		$addy = $result['EmailAddress'];
		print "<option value=\"$addy\">$addy</option>\n";
		}
		print "</select>";
		print "<br />\n";
		print "<input type=\"hidden\" name=\"page\" value=\"infinityresponder\"> \n";
		print "<input type=\"hidden\" name=\"subpage\" value=\"blacklist\"> \n";
		print "<input type=\"hidden\" name=\"action\" value=\"remove\"> \n";
		print "<input class=\"button-secondary\" type=\"submit\" name=\"remove\" value=\"Remove Address\" alt=\"Remove Address\">  \n";
		print "</FORM> \n";
		print "<br /></center>\n";
	}
	else {
		print "<br /><center><strong>No email addresses blacklisted yet.</strong></center><br /><br />\n";
	}

	# Add new address
	print "<center><br />\n";
	# MOD Action to Wordpress Menu
	print "<FORM action=\"\" method=POST> \n";
	print "<input type=\"hidden\" name=\"page\" value=\"infinityresponder\"> \n";
	print "<input type=\"hidden\" name=\"subpage\" value=\"blacklist\"> \n";
	print "<input name=\"address\" size=40 maxlength=250 value=\"\" class=\"fields\">\n";
	print "<input type=\"hidden\" name=\"action\" value=\"add\"> \n";
	print "<input class=\"button-primary\" type=\"submit\" name=\"add\"    value=\"Blacklist Address\" alt=\"Blacklist Address\">  \n";
	print "</FORM></center>\n";

	# Back to admin button
	print "<br /><br />\n";
	# MOD Action to Wordpress Menu
	print "<FORM action=\"\" method=GET> \n";
	print "<input type=\"hidden\" name=\"page\" value=\"infinityresponder\"> \n";
	print "<input type=\"hidden\" name=\"subpage\" value=\"admin\"> \n";
	print "<input type=\"hidden\" name=\"action\" value=\"list\"> \n";
	print "<input class=\"button-secondary\" type=\"submit\" name=\"admin\"  value=\"<< Back to Admin\" alt=\"<< Back to Admin\">  \n";
	print "</FORM> \n";
// }

# Template bottom
copyright();
echo "</td></tr></table>";
include('templates/close.page.php');

DB_disconnect();
?>