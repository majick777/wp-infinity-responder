<?php
# Modified 04/29/2014 by Plugin Review Network
# ------------------------------------------------
# License and copyright:
# See license.txt for license information.
# ------------------------------------------------

if (!function_exists('add_action')) {die();}
include('config.php');

# MOD new tables include WP prefix
global $table_prefix, $mail_id;
$infrespmail = $table_prefix.'InfResp_mail';
$infrespmailcache = $table_prefix.'InfResp_mail_cache';
$infrespsubscribers = $table_prefix.'InfResp_subscribers';

# ------------------------------------------------

function mail_msg_exists($mail_id = "0") {
	global $DB_LinkID, $table_prefix;
	$infrespmail = $table_prefix.'InfResp_mail';

	# Bounds check
	if (isEmpty($mail_id)) {return FALSE;}
	if ($mail_id == "0") {return FALSE;}
	if (!(is_numeric($mail_id))) {return FALSE;}

	# Check for its existance
	$query = "SELECT * FROM ".$infrespmail." WHERE Mail_ID = '$mail_id'";
	$result = mysql_query($query, $DB_LinkID) or die("Invalid query: " . mysql_error());
	if (mysql_num_rows($result) > 0) {return TRUE;}
	else {return FALSE;}
}

# ------------------------------------------------

function get_send_figures($mail_id) {
     global $DB_LinkID, $mail_id, $table_prefix;

	$infrespmailcache = $table_prefix.'InfResp_mail_cache';

	# Init
	$the_math['total']  = 0;
	$the_math['sent']   = 0;
	$the_math['queued'] = 0;

	# Query it
	$query = "SELECT * FROM ".$infrespmailcache." WHERE Mail_ID = '$mail_id'";
	$result = mysql_query($query,$DB_LinkID) or die("Invalid query: " . mysql_error());
	for ($i=0; $i < mysql_num_rows($result); $i++) {
		# Grab query results
		$this_row = mysql_fetch_assoc($result);
		# Tally it
		if ($this_row['Status'] == 'queued') {$the_math['queued']++;}
		elseif ($this_row['Status'] == 'sent') {$the_math['sent']++;}
	}

	# Tally it up
	$the_math['total']   = mysql_num_rows($result);
	if ($the_math['total'] == 0) {$the_math['percent'] = 100;}
	else {$the_math['percent'] = (round($the_math['sent'] / $the_math['total']) * 100);}
	return $the_math;
}

# ------------------------------------------------

# Get and verify input
$Responder_ID = MakeSafe($_REQUEST['r_ID']);
$action       = MakeSafe($_REQUEST['action']);
if (!(is_numeric($Responder_ID))) {$Responder_ID = FALSE;}

