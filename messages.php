<?php
# Modified 04/16/2014 by Plugin Review Network
# ------------------------------------------------
# Modified by Infinity Responder development team: 2009-06-04
# License and copyright:
# See license.txt for license information.
# ------------------------------------------------

if (!function_exists('add_action')) {die();}
include('config.php');

# MOD call globals fix
global $Responder_ID, $DB_ResponderID, $DB_MsgList;

# MOD new tables include WP prefix
global $table_prefix;
$infrespmessages = $table_prefix.'InfResp_messages';
$infresponders = $table_prefix.'InfResp_responders';

# Grab the data
$Responder_ID = MakeSafe($_REQUEST['r_ID']);
$M_ID = MakeSafe($_REQUEST['MSG_ID']);
$action = MakeSafe($_REQUEST['action']);

# A small bit of magic to filter out any screwy crackerness of the RespID and Message ID
if (!(is_numeric($Responder_ID))) {$Responder_ID = NULL;}
if (!(is_numeric($M_ID))) {$M_ID = NULL;}

# MOD now with Wordpress capability
// if ($Is_Auth = User_Auth()) {
if (current_user_can('manage_options')) {
	# Template top
	include('templates/open.page.php');
	// include_once('popup_js.php');

	# Check responder ID
	if (!(ResponderExists($Responder_ID))) {admin_redirect();}

	# Action processing
	if ($action == "create") {
		# Init vars
		$DB_absDay   = ""; 
		$DB_absHours = 0; 
		$DB_absMins  = 0;

		# Display template
		include('templates/create.messages.php');
	}
	
	elseif ($action == "update") {
		# MOD for updated GetMsgInfo function
		$MessageInfo = GetMsgInfo($M_ID);
		$DB_MsgID = $MessageInfo['ID'];
		$DB_MsgSub = $MessageInfo['Subject'];
		$DB_MsgSeconds = $MessageInfo['Seconds'];
		$DB_MsgMonths = $MessageInfo['Months'];
		$DB_absDay = $MessageInfo['absDay'];
		$DB_absMins = $MessageInfo['absMins'];
		$DB_absHours = $MessageInfo['absHour'];
		$DB_MsgBodyText = stripslashes($MessageInfo['BodyText']);
		$DB_MsgBodyHTML = stripslashes($MessageInfo['BodyHTML']);

		# Do the math
		$T_minutes = intval($DB_MsgSeconds / 60);
		$T_seconds = $DB_MsgSeconds - ($T_minutes * 60);
		$T_hours = intval($T_minutes / 60);
		$T_minutes = $T_minutes - ($T_hours * 60);
		$T_days = intval($T_hours / 24);
		$T_hours = $T_hours - ($T_days * 24);
		$T_weeks = intval($T_days / 7);
		$T_days = $T_days - ($T_weeks * 7);
		$T_months = $DB_MsgMonths;

		# Select the correct absDay
		if ($DB_absDay == "Sunday") {$absday['Sunday'] = " SELECTED";} else {$absday['Sunday'] = "";}
		if ($DB_absDay == "Monday") {$absday['Monday'] = " SELECTED";} else {$absday['Monday'] = "";}
		if ($DB_absDay == "Tuesday") {$absday['Tuesday'] = " SELECTED";} else {$absday['Tuesday'] = "";}
		if ($DB_absDay == "Wednesday") {$absday['Wednesday'] = " SELECTED";} else {$absday['Wednesday'] = "";}
		if ($DB_absDay == "Thursday") {$absday['Thursday'] = " SELECTED";} else {$absday['Thursday'] = "";}
		if ($DB_absDay == "Friday") {$absday['Friday'] = " SELECTED";} else {$absday['Friday'] = "";}
		if ($DB_absDay == "Saturday") {$absday['Saturday'] = " SELECTED";} else {$absday['Saturday'] = "";}

		# Debug info
		# print "  MsgID   $DB_MsgID<br>\n";
		# print "  MsgSub  $DB_MsgSub<br>\n";
		# print "  MsgSec  $DB_MsgSeconds<br>\n";
		# print "  Months  $DB_MsgMonths<br>\n";
		# print "  AbsDay  $DB_absDay<br>\n";
		# print "  AbsMin  $DB_absMins<br>\n";
		# print "  AbsHour $DB_absHours<br>\n";
		# print "  MsgBody $DB_MsgBodyText<br>\n";
		# print "  MsgHTML $DB_MsgBodyHTML<br>\n";

		# Display template
		include('templates/update.messages.php');
	}

	elseif ($action == "delete") {
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

		# Display template
		include('templates/delete.messages.php');
	}

	elseif ($action == "do_create") {
		# Prep data
		$P_subj = MakeSemiSafe($_REQUEST['subj']);
		$P_bodytext = MakeSemiSafe($_REQUEST['bodytext']);
		$P_bodyhtml = MakeSemiSafe($_REQUEST['bodyhtml']);
		$P_months = MakeSafe($_REQUEST['months']);
		$P_weeks = MakeSafe($_REQUEST['weeks']);
		$P_days = MakeSafe($_REQUEST['days']);
		$P_hours = MakeSafe($_REQUEST['hours']);
		$P_min = MakeSafe($_REQUEST['min']);
		$P_absday = MakeSafe($_REQUEST['abs_day']);
		$P_abshours = MakeSafe($_REQUEST['abs_hours']);
		$P_absmin = MakeSafe($_REQUEST['abs_min']);

		if (!(is_numeric($P_months))) {$P_months = 0;}
		if (!(is_numeric($P_weeks))) {$P_weeks = 0;}
		if (!(is_numeric($P_days))) {$P_days = 0;}
		if (!(is_numeric($P_hours))) {$P_hours = 0;}
		if (!(is_numeric($P_min))) {$P_min = 0;}
		if (!(is_numeric($P_abshours))) {$P_abshours = 0;}
		if (!(is_numeric($P_absmin))) {$P_absmin = 0;}
		if (($P_absday != "Monday") && ($P_absday != "Tuesday") && ($P_absday != "Wednesday") && ($P_absday != "Thursday") && ($P_absday != "Friday") && ($P_absday != "Saturday") && ($P_absday != "Sunday")) {$P_absday = "";}

		# MOD for updated GetResponder function
		$ResponderInfo = GetResponderInfo($Responder_ID);
		$DB_MsgList = $ResponderInfo['MessageList'];

		$TempDay_Seconds =  (($P_weeks * 7) + $P_days) * 86400;
		$TempHour_Seconds = 3600 * $P_hours;
		$TempMin_Seconds  = 60 * $P_min;

		$Time_stamp = $TempDay_Seconds + $TempHour_Seconds + $TempMin_Seconds;

		# Add row to database
		$query = "INSERT INTO ".$infrespmessages." (Subject, SecMinHoursDays, Months, absDay, absMins, absHours, BodyText, BodyHTML)
			VALUES('$P_subj', '$Time_stamp', '$P_months', '$P_absday', '$P_absmin', '$P_abshours', '$P_bodytext', '$P_bodyhtml')";
		$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());

		# Clear $M_ID. If the query was successful then get the new $M_ID and
		# and attach it to the end of the Responders message list.
		$M_ID = 0;
		if (mysql_affected_rows()>0) {
			$M_ID=mysql_insert_id();
			$Update_MsgList = $DB_MsgList.",".$M_ID;
			$Update_MsgList = trim($Update_MsgList, ",");
		}

		# Update Responder MsgList with new list string.
		$query = "UPDATE ".$infresponders." SET MsgList = '$Update_MsgList' WHERE ResponderID = '$Responder_ID'";
		$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());

		# MOD set message and return to list
		$_SESSION['inf_resp_msg'] = "Message Added!";
		$action = "list";

		# Done!
		// print "<H3 style=\"color : #003300\">Message added!</H3> \n";
		// print "<font size=4 color=\"#666666\">Return to list. <br></font> \n";
		# Print back button
		// $return_action = "update";
		// include('templates/back_button.messages.php');
	}

	elseif ($action == "do_update") {
		# Prep the data
		$P_subj = MakeSemiSafe($_REQUEST['subj']);
		
		# MOD removed MakeSemiSafe filter - ruining mails!
		// $P_bodytext = MakeSemiSafe($_REQUEST['bodytext']);
		// $P_bodyhtml = MakeSemiSafe($_REQUEST['bodyhtml']);
		$P_bodytext = trim($_REQUEST['bodytext']);		
		$P_bodyhtml = trim($_REQUEST['bodyhtml']);
		
		# echo "******************";
		# print "bodyhtml: $P_bodyhtml <br>\n";
		# echo "******************";

		$img_bodyhtml = stripslashes($P_bodyhtml);
		
		if (get_option('inf_resp_embed_images') == 'yes') {

			$pattern = '/<*img[^>]*src *= *["\']?([^"\']*)/i';
			preg_match_all($pattern,$img_bodyhtml,$images);
			$imgsrcs = $images[1];
			array_unique($imgsrcs);
			echo "<b>".count($imgsrcs)." images found for embedding...</b><br><br>";
			// print_r($imgsrcs);

			// $dom = new DOMDocument;
			// $dom->loadHTML($HTML);
			// $images = $dom->getElementsByTagName('img');
			// $i = 0;
			// foreach($images as $im) {
			//	$attrs = $images->attributes();
			//	$imgsrcs[$i] = $attrs->getNamedItem('src')->nodeValue
			// 	$i++;
			// }

			$vi = 0; 
			$imageurl = get_option('inf_resp_image_url');
			$imagedir = get_option('inf_resp_image_dir');
			echo "Image Base URL: ".$imageurl."<br>";
			echo "Image Base Path: ".$imagedir."<br>";

			foreach ($imgsrcs as $image) {
				$imgtemp = substr($image,0,strlen($imageurl));
				if (strtolower($imgtemp) == strtolower($imageurl)) {
					$pos = strrpos($image,'/') + 1;
					$chunks = str_split($image,$pos);
					$thisfile = $imagedir.$chunks[1];
					if (file_exists($thisfile)) {
						$file[$vi] = $thisfile;
						echo "<b>Note:</b> Image will be embedded on send:<br><i>".$file[$vi]."</i><br>";
						$filename[$vi] = $chunks[1];
						$split = explode('.',$filename[$vi]);
						$uid[$vi] = "cid:".$split[0];
						// echo $file[$vi]." - ".$filename[$vi]." - ".$uid[$vi];
						$vi++;
					}
					else {echo "<font color=#ee0000;><b>Warning:</b></font> Image file not found:<br><i>".$thisfile."</i><br>";}
				}
				else {echo "<font color=#ee0000;><b>Warning:</b></font> External image URL:<br><i>".$image."</i><br>";}
			}
		}
				
		$P_months = MakeSafe($_REQUEST['months']);
		$P_weeks = MakeSafe($_REQUEST['weeks']);
		$P_days = MakeSafe($_REQUEST['days']);
		$P_hours = MakeSafe($_REQUEST['hours']);
		$P_min = MakeSafe($_REQUEST['min']);
		$P_absday = MakeSafe($_REQUEST['abs_day']);
		$P_abshours = MakeSafe($_REQUEST['abs_hours']);
		$P_absmin = MakeSafe($_REQUEST['abs_min']);

		if (!(is_numeric($P_months))) {$P_months = 0;}
		if (!(is_numeric($P_weeks))) { $P_weeks = 0;}
		if (!(is_numeric($P_days))) {$P_days = 0;}
		if (!(is_numeric($P_hours))) {$P_hours = 0;}
		if (!(is_numeric($P_min))) {$P_min = 0;}
		if (!(is_numeric($P_abshours))) {$P_abshours = 0;}
		if (!(is_numeric($P_absmin))) {$P_absmin = 0;}
		if (($P_absday != "Monday") && ($P_absday != "Tuesday") && ($P_absday != "Wednesday") && ($P_absday != "Thursday") && ($P_absday != "Friday") && ($P_absday != "Saturday") && ($P_absday != "Sunday")) {$P_absday = "";}

		$TempDay_Seconds =  (($P_weeks * 7) + $P_days) * 86400;
		$TempHour_Seconds = 3600 * $P_hours;
		$TempMin_Seconds  = 60 * $P_min;

		$Time_stamp = $TempDay_Seconds + $TempHour_Seconds + $TempMin_Seconds;

		# print "M_ID: $M_ID <br>\n";
		# print "P_subj: $P_subj <br>\n";
		# print "P_bodytext: $P_bodytext <br>\n";
		# print "P_bodyhtml: $P_bodyhtml <br>\n";
		# print "P_months: $P_months <br>\n";
		# print "P_weeks: $P_weeks <br>\n";
		# print "P_days: $P_days <br>\n";
		# print "P_hours: $P_hours <br>\n";
		# print "P_min: $P_min <br>\n";
		# print "Time: $Time_stamp <br>\n";
		# print "Abs day: " . $P_absday . "<br>\n";
		# print "Abs min: " . $P_absmin . "<br>\n";
		# print "Abs hour: " . $P_abshours . "<br>\n";

		# subject, body text, body html, timestamp, months

		$query = "UPDATE ".$infrespmessages."
			SET Subject = '$P_subj',
			SecMinHoursDays = '$Time_stamp',
			Months = '$P_months',
			absDay = '$P_absday',
			absMins = '$P_absmin',
			absHours = '$P_abshours',
			BodyText = '$P_bodytext',
			BodyHTML = '$P_bodyhtml'
			WHERE MsgID = '$M_ID'";

		$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());

		# MOD set message and return to list
		$_SESSION['inf_resp_msg'] = "Message ".$M_ID." Saved!";
		$action = "list";

		# Done!
		// print "<H3 style=\"color : #003300\">Message Saved!</H3> \n";
		// print "<font size=4 color=\"#666666\">Return to list. <br></font> \n";
		# Print back button
		// $return_action = "update";
		// include('templates/back_button.messages.php');
	}

	elseif ($action == "do_delete") {

		# MOD for updated GetResponder function
		$ResponderInfo = GetResponderInfo($Responder_ID);
		$DB_MsgList = $ResponderInfo['MessageList'];

		$NewList = "";
		$MsgList_Array = explode(',',$DB_MsgList);
		$Max_Index = sizeof($MsgList_Array);
		for ($i=0; $i<=$Max_Index-1; $i++) {
			$Temp_ID = trim($MsgList_Array[$i]);
			if ($Temp_ID != $M_ID) {$NewList = $NewList.",".$Temp_ID;}
		}
		$NewList = trim($NewList, ",");

		$query = "DELETE FROM ".$infrespmessages." WHERE MsgID = '$M_ID'";
		$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());

		$query = "UPDATE ".$infresponders." SET MsgList = '$NewList' WHERE ResponderID = '$Responder_ID'";
		$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());

		# MOD set message and return to list
		$_SESSION['inf_resp_msg'] = "Message Deleted!";
		$action = "list";

		# Done!
		// print "<H3 style=\"color : #003300\">Message deleted!</H3> \n";
		// print "<font size=4 color=\"#666666\">Return to list. <br></font> \n";
		# Print back button
		// $return_action = "update";
		// include('templates/back_button.messages.php');
	}

	elseif ($action == "test") {
		# MOD new action for sending test message sequence
		$ResponderInfo = GetResponderInfo($Responder_ID);
		$DB_ResponderName = $ResponderInfo['Name'];
		$DB_OwnerEmail = $ResponderInfo['OwnerEmail'];
		$DB_OwnerName = $ResponderInfo['OwnerName'];
		$DB_ReplyToEmail = $ResponderInfo['ReplyToEmail'];
		$DB_ResponderDesc = $ResponderInfo['ResponderDesc'];

		include('templates/test_msg.sequence.php');

		include('templates/back_button.messages.php');  
	}

	elseif ($action == "do_test") {
	# MOD new action for sending test message sequence

		$SubscriberInfo['EmailAddress'] = $DB_EmailAddress = $_POST['testemail'];
		$SubscriberInfo['FirstName'] = $DB_FirstName = $_POST['testfirstname'];
		$SubscriberInfo['LastName'] = $DB_LastName = $_POST['testlastname'];
		$SubscriberInfo['CanReceiveHTML'] = $CanReceiveHTML = $_POST['testhtml'];
		if ($DB_FirstName == '') {$DB_Firstname = "-=-First Name-=-";}
		if ($DB_LastName == '') {$DB_Lastname = "-=-Last Name-=-";}

		$ResponderInfo = GetResponderInfo($Responder_ID);
		$DB_ResponderName = $ResponderInfo['Name'];
		$DB_OwnerEmail = $ResponderInfo['FromEmail'];
		$DB_OwnerName = $ResponderInfo['FromName'];
		$DB_ReplyToEmail = $ResponderInfo['ReplyEmail'];

		$DB_MsgList = trim($ResponderInfo['MessageList'], ",");
		$DB_MsgList = trim($DB_MsgList);
		$MsgList_Array = explode(',',$DB_MsgList);
		$Max_Index = sizeof($MsgList_Array);

		# Sort the message list by time sequence
		for ($i=0; $i<=$Max_Index-1; $i++) {
			$M_ID = trim($MsgList_Array[$i]);
			$MessageInfo = GetMsgInfo($M_ID);
			$MsgList_Array_Data[$i]['ID'] = $M_ID;
			$MsgList_Array_Data[$i]['Seconds'] = $MessageInfo['Seconds'];
			$MsgList_Array_Data[$i]['Months'] = $MessageInfo['Months'];
		}
		usort($MsgList_Array_Data,'sort_by_time');
		// print_r($MsgList_Array_Data);

		# Work thru the msg list
		for ($msg_idx=0; $msg_idx < $Max_Index; $msg_idx++) {
			$msg_id = $MsgList_Array_Data[$msg_idx]['ID'];
			$MessageInfo = GetMsgInfo($msg_id);

			# Set the tag variables	
			$SubscriberInfo['TimeJoined'] = $DB_TimeJoined = "-=-Time Joined-=-";
			$SubscriberInfo['Real_TimeJoined'] = $DB_Real_TimeJoined = "-=-Realtime Joined-=-";
			$SubscriberInfo['LastActivity'] = $DB_LastActivity = "-=-Last Activity-=-";
			$SubscriberInfo['SubscriberID'] = $DB_SubscriberID = "-=-Subscriber ID-=-";
			$SubscriberInfo['SentMsgs'] = $DB_SentMsgs = "-=-SentMSGS-=-";
			$SubscriberInfo['UniqueCode'] = $DB_UniqueCode = "-=-Unique Code-=-";
			$SubscriberInfo['ReferralSouce'] = $DB_ReferralSource = "-=-Admin Test Sequence-=-";
			$SubscriberInfo['IP_Addy'] = $DB_IPaddy = "-=-IP Address-=-";

			$DB_MsgBodyHTML = $MessageInfo['BodyHTML'];
			$DB_MsgBodyText = $MessageInfo['BodyText'];
			$DB_MsgSub = $MessageInfo['Subject'];
			$Send_Subject = $DB_MsgSub;

			$subcode = "s" . $DB_UniqueCode;
			$unsubcode = "u" . $DB_UniqueCode;
			$UnsubURL = $siteURL."/?infresp=s&c=$unsubcode";

			# Filter the email address of a few nasties
			$DB_EmailAddress = stripnl(str_replace("|","",$DB_EmailAddress));
			$DB_EmailAddress = str_replace(">","",$DB_EmailAddress);
			$DB_EmailAddress = str_replace("<","",$DB_EmailAddress);
			$DB_EmailAddress = str_replace('/',"",$DB_EmailAddress);
			$DB_EmailAddress = str_replace('..',"",$DB_EmailAddress);

			# Process the tags
			$MessageInfo['ResponderID'] = $Responder_ID;
			$message = ProcessMessageTags($MessageInfo,$SubscriberInfo);
				
			$DB_MsgBodyText = stripslashes($message['BodyText']);
			$DB_MsgBodyHTML = stripslashes($message['BodyHTML']);
			$Send_Subject = $message['Subject'];

			# echo "************************";
			# echo $DB_MsgBodyHTML;
			# echo "************************";

			# MOD for embedding images with phpmailer			
			if (get_option('inf_resp_embed_images') == 'yes') {

				$pattern = '/<*img[^>]*src *= *["\']?([^"\']*)/i';
				preg_match_all($pattern,$DB_MsgBodyHTML,$images);
				$imgsrcs = $images[1];
				array_unique($imgsrcs);

				$vi = 0; 
				$imageurl = get_option('inf_resp_image_url');
				$imagedir = get_option('inf_resp_image_dir');;

				foreach ($imgsrcs as $image) {
					$getexternal = "";
					$imgsrc[$vi] = $image;
					$imgtemp = substr($image,0,strlen($imageurl));
					$pos = strrpos($image,'/') + 1;
					$chunks = str_split($image,$pos);
					$imgfilename[$vi] = $chunks[1];
					$splitted = explode('.',$chunks[1]);
					$imguid[$vi] = $splitted[0];
					
					if (strtolower($imgtemp) == strtolower($imageurl)) {
						$thisfile = $imagedir.$chunks[1];
						if (file_exists($thisfile)) {
							if ($imageembedinfo != "") {$imageembedinfo .= "~~~";}
							$imageembedinfo .= $thisfile;
							$imgfilepath[$vi] = $thisfile;
							$imageembedinfo .= "|||".$imgfilename[$vi]."|||".$imguid[$vi];
							$imgintext[$vi] = "internal";
							# echo "Replacing: ".$image." with ".$imguid[$vi]."<br>";
							$DB_MsgBodyHTML = str_ireplace($image,"cid:".$imguid[$vi],$DB_MsgBodyHTML);
						}
						else {$getexternal = "yes";}
					}
					else {$getexternal = "yes";}
					
					if ($getexternal == 'yes') {
						echo "Message ".$msg_idx.": downloading external image:<br>".$imgsrc[$vi]."<br>";
						// download external image
						$imgintext[$vi] = "external";
						if (get_option('inf_resp_mailer') == 'wp_mail') {
							if ($imageembedinfo != "") {$imageembedinfo .= "~~~";}
							$contents = file_get_contents($imgsrc[$vi]);
							if ($contents != "") {
								$filepath = dirname(__FILE__).'/imgtmp/'.$imgfilename[$vi];
								$handle = fopen($filepath,'w'); fwrite($handle,$contents); fclose($handle);
								$imageembedinfo .= $filepath;
								$imageembedinfo .= "|||".$imgfilename[$vi]."|||".$imguid[$vi];
							}
						}
						$DB_MsgBodyHTML = str_ireplace($image,"cid:".$imguid[$vi],$DB_MsgBodyHTML);
					}
					$vi++;
				}

				if (get_option('inf_resp_mailer') == 'wp_mail') {
					add_option('inf_resp_image_embed_info',$imageembedinfo);
					add_action('phpmailer_init','inf_resp_add_embedded_images');
				}
			}			
		
			# echo "<b>HTML Body:</b><br>";
			# echo "<textarea rows=7 cols=80>";
			# echo $DB_MsgBodyHTML;
			# echo "</textarea><br>";
			# echo "<b>Text Body:</b><br>\n";
			# echo "<textarea rows=7 cols=80>";
			# echo $DB_MsgBodyText;
			# echo "</textarea><br>";

			# Generate the headers
			$Message_Body = "";
			$Message_Headers  = "Return-Path: <" . $DB_ReplyToEmail . ">$newline";
			$Message_Headers .= "Envelope-to: $DB_EmailAddress$newline";
			$Message_Headers .= "From: $DB_OwnerName <" . $DB_ReplyToEmail . ">$newline";
			$Message_Headers .= "Date: " . date('r') . "$newline";
			$Message_Headers .= "Reply-To: $DB_ReplyToEmail$newline";
			$Message_Headers .= "Sender-IP: " . $_SERVER["SERVER_ADDR"] . $newline;
			$Message_Headers .= "MIME-Version: 1.0$newline";
			$Message_Headers .= "Priority: normal$newline";
			$Message_Headers .= "X-Mailer: WP Infinity Responder$newline";

			# Generate the body
			if (get_option('inf_resp_mailer') == 'mail') {
				if ($CanReceiveHTML == 1) {
					$boundary = md5(time()).rand(1000,9999);
					$boundary2 = md5(time()).rand(1000,9999);
					$Message_Headers .= "Content-Type: multipart/alternative; ".$newline."            boundary=\"$boundary\"$newline";
					$Message_Body .= "This is a multi-part message in MIME format.$newline$newline";
					$Message_Body .= "--".$boundary.$newline;
					$Message_Body .= "Content-type: text/plain; charset=$charset$newline";
					$Message_Body .= "Content-Transfer-Encoding: 8bit".$newline;
					$Message_Body .= "Content-Disposition: inline$newline$newline";
					$Message_Body .= $DB_MsgBodyText . $newline.$newline;
					$Message_Body .= "--".$boundary.$newline;
					if ((get_option('inf_resp_embed_images') == 'yes') && (count($imgsrc) > 0)) {					
						$Message_Body .= "Content-Type: multipart/related; ".$newline."            boundary=\"$boundary2\"".$newline.$newline;					
						$Message_Body .= "--".$boundary2.$newline;					
					}					
					$Message_Body .= "Content-type: text/html; charset=$charset$newline";
					$Message_Body .= "Content-Transfer-Encoding: 8bit".$newline;
					$Message_Body .= "Content-Disposition: inline$newline$newline";
					$Message_Body .= $DB_MsgBodyHTML . $newline.$newline;
					
					if (get_option('inf_resp_embed_images') == 'yes') {
						// Embed Images
						$vi = 0;
						if (count($imgsrc) > 0) {
							foreach ($imgsrc as $imgsource) {						
								if ($imgintext[$vi] == 'internal') {
									$file_size = filesize($imgfilepath[$vi]);
									$handle = fopen($imgfilepath[$vi], "r");
									$content = fread($handle, $file_size);
									fclose($handle);
									$content = chunk_split(base64_encode($content));
								}
								elseif ($imgintext[$vi] == 'external') {
									$content = file_get_contents($imgsrc[$vi]);
									$content = chunk_split(base64_encode($content));
								}

								$Message_Body .= "--".$boundary2.$newline;
								$Message_Body .= "Content-Type: application/octet-stream; name=\"".$imgfilename[$vi]."\"".$newline; 
								$Message_Body .= "Content-Transfer-Encoding: base64".$newline;
								$Message_Body .= "Content-ID: <".$imguid[$vi].">".$newline;
								$Message_Body .= "Content-Disposition: inline; filename=\"".$imgfilename[$vi]."\"".$newline.$newline;
								$Message_Body .= $content.$newline.$newline;
								$vi++;	
							}   						
							$Message_Body .= "--".$boundary2."--".$newline.$newline;
						}
						$Message_Body .= "--".$boundary."--".$newline.$newline;
					}
				}
				else {
					$Message_Headers .= "Content-type: text/plain; charset=$charset$newline";
					$Message_Headers .= "Content-Transfer-Encoding: 8bit".$newline;
					$Message_Body = $DB_MsgBodyText . $newline;
				}
			}

			$Send_Subject    = stripnl(str_replace("|","",$Send_Subject));
			$Message_Body    = str_replace("|","",$Message_Body);
			$Message_Headers = str_replace("|","",$Message_Headers);
			$Message_Body    = utf8_decode($Message_Body);

			echo "Sending Message <b>".$msg_idx."</b> to ".$DB_EmailAddress." :<br>";
			echo $Send_Subject."<br>";
			
			# echo "---------------------------<br>\n";
			# echo "Headers: $Message_Headers <br>\n";
			# echo "---------------------------<br>\n";		
			
			# MOD for sending message via wp_mail /phpmailer
			if (get_option('inf_resp_mailer') == 'wp_mail') {
				// Set Sender Name and Email
				add_option('inf_resp_owner_email',$DB_OwnerEmail); update_option('inf_resp_owner_email',$DB_OwnerEmail);
				add_option('inf_resp_owner_name',$DB_OwnerName); update_option('inf_resp_owner_name',$DB_OwnerName);
				add_filter('wp_mail_from', 'inf_resp_from_email',100);
				add_filter('wp_mail_from_name', 'inf_resp_from_name',100);			
				
				if ($CanReceiveHTML == 1) {
				
					# echo "<b>HTML Body:</b><br>";
					# echo "<textarea rows=7 cols=80>";
					# echo $DB_MsgBodyHTML;
					# echo "</textarea><br>";
					# echo "<b>Text Body:</b><br>\n";
					# echo "<textarea rows=7 cols=80>";
					# echo $DB_MsgBodyText;
					# echo "</textarea><br>";
				
					// Set Alt Text Body and Wordwrap
					add_option('inf_resp_alt_body',$DB_MsgBodyText); 
					update_option('inf_resp_alt_body',$DB_MsgBodyText);
					add_action('phpmailer_init', 'inf_resp_set_alt_body');
					add_action('phpmailer_init', 'inf_resp_set_word_wrap');
					
					// Send Multipart HTML/Text Email via wp_mail
					$result = wp_mail($DB_EmailAddress, $Send_Subject, $DB_MsgBodyHTML, $Message_Headers, false);
				}
				else {
					// Set Wordwrap and Send Text Only Email via wp_mail
					add_action('phpmailer_init', 'inf_resp_set_word_wrap');
					$result = wp_mail($DB_EmailAddress, $Send_Subject, $DB_MsgBodyText, $Message_Headers, false);
				}
			}
			else {
				// Send Email via mail
				# echo "Body:<br>".$Message_Body."<br>\n";
				# echo "====================<br>\n";		
				$result = mail($DB_EmailAddress, $Send_Subject, $Message_Body, $Message_Headers, "-f $DB_ReplyToEmail");	
			}
					
			if ($result) {echo "<i>Successfully Sent.</i><br>";} else {echo "<i>Sending Failed.</i><br>";}
			// echo $result;
			sleep(0.5);
		}

		$message = count($MsgList_Array)." messages in test sequence sent from Responder ".$Responder_ID." to ".$DB_EmailAddress;
		$_SESSION['inf_resp_msg'] = $message;
		$action = 'list';
	}  
	elseif ($action != 'list') {admin_redirect();}

	# MOD Copy of Message List from responders.php
	if ($action == 'list') {
		# MOD for updated GetResponder function
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
}

# Template bottom
copyright();
include('templates/close.page.php');

# MOD new include for new HTML editor options
include('htmleditors.php');

DB_disconnect();

?>