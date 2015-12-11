<?php
# Modified 04/29/2014 by Plugin Review Network
# ------------------------------------------------
# License and copyright:
# See license.txt for license information.
# ------------------------------------------------

// Load Wordpress by Shortinit
// -----------------------
	
if (!function_exists('inf_resp_find_require')) {
	function inf_resp_find_require($file,$folder=null) {
		if ($folder === null) {$folder = dirname(__FILE__);}
		$path = $folder.'/'.$file;
		if (file_exists($path)) {require($path); return $folder;} 
		else {
			$upfolder = inf_resp_find_require($file,dirname($folder));
			if ($upfolder != '') {return $upfolder;}
		}
	}
}

global $table_prefix, $siteURL;
if ($table_prefix == "") {
	define('SHORTINIT', true); 
	$wproot = inf_resp_find_require('wp-load.php');
	include($wproot.'/wp-includes/general-template.php');
	include($wproot.'/wp-includes/link-template.php');
	include($wproot.'/wp-includes/formatting.php');
}

include_once(dirname(__FILE__).'/config.php');

// Output for PHP Called Cron Line
if (isset($argv)) {if ($argv[1] == get_option('inf_resp_cron_key')) {$silent = FALSE;} }

# MOD all tables now include WP table prefix
$infrespconfig = $table_prefix.'InfResp_config';
$infrespmessages = $table_prefix.'InfResp_messages';
$infresponders = $table_prefix.'InfResp_responders';
$infrespsubscribers = $table_prefix.'InfResp_subscribers';
$infrespmail = $table_prefix.'InfResp_mail';
$infrespmailcache = $table_prefix.'InfResp_mail_cache';
$infrespcustomfields = $table_prefix.'InfResp_customfields';

if ($silent != TRUE) {
     echo "<html>\n";
     echo "<head>\n";
     echo "   <title>WP Infinity Responder Mailer</title>\n";
     echo "   <meta http-equiv=Content-Type content=\"text/html; charset=UTF-8\">\n";
     echo "</head>\n";
     echo "<font face='helvetica' style='font-size:9pt;'>\n";
}

# Verbose
if ($silent != TRUE) {echo "Loading...<br>\n";}

# Check mail and bounces?
if ($sendmails_included != TRUE) {
	if ($config['check_mail'] == '1') {
		$included = TRUE;
		if ($silent != TRUE) { echo "Running MailChecker...<br>\n"; }
		include_once('mailchecker.php');
	}
	if ($config['check_bounces'] == '1') {
		$included = TRUE;
		if ($silent != TRUE) { echo "Running BounceChecker...<br>\n"; }
		include_once('bouncechecker.php');
	}
}

# Verbose
if ($silent != TRUE) { echo "<br>Initializing...<br>\n"; }

# Init the batch send count
$Send_Count = 0;

# Prep the daily send count
$now = time();
if ($config['daily_reset'] == 0) {
	$config['daily_reset'] = $now;
	$query = "UPDATE ".$infrespconfig." SET daily_count = '0', daily_reset = '$now'";
	$result = mysql_query($query) or die("Invalid query: " . mysql_error());
}
$reset_time = strtotime("+1 day",$config['daily_reset']);
if ($now > $reset_time) {
	# It's time to reset the count!
	$config['daily_reset'] = $now;
	$config['daily_count'] = 0;
	$query = "UPDATE ".$infrespconfig." SET daily_count = '0', daily_reset = '$now'";
	$result = mysql_query($query) or die("Invalid query: " . mysql_error());
}

# - - - - - - - - - - - - - - - - - - -
# Pre-cache DB data to reduce SQL calls
# - - - - - - - - - - - - - - - - - - -

