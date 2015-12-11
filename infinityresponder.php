<?php
/*
Plugin Name: Infinity Responder
Plugin URI: http://pluginreview.net/wordpress-plugins/wp-infinity-responder/
Description: The fully featured Inifinity Autoresponder now for Wordpress!
Version: 1.6.0
Author: Tony Hayes
Author URI: http://pluginreview.net
*/

if (!function_exists('add_action')) {exit;}

$virversion = "1.6.0";
define('INFINITY_RESPONDER_VERSION',$virversion);
$virdir = dirname(__FILE__);
$vserverhost = $_SERVER["HTTP_HOST"];

// Load Integration Module
$vintegration = $virdir.'/integration.php';
if (file_exists($vintegration)) {include_once($vintegration);}

// Set Global Table Prefix
if (!isset($table_prefix)) {global $wpdb; $table_prefix = $wpdb->prefix;}

// ---------
// Multisite
// ---------

// TODO: Single Table Option for All Subsites on a Multisite Install?
// ...tested but not working just yet...

// global $ir_table_prefix, $table_prefix, $wpdb;
// if (get_option('inf_resp_multisite_onetable') == 'on') {$ir_table_prefix = $wpdb->base_prefix;}
// else {$ir_table_prefix = $table_prefix;} // $table_prefix = $wpdb->prefix;

if (isset($_REQUEST['inf_resp_single_table'])) {add_action('init','inf_resp_multisite_table_option');}

function inf_resp_multisite_table_option() {
	if (current_user_can('manage_options')) {
		if ($_REQUEST['inf_resp_single_table'] == 'on') {
			delete_option('inf_resp_multisite_onetable');
			add_option('inf_resp_multisite_onetable','on');
		}
		if ($_REQUEST['inf_resp_single_table'] == 'off') {
			delete_option('inf_resp_multisite_onetable');
		}
	}
}

// --------------
// Update Checker
// --------------
// if not from wp.org repository
$vslug = 'wp-infinity-responder';
$vupdatechecker = dirname(__FILE__).'/updatechecker.php';
if (file_exists($vupdatechecker)) {
	include($vupdatechecker);
	$vupdatecheck = new PluginUpdateChecker_2_1 (
		'http://pluginreview.net/updates/?action=get_metadata&slug='.$vslug, __FILE__, $vslug
	);
}

// ------------
// INSTALLATION
// ------------

register_activation_hook(__FILE__, 'inf_resp_add_options');
register_deactivation_hook(__FILE__, 'inf_resp_deactivation');

// register_activation_hook(__FILE__, 'inf_resp_install_tables');
// function inf_resp_install_tables() {include('config.php'); include_once('install.php');}

// 1.6.0: added cron deactivation on plugin deactivation
function inf_resp_deactivation() {inf_resp_clear_wpcron_sendmails();}

// -------------------
// ADD/UPDATE OPTIONS
// -------------------

function inf_resp_add_options() {
	add_option('inf_resp_donation_box_off','');
	add_option('inf_resp_report_box_off','');
	add_option('inf_resp_ads_box_off','');
	add_option('inf_resp_mailer','wp_mail');
	add_option('inf_resp_word_wrap','80');
	add_option('inf_resp_address','');
	add_option('inf_resp_embed_images','yes');
	add_option('inf_resp_image_url','http://'.$_SERVER['HTTP_HOST'].'/images/');
	add_option('inf_resp_image_dir',ABSPATH.'images/');
	add_option('inf_resp_embed_external','yes');
	add_option('inf_resp_wpcron_frequency','off');
	add_option('inf_resp_cron_key','');
}

// 1.5.0: removed as handled by sidebar.php
// function inf_resp_update_sidebar_options() {
// 	$vdonationboxoff = $_POST['ir_donation_box_off'];
// 	$vreportboxoff = $_POST['ir_report_box_off'];
// 	$vadsboxoff = $_POST['ir_ads_box_off'];
// 	update_option('ir_donation_box_off',$vdonationsboxoff);
// 	update_option('ir_report_box_off',$vreportboxoff);
// 	update_option('ir_ads_box_off',$vadsboxoff);

// 	echo "<script language='javascript' type='text/javascript'>";
// 	if ($vdonationboxoff == 'checked') {echo "parent.document.getElementById('donate').style.display = 'none'; ";}
// 	else {echo "parent.document.getElementById('donate').style.display = ''; ";}
// 	if ($vreportboxoff == 'checked') {echo "parent.document.getElementById('bonusoffer').style.display = 'none'; ";}
// 	else {echo "parent.document.getElementById('bonusoffer').style.display = ''; ";}
// 	if ($vadsboxoff == 'checked') {echo "parent.document.getElementById('pluginads').style.display = 'none'; ";}
// 	else {echo "parent.document.getElementById('pluginads').style.display = ''; ";}
// 	echo "parent.document.getElementById('sidebarsaved').style.display = ''; ";
// 	echo "parent.document.getElementById('sidebarsettings').style.display = 'none'; ";
// 	echo "</script>";
// 	exit;
// }

// -------
// ACTIONS
// -------

if (is_admin()) {
	if (isset($_REQUEST['page'])) {
		if ($_REQUEST['page'] == 'infinityresponder') {add_action('wp_enqueue_scripts','inf_resp_load_stylesheet');}
	}
}

function inf_resp_load_stylesheet() {
	$vmaincss = WP_PLUGIN_URL.'/wp-infinity-responder/templates/main.css';
	// 1.6.0: enqueue style instead of adding link
	wp_enqueue_style('infinityresponder', $vmaincss, array());
	// echo '<link rel="stylesheet" type="text/css" href="'.$vmaincss.'">';
}

