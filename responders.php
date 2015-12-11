<?php
# Modified 04/19/2014 by Plugin Review Network
# ------------------------------------------------
# Modified by Infinity Responder development team: 2009-06-04
# License and copyright:
# See license.txt for license information.
# ------------------------------------------------

if (!function_exists('add_action')) {die();}
include('config.php');

# MOD call globals fix
global $DB_ResponderID, $DB_ResponderName, $DB_OwnerEmail;
global $DB_OwnerName, $DB_ReplyToEmail, $DB_MsgList, $DB_RespEnabled;
global $DB_result, $DB_LinkID, $DB_ResponderDesc, $Responder_ID;
global $DB_OptMethod, $DB_OptInRedir, $DB_NotifyOnSub;
global $DB_OptOutRedir, $DB_OptInDisplay, $DB_OptOutDisplay;
global $siteURL, $ResponderDirectory;

# MOD new tables include WP prefix
global $table_prefix;
$infrespconfig = $table_prefix.'InfResp_config';
$infrespsubscribers = $table_prefix.'InfResp_subscribers';
$infrespcustomfields = $table_prefix.'InfResp_customfields';
$infresponders = $table_prefix.'InfResp_responders';
$infresppop3 = $table_prefix.'InfResp_POP3';
$infrespmessages = $table_prefix.'InfResp_messages';

$silent = $_REQUEST['silent'];
if ($silent == "1") {$silent = TRUE;} else {$silent = FALSE;}

# Reset some variables
$DB_ResponderID = 0;
$DB_ResponderName = "";
$DB_OwnerEmail = "";
$DB_OwnerName = "";
$DB_ReplyToEmail = "";
$DB_MsgList = "";
$DB_ResponderDesc = "";

# Passed stuff
$Responder_ID = MakeSafe($_REQUEST['r_ID']);
$action = MakeSafe($_REQUEST['action']);
$HandleHTML   = MakeSafe($_REQUEST['h']);

# Bounds check
if ($HandleHTML != 1) {$HandleHTML = 0;}
if (!(is_numeric($Responder_ID))) {$Responder_ID = 0;}