# Check the send counts first...
if ($config['daily_count'] <= $config['daily_limit']) {
	# Verbose
	if ($silent != TRUE) {echo "Pre-caching the database...<br>\n";}

	# Cache the messages
	$query = "SELECT * FROM ".$infrespmessages." ORDER BY MsgID";
	$DB_Message_Result = mysql_query($query) or die("Invalid query: " . mysql_error());
	for ($i=0; $i < mysql_num_rows($DB_Message_Result); $i++) {
		$this_row = mysql_fetch_assoc($DB_Message_Result);
		$message_id = $this_row['MsgID'];
		$message_array[$message_id] = $this_row;
		// if ($silent != TRUE) {
		//	echo $this_row['MsgID'] . " " . $this_row['BodyText'] . "<br>\n";
		// }
	}
	mysql_free_result($DB_Message_Result);

	# Cache the responders
	$query = "SELECT * FROM ".$infresponders." ORDER BY ResponderID";
	$DB_Responder_Result = mysql_query($query) or die("Invalid query: " . mysql_error());
	for ($i=0; $i < mysql_num_rows($DB_Responder_Result); $i++) {
		$this_row = mysql_fetch_assoc($DB_Responder_Result);
		$responder_id = $this_row['ResponderID'];
		$responder_array[$responder_id] = $this_row;
		// if ($silent != TRUE) {
		// 	foreach ($responder_array[$responder_id] as $key => $value) {
		//	    echo $key . " - " . $value . "<br />\n";
		//	}
		// }
	}
	mysql_free_result($DB_Responder_Result);

	# Cache the subscribers
	$query = "SELECT * FROM ".$infrespsubscribers." ORDER BY ResponderID";
	$DB_Subscriber_Result = mysql_query($query) or die("Invalid query: " . mysql_error());
	for ($i=0; $i < mysql_num_rows($DB_Subscriber_Result); $i++) {
		$this_row = mysql_fetch_assoc($DB_Subscriber_Result);
		$subscriber_id = $this_row['SubscriberID'];
		$subscriber_array[$subscriber_id] = $this_row;
		// if ($silent != TRUE) {
		//	foreach ($subscriber_array[$subscriber_id] as $key => $value) {
		//	    echo $key . " - " . $value . "<br />\n";
		//	}
		//	echo "<br>\n";
		// }
	}
	mysql_free_result($DB_Subscriber_Result);

	# Cache the mail messages
	$query = "SELECT * FROM ".$infrespmail." ORDER BY Mail_ID";
	$DB_Mail_Result = mysql_query($query) or die("Invalid query: " . mysql_error());
	for ($i=0; $i < mysql_num_rows($DB_Mail_Result); $i++) {
		$this_row = mysql_fetch_assoc($DB_Mail_Result);
		$mail_id = $this_row['Mail_ID'];
		$mail_msg_array[$mail_id] = $this_row;
		// if ($silent != TRUE) {
		//	foreach ($mail_msg_array[$mail_id] as $key => $value) {
		//	    echo $key . " - " . $value . "<br />\n";
		//	}
		// }
	}
	mysql_free_result($DB_Mail_Result);
}
else {
	# Verbose
	if ($silent != TRUE) { echo "Daily throttle reached!<br>\n"; }
}
$cop = checkit();

# - - - - - - - - - - - - - - - - - - -
# Handle the responder-style messages
# - - - - - - - - - - - - - - - - - - -

