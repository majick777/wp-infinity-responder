<?php
# Modified 07/15/2013 by Plugin Review Network
# ------------------------------------------------
# License and copyright:
# See license.txt for license information.
# ------------------------------------------------

if (!function_exists('add_action')) {die();}
include('config.php');

global $table_prefix;
$infrespbounceregs = $table_prefix.'InfResp_BounceRegs';

# ------------------------------------------------

function regexp_exists($regexp_id) {
	global $DB_LinkID, $table_prefix;
	$infrespbounceregs = $table_prefix.'InfResp_BounceRegs';

	# Bounds check
	if (isEmpty($regexp_id)) {return FALSE;}
	if ($regexp_id == "0") {return FALSE;}
	if (!(is_numeric($regexp_id))) {return FALSE;}

	# Check for its existance
	$query = "SELECT * FROM ".$infrespbounceregs." WHERE BounceRegexpID = '$regexp_id'";
	$result = mysql_query($query, $DB_LinkID) or die("Invalid query: " . mysql_error());
	if (mysql_num_rows($result) > 0) {return TRUE;}
	else {return FALSE;}
}

# ------------------------------------------------

# Get the action var
$action = strtolower(MakeSafe($_REQUEST['action']));

# Not logged in?
// if (!($Is_Auth = User_Auth($X_login, $X_pass))) {admin_redirect();}
# MOD now by capability
if (!current_user_can('manage_options')) {admin_redirect();}

# Top template
$help_section = "regexps";
include('templates/open.page.php');
// include('templates/controlpanel.php');

# Set address
$address = MakeSafe($_REQUEST['address']);

# Process actions
if ($action == "add") {
	$regexp = MakeSafe($_REQUEST['regx']);
	$query  = "SELECT * FROM ".$infrespbounceregs." WHERE RegX = '$regexp'";
	$result = mysql_query($query) or die("Invalid query: " . mysql_error());
	if (mysql_num_rows($result) > 0) {
		# Print msg
		inf_resp_message_box("That RegExp already exists.");
		// print "<p class=\"big_header\">That Regexp Already Exists!</p>\n";
    	}
    	else {
		$query   = "INSERT INTO ".$infrespbounceregs." (RegX) VALUES ('$regexp')";
		$result  = mysql_query($query) OR die("Invalid query: " . mysql_error());
		$regx_id = mysql_insert_id();

       		# Print msg
       		inf_resp_message_box("RegExp added.");
       		// print "<p class=\"big_header\">Regexp Added!</p>\n";
	}
}
elseif ($action == "remove") {
	$regexp_id = MakeSafe($_REQUEST['regx']);
	if (regexp_exists($regexp_id)) {
		# Delete from the regexp table
		$query = "DELETE FROM ".$infrespbounceregs." WHERE BounceRegexpID = '$regexp_id'";
		$result = mysql_query($query) OR die("Invalid query: " . mysql_error());

		# Print msg
		inf_resp_message_box("Bouncer RegExp deleted.");
		// print "<p class=\"big_header\">Bouncer Regexp Deleted!</p>\n";
	}
    	else {
    		# Print msg
    		inf_resp_message_box("That RegExp wasn't found.");
       		// print "<p class=\"big_header\">That Regexp Wasn't Found!</p>\n";
    	}
}

print "<p class=\"big_header\">- Bouncer RegExps -</p>\n";
$query = "SELECT * FROM ".$infrespbounceregs;
$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());
if (mysql_num_rows($DB_result) > 0) {
	# Remove regexp box
	print "<center>\n";
	# MOD Action to Wordpress Menu
	print "<FORM action=\"?page=infinityresponder&subpage=regexps\" method=GET> \n";
	print "<select name=\"regx\" size=\"10\">\n";
	while ($result = mysql_fetch_assoc($DB_result)) {
		print "<option value=\"" . $result['BounceRegexpID'] . "\">" . $result['RegX'] . "</option>\n";
	}
	print "</select>";
	print "<br />\n";
	print "<input type=\"hidden\" name=\"action\" value=\"remove\"> \n";
	print "<input class=\"button-secondary\" type=\"submit\" name=\"admin\"  value=\"Remove Regexp\" alt=\"Remove Regexp\">  \n";
	print "</FORM> \n";
	print "<br /></center>\n";
}
else {
	print "<br /><strong>No RegExps Found!</strong><br /><br />\n";
}

# Template for "add new"
include('templates/add_new.regexps.php');

# Template for "Back to admin"
include('templates/admin_button.regexps.php');

# Template bottom
copyright();
include('templates/close.page.php');

DB_disconnect();
?>