// Subscribe Triggers
// ------------------
if (isset($_REQUEST['infresp'])) {
	if ($_REQUEST['infresp'] == 'subscribe') {add_action('init','inf_resp_subscribe_call');}
	if ($_REQUEST['infresp'] == 's') {add_action('init','inf_resp_subscribe_call');}
}

// Call Subscribe
// --------------
function inf_resp_subscribe_call() {include(dirname(__FILE__)."/s.php"); exit;}


// Sendmail  Triggers
// ------------------
if (isset($_REQUEST['ir'])) {
	if ( ($_REQUEST['ir'] == 'sendmail') || ($_REQUEST['ir'] == 'sendmails') ) {
		add_action('init','inf_resp_call_sendmails');
	}
}

function inf_resp_call_sendmails() {
	if (isset($_REQUEST['cronkey'])) {if ($_REQUEST['cronkey'] == get_option('inf_resp_cron_key')) {$silent = FALSE;} }
	require(dirname(__FILE__)."/sendmails.php");
	exit;
}
function inf_resp_run_sendmails() {$silent = TRUE; require(dirname(__FILE__)."/sendmails.php"); exit;}

// Cron Options
// ------------
if (isset($_REQUEST['inf_resp_update_wpcron'])) {if ($_REQUEST['inf_resp_update_wpcron'] == 'yes') {add_action('init','inf_resp_update_wpcron_sendmails');} }
if (isset($_REQUEST['inf_resp_update_cron_key'])) {if ($_REQUEST['inf_resp_update_cron_key'] == 'yes') {add_action('init','inf_resp_update_secret_key');} }

// ----------------
// Cron and WP Cron
// ----------------

// Cron Secret Key
// ---------------

function inf_resp_update_secret_key() {
	if (current_user_can('manage_options')) {
		if (isset($_POST['inf_resp_secret_cron_key'])) {
			$vsecretkey = $_POST['inf_resp_secret_cron_key'];
			$maybe = array(); preg_match( "/[a-zA-Z0-9]+/", $vsecretkey, $maybe);
			if ($vcampaign != $maybe[0]) {$vsecretkey = $maybe[0];}
			if ($vsecretkey != '') {
				delete_option('inf_resp_cron_key');
				add_option('inf_resp_cron_key',$vsecretkey);
			}
		}
	}
}

// WP Cron
// -------

add_action('infinityrespondersendmail','inf_resp_run_sendmails');

function inf_resp_clear_wpcron_sendmails() {
	wp_clear_scheduled_hook('infinity_responder_sendmail');
	wp_clear_scheduled_hook('infinityrespondersendmail');
}

function inf_resp_update_wpcron_sendmails() {
	inf_resp_clear_wpcron_sendmails();
	$vfrequency = $_POST['wpcron_frequency'];
	// hourly, twicedaily, daily
	if (!wp_next_scheduled('infinityrespondersendmail')) {
		wp_schedule_event( time(), $vfrequency, 'infinityrespondersendmail' );
	}
	delete_option('inf_resp_wpcron_frequency',$vfrequency);
	add_option('inf_resp_wpcron_frequency',$vfrequency);
}

add_filter( 'cron_schedules', 'inf_resp_add_cron_intervals' );
function inf_resp_add_cron_intervals($schedules) {
	$schedules['5minutes'] = array('interval' => 300, 'display' => __('Every 5 Minutes'));
	$schedules['10minutes'] = array('interval' => 600, 'display' => __('Every 10 Minutes'));
	$schedules['15minutes'] = array('interval' => 900, 'display' => __('Every 15 Minutes'));
	$schedules['20minutes'] = array('interval' => 1200, 'display' => __('Every 20 Minutes'));
	$schedules['30minutes'] = array('interval' => 1800, 'display' => __('Every 30 Minutes'));
	// hourly
	$schedules['2hours'] = array('interval' => 7200, 'display' => __('Every 2 Hours'));
	$schedules['3hours'] = array('interval' => 10800, 'display' => __('Every 3 Hours'));
	$schedules['6hours'] = array('interval' => 21600, 'display' => __('Every 6 Hours'));
	// twicedaily, daily
   	return $schedules;
}

// -----
// MENUS
// -----

if (is_admin()) {add_action('admin_menu', 'inf_resp_admin_menu');}
function inf_resp_admin_menu() {
	$vicon = WP_PLUGIN_URL.'/wp-infinity-responder/images/icon.png';
	add_menu_page('Infinity Responder', 'Infinity Responder', 'manage_options', 'infinityresponder', 'inf_resp_admin_page',$vicon,76);
	add_options_page('Infinity Responder', 'Infinity Responder', 'manage_options', 'infinityresponder&subpage=editconfig', 'inf_resp_config_page');

	// add_submenu_page('infinityresponder', '', '', 'manage_options', 'infinityresponder', 'inf_resp_dummy_function');
	add_submenu_page('infinityresponder', 'Responders', 'Responders', 'manage_options', 'infinityresponder&subpage=responders&action=list', 'inf_resp_admin_page');
	add_submenu_page('infinityresponder', 'Config', 'Config', 'manage_options', 'infinityresponder&subpage=editconfig', 'inf_resp_admin_page');
	add_submenu_page('infinityresponder', 'Cron', 'Cron', 'manage_options', 'infinityresponder&subpage=cron', 'inf_resp_admin_page');
	add_submenu_page('infinityresponder', 'Tools', 'Tools', 'manage_options', 'infinityresponder&subpage=tools', 'inf_resp_admin_page');
}