# Are we under the send counts?
if (($Send_Count <= $max_send_count) && ($config['daily_count'] <= $config['daily_limit']) && (count($subscriber_array) > 0)) {
	# Verbose
	if ($silent != TRUE) {echo "<br>Checking responder messages...<br>\n";}

 	# Yes, start going thru the subscribers to handle the responder-style msgs
 	foreach ($subscriber_array as $subscriber_id => $this_subscriber) {
 		if ($Send_Count <= $max_send_count) {
			# Fetch the responder ID
			$this_responder_id = $this_subscriber['ResponderID'];

			# Get the message list for this subscriber's responder
			$this_responder = $responder_array[$this_responder_id];
	
			if ( ($this_responder['OptMethod'] == 'Single') || ( ($this_responder['OptMethod'] == 'Double') && ($this_subscriber['Confirmed'] == '1') ) ) {

				# Debug info
				# echo "<br>\n";
				if ($silent != TRUE) {
					echo "Responder:  " . $this_subscriber['ResponderID'] . "<br>\n";
					echo "Email: " . $this_subscriber['EmailAddress'] . "<br>\n";
				}

				$DB_Enabled = $this_responder['Enabled'];

				if (!$DB_Enabled) {
					if ($silent != TRUE) {
						echo "Skipping Responder ".$this_responder_id." for subscriber ".$subscriber_id." (paused).";
					}
				}
				else {

					# Split and process the list
					$DB_MsgList = trim($this_responder['MsgList'], ",");
					$DB_MsgList = trim($DB_MsgList);
					$MsgList_Array=explode(',',$DB_MsgList);
					$Max_Index = sizeof($MsgList_Array);

					if ($silent != TRUE) {echo "Max index: " . $Max_Index . "<br>\n";}

					# Work thru the msg list
					for ($msg_idx=0; $msg_idx < $Max_Index; $msg_idx++) {
						$msg_id   = $MsgList_Array[$msg_idx];
						$msg_data = $message_array[$msg_id];

						# Check to see if the message ID is in the message list.
						if ((!(IsInList($this_subscriber['SentMsgs'], $msg_id))) && ($Send_Count <= $max_send_count) && (is_numeric($msg_id)) && ($config['daily_count'] <= $config['daily_limit'])) {
							# Debug info
							if ($silent != TRUE) {
								echo "ID:   " . $msg_id . "<br>\n";
								echo "Subj: " . $msg_data['Subject'] . "<br>\n";
							}

							# Figure out the time that this subscriber should receive this message.

							# Seconds math (mins, hours, days).
							$message_send_time = $this_subscriber['TimeJoined'] + $msg_data['SecMinHoursDays'];

							# Months math.
							if ($msg_data['Months'] > 0) {
								$month_str = "+" . $msg_data['Months'] . " months";
								$message_send_time = strtotime($month_str,$message_send_time);
							}

							# Check bounds
							if (!(is_numeric($msg_data['absHours']))) {$msg_data['absHours'] = 0;}
							if (!(is_numeric($msg_data['absMins']))) {$msg_data['absMins'] = 0;}

							# Calculate absolute positioning.
							if (($msg_data['absDay'] != "") || ($msg_data['absHours'] > 0) || ($msg_data['absMins'] > 0)) {
								# Reposition the clock to the day
								$that_day = date('j F Y',$message_send_time);
								$message_send_time = strtotime($that_day);

								# Figure the next day
								if (($msg_data['absDay'] == "Monday") || ($msg_data['absDay'] == "Tuesday") || ($msg_data['absDay'] == "Wednesday") || ($msg_data['absDay'] == "Thursday") || ($msg_data['absDay'] == "Friday") || ($msg_data['absDay'] == "Saturday") || ($msg_data['absDay'] == "Sunday")) {
									# Get this day
									$day_in_question = date('l',$message_send_time);

									# Do we need to find the next day?
									if ($day_in_question != $msg_data['absDay']) {
										# Yes, reposition the day
										$day_str = "next " . $msg_data['absDay'];
										$message_send_time = strtotime($day_str,$message_send_time);
									}
								}

								# Add the hours
								if ($msg_data['absHours'] > 0) {
									$message_send_time = strtotime("+" . $msg_data['absHours'] . " hours",$message_send_time);
								}

								# Add the minutes
								if ($msg_data['absMins'] > 0) {
									$message_send_time = strtotime("+" . $msg_data['absMins'] . " minutes",$message_send_time);
								}
							}

							# Ok, we've constructed the correct send time, is it time yet?
							if (time() >= $message_send_time) {
								# Yes, it is.

								# Make the new msg str
								$NewMsgStr = $this_subscriber['SentMsgs'] . "," . $msg_id;
								$NewMsgStr = trim($NewMsgStr, ",");
								$NewMsgStr = trim($NewMsgStr);
								$this_subscriber['SentMsgs'] = $NewMsgStr;

								# Update a little more data
								$Set_LastActivity = time();
								$this_subscriber['LastActivity'] = $Set_LastActivity;
								$subscriber_array[$subscriber_id]['LastActivity'] = $Set_LastActivity;

								# Set the tag variables
								$SubscriberInfo['TimeJoined'] = $DB_TimeJoined = $this_subscriber['TimeJoined'];
								$SubscriberInfo['Real_TimeJoined'] = $DB_Real_TimeJoined = $this_subscriber['Real_TimeJoined'];
								$SubscriberInfo['EmailAddress'] = $DB_EmailAddress = $this_subscriber['EmailAddress'];
								$SubscriberInfo['LastActivity'] = $DB_LastActivity = $this_subscriber['LastActivity'];
								$SubscriberInfo['FirstName'] = $DB_FirstName = $this_subscriber['FirstName'];
								$SubscriberInfo['LastName'] = $DB_LastName = $this_subscriber['LastName'];
								$SubscriberInfo['CanReceiveHTML'] = $CanReceiveHTML = $this_subscriber['CanReceiveHTML'];
								$SubscriberInfo['SubscriberID'] = $DB_SubscriberID = $this_subscriber['SubscriberID'];
								$SubscriberInfo['SentMsgs'] = $DB_SentMsgs = $this_subscriber['SentMsgs'];
								$SubscriberInfo['UniqueCode'] = $DB_UniqueCode = $this_subscriber['UniqueCode'];
								# MOD - Bugfix for these two tags!
								$SubscriberInfo['ReferralSource'] = $DB_ReferralSource = $this_subscriber['ReferralSource'];
								$SubscriberInfo['IP_Addy'] = $DB_IPaddy = $this_subscriber['IP_Addy'];

								$DB_ResponderName = $this_responder['Name'];
								$DB_OwnerEmail = $this_responder['OwnerEmail'];
								$DB_OwnerName = $this_responder['OwnerName'];
								$DB_ReplyToEmail = $this_responder['ReplyToEmail'];
								$DB_ResponderDesc = $this_responder['ResponderDesc'];

								$DB_MsgBodyHTML = $MessageInfo['BodyHTML'] = $msg_data['BodyHTML'];
								$DB_MsgBodyText = $MessageInfo['BodyText'] = $msg_data['BodyText'];
								$DB_MsgSub = $MessageInfo['Subject'] = $msg_data['Subject'];
								$Responder_ID = $this_responder_id;
								$Send_Subject = "$DB_MsgSub";
								$subcode = "s" . $DB_UniqueCode;
								$unsubcode = "u" . $DB_UniqueCode;

								// MOD ACTION
								// $UnsubURL = $siteURL.$ResponderDirectory."/s.php?c=$unsubcode";
								$UnsubURL = $siteURL."/?infresp=s&c=$unsubcode";
								if ($silent != TRUE) {echo "Unsub url: $UnsubURL <br>\n";}

								# echo "------------------------------<br>\n";
								# echo "HTML:  " . $DB_MsgBodyHTML . "<br>\n";
								# echo "Text:  " . $DB_MsgBodyText  . "<br>\n";
								# echo "Subj:  " . $msg_data['Subject'] . "<br>\n";

								# Filter the email address of a few nasties
								$DB_EmailAddress = stripnl(str_replace("|","",$DB_EmailAddress));
								$DB_EmailAddress = str_replace(">","",$DB_EmailAddress);
								$DB_EmailAddress = str_replace("<","",$DB_EmailAddress);
								$DB_EmailAddress = str_replace('/',"",$DB_EmailAddress);
								$DB_EmailAddress = str_replace('..',"",$DB_EmailAddress);

								# Process the tags
								$MessageInfo['ResponderID'] = $Responder_ID;
								$message = ProcessMessageTags($MessageInfo,$SubscriberInfo);
								// print_r($message);
								// echo "<br>";

								$DB_MsgBodyText = $message['BodyText'];
								$DB_MsgBodyHTML = stripslashes($message['BodyHTML']);
								$Send_Subject = $message['Subject'];

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
											if ($silent != TRUE) {echo "Message ".$msg_idx.": downloading external image:<br>".$imgsrc[$vi]."<br>";}
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

								# Generate the headers
								$Message_Body     = "";
								$Message_Headers  = "Return-Path: <" . $DB_ReplyToEmail . ">$newline";
								# $Message_Headers .= "Return-Receipt-To: <" . $DB_ReplyToEmail . ">$newline";
								$Message_Headers .= "Envelope-to: $DB_EmailAddress$newline";
								$Message_Headers .= "From: $DB_OwnerName <" . $DB_ReplyToEmail . ">$newline";
								# $Message_Headers .= "Date: " . date('D\, j F Y H:i:s O') . "$newline";
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

								# Final filtering
								$Send_Subject    = stripnl(str_replace("|","",$Send_Subject));
								$Message_Body    = str_replace("|","",$Message_Body);
								$Message_Headers = str_replace("|","",$Message_Headers);
								$Message_Body    = utf8_decode($Message_Body);

								# Send the mail
								if ($silent != TRUE) {
									echo "Addy: $DB_EmailAddress <br>\n";
									echo "Subj: $Send_Subject <br>\n";
									echo "Head: $Message_Headers <br>\n";				
								}

								# MOD for sending message via wp_mail /phpmailer
								if (get_option('inf_resp_mailer') == 'wp_mail') {
									if ($silent != TRUE) {
										echo "Text Body: <textarea>$DB_MsgBodyText </textarea><br>\n";
										echo "HTML Body: <textarea>$DB_MsgBodyHTML</textarea><br>\n";
										echo "---------------------------<br>\n";
									}

									// Set Sender Name and Email
									add_option('inf_resp_owner_email',$DB_OwnerEmail); update_option('inf_resp_owner_email',$DB_OwnerEmail);
									add_option('inf_resp_owner_name',$DB_OwnerName); update_option('inf_resp_owner_name',$DB_OwnerName);
									add_filter('wp_mail_from', 'inf_resp_from_email',100);
									add_filter('wp_mail_from_name', 'inf_resp_from_name',100);			

									if ($CanReceiveHTML == 1) {

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
									if ($silent != TRUE) {
										echo "Mail Body: <textarea>$Message_Body</textarea><br>\n";
										echo "---------------------------<br>\n";
									}
									$result = mail($DB_EmailAddress, $Send_Subject, $Message_Body, $Message_Headers, "-f $DB_ReplyToEmail");	
								}

								if ($silent != TRUE) {echo "Result: $result <br>\n";}

								# Verbose
								if ($silent != TRUE) {echo "Responder message to subscriber #" . $subscriber_id . "<br>\n";}

								# Update the DB
								$query = "UPDATE ".$infrespsubscribers."
								SET SentMsgs = '$NewMsgStr',
								LastActivity = '$Set_LastActivity'
								WHERE SubscriberID = '$DB_SubscriberID'";
								$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());

								# Increment the send counts
								$Send_Count++;
								$config['daily_count']++;
							}
						}
					}
				}
			}
		}
	}
}
else {
	if (count($subscriber_array) > 0) {
		# Verbose
		if ($silent != TRUE) {echo "No responder messages sent - throttle limit reached.<br>\n";}
	}
	else {
		# Verbose
		if ($silent != TRUE) {echo "No subscribers to send to yet.<br>\n";}
	}
}


