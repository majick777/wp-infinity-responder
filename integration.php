<?php

// ============================
// Auto Signup Module for WP Infinity Responder
// Integrates: eStore, eMember, Affiliate Plaftorm
// ============================

// Tips and Tricks HQ Reference URL:
// http://www.tipsandtricks-hq.com/forum/topic/can-my-autoresponderemail-marketing-manager-be-integrated-with-your-plugins

// ----------------
// Add Settings Menu
// ----------------

if (is_admin()) {add_action('admin_menu', 'asm_settings_menu', 99);}
function asm_settings_menu() {
	// $vicon = WP_PLUGIN_URL.'/wp-infinity-responder/images/icon.png';
	// add_options_page('Integration', 'Integration', 'manage_options', 'autosignupintegration', 'asm_options_menu');
	add_submenu_page('infinityresponder', 'Integration', 'Integration', 'manage_options', 'autosignupintegration', 'asm_options_menu');
}

// ------------
// Options Menu
// ------------

function asm_options_menu() {

	echo "<h2>Infinity Responder</h2>";
	echo "<h3>Auto Signup Module Integration</h3>";	

	echo "Allows you to signup subscribers to autoresponders automatically ";
	echo "when they make a purchase or become a member or an affiliate.<br>";
	echo "This way you can easily followup with all customers, all members,";
	echo "all affiliates... or with specific item or membership purchasers!<br><br>";

	echo "<b>Please choose which subscription triggers you would like to enable:</b>";
	echo "<table><tr><td style='vertical-align:top;'><form action='' method='post'>";
	echo "<input type='hidden' name='update_ir_integration' value='yes'>";
	echo "<table><tr><td><b>eStore Global Autoresponders</b></td>";
	echo "<td align='center'><input type='checkbox' value='yes' name='ir_estore_global' id='ir_estore_global'";
	if (get_option('ir_estore_global') == 'yes') {echo " checked>";} else {echo ">";}
	echo "</td></tr>";	
	
	echo "<tr><td><b>eStore Item Specific Autoresponders</b></td>";
	echo "<td align='center'><input type='checkbox' value='yes' name='ir_estore_specific' id='ir_estore_specific'";
	if (get_option('ir_estore_specific') == 'yes') {echo " checked>";} else {echo ">";}
	echo "</td></tr>";
		
	echo "<tr><td><b>eMember Global Autoresponders</b></td>";
	echo "<td align='center'><input type='checkbox' value='yes' name='ir_emember_general' id='ir_emember_general'";
	if (get_option('ir_emember_general') == 'yes') {echo " checked>";} else {echo ">";}
	echo "</td></tr>";
	
	echo "<td><tr><td><b>eMember Membership Specific Autoresponders</b></td>";
	echo "<td align='center'><input type='checkbox' value='yes' name='ir_emember_specific' id='ir_emember_specific'";
	if (get_option('ir_emember_specific') == 'yes') {echo " checked>";} else {echo ">";}
	echo "</td></tr>";
	
	echo "<td><tr><td><b>WP Affiliate Platform Global Autoresponders</b></td>";
	echo "<td align='center'><input type='checkbox' value='yes' name='ir_affplat_global' id='ir_affplat_global'";
	if (get_option('ir_affplat_global') == 'yes') {echo " checked>";} else {echo ">";}
	echo "</td></tr>";
	
	echo "<tr><td></td><td><input type='submit' class='button-primary' value='Update Triggers'></td></tr>";
	echo "</table><br>";
	
	echo "</td><td style='vertical-align:top;'>";
	echo "<center><b>Also from Tips and Tricks HQ:</b></center><br>";
	echo "<script language='javascript' src='http://pluginreview.net/recommends/?s=yes&p=landingpages&a=majick&c=infinityresponder&t=integration'></script>";
	echo "</td></tr>";
		
	echo "<tr><td colspan='2'>";
	echo "<b>Setup</b>: For the global triggers to work, you must have the relevent ";
	echo "settings for each turned on in your Tips and Tricks HQ Plugins.<br><br>";
	echo "<b>Note</b>: You can also put a combination of comma separated Responder ";
	echo "IDs in any List/Campaign field instead of a single Responder ID.<br><br>";
	echo "<b><a href='http://www.tipsandtricks-hq.com/products?ap_id=majick'>Click here purchase eStore, eMember and WP Affiliate Platform together for a discount!</a></b>";
	echo "</td></tr>";
	
	echo "<tr height='15'><td> </td></tr>";	
	
	echo "<tr><td colspan='2' align='center'><b>Quick Settings Finder Guide</b></td></tr>";	
	
	echo "<tr><td style='vertical-align:top;'>";
	echo "<b>eStore Global Subscriptions</b><br>";
	echo "=> <a href='admin.php?page=wp_eStore_settings'>eStore Settings</a> -> <a href='admin.php?page=wp_eStore_settings&settings_action=aweber'>Autoresponder Settings</a><br>";
	echo "=> Generic Autoresponder Integration Settings<br>";
	echo " - Tick 'Enable Generic Autoresponder Integration'<br>";
	echo " - Tick 'Enable Global Integration'<br>";
	echo " - Enter Responder ID in 'Global List/Campaign Email Address' and Save.<br><br>";
	
	echo "<b>eStore Item Specific Subscriptions</b><br>";
	echo "=> <a href='admin.php?page=wp-cart-for-digital-products/wp_eStore1.php'>eStore Products</a><br>";
	echo " - Find and edit the chosen product.<br>";
	echo " - Open 'Autoresponder Settings' tab.<br>";
	echo " - Enter Responder ID in 'List Name' and Save.<br>";
	echo "(<i>Advanced:</i> Column key is 'aweber_list' in wp_eStore_tbl)<br><br>";
	
	echo "</td><td style='vertical-align:top;'>";
	echo "<script language='javascript' src='http://pluginreview.net/recommends/?s=yes&p=estore&a=majick&c=infinityresponder&t=integration'></script>";
	echo "</td></tr><tr><td style='vertical-align:top;'>";	
	
	echo "<b>eMember Global Subscriptions</b><br>";
	echo "=> <a href='admin.php?page=eMember_settings_menu&tab=5'>eMember Settings</a> ";
	echo "=> <a href='admin.php?page=eMember_settings_menu&tab=5'>Autoresponder Settings</a><br>";
	echo "=> Generic Autoresponder Integration Settings<br>";
	echo " - Tick 'Enable Generic Autoresponder Integration'<br>";
	echo " - Tick 'Enable Global Integration'<br>";
	echo " - Enter Responder ID in 'Global List/Campaign Email Address' and Save.<br><br>";
	
	echo "<b>eMember Membership Level Specific Subscriptions</b><br>";
	echo "=> <a href='admin.php?page=eMember_membership_level_menu'>eMember Memberships</a><br>";
	echo "- Edit the desired membership level.<br>";
	echo "- Put the Responder ID in the 'Autoresponder/Campaign Name' field.<br>";
	echo "(<i>Advanced:</i> Column key is 'campaign_name' in wp_eMember_membership_table)<br><br>";

	echo "</td><td style='vertical-align:top;'>";
	echo "<script language='javascript' src='http://pluginreview.net/recommends/?s=yes&p=emember&a=majick&c=infinityresponder&t=integration'></script>";
	echo "</td></tr><tr><td style='vertical-align:top;'>";

	echo "<b>Affiliate Platform Global Subscriptions</b><br>";
	echo "=> <a href='admin.php?page=wp_aff_platform_settings'>Affiliate Platform Settings</a> ";
	echo "=> <a href='admin.php?page=wp_aff_platform_settings&settings_action=autoresponder'>Autoresponder Settings</a><br>";
	echo "=> Generic Autoresponder Integration<br>";
	echo "- Tick Enable Generic Autoresponder Integration<br>";
	echo "- Enter Responder ID in 'List/Campaign Email Address' and Save.<br>";

	echo "</td><td style='vertical-align:top;'>";
	echo "<script language='javascript' src='http://pluginreview.net/recommends/?s=yes&p=affiliateplatform&a=majick&c=infinityresponder&t=integration'></script>";		
	echo "</td></tr>";

	echo "<tr><td colspan='2' align='center'><h3><a href='http://www.tipsandtricks-hq.com/products?ap_id=majick'>Click here purchase eStore, eMember and WP Affiliate Platform together for a discount!</a></h3></td></tr>";	
	echo "</table>";
}