function inf_resp_dummy_function() {}

function inf_resp_admin_page() {
	// add_action('admin_footer','inf_resp_remove_footer_javascript');
	echo "<style>body {background-color:#FFF !important;} #wpfooter {display:none !important;}</style>";
	$vsubpage = $_REQUEST['subpage'];
	if ($vsubpage == '') {$vsubpage = 'admin';}
	if ($vsubpage == 'editconfig') {$vsubpage = 'edit_config';}
	$vsubmenu = dirname(__FILE__)."/".$vsubpage.".php";
	// echo $vsubmenu;
	if (file_exists($vsubmenu)) {include($vsubmenu);}
	else {
		$vsubmenu = dirname(__FILE__)."/admin.php";
		include($vsubmenu);
	}
}

// Add Settings Link to Plugin Page
add_filter('plugin_action_links', 'inf_resp_plugin_action_links', 10, 2);
function inf_resp_plugin_action_links($vlinks, $vfile) {
	$vthisplugin = plugin_basename(__FILE__);
	if ($vfile == $vthisplugin) {
		$vsettingsurl = admin_url('admin.php').'?page=infinityresponder&subpage=editconfig';
		$vsettingslink = "<a href='".$vsettingsurl."'>Settings</a>";
		array_unshift($vlinks, $vsettingslink);
	}
	return $vlinks;
}

// ----------------
// SUBSCRIBE WIDGET
// ----------------

function inf_resp_load_widget() {register_widget('inf_resp_widget');}
add_action('widgets_init', 'inf_resp_load_widget');

class inf_resp_widget extends WP_Widget {

	function inf_resp_widget() {
	    $widget_ops = array('classname' => 'ir_widget', 'description' => 'Infinity Responder Subscription Form' );
	    $this->WP_Widget('infinity_responder', 'Infinity Responder Subscribe', $widget_ops);
	  }

	public function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title'] );

		$subscribeform = '<center><form class="ir_form" action="/?infresp=subscribe" method=GET>
		<input type="hidden" name="r"   value="'.$instance['rid'].'">
		<input type="hidden" name="a"   value="sub">
		<input type="hidden" name="ref" value="widget">
		<input type="hidden" name="h" value="1">
		<table class="ir_table" cellspacing="10" bgcolor="#F0F0F0" style="border: 1px solid #C0C0C0;">
		<tr><td class="ir_table_cell" align="center"><input class="ir_name" type="text" name="f" style="background-color:#FFFFFF;" size=21 maxlength=50 placeholder="Your Name..."></td></tr>
		<tr><td class="ir_table_cell" align="center"><input class="ir_email" type="text" name="e" style="background-color:#FFFFFF;" size=21 maxlength=100 placeholder="Your Email..."></td></tr>';
		if ($instance['imgbtn'] == 'on') {$subscribeform .= '<tr><td class="ir_table_cell" align="center"><input class="ir_submit" type="image" class="ir_submit" name="submit" src="'.$instance['btnurl'].'"></td></tr>';}
		else {$subscribeform .= '<tr><td class="ir_table_cell" align="center"><input class="ir_submit" type="submit" class="ir_submit" name="submit" value="'.$instance['btntxt'].'"></td></tr>';}
		$subscribeform .= '</table></form></center>';