# - - - - - - - - - - - - - - - - - - -
# Handle the newsletter-style messages
# - - - - - - - - - - - - - - - - - - -

# Are we under the send counts?
if (($Send_Count <= $max_send_count) && ($config['daily_count'] <= $config['daily_limit'])) {
	# Verbose
	if ($silent != TRUE) {echo "<br>Checking newsletter messages...<br>\n";}

	// print_r($subscriber_array);

	# Check for unsent mail in the cache
	$update_list = "";
	$query = "SELECT * FROM ".$infrespmailcache." WHERE Status = 'queued'";
	$DB_Mail_Cache_Result = mysql_query($query) or die("Invalid query: " . mysql_error());
	while ($this_entry = mysql_fetch_assoc($DB_Mail_Cache_Result)) {
		
		# MOD Fix for Mail ID 
		$mail_id = $this_entry['Mail_ID'];
	
		# Should we send?
		if ( ($Send_Count <= $max_send_count) && ($config['daily_count'] <= $config['daily_limit']) ) {
		
			if ($silent != TRUE) {
				if ($mail_msg_array[$mail_id]['Closed'] == '0') {
					echo "Mail ID: ".$this_entry['Mail_ID']." - SubID: ".$this_entry['SubscriberID']." - CacheID: ".$this_entry['Cache_ID']." - Status: ".$this_entry['Status']." - LastActivity: ".$this_entry['LastActivity'];
					echo " - Scheduled: ".$mail_msg_array[$mail_id]['Time_To_Send']." - Created: ".$mail_msg_array[$mail_id]['Time_Sent']."<br>";
					echo "<br>";
				}
			}
		
			if ( ($mail_msg_array[$mail_id]['Closed'] == "0") && ($mail_msg_array[$mail_id]['Time_To_Send'] <= time()) ) {
						
				# Fetch the cache entry details
				$sub_id     = $this_entry['SubscriberID'];
				$cache_id   = $this_entry['Cache_ID'];

				# Get the other relevant data
				$this_mail_msg   = $mail_msg_array[$mail_id];
				$this_subscriber = $subscriber_array[$sub_id];
				$responder_id    = $this_mail_msg['ResponderID'];
				$this_responder  = $responder_array[$responder_id];
				
				if ($silent != TRUE) {
					echo "Schedule reached: Sending to Sub ID.".$sub_id."...";
					print_r($this_subscriber);
					echo "<br>";
				}

				# Set the tag variables and send? 
				# MOD replaced !isEmpty with isset
				if (isset($this_subscriber)) {
				
					# Set the tag variables
					$SubscriberInfo['TimeJoined'] = $DB_TimeJoined = $this_subscriber['TimeJoined'];
					$SubscriberInfo['Real_TimeJoined'] = $DB_Real_TimeJoined = $this_subscriber['Real_TimeJoined'];
					$SubscriberInfo['EmailAddress'] = $DB_EmailAddress = $this_subscriber['EmailAddress'];
					$SubscriberInfo['LastActivity'] = $DB_LastActivity = $this_subscriber['LastActivity'];
					$SubscriberInfo['FirstName'] = $DB_FirstName = $this_subscriber['FirstName'];
					$SubscriberInfo['LastName'] = $DB_LastName = $this_subscriber['LastName'];
					$SubscriberInfo['CanReceiveHTML'] = $CanReceiveHTML = $this_subscriber['CanReceiveHTML'];
					$SubscriberInfo['SubscriberID'] = $DB_SubscriberID = $this_subscriber['SubscriberID'];
					$SubscriberInfo['SentMsgs'] = $DB_SentMsgs = $this_subscriber['SentMsgs'];
					$SubscriberInfo['UniqueCode'] = $DB_UniqueCode = $this_subscriber['UniqueCode'];
					# MOD - Bugfix for these two tags!
					$SubscriberInfo['ReferralSource'] = $DB_ReferralSource = $this_subscriber['ReferralSource'];
					$SubscriberInfo['IP_Addy'] = $DB_IPaddy = $this_subscriber['IP_Addy'];

					$DB_ResponderName = $this_responder['Name'];
					$DB_OwnerEmail = $this_responder['OwnerEmail'];
					$DB_OwnerName = $this_responder['OwnerName'];
					$DB_ReplyToEmail = $this_responder['ReplyToEmail'];
					$DB_ResponderDesc = $this_responder['ResponderDesc'];

					$MessageInfo['BodyHTML'] = $DB_MsgBodyHTML = $this_mail_msg['HTML_msg'];
					$MessageInfo['BodyText'] = $DB_MsgBodyText = $this_mail_msg['TEXT_msg'];
					$MessageInfo['Subject'] = $DB_MsgSub = $this_mail_msg['Subject'];
					$Responder_ID = $this_responder_id;
					$Send_Subject = "$DB_MsgSub";
					$subcode = "s" . $DB_UniqueCode;
					$unsubcode = "u" . $DB_UniqueCode;

					// MOD Unsub URL
					// $UnsubURL = $siteURL.$ResponderDirectory."/s.php?c=$unsubcode";
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
					// print_r($message);
					$DB_MsgBodyText = $message['BodyText'];
					$DB_MsgBodyHTML = stripslashes($message['BodyHTML']);
					$Send_Subject = $message['Subject'];

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
								if ($silent != TRUE) {echo "Message ".$msg_idx.": downloading external image:<br>".$imgsrc[$vi]."<br>";}
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

					# Generate the headers
					$Message_Body     = "";
					$Message_Headers  = "Return-Path: <" . $DB_ReplyToEmail . ">$newline";
					# $Message_Headers .= "Return-Receipt-To: <" . $DB_ReplyToEmail . ">$newline";
					$Message_Headers .= "Envelope-to: $DB_EmailAddress$newline";
					$Message_Headers .= "From: $DB_OwnerName <" . $DB_ReplyToEmail . ">$newline";
					# $Message_Headers .= "Date: " . date('D\, j F Y H:i:s O') . "$newline";
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

					# Final filtering
					$Send_Subject    = stripnl(str_replace("|","",$Send_Subject));
					$Message_Body    = str_replace("|","",$Message_Body);
					$Message_Headers = str_replace("|","",$Message_Headers);
					$Message_Body    = utf8_decode($Message_Body);

					# Send the mail
					if ($silent != TRUE) {
						echo "Addy: $DB_EmailAddress <br>\n";
						echo "Subj: $Send_Subject <br>\n";
						echo "Head: $Message_Headers <br>\n";				
					}

					# MOD for sending message via wp_mail /phpmailer
					if (get_option('inf_resp_mailer') == 'wp_mail') {
						if ($silent != TRUE) {
							echo "Text Body: <textarea>$DB_MsgBodyText </textarea><br>\n";
							echo "HTML Body: <textarea>$DB_MsgBodyHTML</textarea><br>\n";				
							echo "---------------------------<br>\n";
						}

						// Set Sender Name and Email
						add_option('inf_resp_owner_email',$DB_OwnerEmail); update_option('inf_resp_owner_email',$DB_OwnerEmail);
						add_option('inf_resp_owner_name',$DB_OwnerName); update_option('inf_resp_owner_name',$DB_OwnerName);
						add_filter('wp_mail_from', 'inf_resp_from_email',100);
						add_filter('wp_mail_from_name', 'inf_resp_from_name',100);			

						if ($CanReceiveHTML == 1) {
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
						if ($silent != TRUE) {
							echo "Mail Body:<br>".$Message_Body."<br>\n";
							echo "---------------------------<br>\n";
						}
						$result = mail($DB_EmailAddress, $Send_Subject, $Message_Body, $Message_Headers, "-f $DB_ReplyToEmail");	
					}

					# Verbose
					if ($silent != TRUE) {echo "Newsletter message to sub #" . $sub_id . "<br>\n";}

					# Update the last activity field
					$Set_LastActivity = time();
					$this_subscriber['LastActivity'] = $Set_LastActivity;
					$subscriber_array[$sub_id]['LastActivity'] = $Set_LastActivity;
					$query = "UPDATE ".$infrespsubscribers." SET LastActivity = '$Set_LastActivity' WHERE SubscriberID = '$DB_SubscriberID'";
					$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());

					# Update the cache database
					$query = "UPDATE ".$infrespmailcache." SET Status = 'sent', LastActivity = '$Set_LastActivity' WHERE Cache_ID = '$cache_id'";
					$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());
					
					# Increment the send counts
					$Send_Count++;
					$config['daily_count']++;
				}
			}
		}
	}
}
else {
	# Verbose
	if ($silent != TRUE) {echo "No newsletter messages sent - throttle limit reached.<br>\n";}
}

