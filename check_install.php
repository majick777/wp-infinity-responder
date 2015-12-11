<?php
# Modified 07/15/2013 by Plugin Review Network
# ------------------------------------------------
# License and copyright:
# See license.txt for license information.
# ------------------------------------------------

if (!function_exists('add_action')) {die();}

# MOD to include WP table prefix
global $table_prefix;
$infrespconfig = $table_prefix.'InfResp_config';

# Does the config table exist?
$query = "SHOW TABLES LIKE '".$infrespconfig."'";
$result = mysql_query($query) OR die("Invalid query: " . mysql_error());
if (mysql_num_rows($result) == 0) {
	# No, the defs are not installed!
	$wpdefs = dirname(__FILE__)."/wp-defs.sql";
	$contents = GrabFile($wpdefs);

	# MOD to include WP table prefix
	$contents = str_ireplace('InfResp',$table_prefix.'InfResp',$contents);

	if ($contents == FALSE) {die("Could not find the wp-defs.sql file!\n");}

	# Process the defs file.
	preg_match_all('/-- Start command --(.*?)-- End command --/ims', $contents, $queries);
	for ($i=0; $i < sizeof($queries[1]); $i++) {
		$query = $queries[1][$i];
		# echo nl2br($query) . "<br>\n";
		$result = mysql_query($query) OR die("Invalid query: " . nl2br(mysql_error()));
	}
}

?>