		echo $args['before_widget'];
		if (!empty($title)) {echo $args['before_title'].$title.$args['after_title'];}
		echo $instance['pitch'];
		echo $subscribeform;
		echo $args['after_widget'];
	}

	public function form($instance) {
		global $siteURL, $ResponderDirectory;
		global $table_prefix, $wpdb;

		$defaults = array('title' => 'Subscribe',
			'pitch' => '',
			'rid' => '',
			'imgbtn' => 'on',
			'btntxt' => 'Subscribe Now',
			'btnurl'=>WP_PLUGIN_URL.'/wp-infinity-responder/images/subscribe.png'
		);
		$instance = wp_parse_args((array)$instance,$defaults);

		// print_r($instance);
		// if (isset($instance['title'])) {$title = $instance['title'];} else {$title = 'Subscribe';}
		// if (isset($instance['pitch'])) {$pitch = $instance['pitch'];} else {$pitch = '';}
		// if (isset($instance['rid'])) {$rid = $instance['rid'];} else {$rid = '';}
		// if (isset($instance['imgbtn'])) {$imgbtn = $instance['imgbtn'];} else {$imgbtn = 'on';}
		// if (isset($instance['btntxt'])) {$btntxt = $instance['btntxt'];} else {$btntxt = 'Subscribe Now';}
		// if (isset($instance['btnurl'])) {$btnurl = $instance['btnurl'];} else {$btnurl = WP_PLUGIN_URL.'/wp-infinity-responder/images/subscribe.png';}

		$infresponders = $table_prefix.'InfResp_responders';
		$menu_query = "SELECT * FROM ".$infresponders." ORDER BY ResponderID";
		$menu_results = $wpdb->get_results($menu_query);
		// print_r($menu_results);

		$responderpulldown = "<select id=\"respselect\" name=\"$field\" class=\"fields\" onchange=\"showresponder();\">";
		foreach ($menu_results as $menu_result) {

			// print_r($menu_result);
			// $menu_row = mysql_fetch_assoc($menu_result))

			$DB_ResponderID = $menu_result->ResponderID;
			$DB_RespEnabled = $menu_result->Enabled;
			$DB_ResponderName = $menu_result->Name;
			$DB_ResponderDesc = $menu_result->ResponderDesc;
			$DB_OptMethod = $menu_result->OptMethod;
			$DB_OwnerEmail = $menu_result->OwnerEmail;
			$DB_OwnerName = $menu_result->OwnerName;

			// $DB_ReplyToEmail = $menu_result->ReplyToEmail;
			// $DB_MsgList = $menu_result->MsgList;
			// $DB_OptInRedir = $menu_result->OptInRedir;
			// $DB_OptOutRedir = $menu_result->OptOutRedir;
			// $DB_OptInDisplay = $menu_result->OptInDisplay;
			// $DB_OptOutDisplay = $menu_result->OptOutDisplay;
			// $DB_NotifyOnSub = $menu_result->NotifyOwnerOnSub;

			$PullDown_String = $DB_ResponderName;
			$responderpulldown .= "<option value=\"$DB_ResponderID\"";
			if ($DB_ResponderID == $selected) {$responderpulldown .= " selected=\"selected\"";}
			$responderpulldown .= ">$PullDown_String</option>\n";
			if ($DB_ResponderID == 1) {$responder_details .= "<div id=\"responder".$DB_ResponderID."\">";}
			else {$responder_details .= "<div id=\"responder".$DB_ResponderID."\" style=\"display:none;\">";}
			$responder_details .= "Description: ".$DB_ResponderDesc."<br>";
			$responder_details .= "From Name: ".$DB_OwnerName."<br>";
			$responder_details .= "Optin Method: ".$DB_OptMethod."<br>";
			// $responder_details .= "From Email: ".$DB_OwnerEmail."<br>";
			// $responder_details .= "Reply-to Email: ".$DB_ReplyToEmail."<br>";
			$responder_details .= "</div>";
			$javascript .= "document.getElementById('responder".$DB_ResponderID."').style.display = 'none';\n";
		}
		$responderpulldown .=  "</select>\n";
		$responderpulldown .=  "<script language=\"javascript\" type=\"text/javascript\">";
		$responderpulldown .=  "function showresponder() {\n";
		$responderpulldown .=  $javascript;
		$responderpulldown .= "var responderid = 'responder'+document.getElementById('respselect').value;\n";
		$responderpulldown .= "document.getElementById(responderid).style.display = '';\n";
		$responderpulldown .= "} </script>";
		$responderpulldown .= $responder_details;

		?>

		<p><b>Title:</b><input name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr($title);?>" /></p>
		<p><div style="vertical-align:top;"><b>Pitch:</b></div><textarea name="<?php echo $this->get_field_name( 'pitch' ); ?>" rows="5" cols="30"><?php echo esc_attr($pitch);?></textarea></p>
		<p><b>Responder:</b><?php echo $responderpulldown; ?></p>
		<p>Subscribe Button Image: <input class="checkbox" type="checkbox" <?php checked(isset($instance['imgbtn']), true ); ?> id="<?php echo $this->get_field_id('imgbtn'); ?>" name="<?php echo $this->get_field_name('imgbtn'); ?>" /></p>
		<p>Subscribe Button Text: <input name="<?php echo $this->get_field_name( 'btntxt' ); ?>" type="text" value="<?php echo esc_attr($btntxt);?>" /></p>
		<p>Subscribe Image URL: <input name="<?php echo $this->get_field_name( 'btnurl' ); ?>" type="text" value="<?php echo esc_attr($btnurl);?>" /></p>

	<?php
	}

	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['pitch'] = (!empty($new_instance['pitch'])) ? strip_slashes($new_instance['pitch']) : '';
		$instance['rid'] = (!empty($new_instance['rid'])) ? strip_tags($new_instance['rid']) : '';
		$instance['imgbtn'] = (!empty($new_instance['imgbtn'])) ? $new_instance['imgbtn'] : '';
		$instance['btntxt'] = (!empty($new_instance['btntxt'])) ? strip_tags($new_instance['btntxt']) : '';
		$instance['btnurl'] = (!empty($new_instance['btnurl'])) ? strip_tags($new_instance['btnurl']) : '';
		return $instance;
	}

}


// ---------------
// === Sidebar ===
// ---------------

// Save Sidebar Options
// --------------------
if (isset($_REQUEST['sidebarprefix'])) {
	if ($_REQUEST['sidebarprefix'] == 'inf_resp') {
		include(dirname(__FILE__).'/sidebar.php');
	}
}

// Load Dashboard Feed
// -------------------
if (is_admin()) {
	if (isset($_GET['loadprncat'])) {
		include_once(dirname(__FILE__).'/sidebar.php');
		add_action('init','prn_load_category_feed');
	}
	$vrequesturi = $_SERVER['REQUEST_URI'];
	if ( (preg_match('|index.php|i', $vrequesturi))
	  || (substr($vrequesturi,-(strlen('/wp-admin/'))) == '/wp-admin/')
	  || (substr($vrequesturi,-(strlen('/wp-admin/network'))) == '/wp-admin/network/') ) {
		include_once(dirname(__FILE__).'/sidebar.php');
		add_action('wp_dashboard_setup', 'prn_add_dashboard_feed_widget');
	}
}

// Call Sidebar
// ------------
function inf_resp_sidebar() {
	include(dirname(__FILE__).'/sidebar.php');
	prn_sidebar_floatbox('inf_resp','wp-infinity-responder','free','wp-infinity-responder','');

	$vfloatmenuscript = prn_sidebar_get_floatmenuscript();
	echo $vfloatmenuscript;

	echo '<script language="javascript" type="text/javascript">
	floatingMenu.add("floatdiv", {targetRight: 10, targetTop: 20, centerX: false, centerY: false});
	function move_upper_right() {
		floatingArray[0].targetTop=20;
		floatingArray[0].targetBottom=undefined;
		floatingArray[0].targetLeft=undefined;
		floatingArray[0].targetRight=10;
		floatingArray[0].centerX=undefined;
		floatingArray[0].centerY=undefined;
	}
	move_upper_right();
	</script></div>';
}