# Check authentication
// $Is_Auth = User_Auth();
// if ($Is_Auth) {
# MOD now Wordpress capability
if (current_user_can('manage_options')) {
	# Check the responder ID
	if (!($Responder_ID)) {admin_redirect();}
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
       		
	# Top template
	include('templates/open.page.php');
	// include_once('popup_js.php');

	# Check the mail ID
	$mail_id = MakeSafe($_REQUEST['m_ID']);
	if ((!(is_numeric($mail_id))) || (empty($mail_id)) || ($mail_id == "")) {$mail_id = "0";}

	if ($action == "create") {
		# Init vars
		$subject  = "";
		$text_msg = "%unsub_msg%";
		$html_msg = "<br>%unsub_msg%";
		$heading  = "Send a New Mailburst to:<br>$DB_ResponderName";
		$submit_action = "do_create";
		$return_action = "list";
		$month_to_send = strtolower(date('F', time()));
		$day_to_send   = date('d', time());
		$year_to_send  = date('Y', time());
		$hour_to_send  = date('G', time());
		$min_to_send   = date('i', time());
		$time_to_send  = date('l, dS \of F Y h:i:s A', time());
		$this_year     = date('Y', time());

		# Show the template
		include('templates/create.mailbursts.php');
	}
	elseif ($action == "do_create") {
		# Sanitize the input
		$P_subj = MakeSemiSafe($_REQUEST['subj']);

		# MOD removed MakeSemiSafe filter - ruining mails!
		// $P_bodytext = MakeSemiSafe($_REQUEST['bodytext']);
		// $P_bodyhtml = MakeSemiSafe($_REQUEST['bodyhtml']);
		$P_bodytext = trim($_REQUEST['bodytext']);		
		$P_bodyhtml = trim($_REQUEST['bodyhtml']);
		
		# echo "******************";
		# print "bodyhtml: $P_bodyhtml <br>\n";
		# echo "******************";
		
		if (isset($_REQUEST['convertlinebreaks'])) {
			if ($_REQUEST['convertlinebreaks'] == 'yes') {
				$P_bodyhtml = str_replace(PHP_EOL,'<br>',$P_bodyhtml);
			}
		}
		
		$img_bodyhtml = stripslashes($P_bodyhtml);

		if (get_option('inf_resp_embed_images') == 'yes') {

			$pattern = '/<*img[^>]*src *= *["\']?([^"\']*)/i';
			preg_match_all($pattern,$img_bodyhtml,$images);
			$imgsrcs = $images[1];
			array_unique($imgsrcs);
			echo "<b>".count($imgsrcs)." images found for embedding...</b><br><br>";
			// print_r($imgsrcs);

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
		
		$send_month = strtolower(MakeSafe($_REQUEST['send_month']));
		$send_day   = MakeSafe($_REQUEST['send_day']);
		$send_year  = MakeSafe($_REQUEST['send_year']);
		$send_hour  = MakeSafe($_REQUEST['send_hour']);
		$send_min   = MakeSafe($_REQUEST['send_min']);
		if (!(is_numeric($send_day)))  { $send_day  = date('d', time()); }
		if (!(is_numeric($send_year))) { $send_year = date('Y', time()); }
		if (!(is_numeric($send_hour))) { $send_hour = date('h', time()); }
		if (!(is_numeric($send_min)))  { $send_min  = date('i', time()); }
		if (($send_month != 'january') && ($send_month != 'february') && ($send_month != 'march') && ($send_month != 'april') && ($send_month != 'may') && ($send_month != 'june') && ($send_month != 'july') && ($send_month != 'august') && ($send_month != 'september') && ($send_month != 'october') && ($send_month != 'november') && ($send_month != 'december')) {
			$send_month = strtolower(date('F', time()));
		}

		# Get the timestamp
		$str = "$send_month $send_day $send_year +$send_hour hours +$send_min minutes";
		$time_to_send = strtotime($str);
		# echo $str . "<br>\n";
		# echo $time_to_send . "<br>\n";
		# echo date('l, dS \of F Y h:i:s A', $time_to_send);

		# Add the burst message to the DB
		$timestamp = time();
		$query = "INSERT INTO ".$infrespmail." (ResponderID,Closed,Subject,TEXT_msg,HTML_msg,Time_To_Send,Time_Sent) VALUES ('$Responder_ID','0','$P_subj','$P_bodytext','$P_bodyhtml','$time_to_send','$timestamp')";
		$result = mysql_query($query) OR die("Invalid query: " . mysql_error());
		$mail_id = mysql_insert_id();

		$ResponderInfo = GetResponderInfo($Responder_ID);
		
		# Get the subscriber list for this responder
		$query = "SELECT * FROM ".$infrespsubscribers." WHERE ResponderID = '$Responder_ID'";
		$DB_Subscriber_Result = mysql_query($query) or die("Invalid query: " . mysql_error());
		for ($i=0; $i < mysql_num_rows($DB_Subscriber_Result); $i++) {
			# Grab query results
			$this_row = mysql_fetch_assoc($DB_Subscriber_Result);
			$subscriber_id = $this_row['SubscriberID'];

			# Add the cache entries for this subscriber if they're confirmed
			if ($this_row['Confirmed'] == 1) {
				$query = "INSERT INTO ".$infrespmailcache." (Mail_ID,SubscriberID,Status,LastActivity) VALUES ('$mail_id','$subscriber_id','queued','$timestamp')";
				$result = mysql_query($query) OR die("Invalid query: " . mysql_error());
			}
			else {			
				# MOD fix for mailbursts to single-optin responders!
				if ($ResponderInfo['OptinMethod'] == 'Single') {
					$query = "INSERT INTO ".$infrespmailcache." (Mail_ID,SubscriberID,Status,LastActivity) VALUES ('$mail_id','$subscriber_id','queued','$timestamp')";
					$result = mysql_query($query) OR die("Invalid query: " . mysql_error());
				}				
			}			
		}

		inf_resp_message_box("Mailburst added.");
		$action = 'list';
		# Done! Take us back...
		// $return_action = "list";
		// print "<p class=\"big_header\">Mailburst added!</p>\n";
		// include('templates/back_button.mailbursts.php');
	}
	elseif (($action == "edit") && (mail_msg_exists($mail_id))) {
		# Query DB - We already know there's a row for it.
		$query = "SELECT * FROM ".$infrespmail." WHERE Mail_ID = '$mail_id'";
		$result = mysql_query($query) OR die("Invalid query: " . mysql_error());
		$this_msg = mysql_fetch_assoc($result);

		# Init vars
		$subject  = $this_msg['Subject'];
		$text_msg = $this_msg['TEXT_msg'];
		$html_msg = $this_msg['HTML_msg'];
		$timesent = date('l dS \of F Y h:i:s A', $this_msg['Time_Sent']);
		$month_to_send = strtolower(date('F', $this_msg['Time_To_Send']));
		$day_to_send   = date('d', $this_msg['Time_To_Send']);
		$year_to_send  = date('Y', $this_msg['Time_To_Send']);
		$hour_to_send  = date('G', $this_msg['Time_To_Send']);
		$min_to_send   = date('i', $this_msg['Time_To_Send']);
		$time_to_send  = date('l, dS \of F Y h:i:s A', $this_msg['Time_To_Send']);
		$this_year = date('Y', time());
		if ($this_msg['Closed'] == "0") {$status = "Active";}
		else {$status = "Paused";}
		$heading = "Edit Mailburst to:<br>$DB_ResponderName";
		$submit_action = "do_edit";
		$return_action = "list";

		# Get the math numbers
		$the_math = get_send_figures($mail_id);

		# foreach ($this_msg as $key => $value) {
		#    echo $key . " - " . $value . "<br>\n";
		# }

		# Show the template
		include('templates/edit.mailbursts.php');
	}
	elseif (($action == "do_edit") && (mail_msg_exists($mail_id))) {
		# Sanitize the input
		$P_subj     = MakeSemiSafe($_REQUEST['subj']);
		
		# MOD removed MakeSemiSafe filter - ruining mails!
		$P_bodytext = trim($_REQUEST['bodytext']);
		$P_bodyhtml = trim($_REQUEST['bodyhtml']);
		$send_month = strtolower(MakeSafe($_REQUEST['send_month']));
		$send_day   = MakeSafe($_REQUEST['send_day']);
		$send_year  = MakeSafe($_REQUEST['send_year']);
		$send_hour  = MakeSafe($_REQUEST['send_hour']);
		$send_min   = MakeSafe($_REQUEST['send_min']);
		if (!(is_numeric($send_day)))  { $send_day  = date('d', time()); }
		if (!(is_numeric($send_year))) { $send_year = date('Y', time()); }
		if (!(is_numeric($send_hour))) { $send_hour = date('h', time()); }
		if (!(is_numeric($send_min)))  { $send_min  = date('i', time()); }
		if (($send_month != 'january') && ($send_month != 'february') && ($send_month != 'march') && ($send_month != 'april') && ($send_month != 'may') && ($send_month != 'june') && ($send_month != 'july') && ($send_month != 'august') && ($send_month != 'september') && ($send_month != 'october') && ($send_month != 'november') && ($send_month != 'december')) {
			$send_month = strtolower(date('F', time()));
		}

		# Get the timestamp
		$str = "$send_month $send_day $send_year +$send_hour hours +$send_min minutes";
		$time_to_send = strtotime($str);
		# echo $str . "<br>\n";
		# echo $time_to_send . "<br>\n";
		# echo date('l, dS \of F Y h:i:s A', $time_to_send);

		# Do the update
		$query = "UPDATE ".$infrespmail." SET Subject = '$P_subj', TEXT_msg = '$P_bodytext', HTML_msg = '$P_bodyhtml', Time_To_Send = '$time_to_send' WHERE Mail_ID = '$mail_id'";
		$result = mysql_query($query) OR die("Invalid query: " . mysql_error());

		# MOD Update Mail Cache (for new subscribers)
		$query = "SELECT * FROM ".$infrespmailcache." WHERE Mail_ID = '".$mail_id."'";
		$DB_Mail_Cache_Result = mysql_query($query) or die("Invalid query: " . mysql_error());
		$vi = 0;
		for ($i=0; $i < mysql_num_rows($DB_Mail_Cache_Result); $i++) {
			$this_entry = mysql_fetch_assoc($DB_Mail_Cache_Result);
			$this_mail_subscribers[$vi] = $this_entry['SubscriberID']; $vi++;
		}
	
		// print_r($this_mail_subscribers);
	
		$query = "SELECT * FROM ".$infrespsubscribers." WHERE ResponderID = '$Responder_ID'";
		$DB_Subscriber_Result = mysql_query($query) or die("Invalid query: " . mysql_error());
		for ($i=0; $i < mysql_num_rows($DB_Subscriber_Result); $i++) {
			# Grab query results
			$this_row = mysql_fetch_assoc($DB_Subscriber_Result);
			$subscriber_id = $this_row['SubscriberID'];
			$timestamp = time();
			
			if (!in_array($subscriber_id,$this_mail_subscribers)) {
				# Add the cache entries for this subscriber if they're confirmed
				if ($this_row['Confirmed'] == 1) {
					$query = "INSERT INTO ".$infrespmailcache." (Mail_ID,SubscriberID,Status,LastActivity) VALUES ('$mail_id','$subscriber_id','queued','$timestamp')";
					$result = mysql_query($query) OR die("Invalid query: " . mysql_error());
				}
				else {			
					# MOD fix for mailbursts to single-optin responders!
					if ($ResponderInfo['OptinMethod'] == 'Single') {
						$query = "INSERT INTO ".$infrespmailcache." (Mail_ID,SubscriberID,Status,LastActivity) VALUES ('$mail_id','$subscriber_id','queued','$timestamp')";
						$result = mysql_query($query) OR die("Invalid query: " . mysql_error());
					}				
				}			
			}
		}
		
		inf_resp_message_box("Mailburst updated.");
		$action = 'list';
		# Done! Take us back...
		// $return_action = "list";
		// print "<p class=\"big_header\">Mailburst changed!</p>\n";
		// include('templates/back_button.mailbursts.php');
	}
	elseif (($action == "pause") && (mail_msg_exists($mail_id))) {
		# Toggle pause
		$query = "SELECT * FROM ".$infrespmail." WHERE Mail_ID = '$mail_id'";
		$result = mysql_query($query) OR die("Invalid query: " . mysql_error());
		if (mysql_num_rows($result) > 0) {
			$this_row = mysql_fetch_assoc($result);
			if ($this_row['Closed'] == "0") {
				$msg = "Message paused.";
				// $msg = "<br><center>Message paused!</center><br><br>\n";
				$toggle_query = "UPDATE ".$infrespmail." SET Closed = '1' WHERE Mail_ID = '$mail_id'";
			}
			else {
				$msg = "Message re-activated.";
				// $msg = "<br><center>Message re-activated!</center><br><br>\n";
				$toggle_query = "UPDATE ".$infrespmail." SET Closed = '0' WHERE Mail_ID = '$mail_id'";
			}
			$tog_result = mysql_query($toggle_query) or die("Invalid query: " . mysql_error());

			inf_resp_message_box($msg);
			$action = 'list';
			# Show screen msg
			// $return_action = "edit";
			// print $msg;
			// include('templates/back_button.mailbursts.php');
		}
	}
	elseif (($action == "delete") && (mail_msg_exists($mail_id))) {
		# Query DB - We already know there's a row for it.
		$query = "SELECT * FROM ".$infrespmail." WHERE Mail_ID = '$mail_id'";
		$result = mysql_query($query) OR die("Invalid query: " . mysql_error());
		$this_msg = mysql_fetch_assoc($result);

		# Init vars
		$subject  = $this_msg['Subject'];
		$text_msg = $this_msg['TEXT_msg'];
		$html_msg = $this_msg['HTML_msg'];
		$timesent = date('l, dS \of F Y h:i:s A', $this_msg['Time_Sent']);
		$month_to_send = strtolower(date('F', $this_msg['Time_To_Send']));
		$day_to_send   = date('d', $this_msg['Time_To_Send']);
		$year_to_send  = date('Y', $this_msg['Time_To_Send']);
		$hour_to_send  = date('G', $this_msg['Time_To_Send']);
		$min_to_send   = date('i', $this_msg['Time_To_Send']);
		$time_to_send  = date('l, dS \of F Y h:i:s A', $this_msg['Time_To_Send']);
		if ($this_msg['Closed'] == "0") {$status = "Active";}
		else {$status = "Paused";}
		$heading       = "Delete Mailburst?";
		$submit_action = "do_delete";
		$return_action = "list";

		# Get the math numbers
		$the_math = get_send_figures($mail_id);

		# Show the template
		include('templates/delete.mailbursts.php');
	}
	elseif (($action == "do_delete") && (mail_msg_exists($mail_id))) {
		# Delete from the mail table
		$query = "DELETE FROM ".$infrespmail." WHERE Mail_ID = '$mail_id'";
		$result = mysql_query($query) OR die("Invalid query: " . mysql_error());

		# Delete from the mail cache table
		$query = "DELETE FROM ".$infrespmailcache." WHERE Mail_ID = '$mail_id'";
		$result = mysql_query($query) OR die("Invalid query: " . mysql_error());

		inf_resp_message_box("Message deleted.");
		$action = 'list';
		# Done! Take us back...
		// $return_action = "list";
		// print "<p class=\"big_header\">Mailburst deleted!</p>\n";
		// include('templates/back_button.mailbursts.php');
	}
	
	# ---------------
	# MOD mailburst list 
	if ( ($action == "list") || ($action == "") ) {
		# Init vars
		$submit_action = "create";
		$return_action = "list";
		$heading = "Mailbursts for: $DB_ResponderName";

		# Responder button template
		include('templates/responder_button.mailbursts.php');

		$alt = TRUE;
		$query = "SELECT * FROM ".$infrespmail." WHERE ResponderID = '$Responder_ID'";
		$DB_Mail_Result = mysql_query($query) or die("Invalid query: " . mysql_error());
		if (mysql_num_rows($DB_Mail_Result) > 0) {
			# Top template
			$servertime = time();
			$serverdate = date('h:i:s A l,\<\b\r\>dS \of F Y ', $servertime);
			include('templates/list_top.mailbursts.php');

			for ($i=0; $i < mysql_num_rows($DB_Mail_Result); $i++) {
				# Mail_ID, ResponderID, Closed, Subject, TEXT_msg, HTML_msg, Time_Sent
				$data = mysql_fetch_assoc($DB_Mail_Result);

				# Init vars
				$mail_id = $data['Mail_ID'];
				$timesent = date('h:i:s A l,\<\b\r\>dS \of F Y', $data['Time_Sent']);
				$timetosend = date('h:i:s A l,\<\b\r\>dS \of F Y', $data['Time_To_Send']);
				$month_to_send = strtolower(date('F', $this_msg['Time_To_Send']));
				$day_to_send   = date('d', $this_msg['Time_To_Send']);
				$year_to_send  = date('Y', $this_msg['Time_To_Send']);
				$hour_to_send  = date('G', $this_msg['Time_To_Send']);
				$min_to_send   = date('i', $this_msg['Time_To_Send']);
				$time_to_send  = date('l, dS \of F Y h:i:s A', $this_msg['Time_To_Send']);
				
				if ($data['Time_To_Send'] <= $servertime) {$ready = 'yes';} else {$ready = 'no';}
				$the_math = get_send_figures($mail_id);
				
				if ($data['Closed'] == "0") {$status = "Active";}
				else {$status = "Paused";}

				# Show the template
				include('templates/list_row.mailbursts.php');

				# Alternate colors
				$alt = (!($alt));
			}

			# Bottom template
			include('templates/list_bottom.mailbursts.php');
		}
		else {
			print "<br><p style='text-align:center;'><b>No mailbursts exist. Create one?</b></p><br>";
		}

		# Bottom template - Add new / back
		include('templates/add_new.mailbursts.php');
	}

	# Template bottom
	copyright();
	include('templates/close.page.php');
}
else  {admin_redirect();}

# MOD for new editor options
include('htmleditors.php');

DB_disconnect();
?>