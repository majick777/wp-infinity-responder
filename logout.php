<?php
# Modified 07/15/2013 by Plugin Review Network
# ------------------------------------------------
# License and copyright:
# See license.txt for license information.
# ------------------------------------------------

# MOD DEPRECATED - no longer required for Wordpress

include_once('config.php');

# ------------------------------------------------

# Check authentication
$Is_Auth = User_Auth();
if ($Is_Auth) {
   $now = time();
   $str1 = generate_random_block();
   $str2 = generate_random_block();
   $query = "UPDATE InfResp_config
             SET random_timestamp = '$now',
             random_str_1 = '$str1',
             random_str_2 = '$str2'";
   $DB_result = mysql_query($query) or die("Invalid query: " . mysql_error());
   $config['random_timestamp'] = $now;
   $config['random_str_1'] = $str1;
   $config['random_str_2'] = $str2;

   # Reset the user session
   reset_user_session();
}

# Redirect to the login panel
admin_redirect();

DB_disconnect();
?>