// Sidebar Footer
// --------------
function inf_resp_sidebar_plugin_footer() {
	global $virversion;
	$vplugintitle = "WP Infinity Responder";
	echo '<div id="pluginfooter"><div class="stuffbox" style="width:250px;background-color:#ffffff;"><h3>Plugin Info</h3><div class="inside">';
	echo "<center><table><tr>";
	echo "<td><a href='http://pluginreview.net/' target='_blank'><img src='".WP_PLUGIN_URL."/wp-infinity-responder/prn-logo.jpg' border=0></a></td></td>";
	echo "<td width='14'></td>";
	echo "<td><a href='http://pluginreview.net/wordpress-plugins/wp-infinity-responder/' target='_blank'>".$vplugintitle."</a> <i>v".$virversion."</i><br>";
	echo "by <a href='http://pluginreview.net/' target='_blank'>Plugin Review Network</a><br>";
	echo "<a href='http://pluginreview.net/wordpress-plugins/' target='_blank'><b>More Cool Free Plugins</b></a></td>";
	echo "</tr></table></center>";
	echo "<a href='http://www.gnu.org/licenses/gpl-2.0.html'>License: GNU v2</a>";
	echo '</div></div></div>';
}

// Donations Special
// -----------------
function inf_resp_donations_special_top() {

	echo "<script language='javascript' type='text/javascript'>
	function showdonationsbox(boxid) {
		if (boxid == 'authordonate') {
			document.getElementById('specialdonate').style.display = 'none';
			document.getElementById('normaldonate').style.display = 'none';
			document.getElementById('authordonate').style.display = '';
			document.getElementById('authorcell').style.backgroundColor = '#EEE';
			document.getElementById('normalcell').style.backgroundColor = '#FFF';
			document.getElementById('specialcell').style.backgroundColor = '#FFF';
		}
		if (boxid == 'normaldonate') {
			document.getElementById('authordonate').style.display = 'none';
			document.getElementById('specialdonate').style.display = 'none';
			document.getElementById('normaldonate').style.display = '';
			document.getElementById('authorcell').style.backgroundColor = '#FFF';
			document.getElementById('normalcell').style.backgroundColor = '#EEE';
			document.getElementById('specialcell').style.backgroundColor = '#FFF';
		}
		if (boxid == 'specialdonate') {
			document.getElementById('authordonate').style.display = 'none';
			document.getElementById('normaldonate').style.display = 'none';
			document.getElementById('specialdonate').style.display = '';
			document.getElementById('authorcell').style.backgroundColor = '#FFF';
			document.getElementById('normalcell').style.backgroundColor = '#FFF';
			document.getElementById('specialcell').style.backgroundColor = '#EEE';
		}
	}</script>";

	echo '<center><table><tr><td id="authorcell" style="background-color:#EEE;"><a href="javascript:void(0);" onclick="showdonationsbox(\'authordonate\');">Original Author</a></td>';
	echo '<td width=10></td>';
	echo '<td id="normalcell"><a href="javascript:void(0);" onclick="showdonationsbox(\'normaldonate\');">WP Author</a></td>';
	echo '<td width=10></td>';
	echo '<td id="specialcell"><a href="javascript:void(0);" onclick="showdonationsbox(\'specialdonate\');">Contributor</a></td>';
	echo '</tr></table></center><br>';

	echo '<div id="authordonate"><center>
		  <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
		  <input type="hidden" name="cmd" value="_xclick">
		  <input type="hidden" name="business" value="aaron@ibasics.biz">
		  <input type="hidden" name="item_name" value="Donate to Infinite Responder">
		  <input type="hidden" name="buyer_credit_promo_code" value="">
		  <input type="hidden" name="buyer_credit_product_category" value="">
		  <input type="hidden" name="buyer_credit_shipping_method" value="">
		  <input type="hidden" name="buyer_credit_user_address_change" value="">
		  <input type="hidden" name="no_shipping" value="0">
		  <input type="hidden" name="no_note" value="1">
		  <input type="hidden" name="currency_code" value="USD">
		  <input type="hidden" name="tax" value="0">
		  <input type="hidden" name="lc" value="US">
		  <input type="hidden" name="bn" value="PP-DonationsBF">
		  <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="Make payments with PayPal - it\'s fast, free and secure!">
		  <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
		  </form></center></div>';

	echo '<div id="specialdonate" style="display:none;"><center>
		  <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
		    <input type="hidden" name="cmd" value="_s-xclick">
		    <input type="hidden" name="hosted_button_id" value="6114284">
		    <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		    <img alt="" border="0" src="https://www.paypal.com/sv_SE/i/scr/pixel.gif" width="1" height="1">
          	</form></center></div>';

	echo '<div id="normaldonate" style="display:none;">';
}

function inf_resp_donations_special_bottom() {
	echo "<br>";
	echo "</div>";
}

// ---------------------------
// SUBSCRIPTION AND ACTIVATION
// ---------------------------

