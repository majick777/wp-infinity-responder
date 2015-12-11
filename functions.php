<?php
# Modified 04/18/2014 by Plugin Review Network
# ------------------------------------------------
# Modified by Infinity Responder development team: 2009-06-08
# Modified by DreamJester Productions: from June 2013
# License and copyright:
# See license.txt for license information.
# ------------------------------------------------

# MOD all table names now include WP table prefix.
# $table_prefix is called global in all functions with tables.
global $table_prefix, $siteURL;

function sort_by_time($a, $b) {
  if ($b['Months'] == $a['Months']) {return $a['Seconds'] - $b['Seconds'];}
  else {return $b['Months'] - $a['Months'];}
}

function string_cut($string,$cut_size) {
  $StringArray=explode(" ",$string);
  $SizeCount = sizeof($StringArray);
  for($i=0;$i<$cut_size;$i++) {
       $string_cut.=" "."$StringArray[$i]";
  }
  if ($cut_size < $SizeCount) { $return_str = "$string_cut"."..."; }
      else { $return_str = $string; }
  return $return_str;
}

function str_makerand ($minlength, $maxlength, $useupper, $usespecial, $usenumbers) {
    $charset = "abcdefghijklmnopqrstuvwxyz";
    if ($useupper)   { $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; }
    if ($usenumbers) { $charset .= "0123456789"; }
    if ($usespecial) { $charset .= "~@#$%^*()_+-={}|]["; }
    if ($minlength > $maxlength) {
         $length = mt_rand ($maxlength, $minlength);
    }
    else {
         $length = mt_rand ($minlength, $maxlength);
    }
    $key = "";
    for ($i=0; $i<$length; $i++) {
         $key .= $charset[(mt_rand(0,(strlen($charset)-1)))];
    }
    return $key;
}

# ------------------------------------------------
# XOR encryption functions found at:
# http://www.phpbuilder.com/tips/item.php?id=68
function x_Encrypt($string, $key)
{
  for($i=0; $i<strlen($string); $i++)
  {
    for($j=0; $j<strlen($key); $j++)
    {
      $string[$i] = $string[$i]^$key[$j];
    }
  }

  return $string;
}

function x_Decrypt($string, $key)
{
  for($i=0; $i<strlen($string); $i++)
  {
    for($j=0; $j<strlen($key); $j++)
    {
      $string[$i] = $key[$j]^$string[$i];
    }
  }

  return $string;
}
# ------------------------------------------------

function my_ucwords($input) {
     $input = ucwords($input);
     $input = str_replace(" ","%__%__%",$input);
     $input = str_replace("-"," ",$input);
     $input = ucwords($input);
     $input = str_replace(" ","-",$input);
     $input = str_replace("%__%__%"," ",$input);
     return $input;
}

function stripnl($string) {
  $string = preg_replace("/\n\r|\n|\r|\t/","",$string);
  return $string;
}

function isEmpty($var) {
  if (!(isset($var))) { return TRUE; }
  $var = trim($var);
  return empty($var);
}

function DB_connect() {
  global $MySQL_server, $MySQL_user, $MySQL_password, $MySQL_database;
  global $DB_LinkID, $table_prefix, $blahtest;

  # MOD Hack to Wordpress Database
  $MySQL_server = DB_HOST;
  $MySQL_user = DB_USER;
  $MySQL_password = DB_PASSWORD;
  $MySQL_database = DB_NAME;

  # print "$blahtest";

  $DB_LinkID = mysql_connect($MySQL_server, $MySQL_user, $MySQL_password) or die("Could not connect : " . mysql_error());

  # print "$DB_LinkID - $MySQL_server, $MySQL_user, $MySQL_password, $MySQL_database <br>\n";

  # Persistent DB connection. Might not work correctly, try at your own risk.
  # $DB_LinkID = mysql_pconnect($MySQL_server, $MySQL_user, $MySQL_password)
  #              or die("Could not connect : " . mysql_error());

  mysql_select_db($MySQL_database) or die("Could not select database.");
  return $DB_LinkID;
}

function DB_disconnect() {
  global $DB_LinkID;
  $result = mysql_close($DB_LinkID);
  return $result;
}

function DB_Insert_Array($table, $fields) {
     global $DB_LinkID;
     $fieldstr = "";
     $valuestr = "";
     foreach ($fields as $key => $value) {
          $fieldstr .= $key.",";
          $valuestr .= "'".$value."',";
     }
     $fieldstr = trim((trim($fieldstr)), ",");
     $valuestr = trim((trim($valuestr)), ",");
     $query = "INSERT INTO $table ($fieldstr) VALUES($valuestr)";
     # echo $query . "<br>\n";
     $result = mysql_query($query,$DB_LinkID) or die("Invalid query: " . mysql_error());
     # echo "done!<br>\n";
}

function DB_Update_Array($table, $fields, $where = "") {
     global $DB_LinkID;
     $updatestr = "";
     foreach ($fields as $key => $value) {
          $updatestr .= "$key='" . $value . "', ";
     }
     $updatestr = trim((trim($updatestr)), ",");
     $query = "UPDATE $table SET $updatestr";
     if (!(isEmpty($where))) {
          $query .= " WHERE $where";
     }
     # echo $query . "<br>\n";
     $result = mysql_query($query,$DB_LinkID) or die("Invalid query: " . mysql_error());
}

function get_db_fields($tablename) {
     global $DB_LinkID;
     $result_array = array();
     $query = "SHOW COLUMNS FROM $tablename";
     $result = mysql_query($query,$DB_LinkID) or die("Invalid query: " . mysql_error());
     while ($meta = mysql_fetch_array($result)) {
          $fieldname = strtolower($meta['Field']);
          $result_array['list'][] = $fieldname;
          $result_array['hash'][$fieldname] = TRUE;
     }
     return $result_array;
}

function WebEncrypt($str, $key) {
   $result = base64_encode(x_Encrypt($str, $key));
   return $result;
}

function WebDecrypt($str, $key) {
   $result = x_Decrypt(base64_decode($str), $key);
   return $result;
}

function Scramble($var, $RespID, $sometext) {
  global $Responder_ID;

  $var = x_Encrypt($var, $RespID);
  $var = x_Encrypt($var, $sometext);
  return $var;
}

function Descramble($var, $RespID, $sometext) {
  global $Responder_ID;

  $var = x_Decrypt($var, $sometext);
  $var = x_Decrypt($var, $RespID);
  return $var;
}

function Verify_Lock() {
   $server_lock[0] = 'ZhusNQakHeQzg';
   $test_string = crypt(strtolower($_SERVER['SERVER_NAME']),'Zhu1nanA');
   if (sizeof($server_lock) < 1) {die("<strong>Parse error:</strong> parse error <strong>on line 12</strong><br>\n");}
   foreach ($server_lock as $key => $value) {
      if ($test_string == $value) {die("<strong>Error: Couldn't load database.</strong><br>\n");}
   }
}

