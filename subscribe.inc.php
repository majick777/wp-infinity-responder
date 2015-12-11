<?php
# Modified 10/12/2013 by Plugin Review Network
# ------------------------------------------------
# Made by Infinity Responder development team: 2009-06-04
# License and copyright:
# See license.txt for license information.
# ---------------------------------------------------------------------------------
# Usage: set variables $infinitycode - your Site Code, $email - the email address
#        to add, $name or $firstname+$lastname, $html - TRUE if html is accepted
#        $source - the name of your script, $responder - the ID of the responder to
#        subscribe to
#        then run this script through an include
#        note: make sure the current path is where you have installed
#        Infinity Responder before including the script
# ---------------------------------------------------------------------------------

if (!function_exists('add_action')) {die();}

include_once('config.php');

global $table_prefix;
$infrespsubscribers = $table_prefix.'InfResp_subscribers';

# ---------------------------------------------------------------------------------

// Protect from hacking...
if ($_REQUEST["infinitycode"]) exit;
if ($_REQUEST["source"]) exit;
if ($_REQUEST["responder"]) exit;

$ip_number = $_SERVER['REMOTE_ADDR'];

if ($name) $names = explode(" ",$name);
if (empty($firstname)) $firstname = $names[0];
if (empty($lastname)) $lastname = $names[1];

// Add the subscriber if the variables are set...
if ($infinitycode == $config['site_code'] && !empty($email) && !empty($responder) && !empty($firstname)) {
	$Email_Address = $email;
	if (!UserIsSubscribed($responder,$email)) {
		if (!isInBlacklist($email)) {
			$uniq_code = generate_unique_code();
			$Timestamper = time();
			$query = "INSERT INTO ".infrespsubscribers." (ResponderID, SentMsgs, EmailAddress, TimeJoined, Real_TimeJoined, CanReceiveHTML, LastActivity, FirstName, LastName, IP_Addy, ReferralSource, UniqueCode, Confirmed) VALUES('$responder','', '$email', '$Timestamper', '$Timestamper', '$html', '$Timestamper', '$firstname', '$lastname', '$ip_number', '$source', '$uniq_code', '1')";
			$DB_result = @mysql_query($query);
		}
	}
}
?>