// Add Subscriber
// --------------
function inf_resp_add_subscriber($vfirstname,$vlastname,$vemail,$vresponderids) {

	if ($_REQUEST['debug'] == '1') {echo "WP Infinity Responder - Firstname: ".$vfirstname." - Email: ".$vemail."<br>";}

	global $table_prefix; global $wpdb;
	$vinfresponders = $table_prefix.'InfResp_responders';
	$vinfrespsubscribers = $table_prefix.'InfResp_subscribers';
	$vquery = "SELECT * FROM ".$vinfresponders." ORDER BY ResponderID";
	$vresponders = $wpdb->get_results($vquery);

	if ( (count($vresponders) > 0) && (count($vresponderids) > 0) ) {
		foreach ($vresponders as $vresponder) {
			foreach ($vresponderids as $vresponderid) {
				if ( ($vresponderid != '') && ($vresponder->ResponderID == $vresponderid) ) {
					// Add subscriber to Responder
					$vquery = "SELECT SubscriberID FROM ".$vinfrespsubscribers." WHERE ResponderID = '".$vresponder->ResponderID."' AND EmailAddress = '".$vemail."'";
					$vresult = $wpdb->get_var($vquery);

					if (!$vresult) {
						$DB_ResponderID = $vresponder->ResponderID;
						$DB_SentMsgs = "";
						$DB_EmailAddress = $vemail;
						$DB_TimeJoined = $DB_Real_TimeJoined = $DB_LastActivity = time();
						$CanReceiveHTML = "1";
						$DB_FirstName = $vfirstname;
						$DB_LastName = $vlastname;
						$DB_IPaddy = $_SERVER['REMOTE_ADDR'];
						$DB_ReferralSource = "";
						$DB_UniqueCode = inf_resp_generate_unique_code();
						$DB_Confirmed = "1";

						$vquery = "INSERT INTO ".$vinfrespsubscribers." (ResponderID, SentMsgs, EmailAddress, TimeJoined, Real_TimeJoined, CanReceiveHTML, LastActivity, FirstName, LastName, IP_Addy, ReferralSource, UniqueCode, Confirmed)
						 VALUES('$DB_ResponderID','$DB_SentMsgs', '$DB_EmailAddress', '$DB_TimeJoined', '$DB_Real_TimeJoined', '$CanReceiveHTML', '$DB_LastActivity', '$DB_FirstName', '$DB_LastName', '$DB_IPaddy', '$DB_ReferralSource', '$DB_UniqueCode', '$DB_Confirmed')";
						$vresult = $wpdb->query($vquery);
						if ($_REQUEST['debug'] == '1') {
							echo "WP Infinity Responder - Query:".$vquery."<br>";
							echo "Insert Result:"; print_r($vresult);
						}
						return $vresult;
					}
				}
			}
		}
	}
}

// Subscription Activation
// -----------------------
function inf_resp_subscriber_activate($vemail,$vresponderids) {

	if ($_REQUEST['debug'] == '1') {
		echo "WP Infinity Responder - Email: ".$vemail."<br>";
		if (count($vresponderids) > 0) {echo "Responder IDs: "; print_r($vresponderids);}
		else {echo "Responder IDs array is empty!";}
	}

	global $table_prefix; global $wpdb;
	$vinfresponders = $table_prefix.'InfResp_responders';
	$vinfrespsubscribers = $table_prefix.'InfResp_subscribers';
	$vquery = "SELECT * FROM ".$vinfresponders." ORDER BY ResponderID";
	$vresponders = $wpdb->get_results($vquery);

	if ( (count($vresponders) > 0) && (count($vresponderids) > 0) ) {
		foreach ($vresponders as $vresponder) {
			foreach ($vresponderids as $vresponderid) {
				if ( ($vresponderid != '') && ($vresponder->ResponderID == $vresponderid) ) {
					$vquery = "SELECT * FROM ".$vinfrespsubscribers." WHERE ResponderID = '".$vresponder->ResponderID."' AND EmailAddress = '".$vemail."'";
					$vresult = $wpdb->get_results($vquery);
					if ($_REQUEST['debug'] == '1') {
						echo "WP Infinity Responder - Query:".$vquery."<br>";
						echo "Result:"; print_r($vresult);
					}
					if ($vresult) {
						// Update Subscriber as Confirmed
						$vupdatedb = $wpdb->query("UPDATE ".$vinfrespsubscribers." SET Confirmed = '1' WHERE EmailAddress = '".$vemail."' AND ResponderId = '".$vresponder->ResponderID."'");
						if ($_REQUEST['debug'] == '1') {
							echo "WP Infinity Responder - Query:".$vquery."<br>";
							echo "Update Result:".$vupdatedb;
						}
						return $vupdatedb;
					}
				}
			}
		}
	}
}

// Delete Subscriber
// -----------------
function inf_resp_delete_subscriber($vemail,$vresponderids) {
	global $table_prefix; global $wpdb;
	$vinfresponders = $table_prefix.'InfResp_responders';
	$vinfrespsubscribers = $table_prefix.'InfResp_subscribers';
	$vquery = "SELECT * FROM ".$vinfresponders." ORDER BY ResponderID";
	$vresponders = $wpdb->get_results($vquery);

	if ( (count($vresponders) > 0) && (count($vresponderids) > 0) ) {
		foreach ($vresponders as $vresponder) {
			foreach ($vresponderids as $vresponderid) {
				if ( ($vresponderid != '') && ($vresponder->ResponderID == $vresponderid) ) {
					$vquery = "DELETE FROM ".$vinfrespsubscribers." WHERE ResponderID = '".$vresponder->ResponderID."' AND EmailAddress = '".$vemail."'";
					$vresult = $wpdb->query($vquery);
				}
			}
		}
	}
}