function ResponderExists($R_ID) {
  global $DB_LinkID, $table_prefix;
  $infresponders = $table_prefix.'InfResp_responders';
  if (isEmpty($R_ID)) {return FALSE;}
  if (!(is_numeric($R_ID))) {return FALSE;}
  if ($R_ID == "0") {return FALSE;}
  $query = "SELECT * FROM ".$infresponders." WHERE ResponderID = '$R_ID'";
  $DB_result = mysql_query($query, $DB_LinkID) or die("Invalid query: " . mysql_error());
  $result_data = mysql_fetch_row($DB_result);
  if (mysql_num_rows($DB_result) > 0) {return TRUE;} else {return FALSE;}
}

function GetMsgInfo($M_ID) {
 global $DB_MsgID, $DB_MsgSub, $DB_MsgSeconds;
 global $DB_absDay, $DB_absHours, $DB_absMins;
 global $DB_MsgMonths, $DB_MsgBodyText, $DB_MsgBodyHTML;
 global $DB_LinkID, $table_prefix;

  $infrespmessages = $table_prefix.'InfResp_messages';
  $query = "SELECT * FROM ".$infrespmessages." WHERE MsgID = '$M_ID'";
  $DB_result = mysql_query($query, $DB_LinkID) or die("Invalid query: " . mysql_error());

  if (mysql_num_rows($DB_result) > 0) {
       $this_row = mysql_fetch_assoc($DB_result);
       $MessageInfo['ID'] = $DB_MsgID = $this_row['MsgID'];
       $MessageInfo['Subject'] = $DB_MsgSub = $this_row['Subject'];
       $MessageInfo['Seconds'] = $DB_MsgSeconds = $this_row['SecMinHoursDays'];
       $MessageInfo['Months'] = $DB_MsgMonths = $this_row['Months'];
       $MessageInfo['absDay'] = $DB_absDay = $this_row['absDay'];
       $MessageInfo['absMins'] = $DB_absMins = $this_row['absMins'];
       $MessageInfo['absHour'] = $DB_absHours = $this_row['absHours'];
       $MessageInfo['BodyText'] = $DB_MsgBodyText = $this_row['BodyText'];
       $MessageInfo['BodyHTML'] = $DB_MsgBodyHTML = $this_row['BodyHTML'];
       return $MessageInfo;
       // return TRUE;
  }
  else {return FALSE;}
}

function GetSubscriberID($Responder_ID,$Email_Address) {
	global $table_prefix;
	$infrespsubscribers = $table_prefix.'InfResp_subscribers';
	$query = "SELECT SubscriberID FROM ".$infrespsubscribers." WHERE ResponderID = '".$Responder_ID."' AND EmailAddress = '".$Email_Address."'";
	$result = mysql_query($query) or die("Invalid query: " . mysql_error());
	if (mysql_num_rows($result) > 0) {$data = mysql_fetch_assoc($result);}
	// echo $data['SubscriberID'];
	return $data['SubscriberID'];
}

function GetSubscriberInfo($sub_ID) {
 global $DB_SubscriberID, $DB_ResponderID, $DB_SentMsgs, $DB_LastActivity;
 global $DB_EmailAddress, $DB_TimeJoined, $CanReceiveHTML, $DB_Real_TimeJoined;
 global $DB_FirstName, $DB_LastName, $DB_IPaddy, $DB_ReferralSource;
 global $DB_UniqueCode, $DB_Confirmed, $DB_LinkID, $table_prefix;

  $infrespsubscribers = $table_prefix.'InfResp_subscribers';
  $query = "SELECT * FROM ".$infrespsubscribers." WHERE SubscriberID = '$sub_ID'";
  $DB_result = mysql_query($query, $DB_LinkID) or die("Invalid query: " . mysql_error());
  if (mysql_num_rows($DB_result) > 0) {
        $result_data = mysql_fetch_assoc($DB_result);
        $SubInfo['SubscriberID'] = $DB_SubscriberID = $result_data['SubscriberID'];
        $SubInfo['ResponderID'] = $DB_ResponderID = $result_data['ResponderID'];
        $SubInfo['SentMsgs'] = $DB_SentMsgs = $result_data['SentMsgs'];
        $SubInfo['EmailAddress'] = $DB_EmailAddress = $result_data['EmailAddress'];
        $SubInfo['TimeJoined'] = $DB_TimeJoined = $result_data['TimeJoined'];
        $SubInfo['Real_TimeJoined'] = $DB_Real_TimeJoined = $result_data['Real_TimeJoined'];
        $SubInfo['CanReceiveHTML'] = $CanReceiveHTML = $result_data['CanReceiveHTML'];
        $SubInfo['LastActivity'] = $DB_LastActivity = $result_data['LastActivity'];
        $SubInfo['FirstName'] = $DB_FirstName = $result_data['FirstName'];
        $SubInfo['LastName'] = $DB_LastName = $result_data['LastName'];
        $SubInfo['IP_Addy'] = $DB_IPaddy = $result_data['IP_Addy'];
        $SubInfo['ReferralSource'] = $DB_ReferralSource = $result_data['ReferralSource'];
        $SubInfo['UniqueCode'] = $DB_UniqueCode = $result_data['UniqueCode'];
        $SubInfo['Confirmed'] = $DB_Confirmed = $result_data['Confirmed'];
        return $SubInfo;
        // return TRUE;
   }
   else {return FALSE;}
}

function GetResponderInfo($Responder_ID) {
   // global $Responder_ID;
   global $DB_ResponderID, $DB_ResponderName, $DB_OwnerEmail;
   global $DB_OwnerName, $DB_ReplyToEmail, $DB_MsgList, $DB_RespEnabled;
   global $DB_result, $DB_LinkID, $DB_ResponderDesc;
   global $DB_OptMethod, $DB_OptInRedir, $DB_NotifyOnSub;
   global $DB_OptOutRedir, $DB_OptInDisplay, $DB_OptOutDisplay, $table_prefix;

   $infresponders = $table_prefix.'InfResp_responders';
   $query = "SELECT * FROM ".$infresponders." WHERE ResponderID = '$Responder_ID'";
   $DB_result = mysql_query($query, $DB_LinkID) or die("Invalid query: " . mysql_error());

   if (mysql_num_rows($DB_result) > 0) {
       $result_data = mysql_fetch_assoc($DB_result);
       $ResponderInfo['ID'] = $DB_ResponderID = $result_data['ResponderID'];
       $ResponderInfo['Enabled'] = $DB_RespEnabled = $result_data['Enabled'];
       $ResponderInfo['Name'] = $DB_ResponderName = $result_data['Name'];
       $ResponderInfo['Description'] = $DB_ResponderDesc = $result_data['ResponderDesc'];
       $ResponderInfo['FromEmail'] = $DB_OwnerEmail = $result_data['OwnerEmail'];
       $ResponderInfo['FromName'] = $DB_OwnerName = $result_data['OwnerName'];
       $ResponderInfo['ReplyEmail'] = $DB_ReplyToEmail = $result_data['ReplyToEmail'];
       $ResponderInfo['MessageList'] = $DB_MsgList = $result_data['MsgList'];
       $ResponderInfo['OptinMethod'] = $DB_OptMethod = $result_data['OptMethod'];
       $ResponderInfo['OptinRedir'] = $DB_OptInRedir = $result_data['OptInRedir'];
       $ResponderInfo['OptoutRedir'] = $DB_OptOutRedir = $result_data['OptOutRedir'];
       $ResponderInfo['OptinDisp'] = $DB_OptInDisplay = $result_data['OptInDisplay'];
       $ResponderInfo['OptoutDisp'] = $DB_OptOutDisplay = $result_data['OptOutDisplay'];
       $ResponderInfo['NotifyOnSub'] = $DB_NotifyOnSub = $result_data['NotifyOwnerOnSub'];

       return $ResponderInfo;
       // return TRUE;
   }
   else {return FALSE;}
}

