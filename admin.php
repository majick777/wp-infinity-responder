<?php
# Modified 04/19/2014 by Plugin Review Network
# ------------------------------------------------
# Modified by Infinity Responder development team: 2009-06-04
# Modified by DreamJester Productions: from June 2013
# License and copyright:
# See license.txt for license information.
# ------------------------------------------------

if (!function_exists('add_action')) {die();}
include_once('config.php');

# MOD add global fix
global $DB_ResponderID, $DB_ResponderName, $DB_OwnerEmail;
global $DB_OwnerName, $DB_ReplyToEmail, $DB_MsgList, $DB_LastActivity;
global $DB_result, $DB_LinkID, $DB_ResponderDesc, $DB_RespEnabled;
global $Responder_ID, $action, $SearchCount;
global $Search_EmailAddress, $Subscriber_ID, $SubsPerPage;
global $DB_FirstName, $DB_LastName, $DB_IPaddy, $DB_Real_TimeJoined;
global $DB_EmailAddress, $DB_SubscriberID, $DB_SentMsgs;
global $DB_TimeJoined, $CanReceiveHTML, $DB_ReferralSource;
global $DB_UniqueCode, $DB_Confirmed;
global $siteURL, $ResponderDirectory;

// echo $siteURL.$ResponderDirectory;

# MOD new tables include WP prefix
global $table_prefix;
$infrespconfig = $table_prefix.'InfResp_config';
$infrespsubscribers = $table_prefix.'InfResp_subscribers';
$infrespcustomfields = $table_prefix.'InfResp_customfields';
$infresponders = $table_prefix.'InfResp_responders';

# ---------------------------------------------------------------------------------

function Run_UserQuery($query) {
	global $DB_ResponderID, $DB_ResponderName, $DB_OwnerEmail;
	global $DB_OwnerName, $DB_ReplyToEmail, $DB_MsgList, $DB_LastActivity;
	global $DB_result, $DB_LinkID, $DB_ResponderDesc, $DB_RespEnabled;
	global $Responder_ID, $action, $SearchCount;
	global $Search_EmailAddress, $Subscriber_ID, $SubsPerPage;
	global $DB_FirstName, $DB_LastName, $DB_IPaddy, $DB_Real_TimeJoined;

	if ($SubsPerPage != 0) {$Limitedquery = $query." LIMIT $SearchCount, $SubsPerPage";} 
	else {$Limitedquery = $query;}

	$DB_MaxList_result = mysql_query($query) or die("Invalid query: " . mysql_error());
	$DB_search_result = mysql_query($Limitedquery) or die("Invalid query: " . mysql_error());
	$Max_Results_Count = mysql_num_rows($DB_MaxList_result) - 1;

	# MOD display message if any
	if ($_SESSION['inf_resp'] != '') {
		inf_resp_message_box($_SESSION['inf_resp']);
		unset($_SESSION['inf_resp']);
	}
		
	if (mysql_num_rows($DB_search_result) > 0) {
		# User top template
		$alt = FALSE;
		include('templates/listuser_top.admin.php');

		# Display the rows
		while ($search_query_result = mysql_fetch_assoc($DB_search_result)) {
			$DB_SubscriberID    = $search_query_result['SubscriberID'];
			$DB_ResponderID     = $search_query_result['ResponderID'];
			$DB_SentMsgs        = $search_query_result['SentMsgs'];
			$DB_EmailAddress    = $search_query_result['EmailAddress'];
			$DB_TimeJoined      = $search_query_result['TimeJoined'];
			$DB_Real_TimeJoined = $search_query_result['Real_TimeJoined'];
			$CanReceiveHTML     = $search_query_result['CanReceiveHTML'];
			$DB_LastActivity    = $search_query_result['LastActivity'];
			$DB_FirstName       = $search_query_result['FirstName'];
			$DB_LastName        = $search_query_result['LastName'];
			$DB_IPaddy          = $search_query_result['IP_Addy'];
			$DB_ReferralSource  = $search_query_result['ReferralSource'];
			$DB_UniqueCode      = $search_query_result['UniqueCode'];
			$DB_Confirmed       = $search_query_result['Confirmed'];

			$Responder_ID = $DB_ResponderID;
			if (!(ResponderExists($Responder_ID))) { admin_redirect(); }
			$ResponderInfo = GetResponderInfo($Responder_ID);

			# User row template
			$alt = (!($alt));
			include('templates/listuser_row.admin.php');
		}

		# List bottom template
		include('templates/listuser_bottom.admin.php');

		if ($SubsPerPage != 0) {
			$Search_Count_BackStr = $SearchCount - $SubsPerPage;
			$Search_Count_ForwardStr = $SearchCount + $SubsPerPage;
			if ($Search_Count_BackStr < 0) { $Search_Count_BackStr = 0;}
			if ($Search_Count_ForwardStr > $Max_Results_Count) {$Search_Count_ForwardStr = $Max_Results_Count;}

			# Back and forward buttons
			include('templates/back_forward.admin.php');
		}

	# Add new user button
	include('templates/addnew_button.admin.php');
	}
	else {
		if (!(ResponderExists($Responder_ID))) {admin_redirect();}
	 	$ResponderInfo = GetResponderInfo($Responder_ID);
	 	$DB_ResponderName = $ResponderInfo['Name'];
	 	print "<br><center><font size=\"3\" color=\"#330000\">No subscriber(s) found for Responder '".$DB_ResponderName."'.</font></center><br>\n";
	 	print "<br>\n";
	 	# Add new user button
		include('templates/addnew_button.admin.php');
	}

	# Back button
	// print "<br> \n";
	// print "<font size=\"4\" color=\"#666666\">Back to Main:</font><br>\n";
	$return_action = "list";
	include('templates/back_button.admin.php');
}

# ---------------------------------------------------------------------------------

# Redirect to config?
if ($config_row_inserted == TRUE) {
     include('edit_config.php');
     die();
}

# More config stuff
$Add_List_Size = $config['add_sub_size'];
$SubsPerPage   = $config['subs_per_page'];