// Get Subscribers to Array
// ------------------------
function inf_resp_get_subscribers($vresponderid,$vconfirmed) {

	global $table_prefix; global $wpdb;
	$vinfsubscribers = $table_prefix.'InfResp_subscribers';

	if ($vconfirmed == '1') {
		$vquery = "SELECT * FROM ".$vinfsubscribers." WHERE Confirmed = '1' AND ResponderID = '".$vresponderid."'";
	}
	else {
		$vquery = "SELECT * FROM ".$vinfsubscribers." WHERE ResponderID = '$vresponderid'";
	}
	// echo $vquery;
	$vresults = $wpdb->get_results($vquery);
	// print_r($vresults);

	if (count($vresults) > 0) {
		$vi = 0;
		foreach ($vresults as $vresult) {
			$vsubscribers[$vi]['Email'] = $vresult->EmailAddress;
			$vsubscribers[$vi]['Firstname'] = $vresult->FirstName;
			$vsubscribers[$vi]['Lastname'] = $vresult->LastName;
			$vsubscribers[$vi]['Html'] = $vresult->CanReceiveHTML;
			$vsubscribers[$vi]['Confirmed'] = $vresult->Confirmed;
			$vsubscribers[$vi]['IP'] = $vresult->IP_Addy;
			$vsubscribers[$vi]['RefSource'] = $vresult->ReferralSource;
			$vsubscribers[$vi]['UniqueCode'] = $vresult->UniqueCode;
			$vsubscribers[$vi]['SentMsgs'] = str_replace(',','|',$vresult->SentMsgs);
			$vsubscribers[$vi]['TimeJoined'] = $vresult->TimeJoined;
			$vsubscribers[$vi]['RealTime'] = $vresult->Real_TimeJoined;
			$vsubscribers[$vi]['LastActivity'] = $vresult->LastActivity;
			$vi++;
		}
		return $vsubscribers;
	} else {return false;}
}

// ---------------------------------
// Subscription Management Shortcode
// ---------------------------------

add_shortcode('ir-subscriptions','inf_resp_subscription_management');
function inf_resp_subscription_management() {
	global $current_user; get_currentuserinfo();
	$vuserid = $current_user->ID;
	$vemail = $current_user->user_email;

	global $table_prefix; global $wpdb;
	$vinfresponders = $table_prefix.'InfResp_responders';
	$vinfrespsubscribers = $table_prefix.'InfResp_subscribers';

	// Get All Responders for Current Email
	$vquery = "SELECT ResponderID,Confirmed FROM ".$vinfrespsubscribers." WHERE EmailAddress = '".$vemail."'";
	$vresults = $wpdb->get_results($vquery);

	if (count($vresults) > 0) {

		$virsubman .= "<script language='javascript' type='text/javascript'>
		function checkfordelete() {";
		$vi = 0;
		foreach ($vresults as $vresult) {
			$vresponderid = $vresult->ResponderID;
			$virsubman .= "irlist[".$vi."] = '".$vresponderid."'; ";
			$vi++;
		}
		$virsubman .= "for (i=0; i<irlist.length;i++) {
				if (document.getElementById(irlist[i]).value == 'delete') {
					var doconfirm = 'yes';
				}
			}
		if (doconfirm == 'yes') {
			var agree = confirm('Are you sure? You will be removed from selected lists marked Delete.');
			if (!agree) {return false;}
		}
		}</script>";

		$virsubman .= "<h3>List Subscriptions</h3><form action='' target='' method='post'>";
		$virsubman .= "<input type='hidden' name='ir_subscription_update' value='yes'>";
		$virsubman .= "<table><tr><td align='center'><b>Subscriber List</b></td><td width='50'></td><td align='center' colspan='5'><b>Status</b></td></tr>";

		foreach ($vresults as $vresult) {
			$vresponderid = $vresult->ResponderID;
			$vconfirmed = $vresult->Confirmed;

			$vquery = "SELECT ResponderID,Name FROM ".$vinfresponders." WHERE ResponderID = '".$vresponderid."' ORDER BY ResponderID";
			$vresponders = $wpdb->get_results($vquery);

			// Display a Form for this Responder
			if (count($vresponders) > 0) {
				foreach ($vresponders as $vresponder) {
					$virsubman .= "<tr><td>".$vresponder->Name."</td><td></td>";
					$virsubman .= "<td><input type='radio' name='irlist-".$vresponder->ResponderID."' value='active'";
					if ($vconfirmed == '1') {$virsubman .= " checked>";} else {$virsubman .= ">";}
					$virsubman .= "Active</td><td width='15'></td>";
					$virsubman .= "<td><input type='radio' name='irlist-".$vresponder->ResponderID."' value='inactive'";
					if ($vconfirmed == '0') {$virsubman .= " checked>";} else {$virsubman .= ">";}
					$virsubman .= "Inactive</td><td width='15'></td>";
					$virsubman .= "<td><input type='radio' name='irlist-".$vresponder->ResponderID."' value='delete'>";
					$virsubman .= "Remove</td>";
					$virsubman .= "</tr>";
				}
			}
		}
		$virsubman .= "<tr><td></td><td></td><td align='center' colspan='5'><input type='submit' onclick='return checkfordelete();' value='Update Subscriptions'>";
		$virsubman .= "</td></tr></table>";
		return $virsubman;
	}
}


if (isset($_POST['ir_subscription_update'])) {
	if ($_POST['ir_subscription_update'] == 'yes') {
		add_action('init','inf_resp_subscription_update');
	}
}