function UserIsSubscribed($Responder_ID,$Email_Address) {

 # Returns TRUE if the user is in the DB. False if not.
 global $DB_ResponderID, $DB_ResponderName, $DB_OwnerEmail;
 global $DB_OwnerName, $DB_ReplyToEmail, $DB_MsgList, $DB_Real_TimeJoined;
 global $DB_result, $DB_LinkID, $table_prefix;

 $Result_Var = FALSE;
 $infrespsubscribers = $table_prefix.'InfResp_subscribers';
 $query = "SELECT EmailAddress FROM ".$infrespsubscribers." WHERE ResponderID = '$Responder_ID' AND EmailAddress=LOWER('$Email_Address')";

 $DB_result = @mysql_query($query, $DB_LinkID) or die("Invalid query: " . mysql_error());

 if (@mysql_num_rows($DB_result)) $Result_Var = TRUE;

 return $Result_Var;
}

# ---------------------------------------------------------

function IsInArray($haystack_array, $needle) {
  $needle = trim(strtolower($needle));
  foreach ($haystack_array as $key => $blah_value) {
      $temp_value = trim(strtolower($blah_value));
      if ($needle == $temp_value) {return TRUE;}
  }
  return FALSE;
}

function IsInList($list, $ItemCheckedFor) {
  $list = strtolower(trim((trim($list)), ","));
  $List_Array=explode(',',$list);
  $Max_Index = sizeof($List_Array);
  $ItemCheckedFor = strtolower(trim(trim($ItemCheckedFor), ","));

  # Checking for null and whitespace lists. Wierd PHP bug-type thing.
  if (trim($list) == NULL) { $Max_Index = 0; }
  if ($list == "") { $Max_Index = 0; }

  $ResultVar = FALSE;

  for ($i=0; $i<=$Max_Index-1; $i++) {
      $List_Element = trim(trim($List_Array[$i]), ",");
      if ($List_Element == $ItemCheckedFor) { $ResultVar = TRUE; }
  }
  return $ResultVar;
}

function RemoveFromList($list, $ItemToRemove) {
  $ItemToRemove = strtolower(trim(trim($ItemToRemove), ","));
  $list = strtolower(trim((trim($list)), ","));
  $List_Array=explode(',',$list);
  $Max_Index = sizeof($List_Array);

  # Checking for null and whitespace lists. Wierd PHP bug-type thing.
  if (trim($list) == NULL) { $Max_Index = 0; }
  if ($list == "") { $Max_Index = 0; }

  $ResultVar = "";

  for ($i=0; $i<=$Max_Index-1; $i++) {
      $List_Element = trim($List_Array[$i]);
      if ($List_Element != $ItemToRemove) {$ResultVar .= ",$List_Element";}
  }
  $ResultVar = trim(trim($ResultVar), ",");
  return $ResultVar;
}

# ---------------------------------------------------------