# - - - - - - - - - - - - - - - - - - -
# Update the daily count in the DB
# - - - - - - - - - - - - - - - - - - -
$query = "UPDATE ".$infrespconfig." SET daily_count = '" . $config['daily_count'] . "'";
$result = mysql_query($query) or die("Invalid query: " . mysql_error());

# Verbose
if ($Send_Count > 0) {if ($silent != TRUE) {echo "<br>Updating counts...<br>\n";} }
else {if ($silent != TRUE) { echo "<br>No messages sent.<br>\n";} }

# - - - - - - - - - - - - - - - - - - -
# Handle last activity trim
# - - - - - - - - - - - - - - - - - - -

if (($last_activity_trim > 0) && ($this_subscriber['LastActivity'] != "") AND ($this_subscriber['LastActivity'] != NULL) AND ($this_subscriber['LastActivity'] != 0)) {
	# Set some vars
	$trim_str = "+" . $last_activity_trim . " months";

	# Loop thru the subscribers
	foreach ($subscriber_array as $subscriber_id => $this_subscriber) {
		$trim_time = strtotime($trim_str,$this_subscriber['LastActivity']);
		if (time() > $trim_time) {
			$query = "DELETE FROM ".$infrespsubscribers." WHERE SubscriberID = '" . $this_subscriber['SubscriberID'] . "'";
			$DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());
	
			$query = "DELETE FROM ".$infrespcustomfields." WHERE user_attached = '" . $this_subscriber['SubscriberID'] . "'";
			$result = mysql_query($query) or die("Invalid query: " . mysql_error());
		}
	}
}

if ($sendmails_included != TRUE) {DB_disconnect();}

# Verbose
if ($silent != TRUE) {echo "Done!<br>\n";}

# Reset var
$silent = FALSE;

?>