// -------------
// Update Settings
// -------------

if (isset($_REQUEST['update_ir_integration'])) {
	if ($_REQUEST['update_ir_integration'] == 'yes') {
		add_action('init','asm_update_settings');
	}
}
function asm_update_settings() {
	if (current_user_can('manage_options')) {
		$voptionkeys[] = 'ir_estore_specific';
		$voptionkeys[] = 'ir_estore_global';
		$voptionkeys[] = 'ir_affplat_global';
		$voptionkeys[] = 'ir_emember_specific';
		$voptionkeys[] = 'ir_emember_general';

		foreach ($voptionkeys as $voptionkey) {
			delete_option($voptionkey);
			add_option($voptionkey,$_POST[$voptionkey]);
		}
	}	
}


// ------------
// Signup Hooks
// ------------

// WP eStore Signup Hooks
// --------------------
if (get_option('ir_estore_specific') == 'yes') {add_action('eStore_item_specific_autoresponder_signup','asm_trigger_signup_to_infresp_list');}
if (get_option('ir_estore_global') == 'yes') {add_action('eStore_global_autoresponder_signup','asm_trigger_signup_to_infresp_list');}

// WP Affiliate Platform Signup Hooks
// -----------------------------
if (get_option('ir_affplat_global') == 'yes') {add_action('wp_aff_global_autoresponder_signup','asm_trigger_signup_to_infresp_list');}

// WP eMember List Signup Hooks
// --------------------------
if (get_option('ir_emember_specific') == 'yes') {add_action('eMember_level_specific_autoresponder_signup','asm_trigger_signup_to_infresp_list');}
if (get_option('ir_emember_general') == 'yes') {add_action('eMember_global_autoresponder_signup','asm_trigger_signup_to_infresp_list');}



// ------------
// Signup Trigger
// ------------

function asm_trigger_signup_to_infresp_list($signup_data) {

	$vlistid = $signup_data['list_name'];
	
	if ($vlistid != '') {
		if (strstr($vlistid,',')) {$vlistdata = explode(",",$vlistid);}
		else {$vlistdata[0] = $vlistid;}

		$vi = 0; 
		foreach ($vlistdata as $vresponderid) {
			$vresponderid = trim($vresponderid);
			if (is_numeric($vresponderid)) {
				$vresponderids[$vi] = $vresponderid; 
				$vi++;
			}
		}

		if (count($vresponderids) > 0) {
			inf_resp_add_subscriber($signup_data['firstname'],$signup_data['lastname'],$signup_data['email'],$vresponderids);
			inf_resp_subcriber_activate($signup_data['email'],$vresponderids);
		}
	}
	
}
	
?>