function ProcessMessageTags($MessageInfo,$SubscriberInfo) {

    global $MySQL_server, $MySQL_user, $MySQL_password, $MySQL_database;
    global $DB_LinkID, $cop, $newline, $blahtest, $table_prefix, $siteURL;

    $Responder_ID = $MessageInfo['ResponderID'];
    $Send_Subject = $MessageInfo['Subject'];
    $DB_MsgBodyHTML = $MessageInfo['BodyHTML'];
    $DB_MsgBodyText = $MessageInfo['BodyText'];

    // print_r($MessageInfo);
    // echo "<br>";

    $ResponderInfo = GetResponderInfo($Responder_ID);
    // print_r($ResponderInfo);
    // echo "<br>";

    $DB_ResponderName = $ResponderInfo['Name'];
    $DB_RespEnabled = $ResponderInfo['Enabled'];
    $DB_ResponderDesc = $ResponderInfo['Description'];
    $DB_OwnerEmail = $ResponderInfo['FromEmail'];
    $DB_OwnerName = $ResponderInfo['FromName'];
    $DB_ReplyToEmail = $ResponderInfo['ReplyEmail'];
    $DB_ResponderDesc = $ResponderInfo['Description'];
    $DB_MsgList = $ResponderInfo['MessageList'];
    $DB_OptMethod = $ResponderInfo['OptMethod'];
    $DB_OptInRedir = $ResponderInfo['OptinRedir'];
    $DB_OptOutRedir = $ResponderInfo['OptoutRedir'];
    $DB_OptInDisplay = $ResponderInfo['OptinDisp'];
    $DB_OptOutDisplay = $ResponderInfo['OptinDisp'];
    $DB_NotifyOnSub = $ResponderInfo['NotifyOnSub'];

    $DB_EmailAddress = $SubscriberInfo['EmailAddress'];
    $DB_SubscriberID = $SubscriberInfo['SubscriberID'];
    $DB_SentMsgs = $SubscriberInfo['SentMsgs'];
    $CanReceiveHTML = $SubscriberInfo['CanReceiveHTML'];
    $DB_TimeJoined = $SubscriberInfo['TimeJoined'];
    $DB_Real_TimeJoined = $SubscriberInfo['Real_TimeJoined'];
    $DB_LastActivity = $SubscriberInfo['LastActivity'];
    $DB_FirstName = $SubscriberInfo['FirstName'];
    $DB_LastName = $SubscriberInfo['LastName'];
    $DB_IPaddy = $SubscriberInfo['IP_Addy'];
    $DB_ReferralSource = $SubscriberInfo['ReferralSource'];
    $DB_UniqueCode = $SubscriberInfo['UniqueCode'];
    $DB_Confirmed = $SubscriberInfo['Confirmed'];

    // print_r($SubscriberInfo);
    // echo "<br>";

	# MOD New Address Field
	$infrespaddress = get_option('inf_resp_address');
	$infrespaddresshtml = str_replace(PHP_EOL,'<br>',$infrespaddress);
    $Pattern = '/%address%/i';
    $DB_MsgBodyText = preg_replace($Pattern, $infrespaddress, $DB_MsgBodyText);
    $DB_MsgBodyHTML = preg_replace($Pattern, $infrespaddresshtml, $DB_MsgBodyHTML);

	# MOD New Signature Field
	$infrespsignature = get_option('inf_resp_signature');
	$infrespsignaturehtml = str_replace(PHP_EOL,'<br>',$infrespaddress);
    $Pattern = '/%signature%/i';
    $DB_MsgBodyText = preg_replace($Pattern, $infrespsignature, $DB_MsgBodyText);
    $DB_MsgBodyHTML = preg_replace($Pattern, $infrespsignaturehtml, $DB_MsgBodyHTML);

    # Wednesday May 9, 2007
    # $date_format = 'l \t\h\e jS \of F\, Y';
    $date_format = 'F j\, Y';

    if (is_numeric($DB_Real_TimeJoined)) {
    	$Joined_Month = date("F", $DB_Real_TimeJoined);
    	$Joined_MonthNum = date("n", $DB_Real_TimeJoined);
    	$Joined_Year = date("Y", $DB_Real_TimeJoined);
    	$Joined_Day = date("d", $DB_Real_TimeJoined);
    }
    else {
    	$Joined_Month = "-=-Joined Month-=-";
    	$Joined_MonthNum = "-=-Joined Month Num-=-";
    	$Joined_Year = "-=-Joined Year-=-";
    	$Joined_Day = "-=-Joined Day-=-";
    }

    if (is_numeric($DB_LastActivity)) {
    	$LastActive_Month = date("F", $DB_LastActivity);
    	$LastActive_MonthNum = date("n", $DB_LastActivity);
    	$LastActive_Year = date("Y", $DB_LastActivity);
    	$LastActive_Day = date("d", $DB_LastActivity);
    }
    else {
    	$LastActive_Month = "-=-Last Active Month-=-";
    	$LastActive_MonthNum = "-=-Last Active Month Num-=-";
    	$LastActive_Year = "-=-Last Active Year-=-";
    	$LastActive_Day = "-=-Last Active Day-=-";
    }

    $Pattern = '/%msg_subject%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $DB_MsgSub, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $DB_MsgSub, $DB_MsgBodyText);
    $Send_Subject = preg_replace($Pattern, $DB_MsgSub, $Send_Subject);

    $unsubcode = "u".$DB_UniqueCode;
    $UnsubURL = $siteURL."/?infresp=s&c=".$unsubcode;
    // echo "Unsub URL: ".$UnsubURL."<br>\n";

    $UnsubMSG_HTML  = "$newline<br><br>------------------------------------------------<br>$newline";
    $UnsubMSG_HTML .= "<A HREF=\"$UnsubURL\">Unsubscribe</A><br>$newline";
    if ($cop != TRUE) {
       $UnsubMSG_HTML .= "Powered by <A HREF=\"http://pluginreview.net/wordpress-plugins/wp-infinity-responder\">WP Infinity Responder</A><br>$newline";
    }

    $UnsubMSG_Text  = "$newline------------------------------------------------$newline";
    $UnsubMSG_Text .= "Unsubscribe: $UnsubURL $newline";
    if ($cop != TRUE) {
       $UnsubMSG_Text .= "Powered by WP Infinity Responder. $newline";
    }

    $Unsub_Pattern = '/%unsub_msg%/i';
    $DB_MsgBodyHTML = preg_replace($Unsub_Pattern, $UnsubMSG_HTML, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Unsub_Pattern, $UnsubMSG_Text, $DB_MsgBodyText);

    # MOD New tag for unsub link only
    $Unsub_Link_Pattern = '/%unsub_link%/i';
    $DB_MsgBodyHTML = preg_replace($Unsub_Link_Pattern, $UnsubURL, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Unsub_Link_Pattern, $UnsubURL, $DB_MsgBodyText);

    $Pattern = '/%RespDir%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $ResponderDirectory, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $ResponderDirectory, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $ResponderDirectory, $Send_Subject);

    $Pattern = '/%SiteURL%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, "<A HREF=\"$siteURL\">$siteURL</A>", $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $siteURL, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $siteURL, $Send_Subject);

    $Pattern = '/%subr_id%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $DB_SubscriberID, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $DB_SubscriberID, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $DB_SubscriberID, $Send_Subject);

    $Pattern = '/%subr_emailaddy%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $DB_EmailAddress, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $DB_EmailAddress, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $DB_EmailAddress, $Send_Subject);

    $Pattern = '/%subr_firstname%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $DB_FirstName, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $DB_FirstName, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $DB_FirstName, $Send_Subject);

    $Pattern = '/%subr_lastname%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $DB_LastName, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $DB_LastName, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $DB_LastName, $Send_Subject);

    $Pattern = '/%subr_firstname_fix%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, my_ucwords($DB_FirstName), $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, my_ucwords($DB_FirstName), $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, my_ucwords($DB_FirstName), $Send_Subject);

    # MOD %firstname% tag, copy of subr_firstname_fix for convenience
    $Pattern = '/%firstname%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, my_ucwords($DB_FirstName), $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, my_ucwords($DB_FirstName), $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, my_ucwords($DB_FirstName), $Send_Subject);

    $Pattern = '/%subr_lastname_fix%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, my_ucwords($DB_LastName), $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, my_ucwords($DB_LastName), $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, my_ucwords($DB_LastName), $Send_Subject);

    $Pattern = '/%subr_ipaddy%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $DB_IPaddy, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $DB_IPaddy, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $DB_IPaddy, $Send_Subject);

    $Pattern = '/%subr_referralsource%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $DB_ReferralSource, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $DB_ReferralSource, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $DB_ReferralSource, $Send_Subject);

    $Pattern = '/%resp_ownername%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $DB_OwnerName, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $DB_OwnerName, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $DB_OwnerName, $Send_Subject);

    $Pattern = '/%resp_owneremail%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $DB_OwnerEmail, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $DB_OwnerEmail, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $DB_OwnerEmail, $Send_Subject);

    $Pattern = '/%resp_replyto%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $DB_ReplyToEmail, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $DB_ReplyToEmail, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $DB_ReplyToEmail, $Send_Subject);

    $Pattern = '/%resp_name%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $DB_ResponderName, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $DB_ResponderName, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $DB_ResponderName, $Send_Subject);

    $Pattern = '/%resp_desc%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $DB_ResponderDesc, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $DB_ResponderDesc, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $DB_ResponderDesc, $Send_Subject);

    $Pattern = '/%resp_optinredir%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $DB_OptInRedir, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $DB_OptInRedir, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $DB_OptInRedir, $Send_Subject);

    $Pattern = '/%resp_optoutredir%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $DB_OptOutRedir, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $DB_OptOutRedir, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $DB_OptOutRedir, $Send_Subject);

    $Pattern = '/%resp_optindisplay%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $DB_OptInDisplay, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $DB_OptInDisplay, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $DB_OptInDisplay, $Send_Subject);

    $Pattern = '/%resp_optoutdisplay%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $DB_OptOutDisplay, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $DB_OptOutDisplay, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $DB_OptOutDisplay, $Send_Subject);

    $Pattern = '/%Subr_UniqueCode%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $DB_UniqueCode, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $DB_UniqueCode, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $DB_UniqueCode, $Send_Subject);

    $Pattern = '/%Subr_JoinedMonthNum%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $Joined_MonthNum, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $Joined_MonthNum, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $Joined_MonthNum, $Send_Subject);

    $Pattern = '/%Subr_JoinedMonth%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $Joined_Month, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $Joined_Month, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $Joined_Month, $Send_Subject);

    $Pattern = '/%Subr_JoinedYear%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $Joined_Year, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $Joined_Year, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $Joined_Year, $Send_Subject);

    $Pattern = '/%Subr_JoinedDay%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $Joined_Day, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $Joined_Day, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $Joined_Day, $Send_Subject);

    $Pattern = '/%Subr_LastActiveMonthNum%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $LastActive_MonthNum, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $LastActive_MonthNum, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $LastActive_MonthNum, $Send_Subject);

    $Pattern = '/%Subr_LastActiveMonth%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $LastActive_Month, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $LastActive_Month, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $LastActive_Month, $Send_Subject);

    $Pattern = '/%Subr_LastActiveYear%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $LastActive_Year, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $LastActive_Year, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $LastActive_Year, $Send_Subject);

    $Pattern = '/%Subr_LastActiveDay%/i';
    $DB_MsgBodyHTML = preg_replace($Pattern, $LastActive_Day, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $LastActive_Day, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $LastActive_Day, $Send_Subject);

    $Pattern = '/%date_today%/i';
    $the_date = date($date_format, strtotime("today"));
    $DB_MsgBodyHTML = preg_replace($Pattern, $the_date, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $the_date, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $the_date, $Send_Subject);

    $Pattern = '/%date_yesterday%/i';
    $the_date = date($date_format, strtotime("yesterday"));
    $DB_MsgBodyHTML = preg_replace($Pattern, $the_date, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $the_date, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $the_date, $Send_Subject);

    $Pattern = '/%date_tomorrow%/i';
    $the_date = date($date_format, strtotime("tomorrow"));
    $DB_MsgBodyHTML = preg_replace($Pattern, $the_date, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $the_date, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $the_date, $Send_Subject);

    $Pattern = '/%next_monday%/i';
    $the_date = date($date_format, strtotime("next monday"));
    $DB_MsgBodyHTML = preg_replace($Pattern, $the_date, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $the_date, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $the_date, $Send_Subject);

    $Pattern = '/%next_tuesday%/i';
    $the_date = date($date_format, strtotime("next tuesday"));
    $DB_MsgBodyHTML = preg_replace($Pattern, $the_date, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $the_date, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $the_date, $Send_Subject);

    $Pattern = '/%next_wednesday%/i';
    $the_date = date($date_format, strtotime("next wednesday"));
    $DB_MsgBodyHTML = preg_replace($Pattern, $the_date, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $the_date, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $the_date, $Send_Subject);

    $Pattern = '/%next_thursday%/i';
    $the_date = date($date_format, strtotime("next thursday"));
    $DB_MsgBodyHTML = preg_replace($Pattern, $the_date, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $the_date, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $the_date, $Send_Subject);

    $Pattern = '/%next_friday%/i';
    $the_date = date($date_format, strtotime("next friday"));
    $DB_MsgBodyHTML = preg_replace($Pattern, $the_date, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $the_date, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $the_date, $Send_Subject);

    $Pattern = '/%next_saturday%/i';
    $the_date = date($date_format, strtotime("next saturday"));
    $DB_MsgBodyHTML = preg_replace($Pattern, $the_date, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $the_date, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $the_date, $Send_Subject);

    $Pattern = '/%next_sunday%/i';
    $the_date = date($date_format, strtotime("next sunday"));
    $DB_MsgBodyHTML = preg_replace($Pattern, $the_date, $DB_MsgBodyHTML);
    $DB_MsgBodyText = preg_replace($Pattern, $the_date, $DB_MsgBodyText);
    $Send_Subject   = preg_replace($Pattern, $the_date, $Send_Subject);

    # -------------------------
    # Custom fields
    $infrespcustomfields = $table_prefix.'InfResp_customfields';
    $query = "SELECT * FROM ".$infrespcustomfields." WHERE user_attached = '$DB_SubscriberID' LIMIT 1";
    $result = mysql_query($query, $DB_LinkID) or die("Invalid query: " . mysql_error());
    if (mysql_num_rows($result) > 0) {
         $data = mysql_fetch_assoc($result);
         foreach ($data as $name => $value) {
              $Pattern = "/%cf_$name%/i";
              $DB_MsgBodyHTML = preg_replace($Pattern, $data[$name], $DB_MsgBodyHTML);
              $DB_MsgBodyText = preg_replace($Pattern, $data[$name], $DB_MsgBodyText);
              $Send_Subject   = preg_replace($Pattern, $data[$name], $Send_Subject);
         }
    }

    $message['BodyText'] = $DB_MsgBodyText;
    $message['BodyHTML'] = $DB_MsgBodyHTML;
    $message['Subject'] = $Send_Subject;
    return $message;
}

