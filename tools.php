<?php
# Modified 07/15/2013 by Plugin Review Network
# ------------------------------------------------
# License and copyright:
# See license.txt for license information.
# ------------------------------------------------

include_once('config.php');

# Logged in?
// if ($Is_Auth = User_Auth()) {
# MOD replaced with capability
if (current_user_can('manage_options')) {
	# Top template
	$help_section = "tools";
	include('templates/open.page.php');
	// include('templates/controlpanel.php');

	echo '<table width="550">';
	echo '<tr bgcolor="#1EABDF" height="54"><td align="center"><font color="#FFFFFF" style="font-size:18px;">Tools</font></td></tr>';
	echo '<tr><td>';

	# Handle actions
	if ($_REQUEST['action'] == "run_sendmails") {
		$sendmails_included = TRUE;
		include('sendmails.php');
		// print "<p class=\"big_header\">Sendmails Done!</p>\n";
		inf_resp_message_box('Sendmails Done!');
	}
	elseif ($_REQUEST['action'] == "run_mailchecker") {
		$included = TRUE;
		include('mailchecker.php');
		// print "<p class=\"big_header\">Mail Checker Done!</p>\n";
		inf_resp_message_box('Mail Checker Done!');
	}
	elseif ($_REQUEST['action'] == "run_bouncechecker") {
		$included = TRUE;
		include('bouncechecker.php');
		// print "<p class=\"big_header\">Bounce Checker Done!</p>\n";
		inf_resp_message_box('Bounce Checker Done!');
	}

	# Display config template
	include('templates/main.tools.php');

	# Display back to admin button
	include('templates/back_button.tools.php');

	echo '</td></tr></table>';

	# Display the bottom template
	copyright();
	include('templates/close.page.php');
}
else  {admin_redirect();}

DB_disconnect();

?>