# Init vars
$action = MakeSafe($_REQUEST['action']);
$Responder_ID  = MakeSafe($_REQUEST['r_ID']);
$Search_EmailAddress = MakeSafe($_REQUEST['email_addy']);
$Subscriber_ID = MakeSafe($_REQUEST['sub_ID']);
$HandleHTML = MakeSafe($_REQUEST['h']);
$SearchCount = MakeSafe($_REQUEST['Search_Count']);
$FirstName = MakeSafe($_REQUEST['firstname']);
$LastName = MakeSafe($_REQUEST['lastname']);

# Bounds check
if ($HandleHTML != 1) {$HandleHTML = 0;}

# A small bit of magic to filter out any screwy crackerness of the RespID and SearchCount
if (!(is_numeric($Responder_ID))) {$Responder_ID = NULL;}
if (!(is_numeric($SearchCount))) {$SearchCount = 0;}

# MOD now Wordpress capability
// if ($Is_Auth = User_Auth()) {
if (current_user_can('manage_options')) {
	# Template top
	include('templates/open.page.php');

	if ($action == "Form_Gen") {
			# Template
			include('templates/form_gen.admin.php');
	
			# Back button
			print "<br> \n";
			$return_action = "list";
			include('templates/back_button.admin.php');
	} 
	elseif ($action == "Email_Search") {
		# Panel top
		// include('templates/controlpanel.php');

		$SubsPerPage = 0;
		if (($Search_EmailAddress == NULL) OR ($Search_EmailAddress == "")) { $Search_EmailAddress = '*'; }

		$DBquery = "SELECT * FROM ".$infrespsubscribers." WHERE EmailAddress LIKE '%$Search_EmailAddress%' ORDER BY EmailAddress";
		Run_UserQuery($DBquery);
	}
	elseif ($action == "sub_addnew") {

		# ResponderPulldown('r_ID');
		# -> Add a new user(s).  - Email - HTML Y/N. Pull down menu for responders.
		#     - Bulk add. Comma spliced. Universal HTML Y/N.

		# Top Template
		include('templates/adduser_top.admin.php');

		for ($i=1; $i<=$Add_List_Size; $i++) {
			# Row Template
			include('templates/adduser_row.admin.php');
		}

		# Bottom Template
		include('templates/adduser_bottom.admin.php');

		# Back button
		print "<br> \n";
		$return_action = "list";
		include('templates/back_button.admin.php');
	}
	elseif ($action == "sub_edit") {

		# MOD for updated GetResponder function
		if (!(ResponderExists($Responder_ID))) {admin_redirect();}
		$ResponderInfo = GetResponderInfo($Responder_ID);

		$SubscriberInfo = GetSubscriberInfo($Subscriber_ID);
		$DB_SentMsgs = $SubscriberInfo['SentMsgs'];

		$DB_SentMsgs = trim(trim($DB_SentMsgs), ",");
		$SentList_Array = explode(',',$DB_SentMsgs);
		$Max_Index = sizeof($SentList_Array);

		# Explode likes to treat NULL as an element. :/
		if (trim($DB_SentMsgs) == NULL) {$Max_Index = 0;}
		if ($DB_SentMsgs == "") {$Max_Index = 0;}

		# Build option list
		$option_list = "";
		for ($i=0; $i<=$Max_Index-1; $i++) {
			$MessageInfo = GetMsgInfo(trim($SentList_Array[$i]));
			$DB_MsgID = $MessageInfo['ID'];
			$DB_MsgSub = $MessageInfo['Subject'];
			$option_list .= "     <option value=\"$DB_MsgID\">$DB_MsgSub</option>\n";
		}

		# Template
		include('templates/sub_edit.admin.php');

		# Back button
		print "<br> \n";
		$return_action = "edit_users";
		include('templates/back_button.admin.php');
	}
	elseif ($action == "sub_delete") {
		$SubscriberInfo = GetSubscriberInfo($Subscriber_ID);
		$DB_TimeJoined = $SubscriberInfo['TimeJoined'];
		$DB_LastActivity = $SubscriberInfo['LastActivity'];
		$CanReceiveHTML = $SubscriberInfo['CanReceiveHTML'];
		
		$Responder_ID = $DB_ResponderID;
		# MOD for updated GetResponder function
		if (!(ResponderExists($Responder_ID))) {admin_redirect();}
		$ResponderInfo = GetResponderInfo($Responder_ID);

		$JoinedStr = date("F j, Y, g:i a", $DB_TimeJoined);
		$LastActStr = date("F j, Y, g:i a", $DB_LastActivity);
		if ($CanReceiveHTML == 1) {$HTMLstr = "Yes";} else {$HTMLstr = "No";}

		# Template
		include('templates/sub_delete.admin.php');
	}
	elseif ($action == "sub_addnew_do") {

		$Resp_Cached = $Responder_ID;

		for ($i=1; $i<=$Add_List_Size; $i++) {

			print "<br>\n";

			$Blank = "";
			$SH_VAR = "send_html".$i;
			$AR_VAR = "chosen_resp".$i;
			$EA_VAR = "add_email".$i;
			$FN_VAR = "firstname".$i;
			$LN_VAR = "lastname".$i;
			# MOD for sending confirmation email
			$SC_VAR = "subconfirmation".$i;

			$SendHTML[$i] = MakeSafe($_REQUEST["$SH_VAR"]);
			$AddToResp[$i] = MakeSafe($_REQUEST["$AR_VAR"]);
			$EmailToAdd[$i] = MakeSafe($_REQUEST["$EA_VAR"]);
			$FirstNameArray[$i] = MakeSafe($_REQUEST["$FN_VAR"]);
			$LastNameArray[$i] = MakeSafe($_REQUEST["$LN_VAR"]);
			# MOD for sending confirmation email
			$SubConfirmation[$i] = MakeSafe($_REQUEST["$SC_VAR"]);

			$Responder_ID = $AddToResp[$i];
			$Email_Address = $EmailToAdd[$i];

			if ($Email_Address != "") {
				if (UserIsSubscribed($Responder_ID,$Email_Address)) {
					print "<strong>Duplicate address!</strong> Not Added: $Email_Address <br>\n";
				}
				else {
					# MOD for updated GetResponder function
					if (!(ResponderExists($Responder_ID))) {admin_redirect();}
					$ResponderInfo = GetResponderInfo($Responder_ID);
					$DB_OptMethod = $ResponderInfo['OptinMethod'];

					# MOD for new Send Confirmation Email option
					$uniq_code = generate_unique_code();
					$Timestamper = time();

					if (($EmailToAdd[$i] != "") AND ($EmailToAdd[$i] != NULL) AND (!(isInBlacklist($EmailToAdd[$i])))) {
						if (($SubConfirmation[$i] == 'email') && ($DB_OptMethod == "Double")) {
							# Add a non-confirmed row to the DB
							$query = "INSERT INTO ".$infrespsubscribers." (ResponderID, SentMsgs, EmailAddress, TimeJoined, Real_TimeJoined, CanReceiveHTML, LastActivity, FirstName, LastName, IP_Addy, ReferralSource, UniqueCode, Confirmed)
								VALUES('$AddToResp[$i]','$Blank', '$EmailToAdd[$i]', '$Timestamper', '$Timestamper', '$SendHTML[$i]', '$Timestamper', '$FirstNameArray[$i]', '$LastNameArray[$i]', '', 'Manual Add', '$uniq_code', '0')";
							$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());
							$DB_SubscriberID = mysql_insert_id();
							SendMessageTemplate('templates/messages/subscribe.confirm.txt',$EmailToAdd[$i],$ResponderInfo['FromEmail']);
							print "<strong>Subscriber Added and Confirmation Email Sent: $Email_Address</strong><br>\n";
						}
						if (($SubConfirmation[$i] == 'auto') && ($DB_OptMethod == "Double")) {
							$query = "INSERT INTO ".$infrespsubscribers." (ResponderID, SentMsgs, EmailAddress, TimeJoined, Real_TimeJoined, CanReceiveHTML, LastActivity, FirstName, LastName, IP_Addy, ReferralSource, UniqueCode, Confirmed)
								VALUES('$AddToResp[$i]','$Blank', '$EmailToAdd[$i]', '$Timestamper', '$Timestamper', '$SendHTML[$i]', '$Timestamper', '$FirstNameArray[$i]', '$LastNameArray[$i]', '', 'Manual Add', '$uniq_code', '1')";
							$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());
							$DB_SubscriberID = mysql_insert_id();
							print "<strong>Confirmed Subscriber Added: $Email_Address</strong><br>\n";
						}
						else {
							$query = "INSERT INTO ".$infrespsubscribers." (ResponderID, SentMsgs, EmailAddress, TimeJoined, Real_TimeJoined, CanReceiveHTML, LastActivity, FirstName, LastName, IP_Addy, ReferralSource, UniqueCode, Confirmed)
							     VALUES('$AddToResp[$i]','$Blank', '$EmailToAdd[$i]', '$Timestamper', '$Timestamper', '$SendHTML[$i]', '$Timestamper', '$FirstNameArray[$i]', '$LastNameArray[$i]', '', 'Manual Add', '$uniq_code', '0')";
							$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());
							if ($DB_OptMethod == "Double") {print "<strong>Non-Confirmed Subscriber Added: $Email_Address </strong><br>\n";}
							else {print "<strong>Subscriber Added: $Email_Address </strong><br>\n";}
						}
					}
				}
			}
		}
		$Responder_ID = $Resp_Cached;

		# Back button
		$return_action = "list";
		include('templates/back_button.admin.php');
	}
	elseif ($action == "sub_edit_do") {

		$Resend_Msg = MakeSafe($_REQUEST['msg_to_resend']);
		$Reset_Time = MakeSafe($_REQUEST['Reset_Time']);
		$Ref_Src = MakeSafe($_REQUEST['ReferralSource']);
		$UniqueCode = MakeSafe($_REQUEST['UniqueCode']);
		$Confirmed  = MakeSafe($_REQUEST['Confirmed']);

		$SubscriberInfo = GetSubscriberInfo($Subscriber_ID);
		$DB_SentMsgs = $SubscriberInfo['SentMsgs'];
		$DB_TimeJoined = $SubscriberInfo['TimeJoined'];

		if ($Confirmed != "1") {$Confirmed = "0";}
		if (($Resend_Msg != "") && ($Resend_Msg != NULL) && ($Resend_Msg != "none") && ($Resend_Msg != "all")) {
			$DB_SentMsgs = RemoveFromList($DB_SentMsgs, $Resend_Msg);
		}
		if ($Resend_Msg == "all") {$DB_SentMsgs = "";}
		if ($Reset_Time == "yes") {$DB_TimeJoined = time(); $DB_SentMsgs = "";}

		$Set_LastActivity = time();
		$query = "UPDATE ".$infrespsubscribers."
		       SET SentMsgs = '$DB_SentMsgs',
			   EmailAddress = '$Search_EmailAddress',
			   TimeJoined = '$DB_TimeJoined',
			   CanReceiveHTML = '$HandleHTML',
			   LastActivity = '$Set_LastActivity',
			   FirstName = '$FirstName',
			   LastName = '$LastName',
			   ReferralSource = '$Ref_Src',
			   UniqueCode = '$UniqueCode',
			   Confirmed = '$Confirmed'
		       WHERE SubscriberID = '$Subscriber_ID'";
		$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());

		$FullName = "$FirstName $LastName";
		$query = "UPDATE ".$infrespcustomfields."
			  SET email_attached = '$Search_EmailAddress', full_name = '$FullName' 
			  WHERE user_attached = '$Subscriber_ID'";
		$result = mysql_query($query) or die("Invalid query: " . mysql_error());

		# MOD set message
		$_SESSION['inf_resp'] = "Subscriber Updated.";
		$action = "edit_users";
		# Done!
		// print "<H3 style=\"color : #003300\">Subscriber Saved!</H3> \n";
		# Back button
		// print "<br> \n";
		// $return_action = "edit_users";
		// include('templates/back_button.admin.php');
	}
	elseif ($action == "sub_delete_do") {

		$query = "DELETE FROM ".$infrespsubscribers." WHERE SubscriberID = '$Subscriber_ID'";
		$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());

		$query = "DELETE FROM ".$infrespcustomfields." WHERE user_attached = '$Subscriber_ID'";
		$result = mysql_query($query) or die("Invalid query: " . mysql_error());

		# MOD set message
		$_SESSION['inf_resp'] = "Subscriber Deleted.";
		$action = "edit_users";
		
		# Done!
		// print "<br> \n";
		// print "<font size=\"4\" color=\"#666666\">Subscriber Deleted!</font><br>\n";
		# Back button
		// print "<br> \n";
		// $return_action = "edit_users";
		// include('templates/back_button.admin.php');
	}
	elseif ($action == "bulk_add") {
		# Template
		include('templates/bulk_add.admin.php');

		# Back button
		print "<br> \n";
		$return_action = "list";
		include('templates/back_button.admin.php');
	}
	elseif ($action == "bulk_add_do") {
		$Blank = ""; 
		$ResponderInfo = GetResponderInfo($Responder_ID);
		$DB_OptMethod = $ResponderInfo['OptinMethod'];
		
		# MOD to now process Comma List and File Record separately
		// $Complete_List = $file_text.",".$Comma_List;
		// $AddList_Array = explode(',',$Complete_List);

		# MOD Process File Record		
		if ((isset($_FILES['load_file']['tmp_name'])) && ($_FILES['load_file']['size'] > 0)) {
			$file_name = $_FILES['load_file']['tmp_name'];
			$file_size = $_FILES['load_file']['size'];
			$file_text = "";
			$file_handle = fopen($file_name, "r");
			if (($file_handle != "") AND ($file_handle != NULL)) {
				while (!feof($file_handle)) {
					$file_buffer = fgets($file_handle, $file_size);
					$file_text = $file_text.$file_buffer;
				}
				fclose ($file_handle);
			}

			$file_text = str_replace(' ', '', $file_text);
			// $file_text = stripnl($file_text);
			// $file_text = trim(trim($file_text), ",");
			$file_text = MakeSafe($file_text);
			
			echo $file_text;

			if (strstr($file_text,PHP_EOL)) {$AddList_Array = explode(PHP_EOL,$file_text);}
			else {$AddList_Array[0] = $file_text;}			
			$List_Max = sizeof($AddList_Array);
			// if (trim($AddList_Array) == NULL) {$List_Max = 0;}
			// if ($AddList_Array == "") {$List_Max = 0;}

			for ($i=0; $i<=$List_Max-1; $i++) {
				$ListPart = $AddList_Array[$i];
				$ListPartArray = array();
				if (strstr($ListPart,",")) {
					$ListPartArray = explode(",",$ListPart);
					if (count($ListPartArray) > 0) {$Email_Address = trim($ListPartArray[0]);}
					if (count($ListPartArray) > 1) {$First_Name = trim($ListPartArray[1]);}
					if (count($ListPartArray) > 2) {$Last_Name = trim($ListPartArray[2]);}
					if (count($ListPartArray) > 3) {$CanReceiveHTML = trim($ListPartArray[3]);}
					if (count($ListPartArray) > 4) {$Confirmed = trim($ListPartArray[4]);}
					if (count($ListPartArray) > 5) {$IP_Addy = trim($ListPartArray[5]);}
					if (count($ListPartArray) > 6) {$ReferralSource = trim($ListPartArray[6]);}
					if (count($ListPartArray) > 7) {$UniqueCode = trim($ListPartArray[7]);}
					if (count($ListPartArray) > 8) {$SentMsgs = trim(str_replace('|',',',$ListPartArray[8]));}
					if (count($ListPartArray) > 9) {$TimeJoined = trim($ListPartArray[9]);}
					if (count($ListPartArray) > 10) {$Real_TimeJoined = trim($ListPartArray[10]);}
					if (count($ListPartArray) > 11) {$LastActivity  = trim($ListPartArray[11]);}
				}
				else {$Email_Address = trim($ListPart);}
				
				if (count($ListPartArray) > 12) {
					$Email_Address = $AddList_Array[$i];
					print "<strong>Too many data fields!</strong> Not Added: $Email_Address <br>\n";
				}
				else {
					if (($Email_Address != "") && ($Email_Address != NULL) && (!(isInBlacklist($Email_Address)))) {
						if (UserIsSubscribed($Responder_ID,$Email_Address)) {
							if ($_REQUEST['overwrite'] == 'yes') {
								$Subscriber = GetSubscriberID($Responder_ID,$Email_Address);
								$SubscriberInfo = GetSubscriberInfo($Subscriber);
								$SubscriberID = $SubscriberInfo['SubscriberID'];
								// print_r($SubscriberInfo);

								if (!isset($First_Name)) {$First_Name = $SubscriberInfo['FirstName'];}
								if (!isset($Last_Name)) {$Last_Name = $SubscriberInfo['LastName'];}
								if (!isset($CanReceiveHTML)) {$CanReceiveHTML = $SubscriberInfo['CanReceiveHTML'];}
								if (!isset($Confirmed)) {$Confirmed = $SubscriberInfo['Confirmed'];}
								if (!isset($IP_Addy)) {$IP_Addy = $SubscriberInfo['IP_Addy'];}
								if (!isset($ReferralSource)) {$ReferralSource = $SubscriberInfo['ReferralSource'];}
								if (!isset($UniqueCode)) {$UniqueCode = $SubscriberInfo['UniqueCode'];}
								if (!isset($SentMsgs)) {$SentMsgs = $SubscriberInfo['SentMsgs'];}
								if (!isset($TimeJoined)) {$TimeJoined = $SubscriberInfo['TimeJoined'];}
								if (!isset($Real_TimeJoined)) {$Real_TimeJoined = $SubscriberInfo['Real_TimeJoined'];}
								if (!isset($LastActivity)) {$LastActivity = $SubscriberInfo['LastActivity'];}
								if ($ReferralSource == "") {$ReferralSource = "File Import";}
								if ($CanReceiveHTML == "") {$CanReceiveHTML = $HandleHTML;}

								$query = "UPDATE ".$infrespsubscribers." 
										SET FirstName = '$First_Name', LastName = '$Last_Name', CanReceiveHTML = '$CanReceiveHTML', Confirmed = '$Confirmed', IP_Addy = '$IP_Addy', ReferralSource = '$ReferralSource', UniqueCode = '$UniqueCode', SentMsgs = 'SentMsgs', TimeJoined = '$TimeJoined', Real_TimeJoined = '$Real_TimeJoined', LastActivity = '$LastActivity' 
										WHERE SubscriberID = '$SubscriberID'";
								$result = mysql_query($query) or die("Invalid query: " . mysql_error());
								print "<strong>Subscriber Updated: $Email_Address</strong><br>\n";

								if (($_REQUEST['subconfirmation'] == 'email') && ($DB_OptMethod == "Double") && ($Confirmed == '0')) {
									SendMessageTemplate('templates/messages/subscribe.confirm.txt',$Email_Address,$ResponderInfo['FromEmail']);
									print "<strong>Confirmation Email sent to: $Email_Address</strong><br>\n";
								}	
							}
							else {print "<strong>Duplicate Address! Not Added:</strong> $Email_Address <br>\n";}
						}
						else {
							$Timestamper = time();
							$uniq_code = generate_unique_code();
							if (!isset($ReferralSource)) {$ReferralSource = 'File Import';}
							if (!isset($UniqueCode)) {$UniqueCode = $uniq_code;}
							if (!isset($TimeJoined)) {$TimeJoined = $Timestamper;}
							if (!isset($Real_TimeJoined)) {$Real_TimeJoined = $Timestamper;}
							if (!isset($LastActivity)) {$LastActivity = $Timestamper;}
							if (!isset($Confirmed)) {
								if (($_REQUEST['subconfirmation'] == 'email') && ($DB_OptMethod == "Double")) {$Confirmed = '0';}
								elseif (($_REQUEST['subconfirmation'] == 'auto') && ($DB_OptMethod == "Double")) {$Confirmed = '1';}
								elseif (($_REQUEST['subconfirmation'] == 'off') || ($DB_OptMethod == "Single")) {$Confirmed = '0';}
							}
							if ($CanReceiveHTML == "") {$CanReceiveHTML = $HandleHTML;}

							# Add directly to Database
							$query = "INSERT INTO ".$infrespsubscribers." (ResponderID, SentMsgs, EmailAddress, TimeJoined, Real_TimeJoined, CanReceiveHTML, LastActivity, FirstName, LastName, IP_Addy, ReferralSource, UniqueCode, Confirmed)
								VALUES('$Responder_ID','$SentMsgs','$Email_Address', '$TimeJoined', '$Real_TimeJoined', '$CanReceiveHTML', '$LastActivity', '$First_Name', '$Last_Name', '$IP_Addy', '$ReferralSource', '$UniqueCode', '$Confirmed')";
							$result = mysql_query($query) or die("Invalid query: " . mysql_error());     

							if (($DB_OptMethod == "Double") && ($Confirmed == "1")) {print "Added Confirmed Subscriber: $Email_Address <br>\n";}
							elseif (($_REQUEST['subconfirmation'] == 'email') && ($DB_OptMethod == "Double") && ($Confirmed == '0')) {
								SendMessageTemplate('templates/messages/subscribe.confirm.txt',$Email_Address,$ResponderInfo['FromEmail']);
								print "<strong>Confirmation Email sent to: $Email_Address</strong><br>\n";
							}
							elseif (($_REQUEST['subconfirmation'] == 'off') && ($DB_OptMethod == "Double") && ($Confirmed == "0")) {print "Added Non-Confirmed Subscriber: $Email_Address <br>\n";}
							elseif ($DB_OptMethod == "Single") {print "Added Subscriber: $Email_Address <br>\n";}
						}
					}
				}
			}
		}
		
		# Process Comma List
		
		if ((isset($_REQUEST['comma_list'])) && ($_REQUEST['comma_list'] != "")) {
			$Comma_List = $_REQUEST['comma_list'];
			$Comma_List = str_replace(' ', '', $Comma_List);
			// $Comma_List = stripnl($Comma_List);
			// $Comma_List = trim(trim($Comma_List), ",");
			$Comma_List = MakeSafe($Comma_List);

			if (strstr($Comma_List,PHP_EOL)) {$AddList_Array = explode(PHP_EOL,$Comma_List);}
			else {$AddList_Array[0] = $Comma_List;}		
			$List_Max = sizeof($AddList_Array);
			// if (trim($AddList_Array) == NULL) {$List_Max = 0;}
			// if ($AddList_Array == "") {$List_Max = 0;}

			for ($i=0; $i<=$List_Max-1; $i++) {
				# MOD to allow adding of all data fields
				$ListPart = $AddList_Array[$i];
				$Email_Address = ""; $First_Name = ""; $Last_Name = "";
				$CanReceiveHTML = ""; $Confirmed = ""; $IP_Addy = ""; 
				$UniqueCode = ""; $SentMsgs = ""; 
				$TimeJoined = ""; $Real_TimeJoined = ""; $LastActivity = "";

				$ListPartArray = array();
				if (strstr($ListPart,",")) {
					$ListPartArray = explode(",",$ListPart);
					// print_r($ListPartArray);
					if (count($ListPartArray) > 0) {$Email_Address = trim($ListPartArray[0]);}
					if (count($ListPartArray) > 1) {$First_Name = trim($ListPartArray[1]);}
					if (count($ListPartArray) > 2) {$Last_Name = trim($ListPartArray[2]);}
					if (count($ListPartArray) > 3) {$CanReceiveHTML = trim($ListPartArray[3]);}
					if (count($ListPartArray) > 4) {$Confirmed = trim($ListPartArray[4]);}
					if (count($ListPartArray) > 5) {$IP_Addy = trim($ListPartArray[5]);}
					if (count($ListPartArray) > 6) {$ReferralSource = trim($ListPartArray[6]);}
					if (count($ListPartArray) > 7) {$UniqueCode = trim($ListPartArray[7]);}
					if (count($ListPartArray) > 8) {$SentMsgs = trim($ListPartArray[8]);}
					if (count($ListPartArray) > 9) {$TimeJoined = trim($ListPartArray[9]);}
					if (count($ListPartArray) > 10) {$Real_TimeJoined = trim($ListPartArray[10]);}
					if (count($ListPartArray) > 11) {$LastActivity  = trim($ListPartArray[11]);}
				}
				else {$Email_Address = trim($ListPart);}

				if (count($ListPartArray) > 12) {
					$Email_Address = $AddList_Array[$i];
					print "<strong>Too many data fields!</strong> Not Added: $Email_Address <br>\n";
				}
				else {
					if (($Email_Address != "") AND ($Email_Address != NULL) AND (!(isInBlacklist($Email_Address)))) {	
						if (UserIsSubscribed($Responder_ID,$Email_Address)) {
							if ($_REQUEST['overwrite'] == 'yes') {
								$Subscriber = GetSubscriberID($Responder_ID,$Email_Address);
								$SubscriberInfo = GetSubscriberInfo($Subscriber);
								$SubscriberID = $SubscriberInfo['SubscriberID'];
								// print_r($SubscriberInfo);

								if (!isset($First_Name)) {$First_Name = $SubscriberInfo['FirstName'];}
								if (!isset($Last_Name)) {$Last_Name = $SubscriberInfo['LastName'];}
								// if (!isset($CanReceiveHTML)) {$CanReceiveHTML = $SubscriberInfo['CanReceiveHTML'];}
								if (!isset($Confirmed)) {$Confirmed = $SubscriberInfo['Confirmed'];}
								if (!isset($IP_Addy)) {$IP_Addy = $SubscriberInfo['IP_Addy'];}
								if (!isset($ReferralSource)) {$ReferralSource = $SubscriberInfo['ReferralSource'];}
								if (!isset($UniqueCode)) {$UniqueCode = $SubscriberInfo['UniqueCode'];}
								if (!isset($SentMsgs)) {$SentMsgs = $SubscriberInfo['SentMsgs'];}
								if (!isset($TimeJoined)) {$TimeJoined = $SubscriberInfo['TimeJoined'];}
								if (!isset($Real_TimeJoined)) {$Real_TimeJoined = $SubscriberInfo['Real_TimeJoined'];}
								if (!isset($LastActivity)) {$LastActivity = $SubscriberInfo['LastActivity'];}
								if ($ReferralSource == "") {$ReferralSource = "Bulk Import";}
								if ($CanReceiveHTML == "") {$CanReceiveHTML = $HandleHTML;}

								$query = "UPDATE ".$infrespsubscribers." 
										SET FirstName = '$First_Name', LastName = '$Last_Name', CanReceiveHTML = '$CanReceiveHTML', Confirmed = '$Confirmed', IP_Addy = '$IP_Addy', ReferralSource = '$ReferralSource', UniqueCode = '$UniqueCode', SentMsgs = 'SentMsgs', TimeJoined = '$TimeJoined', Real_TimeJoined = '$Real_TimeJoined', LastActivity = '$LastActivity'
										WHERE SubscriberID = '$SubscriberID'";
								// echo $query;
								$result = mysql_query($query) or die("Invalid query: " . mysql_error());
								print "<strong>Subscriber Updated: $Email_Address</strong><br>\n";

								if (($_REQUEST['subconfirmation'] == 'email') && ($DB_OptMethod == "Double") && ($Confirmed == '0')) {
									SendMessageTemplate('templates/messages/subscribe.confirm.txt',$Email_Address,$ResponderInfo['FromEmail']);
									print "<strong>Confirmation Email sent to: $Email_Address</strong><br>\n";
								}						
							}
							else {print "<strong>Duplicate Address! Not Added:</strong> $Email_Address <br>\n";}
						}
						else {
							# MOD for new Send Confirmation Email Option
							if (!(ResponderExists($Responder_ID))) {admin_redirect();}
							$ResponderInfo = GetResponderInfo($Responder_ID);
							$Timestamper = time();
							$uniq_code = generate_unique_code();
							if ($ReferralSource == "") {$ReferralSource = "Bulk Import";}
							if ($CanReceiveHTML == "") {$CanReceiveHTML = $HandleHTML;}
							
							if (($_REQUEST['subconfirmation'] == 'email') && ($DB_OptMethod == "Double")) {
								# Add a non-confirmed row to the DB
								$query = "INSERT INTO ".$infrespsubscribers." (ResponderID, SentMsgs, EmailAddress, TimeJoined, Real_TimeJoined, CanReceiveHTML, LastActivity, FirstName, LastName, IP_Addy, ReferralSource, UniqueCode, Confirmed)
								     VALUES('$Responder_ID','$Blank', '$Email_Address', '$Timestamper', '$Timestamper', '$HandleHTML', '$Timestamper', '$First_Name', '$Last_Name', '$IP_Addy', '$ReferralSource', '$uniq_code', '0')";
								    // VALUES('$Responder_ID','$DB_SentMsgs', '$DB_EmailAddress', '$DB_TimeJoined', '$DB_Real_TimeJoined', '$CanReceiveHTML', '$DB_LastActivity', '$DB_FirstName', '$DB_LastName', '$DB_IPaddy', '$DB_ReferralSource', '$DB_UniqueCode', '$DB_Confirmed')";
								$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());
								$DB_SubscriberID = mysql_insert_id();
								SendMessageTemplate('templates/messages/subscribe.confirm.txt',$Email_Address,$ResponderInfo['FromEmail']);
								print "<strong>Confirmation Email sent to: $Email_Address</strong><br>\n";
							}
							elseif (($_REQUEST['subconfirmation'] == 'auto') && ($DB_OptMethod == "Double")) {
								$query = "INSERT INTO ".$infrespsubscribers." (ResponderID, SentMsgs, EmailAddress, TimeJoined, Real_TimeJoined, CanReceiveHTML, LastActivity, FirstName, LastName, IP_Addy, ReferralSource, UniqueCode, Confirmed)
								   VALUES('$Responder_ID','$Blank', '$Email_Address', '$Timestamper', '$Timestamper', '$HandleHTML', '$Timestamper', '$First_Name', '$Last_Name', '$IP_Addy', 'ReferralSource', '$uniq_code', '1')";
								$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());
								print "Added Confirmed Subscriber: $Email_Address <br>\n";
							}
							elseif (($_REQUEST['subconfirmation'] == 'off') || ($DB_OptMethod == "Single")) {
								$query = "INSERT INTO ".$infrespsubscribers." (ResponderID, SentMsgs, EmailAddress, TimeJoined, Real_TimeJoined, CanReceiveHTML, LastActivity, FirstName, LastName, IP_Addy, ReferralSource, UniqueCode, Confirmed)
									   VALUES('$Responder_ID','$Blank', '$Email_Address', '$Timestamper', '$Timestamper', '$HandleHTML', '$Timestamper', '$First_Name', '$Last_Name', '$IP_Addy', '$ReferralSource', '$uniq_code', '0')";
								$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());
								print "Added Subscriber: $Email_Address <br>\n";
							}
						}
					}
				}
			}
		}
		# Back button
		print "<br> \n";
		$return_action = "list";
		include('templates/back_button.admin.php');
	}
	elseif  ($action == "list_export") {
		# MOD: Completed Feature Addition
		# List export options		
		include('templates/list_export.admin.php');		
		
		$return_action = "list";
		include('templates/back_button.admin.php');
	}
	elseif  ($action == "list_export_do") {
		# MOD: Completed Feature Addition
		# List export output
		
		$ResponderInfo = GetResponderInfo($Responder_ID);
		if ($_POST['exportconfirmed'] == 'yes') {			
			$query = "SELECT * FROM ".$infrespsubscribers." WHERE Confirmed = '1' AND ResponderID = '".$Responder_ID."'";
			$DB_Subscriber_Result = mysql_query($query) or die("Invalid query: " . mysql_error());
		}
		else {
			$query = "SELECT * FROM ".$infrespsubscribers." WHERE ResponderID = '".$Responder_ID."'";
			$DB_Subscriber_Result = mysql_query($query) or die("Invalid query: " . mysql_error());
		}

		for ($i=0; $i < mysql_num_rows($DB_Subscriber_Result); $i++) {
			$this_row = mysql_fetch_assoc($DB_Subscriber_Result);				
			$list_data .= $this_row['EmailAddress'];
			$list_data .= ",".$this_row['FirstName'];
			$list_data .= ",".$this_row['LastName'];
			$list_data .= ",".$this_row['CanReceiveHTML'];
			$list_data .= ",".$this_row['IP_Addy'];
			$list_data .= ",".$this_row['ReferralSource'];
			$list_data .= ",".$this_row['UniqueCode'];
			$list_data .= ",".str_replace(',','|',$this_row['SentMsgs']);
			$list_data .= ",".$this_row['TimeJoined'];
			$list_data .= ",".$this_row['Real_TimeJoined'];
			$list_data .= ",".$this_row['LastActivity'];
			$list_data .= PHP_EOL;				
		}
		mysql_free_result($DB_Subscriber_Result);
		
		# Write to CSV File
		umask(0000);
		if (is_dir(dirname(__FILE__).'/exported')) {@chmod(dirname(__FILE__).'/exported',0755);} 
		else {@mkdir(dirname(__FILE__).'/exported',0755); @chmod(dirname(__FILE__).'/exported',0755);}
		$file_name = "ExportedResponder".$Responder_ID."-".date('Y-m-d').".csv";
		$export_file = dirname(__FILE__).'/exported/'.$file_name;
		$fh = fopen($export_file,'w');
		fwrite($fh,$list_data);
		fclose($fh);
		
		include('templates/list_export_output.admin.php');
		
		$return_action = "list";
		include('templates/back_button.admin.php');
	}
	# MOD Remove this unused code...
	// elseif  ($action == "configure") {
		// Back button
		// print "<br> \n";
		// $return_action = "list";
		// include('templates/back_button.admin.php');
	// }
	// elseif ($action == "configure_do") {
		// Back button
		// print "<br> \n";
		// $return_action = "list";
		// include('templates/back_button.admin.php');
	// }
	elseif ($action == "custom_edit") {

		$query = "SELECT * FROM ".$infrespcustomfields." WHERE user_attached = '$Subscriber_ID' OR (resp_attached = '$Responder_ID' AND email_attached = '$Search_EmailAddress')";
		$result = mysql_query($query) or die("Invalid query: " . mysql_error());

		if (mysql_num_rows($result) < 1) {
		      $query = "INSERT INTO ".$infrespcustomfields." (user_attached, resp_attached, email_attached) VALUES('$Subscriber_ID','$Responder_ID','$Search_EmailAddress')";
		      $DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());
		}

		$CustomFieldsArray = GetFieldNames($infrespcustomfields);
		$query = "SELECT * FROM ".$infrespcustomfields." WHERE user_attached = '$Subscriber_ID' OR (resp_attached = '$Responder_ID' AND email_attached = '$Search_EmailAddress') LIMIT 1";
		$result = mysql_query($query) or die("Invalid query: " . mysql_error());

		$DBarray = mysql_fetch_assoc($result);

		foreach ($CustomFieldsArray as $key => $value) {
			if (empty($DBarray[$value])) {$DBarray[$value] = "";}
		}

		$display_it = TRUE;
		include('templates/customedit.admin.php');

		# Back button
		print "<br> \n";
		$return_action = "sub_edit";
		include('templates/back_button.admin.php');
	}
	elseif ($action == "custom_edit_do") {
		# Get the fields
		$CustomFieldsArray = GetFieldNames($infrespcustomfields);
		foreach ($CustomFieldsArray as $key => $value) {
			$blah = "cf_".$value;
			$reqblah = trim($_REQUEST[$blah]);
			if (!(Empty($reqblah))) {$DBarray[$value] = MakeSafe($reqblah);}
		}

		# Set static info
		$DBarray['user_attached']  = $Subscriber_ID;
		$DBarray['resp_attached']  = $Responder_ID;
		$DBarray['email_attached'] = $Search_EmailAddress;

		# Update the data
		if (is_numeric($Subscriber_ID)) {$where = "user_attached = '$Subscriber_ID'";}
		else {$where = "resp_attached = '$Responder_ID' AND email_attached = '$Search_EmailAddress'";}
		DB_Update_Array($infrespcustomfields, $DBarray, $where);

		# MOD set message
		$_SESSION['inf_resp'] = "Custom Fields Updated.";
		$action = "edit_users";

		# Done!
		// print "<br> \n";
		// print "<font size=\"4\" color=\"#666666\">Custom fields changed!</font><br>\n";
		# Back button
		// print "<br> \n";
		// $return_action = "edit_users";
		// include('templates/back_button.admin.php');
	}
	elseif ($action == "custom_codeit") {
		# Code-it template
		$display_it = TRUE;
		$return_action = "Form_Gen";
		include('templates/back_button.admin.php');
		print "<br> \n";
		include ('templates/custom_codeit.admin.php');

		# Back button
		print "<br> \n";
		include('templates/back_button.admin.php');
	}
 
	# -------------------------------------------
	# MOD moved edit_users to allow for message display
	if ($action == "edit_users") {
		# Panel top
		// $help_section = "editusers";
		// include('templates/controlpanel.php');

		$DBquery = "SELECT * FROM ".$infrespsubscribers." WHERE ResponderID = '$Responder_ID' ORDER BY EmailAddress";
		Run_UserQuery($DBquery);
	}
	elseif (($action == 'list') || ($action == '')) {
		# Panel top
		// $help_section = "mainscreen";
		// include('templates/controlpanel.php');

		# Email search button template
		include('templates/email_search.admin.php');

		// echo $siteURL.$ResponderDirectory;
		
		# MOD display message if any
		if ($_SESSION['inf_resp'] != '') {
			inf_resp_message_box($_SESSION['inf_resp']);
			unset($_SESSION['inf_resp']);
		}

		# Query it
		$query = "SELECT * FROM ".$infresponders." ORDER BY ResponderID";
		$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());

		if (mysql_num_rows($DB_result) > 0) {
			# List top template
			$alt = FALSE;
			// MOD to new list template
			// include('templates/resplist_top.admin.php');
			include('templates/list_top.responders.php');

			$i = 0;
			while ($query_result = mysql_fetch_assoc($DB_result)) {
				 $DB_ResponderID   = $query_result['ResponderID'];
				 $DB_Enabled   = $query_result['Enabled'];
				 $DB_ResponderName = $query_result['Name'];
				 $DB_ResponderDesc = $query_result['ResponderDesc'];
				 $DB_OwnerEmail    = $query_result['OwnerEmail'];
				 $DB_OwnerName     = $query_result['OwnerName'];
				 $DB_ReplyToEmail  = $query_result['ReplyToEmail'];
				 $DB_MsgList       = $query_result['MsgList'];
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

		 		# List row template
		 		$alt = (!($alt));

				// MOD new list row
				// include('templates/resplist_row.admin.php');
				include('templates/list_row.responders.php');
			}

			# List bottom template
			// MOD new list bottom
			// include('templates/resplist_bottom.admin.php');
			include('templates/list_bottom.responders.php');
		}
		else {
			print "<br><center><b>No responders exist. Click 'Add a Responder' to create one.</center>\n";
			include('templates/list_bottom.responders.php');
		}
	}
}