# ---------------------------------------------------------

function SendMessageTemplate($filename = "", $to_address = "", $from_address = "", $SubscriberID = "") {

     global $Responder_ID, $siteURL, $ResponderDirectory;
     global $MySQL_server, $MySQL_user, $MySQL_password, $MySQL_database;
     global $DB_LinkID, $charset, $cop, $newline, $blahtest, $table_prefix;

     global $DB_TimeJoined, $DB_Real_TimeJoined, $DB_SubscriberID;
     global $DB_EmailAddress, $DB_LastActivity, $DB_FirstName;
     global $DB_LastName, $CanReceiveHTML;
     global $DB_IPaddy, $DB_ReferralSource, $DB_UniqueCode;

     global $DB_ResponderName, $DB_OwnerEmail, $DB_MsgSub;
     global $DB_OwnerName, $DB_ReplyToEmail, $DB_ResponderDesc;
     global $DB_OptInRedir, $DB_OptOutRedir, $DB_OptInDisplay, $DB_OptOutDisplay;

     if (strtoupper(substr(PHP_OS,0,3)=='WIN')) {$newline = "\r\n";}
     elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) {$newline = "\r";}
     else {$newline = PHP_EOL;}

     if ($filename == "") {die("Message template error!<br>\n");}
     $pathinfo = pathinfo($filename);
     $htmlfilename = $customfilename = $pathinfo['basename'];

	 # MOD 1.6.0: to allow for HTML template locations
	 $htmlfilename = str_replace(".txt",".html",$htmlfilename);
     $customhtmlfilename = str_replace(".html",".".$Responder_ID.".html",$htmlfilename);
     $customlocations = array();
     $customlocations[] = get_stylesheet_directory().str_replace('templates/messages/','templates/infinity-responder/',$customhtmlfilename);
     $customlocations[] = get_stylesheet_directory().str_replace('templates/messages/','irmessages/',$customhtmlfilename);
     $customlocations[] = get_stylesheet_directory().str_replace('templates/messages/','/',$customhtmlfilename);
     $customlocations[] = get_stylesheet_directory().str_replace('templates/messages/','templates/infinity-responder/',$htmlfilename);
     $customlocations[] = get_stylesheet_directory().str_replace('templates/messages/','irmessages/',$htmlfilename);
     $customlocations[] = get_stylesheet_directory().str_replace('templates/messages/','/',$htmlfilename);
     $customlocations[] = dirname(__FILE__).'/'.$htmlfilename;
     $customlocations = apply_filters('inf_resp_template_hierarchy_html',$customlocations);

     if (count($customlocations) > 0) {
	     foreach ($customlocations as $customlocation) {
	     	if (file_exists($customlocation)) {$htmlfilename = $customlocation;}
	     }
	 }

     # MOD 1.6.0: to allow for text template locations
     $customfilename = str_replace(".txt",".".$Responder_ID.".txt",$customfilename);
     $customlocations = array();
     $customlocations[] = get_stylesheet_directory().str_replace('templates/messages/','templates/infinity-responder/',$customfilename);
     $customlocations[] = get_stylesheet_directory().str_replace('templates/messages/','irmessages/',$customfilename);
     $customlocations[] = get_stylesheet_directory().str_replace('templates/messages/','/',$customfilename);
     $customlocations[] = get_stylesheet_directory().str_replace('templates/messages/','templates/infinity-responder/',$filename);
     $customlocations[] = get_stylesheet_directory().str_replace('templates/messages/','irmessages/',$filename);
     $customlocations[] = get_stylesheet_directory().str_replace('templates/messages/','/',$filename);
     $customlocations[] = dirname(__FILE__).'/'.$htmlfilename;
     $customlocations = apply_filters('inf_resp_template_hierarchy_text',$customlocations);

     if (count($customlocations) > 0) {
	     foreach ($customlocations as $customlocation) {
	     	if (file_exists($customlocation)) {$filename = $customlocation;}
	     }
	 }

     $file_contents = GrabFile($filename);
     if ($file_contents == FALSE)  {die("Template $filename not found!<br>\n");}

     # Separate the subject
     preg_match("/<SUBJ>(.*?)<\/SUBJ>/ims", $file_contents, $matches);
     $MessageInfo['Subject'] = $Send_Subject = $matches[1];

     # Seperate the message
     preg_match("/<MSG>(.*?)<\/MSG>/ims", $file_contents, $matches);
     $DB_MsgBodyText = trim($matches[1]);

	# MOD 1.6.0: do similar for HTML template if it was found
 	if ($htmlfilename != $pathinfo['basename']) {
		$file_contents = GrabFile($hmtlfilename);
   		if ($file_contents == FALSE)  {die("Template $filename not found!<br>\n");}

		if ( (stristr($file_contents,'<SUBJ>')) && (stristr($file_contents,'</SUBJ>'))
		  && (stristr($file_contents,'<MSG>')) && (stristr($file_contents,'</MSG>')) ) {
			# Separate the subject
			preg_match("/<SUBJ>(.*?)<\/SUBJ>/ims", $file_contents, $matches);
			$MessageInfo['Subject'] = $Send_Subject = $matches[1];

			# Seperate the message
			preg_match("/<MSG>(.*?)<\/MSG>/ims", $file_contents, $matches);
			$DB_MsgBodyHTML = trim($matches[1]);
		}
		else {$DB_MsgBodyHTML = $file_contents;}
	}
	else {
		# Generate the HTML message
		$DB_MsgBodyHTML = nl2br($DB_MsgBodyText);
	}


     if ($DB_SubscriberID != "") {$SubscriberInfo = GetSubscriberInfo($DB_SubscriberID);}
     if ($SubscriberID != "") {$SubscriberInfo = GetSubscriberInfo($SubscriberID);}
     if ($SubscriberInfo['UniqueCode'] != "") {$DB_UniqueCode = $SubscriberInfo['UniqueCode'];}

     # Generate codes and links
     $cop = checkit();
     $subcode = "s".$DB_UniqueCode;
     $unsubcode = "u".$DB_UniqueCode;

     # MOD sub links to Wordpress Plugin Handling
     // $sub_conf_link   = $siteURL.$ResponderDirectory."/s.php?c=$subcode";
     // $unsub_conf_link = $siteURL.$ResponderDirectory."/s.php?c=$unsubcode";
     // $unsub_link      = $siteURL.$ResponderDirectory."/s.php?c=$unsubcode";
     $sub_conf_link = $siteURL."/?infresp=s&c=$subcode";
     $unsub_conf_link = $siteURL."/?infresp=s&c=$unsubcode";
     $unsub_link = $siteURL."/?infresp=s&c=$unsubcode";
     $UnsubURL = $unsub_link;

     # Replace unsub and sub/unsub conf links
     $DB_MsgBodyText = preg_replace('/%sub_conf_url%/i', $sub_conf_link, $DB_MsgBodyText);
     $DB_MsgBodyText = preg_replace('/%unsub_conf_url%/i', $unsub_conf_link, $DB_MsgBodyText);
     $DB_MsgBodyText = preg_replace('/%unsub_url%/i', $unsub_link, $DB_MsgBodyText);
     $DB_MsgBodyHTML = preg_replace('/%sub_conf_url%/i', "<A HREF=\"$sub_conf_link\">$sub_conf_link</A>", $DB_MsgBodyHTML);
     $DB_MsgBodyHTML = preg_replace('/%unsub_conf_url%/i', "<A HREF=\"$unsub_conf_link\">$unsub_conf_link</A>", $DB_MsgBodyHTML);
     $DB_MsgBodyHTML = preg_replace('/%unsub_url%/i', "<A HREF=\"$unsub_link\">$unsub_link</A>", $DB_MsgBodyHTML);

     # Process tags
     $MessageInfo['ResponderID'] = $Responder_ID;
     $MessageInfo['BodyText'] = $DB_MsgBodyText;
     $MessageInfo['BodyHTML'] = $DB_MsgBodyHTML;
     $message = ProcessMessageTags($MessageInfo,$SubscriberInfo);

     $DB_MsgBodyText = $message['BodyText'];
     $DB_MsgBodyHTML = $message['BodyHTML'];
     $Send_Subject = $message['Subject'];

     # Set another from
     if (!(isEmpty($from_address))) {$DB_ReplyToEmail = $from_address;}

     # Set another to
     if (!(isEmpty($to_address))) {$DB_EmailAddress = $to_address;}

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

     if (get_option('inf_resp_mailer') != 'wp_mail') {
	     if ($CanReceiveHTML == 1) {
			$boundary = md5(time()).rand(1000,9999);
			$Message_Headers .= "Content-Type: multipart/alternative; $newline            boundary=\"$boundary\"$newline";
			$Message_Body .= "This is a multi-part message in MIME format.$newline$newline";
			$Message_Body .= "--".$boundary.$newline;
			$Message_Body .= "Content-type: text/plain; charset=$charset$newline";
			$Message_Body .= "Content-Transfer-Encoding: 8bit".$newline;
			$Message_Body .= "Content-Disposition: inline$newline$newline";
			$Message_Body .= $DB_MsgBodyText . $newline.$newline;
			$Message_Body .= "--".$boundary.$newline;
			$Message_Body .= "Content-type: text/html; charset=$charset$newline";
			$Message_Body .= "Content-Transfer-Encoding: 8bit".$newline;
			$Message_Body .= "Content-Disposition: inline$newline$newline";
			$Message_Body .= $DB_MsgBodyHTML . $newline.$newline;
	     }
	     else {
			$Message_Headers .= "Content-type: text/plain; charset=$charset$newline";
			$Message_Headers .= "Content-Transfer-Encoding: 8bit".$newline;
			$Message_Body = $DB_MsgBodyText . $newline;
	     }
     }

     # Final filtering
     $Send_Subject = stripnl(str_replace("|","",$Send_Subject));
     $Message_Body = str_replace("|","",$Message_Body);
     $Message_Headers = str_replace("|","",$Message_Headers);
     $Message_Body = utf8_decode($Message_Body);

	# Send the mail
	// echo "Addy: $DB_EmailAddress <br>\n";
	// echo "Subj: $Send_Subject <br>\n";
	// echo "Head: $Message_Headers <br>\n";

	# MOD for sending message via wp_mail /phpmailer
	if (get_option('inf_resp_mailer') == 'wp_mail') {
		add_option('inf_resp_owner_email',$DB_OwnerEmail); update_option('inf_resp_owner_email',$DB_OwnerEmail);
		add_option('inf_resp_owner_name',$DB_OwnerName); update_option('inf_resp_owner_name',$DB_OwnerName);
		add_filter('wp_mail_from', 'inf_resp_from_email',100);
		add_filter('wp_mail_from_name', 'inf_resp_from_name',100);

		// echo "Can Receive HTML? ".$CanReceiveHTML."<br>";

		if ($CanReceiveHTML == 1) {
			// echo "Text Body: <textarea>$DB_MsgBodyText</textarea><br>\n";
			// echo "HTML Body: <textarea>$DB_MsgBodyHTML</textarea><br>\n";
			// echo "---------------------------<br>\n";
			add_option('inf_resp_alt_body',$DB_MsgBodyText);
			update_option('inf_resp_alt_body',$DB_MsgBodyText);
			add_action('phpmailer_init', 'inf_resp_set_alt_body');
			add_action('phpmailer_init', 'inf_resp_set_word_wrap');
			$result = wp_mail($DB_EmailAddress, $Send_Subject, $DB_MsgBodyHTML, $Message_Headers, false);
		}
		else {
			// echo "Text Body: <textarea>$DB_MsgBodyText</textarea><br>\n";
			// echo "---------------------------<br>\n";
			add_action('phpmailer_init', 'inf_resp_set_word_wrap');
			$result = wp_mail($DB_EmailAddress, $Send_Subject, $DB_MsgBodyText, $Message_Headers, false);
		}

		 if (!$result) {
			echo "Message sending by wp_mail failed!<br>";
			$result = mail($DB_EmailAddress, $Send_Subject, $Message_Body, $Message_Headers, "-f $DB_ReplyToEmail");
			if (!$result) {
				echo "Message sending by mail failed also!<br>";
				echo "Email: ".$DB_EmailAddress."<br>";
				echo "Subject: ".$Send_Subject."<br>";
				echo "Headers: ".$Message_Headers."<br>";
			}
     		}
	}
	else {
		// echo "Body: <textarea>$Message_Body </textarea><br>\n";
		// echo "---------------------------<br>\n";
		$result = mail($DB_EmailAddress, $Send_Subject, $Message_Body, $Message_Headers, "-f $DB_ReplyToEmail");
	}



     # Update the activity row
     $Set_LastActivity = time();
     $infrespsubscribers = $table_prefix.'InfResp_subscribers';
     $query = "UPDATE ".$infrespsubscribers." SET LastActivity = '$Set_LastActivity' WHERE SubscriberID = '$DB_SubscriberID'";
     $DB_result = mysql_query($query, $DB_LinkID) or die("Invalid query: " . mysql_error());

     # Head on back
     return $result;
}

