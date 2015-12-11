<?php
# Modified 04/15/2014 by Plugin Review Network
# ------------------------------------------------
# License and copyright:
# See license.txt for license information.
# ------------------------------------------------

if (!function_exists('add_action')) {die();}

global $ir_table_prefix, $table_prefix, $wpdb;
global $siteURL, $ResponderDirectory;

# Check config.php vars
# MOD these are now set to WP constants in config.php
// if ($MySQL_server == '')   { die('$MySQL_server not set in config.php'); }
// if ($MySQL_user == '')     { die('$MySQL_user not set in config.php'); }
// if ($MySQL_password == '') { die('$MySQL_password not set in config.php'); }
// if ($MySQL_database == '') { die('$MySQL_database not set in config.php'); }

# Include the includes
include_once(dirname(__FILE__).'/evilness-filter.php');
include_once(dirname(__FILE__).'/functions.php');

# Set the siteURL
// note: optionally use home_url?
// $siteURL = home_url();
// site_url to support subdirectory installs
$siteURL = site_url();

// if ((isEmpty($_SERVER['HTTPS'])) || ((strtolower($_SERVER['HTTPS'])) == "off")) {
//    $siteURL = "http://" . $_SERVER['SERVER_NAME'];
// }
// else {
//    $siteURL = "https://" . $_SERVER['SERVER_NAME'];
// }

# Set the responder directory
// $directory_array = explode('/',$_SERVER['SCRIPT_NAME']);
// if (sizeof($directory_array) <= 2) {
//     $ResponderDirectory = "/";
// }
//else {
//     $ResponderDirectory = "";
//     for ($i=1; $i < (sizeof($directory_array)-1); $i++) {
//          $ResponderDirectory = $ResponderDirectory . "/" . $directory_array[$i];
//     }
//     $max_i     = sizeof($directory_array) - 1;
//     $this_file = $directory_array[$max_i];
// }

# Figure out the newline character
if (strtoupper(substr(PHP_OS,0,3)=='WIN')) {$newline = "\r\n";}
elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) {$newline = "\r";}
else {$newline = "\n";}

# Connect to the DB
$DB_LinkID = 0;
DB_connect();

# Ensure UTF8
# MOD ensure WP DB Charset
$charset = DB_CHARSET;
mysql_query("SET NAMES '".$charset."'");

# Check the table install
include_once(dirname(__FILE__).'/check_install.php');

# MOD to include WP table prefix
$infrespconfig = $table_prefix.'InfResp_config';

# Check the config
$query  = "SELECT * FROM ".$infrespconfig;
$result = mysql_query($query) or die("Invalid query: " . mysql_error());
if (mysql_num_rows($result) < 1) {
	# MOD for Wordpress set Infinity URLs
	$infinityURL = WP_PLUGIN_URL."/wp-infinity-responder";
	$pos = strpos($infinityURL,'/wp-content');
	$chunks = str_split($infinityURL,$pos);
	unset($chunks[0]);
	$ResponderDirectory = implode('',$chunks);

	# Grab the vars
	$now = time();
	$str1 = generate_random_block();
	$str2 = generate_random_block();

	# Setup the array
	$config['Max_Send_Count'] = '50';
	$config['Last_Activity_Trim'] = '0';
	$config['random_str_1'] = $str1;
	$config['random_str_2'] = $str2;
	$config['random_timestamp'] = $now;
	# MOD user/pass deprecated
	// $config['admin_user'] = 'admin';
	// $config['admin_pass'] = '';
	$config['charset'] = 'UTF-8';
	$config['autocall_sendmails'] = '1';
	$config['add_sub_size'] = '10';
	$config['subs_per_page'] = '100';
	$config['site_code'] = '';
	$config['check_mail'] = '1';
	$config['check_bounces'] = '1';
	$config['tinyMCE'] = '4';
	$config['daily_limit'] = '2500';
	$config['daily_count'] = '0';
	$config['daily_reset'] = $now;
	$config['infinityURL'] = $siteURL.$ResponderDirectory;

	# Insert the data
	DB_Insert_Array($infrespconfig, $config);

	# Set flag
	$config_row_inserted = TRUE;
}
else {
	$config = mysql_fetch_assoc($result);
	$config_row_inserted = FALSE;
}

# Bad, but useful, hackery
$max_send_count = $config['max_send_count'];
$last_activity_trim = $config['last_activity_trim'];
$charset = $config['charset'];
if (!empty($config['infinityURL'])) {
	# MOD: fix for subdirectory installs
	$infinityURL = $config['infinityURL'];
	$tempURL = str_replace('http://','',$infinityURL);
	// $siteURL = "http://".substr($tempURL,0,strpos($tempURL,"/"));
	// $ResponderDirectory = substr($tempURL,strpos($tempURL,"/"));
	$pos = strpos($infinityURL,'/wp-content');
	$chunks = str_split($infinityURL,$pos);
	unset($chunks[0]);
	$ResponderDirectory = implode('',$chunks);
}

// echo "***".$siteURL."***";
// echo "***".$ResponderDirectory."***";

?>