# MOD - DEPRECATED login functions
if ($action == "do_login") {     
	# Reset the user session
	reset_user_session();

	# Was it good or no?
	$l = trim($_REQUEST['login']);
	$p = trim($_REQUEST['pword']);
	if (($l == $config['admin_user']) AND ($p == $config['admin_pass'])) {
		# Reset our randoms
		$now = time();
		$str1 = generate_random_block();
		$str2 = generate_random_block();
		$query = "UPDATE ".$infrespconfig."
		    SET random_timestamp = '$now',
		    random_str_1 = '$str1',
		    random_str_2 = '$str2'";
		$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());
		$config['random_timestamp'] = $now;
		$config['random_str_1'] = $str1;
		$config['random_str_2'] = $str2;

		# Init our session data
		$_SESSION['initialized'] = TRUE;
		$_SESSION['timestamp'] = time();
		$_SESSION['last_IP'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['l'] = md5(WebEncrypt($l, $config['random_str_1']));
		$_SESSION['p'] = md5(WebEncrypt($p, $config['random_str_2']));

		# Redirect
		$redir_URL = $siteURL.$ResponderDirectory.'/admin.php?action=list';
		header("Location: $redir_URL");
		print "<br>\n";
		print "If your browser doesn't support redirects then you'll need to <A HREF=\"$redir_URL\">click here.</A><br>\n";
		print "<br>\n";
		die();
	}
	else {
		# Template top
		include('templates/open.page.php');

		print "<br />\n";
		if (($_REQUEST['login'] != "") && ($_REQUEST['pword'] != "")) {
			print "<p class=\"err_msg\">Error: Invalid Login/Password.</p><br />\n";
		}

		# ------ Admin login panel -------
		include('templates/login.admin.php');
	}
}

# Template bottom
copyright();
include('templates/close.page.php');

DB_disconnect();
?>