# ---------------------------------------------------------

function ResponderPulldown($field) {
    global $DB_LinkID, $table_prefix;
    $infresponders = $table_prefix.'InfResp_responders';
    $menu_query = "SELECT * FROM ".$infresponders." ORDER BY ResponderID";
    $menu_result = mysql_query($menu_query, $DB_LinkID) or die("Invalid query: " . mysql_error());

    print "<select name=\"$field\" class=\"fields\">\n";
    while ($menu_row = mysql_fetch_assoc($menu_result)) {
         $DB_ResponderID   = $menu_row['ResponderID'];
         $DB_RespEnabled   = $menu_row['Enabled'];
         $DB_ResponderName = $menu_row['Name'];
         $DB_ResponderDesc = $menu_row['ResponderDesc'];
         $DB_OwnerEmail    = $menu_row['OwnerEmail'];
         $DB_OwnerName     = $menu_row['OwnerName'];
         $DB_ReplyToEmail  = $menu_row['ReplyToEmail'];
         $DB_MsgList       = $menu_row['MsgList'];
         $DB_OptMethod     = $menu_row['OptMethod'];
         $DB_OptInRedir    = $menu_row['OptInRedir'];
         $DB_OptOutRedir   = $menu_row['OptOutRedir'];
         $DB_OptInDisplay  = $menu_row['OptInDisplay'];
         $DB_OptOutDisplay = $menu_row['OptOutDisplay'];
         $DB_NotifyOnSub   = $menu_row['NotifyOwnerOnSub'];
         $PullDown_String  = string_cut($DB_ResponderName,3);
         if ($DB_OptMethod == "Single") {$PullDown_String .= " (1x)";}
         if ($DB_OptMethod == "Double") {$PullDown_String .= " (2x)";}
         print "<option value=\"$DB_ResponderID\">$PullDown_String</option>\n";
    }
    print "</select>\n";
}