# Logged in?
// if ($Is_Auth = User_Auth()) {
# MOD replaced by Wordpress capability
if (current_user_can('manage_options')) {
	# Top template
	$help_section = "editresps1";
	if ($silent == FALSE) { include('templates/open.page.php'); }

	# MOD moved 'list' action to bottom to enable better flow
	# Process actions
	if ($action == "create") {
		# Display template
		include('templates/create.responders.php');
	}
	elseif ($action == "update") {
		# MOD for updated GetResponder function
		if (!(ResponderExists($Responder_ID))) {admin_redirect();}
		$ResponderInfo = GetResponderInfo($Responder_ID);

       		$DB_ResponderID = $ResponderInfo['ID'];
       		$DB_RespEnabled = $ResponderInfo['Enabled'];
       		$DB_ResponderName = $ResponderInfo['Name'];
       		$DB_ResponderDesc = $ResponderInfo['Description'];
       		$DB_OwnerEmail = $ResponderInfo['FromEmail'];
       		$DB_OwnerName = $ResponderInfo['FromName'];
       		$DB_ReplyToEmail = $ResponderInfo['ReplyEmail'];
       		$DB_MsgList = $ResponderInfo['MessageList'];
       		$DB_OptMethod = $ResponderInfo['OptinMethod'];
       		$DB_OptInRedir = $ResponderInfo['OptinRedir'];
       		$DB_OptOutRedir = $ResponderInfo['OptoutRedir'];
       		$DB_OptInDisplay = $ResponderInfo['OptinDisp'];
       		$DB_OptOutDisplay = $ResponderInfo['OptoutDisp'];
       		$DB_NotifyOnSub = $ResponderInfo['NotifyOnSub'];

		# Display template
		include('templates/update_top.responders.php');

		# MOD added standalone message action
	}
	elseif ($action == "messages") {
		# MOD for updated GetResponder function
		if (!(ResponderExists($Responder_ID))) {admin_redirect();}
		$ResponderInfo = GetResponderInfo($Responder_ID);
		$DB_MsgList = $ResponderInfo['MessageList'];

		# Resp msg anchor
		# print "<a name=\"responder_msgs\">&nbsp;</a>\n";

		# Messages start here.
		$DB_MsgList = trim($DB_MsgList, ",");
		$DB_MsgList = trim($DB_MsgList);
		$MsgList_Array = explode(',',trim($DB_MsgList));
		$Max_Index = sizeof($MsgList_Array);

		# Explode likes to treat NULL as an element. :/
		if (trim($DB_MsgList) == NULL) {$Max_Index = 0;}
		if ($DB_MsgList == "") {$Max_Index = 0;}
		if ($Max_Index == 0) {
			# No msgs found!
			include('templates/no_responder_msgs.responders.php');
		}
		else {
			# Msg list header
			$alt = TRUE;
			include('templates/msg_list_top.responders.php');

			# MOD loop to reorder message display by timing rather than ID
			for ($i=0; $i<=$Max_Index-1; $i++) {
				$M_ID = trim($MsgList_Array[$i]);
				$MessageInfo = GetMsgInfo($M_ID);

				$MsgList_Array_Data[$i]['ID'] = $M_ID;
				$MsgList_Array_Data[$i]['Seconds'] = $MessageInfo['Seconds'];
				$MsgList_Array_Data[$i]['Months'] = $MessageInfo['Months'];
			}

			usort($MsgList_Array_Data,'sort_by_time');
			// print_r($MsgList_Array_Data);
			// rsort($MsgList_Array_Data);
			// print_r($MsgList_Array_Data);

			for ($i=0; $i<=$Max_Index-1; $i++) {
			// $M_ID = trim($MsgList_Array[$i]);
			$M_ID = $MsgList_Array_Data[$i]['ID'];

			# MOD for updated GetMsgInfo function
			$MessageInfo = GetMsgInfo($M_ID);
			$DB_MsgID = $MessageInfo['ID'];
			$DB_MsgSub = $MessageInfo['Subject'];
			$DB_MsgSeconds = $MessageInfo['Seconds'];
			$DB_MsgMonths = $MessageInfo['Months'];
			$DB_absDay = $MessageInfo['absDay'];
			$DB_absMins = $MessageInfo['absMins'];
			$DB_absHours = $MessageInfo['absHour'];
			$DB_MsgBodyText = $MessageInfo['BodyText'];
			$DB_MsgBodyHTML = $MessageInfo['BodyHTML'];

			# gmp_mod and fmod are not working on my host for some reason. :-(
			$T_minutes = intval($DB_MsgSeconds / 60);
			$T_seconds = $DB_MsgSeconds - ($T_minutes * 60);
			$T_hours = intval($T_minutes / 60);
			$T_minutes = $T_minutes - ($T_hours * 60);
			$T_days = intval($T_hours / 24);
			$T_hours = $T_hours - ($T_days * 24);
			$T_weeks = intval($T_days / 7);
			$T_days = $T_days - ($T_weeks * 7);
			$T_months = $DB_MsgMonths;

			// print_r($MessageInfo);

			# Display message row
			$alt = (!($alt));
			include('templates/msg_list_row.responders.php');
			}
			# Msg list footer
			include('templates/msg_list_bottom.responders.php');
		}
		# Display new msg template
		include('templates/new_msg.responders.php');
	}
	elseif ($action == "erase") {
		# MOD for updated GetResponder function
		if (!(ResponderExists($Responder_ID))) {admin_redirect();}
		$ResponderInfo = GetResponderInfo($Responder_ID);

       		$DB_ResponderID = $ResponderInfo['ID'];
       		$DB_RespEnabled = $ResponderInfo['Enabled'];
       		$DB_ResponderName = $ResponderInfo['Name'];
       		$DB_ResponderDesc = $ResponderInfo['Description'];
       		$DB_OwnerEmail = $ResponderInfo['FromEmail'];
       		$DB_OwnerName = $ResponderInfo['FromName'];
       		$DB_ReplyToEmail = $ResponderInfo['ReplyEmail'];
       		$DB_MsgList = $ResponderInfo['MessageList'];
       		$DB_OptMethod = $ResponderInfo['OptinMethod'];
       		$DB_OptInRedir = $ResponderInfo['OptinRedir'];
       		$DB_OptOutRedir = $ResponderInfo['OptoutRedir'];
       		$DB_OptInDisplay = $ResponderInfo['OptinDisp'];
       		$DB_OptOutDisplay = $ResponderInfo['OptoutDisp'];
       		$DB_NotifyOnSub = $ResponderInfo['NotifyOnSub'];
       		
		# Display template
		include('templates/erase.responders.php');

		# MOD add missing back button
		include('templates/back_button.responders.php');
	}
	elseif ($action == "do_create") {

		$Resp_Enabled = '1';
		$Resp_Name   = MakeSemiSafe($_REQUEST['Resp_Name']);
		$Resp_Desc   = MakeSemiSafe($_REQUEST['Resp_Desc']);
		$Reply_To    = MakeSafe($_REQUEST['Reply_To']);
		$Owner_Name  = MakeSafe($_REQUEST['Owner_Name']);
		$Owner_Email = MakeSafe($_REQUEST['Owner_Email']);
		$OptMethod   = MakeSafe($_REQUEST['OptMethod']);
		$OptInRedir  = MakeSafe($_REQUEST['OptInRedir']);
		$OptOutRedir = MakeSafe($_REQUEST['OptOutRedir']);
		$OptInDisp   = myaddslashes($_REQUEST['OptInDisplay']);
		$OptOutDisp  = myaddslashes($_REQUEST['OptOutDisplay']);
		$NotifyOwner = MakeSemiSafe($_REQUEST['NotifyOwner']);
		if ($NotifyOwner != "1") { $NotifyOwner = "0"; }
		if ($OptMethod != "Double") { $OptMethod = "Single"; }
		$Msg_List    = '';

		$query = "INSERT INTO ".$infresponders." (Name, Enabled, ResponderDesc, OwnerEmail, OwnerName, ReplyToEmail, MsgList, OptMethod, OptInRedir, OptOutRedir, OptInDisplay, OptOutDisplay, NotifyOwnerOnSub)
		VALUES('$Resp_Name', '$Resp_Enabled', '$Resp_Desc', '$Owner_Email', '$Owner_Name', '$Reply_To', '$Msg_List', '$OptMethod', '$OptInRedir', '$OptOutRedir', '$OptInDisp', '$OptOutDisp', '$NotifyOwner')";
		$DB_result = mysql_query($query)
		or die("Invalid query: " . mysql_error());

		# MOD set message and return to list
		$_SESSION['inf_resp_msg'] = "Responder Added!";
		$action = "list";

		# Done!
		// print "<H3 style=\"color : #003300\">Responder Added!</H3> \n";
		// print "<font size=4 color=\"#666666\">Return to list. <br></font> \n";
		# Print back button
		// $return_action = "list";
		// include('templates/back_button.responders.php');
	}
	elseif ($action == "do_update") {
		if (!(ResponderExists($Responder_ID))) {admin_redirect();}

		$Resp_Name = MakeSemiSafe($_REQUEST['Resp_Name']);
		$Resp_Desc = MakeSemiSafe($_REQUEST['Resp_Desc']);
		$Reply_To = MakeSafe($_REQUEST['Reply_To']);
		$Owner_Name = MakeSafe($_REQUEST['Owner_Name']);
		$Owner_Email = MakeSafe($_REQUEST['Owner_Email']);
		$OptMethod = MakeSafe($_REQUEST['OptMethod']);
		$OptInRedir = MakeSafe($_REQUEST['OptInRedir']);
		$OptOutRedir = MakeSafe($_REQUEST['OptOutRedir']);
		$OptInDisp = myaddslashes($_REQUEST['OptInDisplay']);
		$OptOutDisp = myaddslashes($_REQUEST['OptOutDisplay']);
		$NotifyOwner = MakeSemiSafe($_REQUEST['NotifyOwner']);
		if ($OptMethod != "Double") {$OptMethod = "Single";}
		if ($NotifyOwner != "1") {$NotifyOwner = "0";}

		$query = "UPDATE ".$infresponders."
			SET Name = '$Resp_Name',
			ResponderDesc = '$Resp_Desc',
			OwnerEmail = '$Owner_Email',
			OwnerName = '$Owner_Name',
			ReplyToEmail = '$Reply_To',
			OptMethod = '$OptMethod',
			OptInRedir = '$OptInRedir',
			OptOutRedir = '$OptOutRedir',
			OptInDisplay = '$OptInDisp',
			OptOutDisplay = '$OptOutDisp',
			NotifyOwnerOnSub = '$NotifyOwner'
			WHERE ResponderID = '$Responder_ID'";
		$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());

		# MOD set message and return to list
		$_SESSION['inf_resp_msg'] = "Responder Saved!";
		$action = "list";

		# Done!
		// print "<H3 style=\"color : #003300\">Responder Saved!</H3> \n";
		// print "<font size=4 color=\"#666666\">Return to list. <br></font> \n";
		# Print back button
		// $return_action = "list";
		// include('templates/back_button.responders.php');
	}
	elseif ($action == "do_erase") {
		# MOD for updated GetResponder function
		if (!(ResponderExists($Responder_ID))) {admin_redirect();}
		$ResponderInfo = GetResponderInfo($Responder_ID);

		$DB_MsgList = trim($DB_MsgList, ",");
		$DB_MsgList = trim($DB_MsgList);

		$query = "DELETE FROM ".$infresponders." WHERE ResponderID = '$Responder_ID'";
		$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());

		$query = "DELETE FROM ".$infresppop3." WHERE Attached_Responder = '$Responder_ID'";
		$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());

		$MsgList_Array = explode(',',$DB_MsgList);
		$Max_Index = sizeof($MsgList_Array);

		# Explode likes to treat NULL as an element. :/
		if (trim($DB_MsgList) == NULL) {$Max_Index = 0;}
		if ($DB_MsgList == "") {$Max_Index = 0;}

		for ($i=0; $i<=$Max_Index-1; $i++) {
			$Temp_ID = trim($MsgList_Array[$i]);
			$query = "DELETE FROM ".$infrespmessages." WHERE MsgID = '$Temp_ID'";
			$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());
		}

		$query = "DELETE FROM ".$infrespsubscribers." WHERE ResponderID = '$Responder_ID'";
		$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());

		# MOD set message and return to list
		$_SESSION['inf_resp_msg'] = "Responder Deleted!";
		$action = "list";

		# Done!
		// print "<H3 style=\"color : #003300\">Responder Deleted!</H3> \n";
		// print "<font size=4 color=\"#666666\">Return to list.</font> <br>\n";
		# Print back button
		// $return_action = "list";
		// include('templates/back_button.responders.php');
	}
	elseif ($action == "POP3") {
		# Check if there is a DB entry
		# If no, create one and set variables
		# If yes, just set variables
		# Print pop3 screen
		# Save button, back button

		# MOD for updated GetResponder function
		if (!(ResponderExists($Responder_ID))) {admin_redirect();}
		$ResponderInfo = GetResponderInfo($Responder_ID);

		$query = "SELECT * FROM ".$infresppop3." WHERE Attached_Responder = '$Responder_ID' LIMIT 1";
		$DB_POP3_Result = mysql_query($query) or die("Invalid query: " . mysql_error());

		if (mysql_num_rows($DB_POP3_Result) < 1) {
			# POP3 defaults.
			$DB_Attached_Responder = $Responder_ID;
			$DB_POP3_host = 'localhost';
			$DB_POP3_port = '110';
			$DB_POP3_username = 'username';
			$DB_POP3_password = 'password';
			$DB_POP3_mailbox = 'INBOX';
			$DB_Pop_Enabled = 0;
			$DB_Confirm_Join = 1;
			$DB_HTML_YN = 0;
			$DB_DeleteYN = 0;
			$DB_SpamHeader = '***SPAM***';
			$DB_ConcatMid = '1';
			$DB_Mail_Type = 'pop3';

			$insertquery = "INSERT INTO ".$infresppop3." (ThisPOP_Enabled, Confirm_Join, Attached_Responder, host, port, username, password, mailbox, HTML_YN, Delete_After_Download, Spam_Header, Concat_Middle, Mail_Type)
				VALUES('$DB_Pop_Enabled','$DB_Confirm_Join','$DB_Attached_Responder','$DB_POP3_host','$DB_POP3_port','$DB_POP3_username','$DB_POP3_password','$DB_POP3_mailbox','$DB_HTML_YN','$DB_DeleteYN','$DB_SpamHeader','$DB_ConcatMid','$DB_Mail_Type')";
			$DB_POP3_Insert_Result = mysql_query($insertquery) or die("Invalid query: " . mysql_error());
			if (mysql_affected_rows()>0) {$DB_POP_ConfID = mysql_insert_id();}
		}
		else {
			$POP3_Result = mysql_fetch_assoc($DB_POP3_Result);
			$DB_POP_ConfID = $POP3_Result['POP_ConfigID'];
			$DB_Pop_Enabled = $POP3_Result['ThisPOP_Enabled'];
			$DB_Confirm_Join = $POP3_Result['Confirm_Join'];
			$DB_Attached_Responder = $POP3_Result['Attached_Responder'];
			$DB_POP3_host = $POP3_Result['host'];
			$DB_POP3_port = $POP3_Result['port'];
			$DB_POP3_username = $POP3_Result['username'];
			$DB_POP3_password = $POP3_Result['password'];
			$DB_POP3_mailbox = $POP3_Result['mailbox'];
			$DB_HTML_YN = $POP3_Result['HTML_YN'];
			$DB_DeleteYN = $POP3_Result['Delete_After_Download'];
			$DB_SpamHeader = $POP3_Result['Spam_Header'];
			$DB_ConcatMid = $POP3_Result['Concat_Middle'];
			$DB_Mail_Type = $POP3_Result['Mail_Type'];
		}

		# Show template
		include('templates/pop3.responders.php');

		# Print back button
		$return_action = "update";
		include('templates/back_button.responders.php');
	}
	elseif ($action == "custom_stuff") {

		$query = "SELECT * FROM ".$infrespcustomfields." WHERE resp_attached = '$Responder_ID'";
		$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());
		print "<br>\n";

		if (mysql_num_rows($DB_result) > 0) {
			$i = 0;
			while ($DBarray = mysql_fetch_assoc($DB_result)) {
				foreach ($DBarray as $key => $value) {
					print "$key: $value <br>\n";
				}
				$i++;
				print "<br>\n";
			}
			print "<br>\n";
			# MOD Action to Wordpress Menu
			print "<FORM action=\"?page=infinityresponder&subpage=responders\" method=GET>\n";
			print "<input type=\"hidden\" name=\"action\"     value=\"custom_stuff_csv\">\n";
			print "<input type=\"hidden\" name=\"r_ID\"       value=\"$Responder_ID\">\n";
			print "<input type=\"hidden\" name=\"silent\"     value=\"1\">\n";
			print "<input class=\"button-secondary\" type=\"submit\" name=\"submit\"     value=\"Print as CSV\">\n";
			print "</FORM>\n";
		} 
		else {print "<br>\nNo custom data found.<br>\n";}

		# Print back button
		$return_action = "update";
		include('templates/back_button.responders.php');
	}
	elseif ($action == "custom_stuff_csv") {
		$filename = time();
		header("Content-Disposition: attachment; filename=$filename.csv");
		header("Content-Type: application/octet-stream");
		header("Pragma: no-cache");
		header("Expires: 0");

		$query = "SELECT * FROM ".$infrespcustomfields." WHERE resp_attached = '$Responder_ID'";
		$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());

		$CustomFieldsArray = GetFieldNames($infrespcustomfields);
		$fieldstr = "";
		foreach ($CustomFieldsArray as $key => $value) {
			$fieldstr .= "$value,";
		}
		$fieldstr = trim(trim($fieldstr), ",");
		print "$fieldstr\n";

		while ($DBarray = mysql_fetch_assoc($DB_result)) {
			$datastr = "";
			foreach ($CustomFieldsArray as $key => $value) {
				$datastr .= $DBarray[$value].",";
			}
			$datastr = trim(trim($datastr), ",");
			print "$datastr\n";
		}
	}
	elseif ($action == "do_POP3") {

		# Test variable passing
		# MOD for updated GetResponder function
		if (!(ResponderExists($Responder_ID))) { admin_redirect(); }
		$ResponderInfo = GetResponderInfo($Responder_ID);

		$user = MakeSafe($_REQUEST['pop3_user']);
		$pass = MakeSafe($_REQUEST['pop3_pw']);
		$Mbox = MakeSafe($_REQUEST['pop3_box']);
		$host = MakeSafe($_REQUEST['pop3_host']);
		$port = MakeSafe($_REQUEST['pop3_port']);
		$spam = MakeSafe($_REQUEST['pop3_spam']);
		$cmid = MakeSafe($_REQUEST['pop3_cmid']);
		$type = strtolower(MakeSafe($_REQUEST['pop3_type']));
		$POP3_ID = MakeSafe($_REQUEST['pop3_ID']);

		# $HandleHTML, $deletemsgs, $confirmjoin, $enabled

		$deletemsgs = MakeSafe($_REQUEST['pop3_deletemsgs']);
		$confirmjoin = MakeSafe($_REQUEST['pop3_confirmjoin']);
		$enabled = MakeSafe($_REQUEST['pop3_enabled']);
		if ($deletemsgs == 1)  {  } else {$deletemsgs = 0;}
		if ($confirmjoin == 1) {  } else {$confirmjoin = 0;}
		if ($enabled == 1)     {  } else {$enabled = 0;}
		if ($cmid != 1) {$cmid = 0;}
		if (($type != "imap") && ($type != "pop3") && ($type != "nntp")) {$type = "pop3";}

		$query = "UPDATE ".$infresppop3."
			SET ThisPOP_Enabled = '$enabled',
			Confirm_Join = '$confirmjoin',
			host = '$host',
			port = '$port',
			username = '$user',
			password = '$pass',
			mailbox = '$Mbox',
			HTML_YN = '$HandleHTML',
			Delete_After_Download = '$deletemsgs',
			Spam_Header = '$spam',
			Concat_Middle = '$cmid',
			Mail_Type = '$type'
			WHERE Attached_Responder = '$Responder_ID'";
		$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());

		inf_resp_message_box("POP3 Changes Saved.");
		$action = "list";
		# Done!
		// print "<H3 style=\"color : #003300\">POP3 changes saved!</H3> \n";
		// print "<font size=4 color=\"#666666\">Return to Responder.</font> <br>\n";
		# Print back button
		// $return_action = "update";
		// include('templates/back_button.responders.php');
	}
	elseif ( ( ($action == "pause") || ($action == "activate") ) && (ResponderExists($Responder_ID)) ) {
		# MOD New pause/activate toggle via Enabled value

		$query = "SELECT * FROM ".$infresponders." WHERE ResponderID = '$Responder_ID'";
		$result = mysql_query($query) OR die("Invalid query: " . mysql_error());
		if (mysql_num_rows($result) > 0) {
			$this_row = mysql_fetch_assoc($result);
			if ( ($this_row['Enabled'] == "1") && ($action == "pause") ) {
				$msg = "Responder paused.";
				$toggle_query = "UPDATE ".$infresponders." SET Enabled = '0' WHERE ResponderID = '$Responder_ID'";
			}
			elseif  ( ($this_row['Enabled'] == "0") && ($action == "activate") ) {
				$msg = "Reponder re-activated.";
				$toggle_query = "UPDATE ".$infresponders." SET Enabled = '1' WHERE ResponderID = '$Responder_ID'";
			}
			$tog_result = mysql_query($toggle_query) or die("Invalid query: " . mysql_error());

			inf_resp_message_box($msg);
			$action = 'list';
		}
	}
	elseif ($action != "list") {admin_redirect();}

	# MOD moved list action here
	if ($action == "list") {
		// include('templates/controlpanel.php');
		$query = "SELECT * FROM ".$infresponders." ORDER BY ResponderID";
		$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());

		# Top template
		$alt = TRUE;
		include('templates/list_top.responders.php');

		# Loop thru the list
		if (mysql_num_rows($DB_result) > 0) {
		$i = 0;
		while ($query_result = mysql_fetch_assoc($DB_result)) {
			$Responder_ID     = $query_result['ResponderID'];
			$DB_Enabled   = $query_result['Enabled'];
			$DB_ResponderID   = $query_result['ResponderID'];
			$DB_ResponderName = $query_result['Name'];
			$DB_ResponderDesc = $query_result['ResponderDesc'];
			$DB_OwnerEmail    = $query_result['OwnerEmail'];
			$DB_OwnerName     = $query_result['OwnerName'];
			$DB_ReplyToEmail  = $query_result['ReplyToEmail'];
			$DB_MsgList       = $query_result['MsgList'];
			$DB_RespEnabled   = $query_result['Enabled'];
			$DB_OptMethod     = $query_result['OptMethod'];
			$DB_OptInRedir    = $query_result['OptInRedir'];
			$DB_OptOutRedir   = $query_result['OptOutRedir'];
			$DB_OptInDisplay  = $query_result['OptInDisplay'];
			$DB_OptOutDisplay = $query_result['OptOutDisplay'];
			$DB_NotifyOnSub   = $query_result['NotifyOwnerOnSub'];

			# MOD get confirmed/unconfirmed count for double optin lists
			if ($DB_OptMethod == 'Double') {
				$Count_query = "SELECT * FROM ".$infrespsubscribers." WHERE ResponderID = '$DB_ResponderID' AND Confirmed = '1'";
				$DB_Count_result = mysql_query($Count_query) or die("Invalid query: " . mysql_error());
				$User_Count = mysql_num_rows($DB_Count_result);

				$Count_query = "SELECT * FROM ".$infrespsubscribers." WHERE ResponderID = '$DB_ResponderID' AND Confirmed = '0'";
				$DB_Count_result = mysql_query($Count_query) or die("Invalid query: " . mysql_error());
				$Pending_User_Count = mysql_num_rows($DB_Count_result);
				if ($Pending_User_Count == 0) {$Pending_User_Count = "";}
			}
			else {	
				$Count_query = "SELECT * FROM ".$infrespsubscribers." WHERE ResponderID = '$DB_ResponderID'";
				$DB_Count_result = mysql_query($Count_query) or die("Invalid query: " . mysql_error());
				$User_Count = mysql_num_rows($DB_Count_result);
				$Pending_User_Count = "";
			}

			# MOD get the message count
			if ($DB_MsgList != "") {
				if (strstr($DB_MsgList,",")) {$Message_Array = explode(",",$DB_MsgList); $Message_Count = count($Message_Array);}
				elseif (is_numeric($DB_MsgList)) {$Message_Count = 1;}
			}
			else {$Message_Count = "";}

			# Row template
			$alt = (!($alt));
			include('templates/list_row.responders.php');

			# Next!
			$i++;
			}
		}
		else {
			print "<br> \n";
			print "<center><strong>No responders exist. Create one?</strong></center><br>\n";
			print "<br> \n";
		}

		# Bottom template
		include('templates/list_bottom.responders.php');
	}

	# Bottom template
	if ($silent == FALSE) {
		copyright();
		include('templates/close.page.php');
	}
}

DB_disconnect();

?>