function inf_resp_subscription_update() {
	global $current_user; get_currentuserinfo();
	$vuserid = $current_user->ID;
	$vemail = $current_user->user_email;

	global $table_prefix; global $wpdb;
	$vinfresponders = $table_prefix.'InfResp_responders';
	$infrespsubscribers = $table_prefix.'InfResp_subscribers';

	// Get All Responders for Current Email
	$vquery = "SELECT ResponderID,Confirmed FROM ".$infrespsubscribers." WHERE EmailAddress = '".$vemail."'";
	$vresults = $wpdb->get_results($vquery);

	if ($vresults) {
		foreach ($vresults as $vresult) {
			$vresponder = $vresult->ResponderID;
			$vconfirmed = $vresult->Confirmed;

			$vquery = "SELECT ResponderID,Name FROM ".$vinfresponders." ORDER BY ResponderID";
			$vresponders = $wpdb->get_results($vquery);

			// Update Subscription for this Responder
			if (count($vresponders) > 0) {
				foreach ($vresponders as $vresponder) {
					$vformkey = "irlist-".$vresponder->ResponderID;
					$vformvalue = $_POST[$vformkey];
					if ( ($vformvalue == 'active') && ($vconfirmed != '1') ) {
						$vupdatedb = $wpdb->query("UPDATE ".$infrespsubscribers." SET Confirmed = '1' WHERE EmailAddress = '".$vemail."' AND ResponderId = '".$vresponder->ResponderID."'");
					}
					elseif ( ($vformvalue == 'inactive') && ($vconfirmed != '0') ) {
						$vupdatedb = $wpdb->query("UPDATE ".$infrespsubscribers." SET Confirmed = '0' WHERE EmailAddress = '".$vemail."' AND ResponderId = '".$vresponder->ResponderID."'");
					}
					elseif ($vformvalue == 'delete') {
						$vupdatedb = $wpdb->query("DELETE FROM ".$infrespsubscribers." WHERE EmailAddress = '".$vemail."' AND ResponderID = '".$vresponder->ResponderID."'");
						// $vupdatedb = $query("DELETE FROM ".$infrespcustomfields." WHERE user_attached = '$Subscriber_ID'");
					}
				}
				echo "Subscriptions Updated";
			}
		}
	}
}

// -----------------
// === Functions ===
// -----------------

function inf_resp_get_urls() {
	$infinityURL = WP_PLUGIN_URL."/wp-infinity-responder";
	$pos = strpos($infinityURL,'/wp-content');
	$chunks = str_split($infinityURL,$pos);
	$siteURL = $chunks[0];
	unset($chunks[0]);
	$ResponderDirectory = implode('',$chunks);
	$urls['ResponderDirectory'] = $ResponderDirectory;
	$urls['siteURL'] = $siteURL;
	return $urls;
}

function inf_resp_message_box($message) {
	echo "<br><center><table style='background-color: lightYellow; border-style:solid; border-width:1px; border-color: #E6DB55; text-align:center;'>";
	echo "<tr><td><div class='message' style='margin:0.5em;'><font style='font-weight:bold;'>";
	echo $message;
	echo "</font></div></td></tr></table></center><br>";
}

function inf_resp_add_embedded_images($phpmailer) {
	$embedimages = get_option('inf_resp_image_embed_info');
	if (strstr($embedimages,'~~~')) {
		$embedimageinfo = explode('~~~',$embedimages);
		foreach ($embedimageinfo as $embedimage) {
			$image = explode("|||",$embedimage);
			$phpmailer->AddEmbeddedImage($image[0],$image[2],$image[1]);
		}
	}
	else {
		$image = explode("|||",$embedimages);
		$phpmailer->AddEmbeddedImage($image[0],$image[2],$image[1]);
	}
	delete_option('inf_resp_image_embed_info');
}

function inf_resp_get_color_scheme() {

	$vcolours[0] = "#FFFFFF";
	$vcolours[1] = "#B6E8FF";
	$vcolours[2] = "#1EABDF";
	$vcolours[3] = "#247EA6";
	return $vcolours;

	global $_wp_admin_css_colors;
	$current_user = wp_get_current_user();
	$vcurrentscheme = $current_user->admin_color;
	$vcolours = array();
	foreach ($_wp_admin_css_colors as $colorscheme => $values) {
		if ($colorscheme == $vcurrentscheme) {
			$vcolours[0] = $values->colors[0];
			$vcolours[1] = $values->colors[1];
			$vcolours[2] = $values->colors[2];
			$vcolours[3] = $values->colors[3];
			$vcolours[4] = $values->name;
		}
	}
	return $vcolours;
}

// deprecated, just doing this with a style display:none !important
function inf_resp_remove_footer_javascript() {
	echo "<script language='javascript' type='text/javascript'>
		function hidefooterdisplay() {document.getElementById('wpfooter').style.display = 'none';}
		window.onload = setTimeout(hidefooterdisplay(),500);
	</script>";
}

// phpmailer Functions
// -------------------

function inf_resp_from_email($email) {return get_option('inf_resp_owner_email');}

function inf_resp_from_name($name) {return get_option('inf_resp_owner_name');}

// note this is not needed as it is set in the message headers manually
function inf_resp_set_html_email($content_type) {return "text/html";}

function inf_resp_set_word_wrap($phpmailer) {
	$phpmailer->WordWrap = get_option('inf_resp_word_wrap');
}

function inf_resp_set_alt_body($phpmailer) {
	$phpmailer->AltBody = get_option('inf_resp_alt_body');
	delete_option('inf_resp_alt_body');
}

?>