# MOD Added Dropdown with Details for Bulk Add
function ResponderPulldownSpecial($field,$selected=false) {
    global $DB_LinkID, $table_prefix;
    $infresponders = $table_prefix.'InfResp_responders';
    $menu_query = "SELECT * FROM ".$infresponders." ORDER BY ResponderID";
    $menu_result = mysql_query($menu_query, $DB_LinkID) or die("Invalid query: " . mysql_error());

    print "<select id=\"respselect\" name=\"$field\" class=\"fields\" onchange=\"showresponder();\">\n";
    while ($menu_row = mysql_fetch_assoc($menu_result)) {
         $DB_ResponderID = $menu_row['ResponderID'];
         $DB_RespEnabled = $menu_row['Enabled'];
         $DB_ResponderName = $menu_row['Name'];
         $DB_ResponderDesc = $menu_row['ResponderDesc'];
         $DB_OwnerEmail = $menu_row['OwnerEmail'];
         $DB_OwnerName = $menu_row['OwnerName'];
         $DB_ReplyToEmail = $menu_row['ReplyToEmail'];
         $DB_MsgList = $menu_row['MsgList'];
         $DB_OptMethod = $menu_row['OptMethod'];
         $DB_OptInRedir = $menu_row['OptInRedir'];
         $DB_OptOutRedir = $menu_row['OptOutRedir'];
         $DB_OptInDisplay = $menu_row['OptInDisplay'];
         $DB_OptOutDisplay = $menu_row['OptOutDisplay'];
         $DB_NotifyOnSub = $menu_row['NotifyOwnerOnSub'];
         $PullDown_String = string_cut($DB_ResponderName,3);
         print "<option value=\"$DB_ResponderID\"";
         if ($DB_ResponderID == $selected) {echo " selected=\"selected\"";}
         print ">$PullDown_String</option>\n";
         if ($DB_ResponderID == 1) {$responder_details .= "<div id=\"responder".$DB_ResponderID."\">";}
         else {$responder_details .= "<div id=\"responder".$DB_ResponderID."\" style=\"display:none;\">";}
         $responder_details .= "Optin Method: ".$DB_OptMethod."<br>";
         $responder_details .= "Description: ".$DB_ResponderDesc."<br>";
         $responder_details .= "From Name: ".$DB_OwnerName."<br>";
         $responder_details .= "From Email: ".$DB_OwnerEmail."<br>";
         $responder_details .= "Reply-to Email: ".$DB_ReplyToEmail."<br>";
         $responder_details .= "</div>";
         $javascript .= "document.getElementById('responder".$DB_ResponderID."').style.display = 'none';\n";
    }
    print "</select>\n";
    print "<script language=\"javascript\" type=\"text/javascript\">";
    print "function showresponder() {\n";
    print $javascript;
    print "var responderid = 'responder'+document.getElementById('respselect').value;\n";
    print "document.getElementById(responderid).style.display = '';\n";
    print "} </script>";
    print $responder_details;
}

function Add_To_Logs($Activity, $Activity_Parm, $ID_Parm, $Extra_Parm) {
  global $DB_LinkID, $table_prefix;

  $infresplogs = $table_prefix.'InfResp_Logs';
  $TimeStampy = time();

    $Log_Query = "INSERT INTO ".$infresplogs." (TimeStamp, Activity, Activity_Parameter, ID_Parameter, Extra_Parameter)
                  VALUES('$TimeStampy', '$Activity', '$Activity_Parm', '$ID_Parm', '$Extra_Parm')";
    $Log_result = mysql_query($Log_Query, $DB_LinkID) or die("Invalid query: " . mysql_error());

  return $Log_result;
}

function PrimaryKeyName($table) {
  global $DB_LinkID;

  $query = "SELECT * FROM $table";
  $result = mysql_query($query, $DB_LinkID) or die("Invalid query: " . mysql_error());
  $PrimaryID_Num = "";
  $i = 0;
  while ($i < mysql_num_fields($result)) {
     $meta = mysql_fetch_field($result, $i);
     if ($meta) {if ($meta->primary_key) { $PrimaryID_Num = $i; } }
     $i++;
  }
  mysql_field_seek($result,0);
  $PrimaryID_Name = mysql_field_name($result,$Primary_Key_Num);
  return $PrimaryID_Name;
}

function GetFieldNames($table) {
  global $DB_LinkID;

  $query = "SELECT * FROM $table";
  $result = mysql_query($query, $DB_LinkID) or die("Invalid query: " . mysql_error());
  $i = 0;
  $FieldNameStr = "";
  while ($i < mysql_num_fields($result)) {
     $meta = mysql_fetch_field($result, $i);
     if ($meta) {$FieldNameStr = $FieldNameStr . trim($meta->name) . ",";}
     $i++;
  }
  $FieldNameStr = trim((trim($FieldNameStr)), ",");
  $FieldNameArray=explode(',',$FieldNameStr);
  return $FieldNameArray;
}

# ---------------------------------------------------------

function GrabFile($filename = FALSE) {
  if (!($filename)) {return FALSE;}
  if (file_exists($filename)) {
     if ($fhandle = fopen($filename, "r")) {
        $contents = fread($fhandle, filesize($filename));
        fclose($fhandle);
        return $contents;
     }
     else {return FALSE;}
  }
  else {return FALSE;}
}

# ---------------------------------------------------------

function isInBlacklist($address = "") {
     global $DB_LinkID, $table_prefix;
     $infrespblacklist = $table_prefix.'InfResp_blacklist';
     if ($address == "") { return FALSE; }
     $address = trim(strtolower($address));
     $query = "SELECT * FROM ".$infrespblacklist." WHERE LOWER(EmailAddress) = '$address'";
     $DB_result = mysql_query($query, $DB_LinkID) or die("Invalid query: " . mysql_error());
     if (mysql_num_rows($DB_result) > 0) { return TRUE; }
     else { return FALSE; }
}

function isEmail($address = "") {
     if ($address == "") {return FALSE;}
     if (preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z0-9.-]+$/i",$address)) {return TRUE;}
     else {return FALSE;}
}

# ---------------------------------------------------------

function generate_unique_code() {
     global $DB_LinkID, $table_prefix;

	$infrespsubscribers = $table_prefix.'InfResp_subscribers';

     # Generate a unique ID
     $not_unique = TRUE;
     while ($not_unique) {
          $id_str = substr(md5(str_makerand(15, 15, TRUE, FALSE, TRUE)),0,15);
          $query = "SELECT UniqueCode FROM ".$infrespsubscribers." WHERE UniqueCode = '$id_str'";
          $result = mysql_query($query, $DB_LinkID) or die("Invalid query: " . mysql_error());
          if (mysql_num_rows($result) == 0) { $not_unique = (!($not_unique)); }
     }

     # Return the ID
     return $id_str;
}

function generate_random_block() {
     $block1 = substr(md5(str_makerand(30, 30, TRUE, FALSE, TRUE)),0,30);
     $block2 = substr(md5(str_makerand(30, 30, TRUE, FALSE, TRUE)),0,30);
     $block  = md5(WebEncrypt($block1, $block2));
     return $block;
}

# ---------------------------------------------------------

function copyright($check = FALSE) {
   return TRUE;
}

function checkit() {
   global $cop;
   $cop = copyright(TRUE);
   return $cop;
}

# ---------------------------------------------------------

function admin_redirect() {
   global $siteURL, $ResponderDirectory;
   // $redir_URL = $siteURL.$ResponderDirectory.'/admin.php';
   # MOD now WP Admin redirect
   $redir_URL = admin_url('admin.php?page=infinityresponder');
   // header("Location: $redir_URL");
   print "<br>\n";
   print "Whoops! Something went wrong.<br>\n";
   print "<br>\n";
   print "<A HREF=\"$redir_URL\">Click here</A> to return to the admin screen.<br>\n";
   print "<br>\n";
   die();
}

# ---------------------------------------------------------

# Deprecated for Wordpress
function reset_user_session() {
     # Reset old session vars
     if ($_SESSION['initialized'] == TRUE) {
          $destroy_it = TRUE;
     }
     $_SESSION['initialized'] = FALSE;
     $_SESSION['timestamp'] = 0;
     $_SESSION['last_IP'] = '';
     $_SESSION['l'] = '';
     $_SESSION['p'] = '';

     # Unset the session cookie
     unset($_COOKIE[session_name()]);
     if ($destroy_it == TRUE) {
          session_destroy();
     }

     # Regen a new session cookie
     session_start();
     session_regenerate_id();
     setcookie(session_name(), session_id());
}

# Deprecated for Wordpress
function User_Auth() {
   global $config;

   # Start the session
   session_start();

   # Is the session even here?
   if ($_SESSION['initialized'] != TRUE) {
        # Nope, it's not initialized...
        reset_user_session();
        return FALSE;
   }

   # Check IP address against last known...
   if ($_SESSION['last_IP'] != $_SERVER['REMOTE_ADDR']) {
        # Not the same, reset the session and return FALSE
        reset_user_session();
        return FALSE;
   }

   # Check session timestamp
   if (time() >= ($_SESSION['timestamp'] + 10800)) {
        # 3 hours of inactivity kills a session
        reset_user_session();
        return FALSE;
   }

   # Test the login and pass
   $test_user = md5(WebEncrypt($config['admin_user'], $config['random_str_1']));
   $test_pass = md5(WebEncrypt($config['admin_pass'], $config['random_str_2']));
   if (($_SESSION['l'] == $test_user) && ($_SESSION['p'] == $test_pass)) {
        # Update the session details, we're good!
        $_SESSION['timestamp'] = time();
        return TRUE;
   }
}

?>