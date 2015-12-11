<?php

// ------------------------
// === Sidebar FloatBox ===
// ------------------------

// --- Version 1.3.0 ---
// - added recurring donations
// - user populate bonus form

if (isset($_REQUEST['sidebarprefix'])) {
	$vpre = $_REQUEST['sidebarprefix'];
	$vsavesidebar = $vpre.'_save_sidebar_options';
	if (isset($_REQUEST[$vsavesidebar])) {
		if ($_REQUEST[$vsavesidebar] == 'yes') {
			add_action('init','prn_update_sidebar_options');
		}
	}
}

if (!function_exists('prn_sidebar_floatbox')) {
	function prn_sidebar_floatbox($vpre,$vpluginslug,$vfreepremium,$vwporgname,$vsavebutton) {

		echo "<script language='javascript' type='text/javascript'>
		function hidesidebarsaved() {document.getElementById('sidebarsaved').style.display = 'none';}
		function showhide(divname) {
			if (document.getElementById(divname).style.display == 'none') {document.getElementById(divname).style.display = '';}
			else {document.getElementById(divname).style.display = 'none';}
		}
		</script>";

		echo '<style>.inside {font-size:9pt; line-height:1.6em; padding:0px;}
		#floatdiv a {text-decoration:none;}
		#floatdiv a:hover {text-decoration:underline;}
		#floatdiv .stuffbox {background-color:#FFFFFF; margin-bottom:10px; padding-bottom:10px; text-align:center; width:25%;}
		#floatdiv .stuffbox .inside {padding:0 3px;}
		.stuffbox h3 {margin:10px 0; background-color:#FAFAFA; font-size:12pt;}
		</style>';

		echo '<div id="floatdiv" class="floatbox">';

		$vfuncname = $vpre.'_sidebar_plugin_header';
		if (function_exists($vfuncname)) {call_user_func($vfuncname);}

		if ($vsavebutton != 'replace') {

			echo '<div id="savechanges"><div class="stuffbox" style="width:250px;background-color:#ffffff;"><h3>Update Settings</h3><div class="inside"><center>';

			if ($vsavebutton == 'yes') {
				echo "<table><tr>";
				echo "<td align='center'><input type='submit' class='button-primary' value='Save Changes'></td>";
				echo "<td width='40'></td>";
				echo "<td><div style='line-height:1em;'><font style='font-size:8pt;'><a href='javascript:void(0);' style='text-decoration:none;' onclick='showhide(\"sidebarsettings\");hidesidebarsaved();'>Sidebar<br>Options</a></font></div></td>";
				echo "</tr></table></form>";
			}
			elseif ($vsavebutton == 'no') {echo "";}
			else {echo "<div style='line-height:1em;text-align:center;'><font style='font-size:8pt;'><a href='javascript:void(0);' style='text-decoration:none;' onclick='showhide(\"sidebarsettings\");hidesidebarsaved();'>Sidebar Options</a></font></div>";}

			echo "<div id='sidebarsettings' style='display:none;'><br>";

			echo "<form action='admin.php?page=".$vpluginslug."' target='savesidebar' method='post'>";
			echo "<input type='hidden' name='".$vpre."_save_sidebar_options' value='yes'>";
			echo "<input type='hidden' name='sidebarprefix' value='".$vpre."'>";
			echo "<table><tr><td align='center'>";
			echo "<b>I rock! I have made a donation.</b><br>(hides donation box)</td><td width='10'></td>";
			echo "<td align='center'><input type='checkbox' name='".$vpre."_donation_box_off' value='checked'";
			if (get_option($vpre.'_donation_box_off') == 'checked') {echo " checked>";} else {echo ">";}
			echo "</td></tr>";

			echo "<tr><td align='center'>";
			echo "<b>I've got your report, you<br>can stop bugging me now. :-)</b><br>(hides report box)</td><td width='10'></td>";
			echo "<td align='center'><input type='checkbox' name='".$vpre."_report_box_off' value='checked'";
			if (get_option($vpre.'_report_box_off') == 'checked') {echo " checked>";} else {echo ">";}
			echo "</td></tr>";

			echo "<tr><td align='center'>";
			echo "<b>My site is so awesome it<br>doesn't need any more quality<br>plugins recommendations.</b><br>(hides sidebar ads.)</td><td width='10'></td>";
			echo "<td align='center'><input type='checkbox' name='".$vpre."_ads_box_off' value='checked'";
			if (get_option($vpre.'_ads_box_off') == 'checked') {echo " checked>";} else {echo ">";}
			echo "</td></tr></table><br>";

			echo "<center><input type='submit' class='button-secondary' value='Save Sidebar Options'></center></form><br>";
			echo "<iframe src='javascript:void(0);' name='savesidebar' id='savesidebar' width='250' height'250' style='display:none;'></iframe>";

			echo "<div id='sidebarsaved' style='display:none;'>";
			echo "<table style='background-color: lightYellow; border-style:solid; border-width:1px; border-color: #E6DB55; text-align:center;'>";
			echo "<tr><td><div class='message' style='margin:0.25em;'><font style='font-weight:bold;'>";
			echo "Sidebar Options Saved.</font></div></td></tr></table></div>";

			echo "</div></center>";

			echo '</div></div></div>';
		}

		// For Free Version? Or Upgrade Link?
		echo '<div id="donate"';
		if (get_option($vpre.'_donation_box_off') == 'checked') {echo " style='display:none;'>";} else {echo ">";}
		if ($vfreepremium == 'free') {
			echo '<div class="stuffbox" style="width:250px;background-color:#ffffff;"><h3>Gifts of Appreciation</h3><div class="inside">';
			prn_sidebar_paypal_donations($vpre,$vpluginslug);
			prn_sidebar_testimonial_box($vpre,$vpluginslug);
			if ($vwporgname != '') {
				echo "<a href='http://wordpress.org/plugins/".$vwporgname."/' target='_blank'>Rate &#9733;&#9733;&#9733;&#9733;&#9733; on Wordpress.Org</a></center>";
			}
		}
		elseif ($vfreepremium == 'premium') {
			echo '<div class="stuffbox" style="width:250px;background-color:#ffffff;"><h3>Testimonials</h3><div class="inside">';
			prn_sidebar_testimonial_box($vpre,$vpluginslug);
		}
		echo '</div></div></div>';

		// populate subcription form for current user
		global $current_user; $current_user = wp_get_current_user();
		$vuseremail = $current_user->user_email; $vuserid = $current_user->ID;
		$vuserdata = get_userdata($vuserid);
		$vusername = $vuserdata->first_name;
		$vlastname = $vuserdata->last_name;
		if ($vlastname != '') {$vusername .= ' '.$vlastname;}

		echo '<div id="bonusoffer"';
		if (get_option($vpre.'_report_box_off') == 'checked') {echo " style='display:none;'>";} else {echo ">";}
		echo '<div class="stuffbox" style="width:250px;background-color:#ffffff;"><h3>Bonus Offer</h3><div class="inside">';
		echo "<center><table cellpadding='0' cellspacing='0'><tr><td align='center'><img src='".WP_PLUGIN_URL."/".$vpluginslug."/rv-report.jpg' width='60' height='80'><br>";
		echo "<font style='font-size:6pt;'><a href='http://pluginreview.net/return-visitors-report/' target=_blank>learn more...</a></font></td><td width='7'></td>";
		echo "<td align='center'><b><font style='color:#ee0000;font-size:9pt;'>Maximize Sales Conversions:</font><br><font style='color:#0000ee;font-size:10pt;'>The Return Visitors Report</font></b><br>";
		echo "<form style='margin-top:7px;' action='http://pluginreview.net/?visitorfunnel=join' target='_blank' method='post'>";
		echo "<input type='hidden' name='source' value='".$vpluginslug."-sidebar'>";
		echo "<input placeholder='Your Email...' type='text' style='width:150px;font-size:9pt;' name='subemail' value='".$vuseremail."'><br>";
		echo "<table><tr><td><input placeholder='Your Name...' type='text' style='width:90px;font-size:9pt;' name='subname' value='".$vusername."'></td>";
		echo "<td><input type='submit' class='button-secondary' value='Get it!'></td></tr></table>";
		echo "</td></tr></table></form></center>";
		echo '</div></div></div>';

		// Load Plugin Ads
		// ---------------
		if (get_option($vpre.'_ads_box_off') != 'checked') {
			echo '<div id="pluginads">';
			echo '<div class="stuffbox" style="width:250px;"><h3>Recommended</h3><div class="inside">';
			echo "<script language='javascript' src='http://pluginreview.net/recommends/?s=yes&a=majick&c=".$vpluginslug."&t=sidebar'></script>";
			echo '</div></div></div>';
		}

		// Call Plugin Footer Function
		// ----------------------
		$vfuncname = $vpre.'_sidebar_plugin_footer';
		if (function_exists($vfuncname)) {call_user_func($vfuncname);}

		echo '</div>';

		echo '</div>';
	}
}

// ----------------
// Paypal Donations
// ----------------

if (!function_exists('prn_sidebar_paypal_donations')) {
	function prn_sidebar_paypal_donations($vpre,$vpluginslug) {
		if (function_exists($vpre.'_donations_special_top')) {
			$vfuncname = $vpre.'_donations_special_top';
			call_user_func($vfuncname);
		}

		// make display name from the plugin slug
		if (strstr($vpluginslug,'-')) {
			$vparts = explode('-',$vpluginslug);
			$vi = 0;
			foreach ($vparts as $vpart) {
				if ($vpart == 'wp') {$vparts[$vi] = 'WP';}
				else {$vparts[$vi] = strtoupper(substr($vpart,0,1)).substr($vpart,1,(strlen($vpart)-1));}
				$vi++;
			}
			$vpluginname = implode(' ',$vparts);
		}
		else {
			$vpluginname = strtoupper(substr($vpluginslug,0,1)).substr($vpluginslug,1,(strlen($vpluginslug)-1));
		}

		$vnotifyurl = '';

		// repeating / one-time switcher
		echo "<center><table cellpadding='0' cellspacing='0'><tr><td>";
		echo "<input name='donatetype' id='recurradio' type='radio' onclick='showrecurringform();' checked> <a href='javascript:void(0);' onclick='showrecurringform();' style='text-decoration:none;'>Recurring</a> ";
		echo "</td><td width='10'></td><td>";
		echo "<input name='donatetype' id='onetimeradio' type='radio' onclick='showonetimeform();'> <a href-'javascript:void(0);' onclick='showonetimeform();' style='text-decoration:none;'>One Time</a>";
		echo "</td></tr></table></center>";

		// recurring form
		echo '
			<center><form id="recurringdonation" method="POST" action="https://www.paypal.com/cgi-bin/webscr" target="_blank">
			<input type="hidden" name="bn" value="PluginReviewNetwork_Donate_SF_AU">
			<input type="hidden" name="business" value="info@pluginreview.net">
			<input type="hidden" id="r_item_name" name="item_name" value="'.$vpluginname.' Donation">
			<input type="hidden" id="r_custom" name="custom" value="'.$vpluginslug.'">
			<input type="hidden" name="item_number" value>
			<input type="hidden" name="currency_code" value="USD">
			<input type="hidden" name="no_shipping" value="1">
			<input type="hidden" name="image_url" value="http://pluginreview.net/images/pluginreview-paypal-logo.jpg">
			<input type="hidden" id="r_return" name="return" value="http://pluginreview.net/thankyou/?plugin='.$vpluginslug.'">
			<input type="hidden" name="cbt" value="Return to Donations Page">
			<input type="hidden" id="r_cancel_return" name="cancel_return" value="http://pluginreview.net/donate/?plugin='.$vpluginslug.'">
			<input type="hidden" name="no_note" value="0">
			<input type="hidden" name="cn" value="Give a Testimonial and/or Log Feature Request">
			<input type="hidden" name="notify_url" value="'.$vnotifyurl.'">

			<input type="hidden" name="cmd" value="_xclick-subscriptions">
			<input type="hidden" name="p3" value="1">
			<input type="hidden" name="src" value="1">
			<input type="hidden" name="sra" value="0">
			<input type="hidden" name="modify" value="1">
			<table cellpadding="0" cellspacing="0"><tr><td>
			<select name="a3" style="font-size:8pt;" size="1">
			<option selected value="">Gifting Amount</option>
			<option value="1">$1 - </option>
			<option value="2">$2 - </option>
			<option value="5" selected="selected">$5 - </option>
			<option value="10">$10 - </option>
			<option value="20">$20 - </option>
			<option value="30">$30 - </option>
			<option value="50">$50 - </option>
			<option value="100">$100 - </option>
			<option value="">Custom</option>
			</select>
			</td><td width="5"></td><td>
			<select name="t3" style="font-size:9pt;">
			<option value="D">Daily</option>
			<option value="W" selected="selected">Weekly</option>
			<option value-"M">Monthly</option>
			</select></tr></table>
			<input type="image" src="'.WP_PLUGIN_URL.'/'.$vpluginslug.'/pp-donate.jpg" border="0" name="I1">
			</center></form>
		';

		// one time form
		echo '
			<center><form id="onetimedonation" style="display:none;" method="POST" action="https://www.paypal.com/cgi-bin/webscr" target="_blank">
			<input type="hidden" name="bn" value="PluginReviewNetwork_Donate_SF_AU">
			<input type="hidden" name="business" value="info@pluginreview.net">
			<input type="hidden" id="o_item_name" name="item_name" value="'.$vpluginname.' Donation">
			<input type="hidden" id="o_custom" name="custom" value="'.$vpluginslug.'">
			<input type="hidden" name="item_number" value>
			<input type="hidden" name="currency_code" value="USD">
			<input type="hidden" name="no_shipping" value="1">
			<input type="hidden" name="image_url" value="http://pluginreview.net/images/pluginreview-paypal-logo.jpg">
			<input type="hidden" id="o_return" name="return" value="http://pluginreview.net/thankyou/?plugin='.$vpluginslug.'">
			<input type="hidden" name="cbt" value="Return to Donations Page">
			<input type="hidden" id="o_cancel_return" name="cancel_return" value="http://pluginreview.net/donate/?plugin='.$vpluginslug.'">
			<input type="hidden" name="no_note" value="0">
			<input type="hidden" name="cn" value="Give a Testimonial and/or Log Feature Request">
			<input type="hidden" name="notify_url" value="'.$vnotifyurl.'">

			<input type="hidden" name="cmd" value="_donations">
			<select name="amount" style="font-size:8pt;" size="1">
			<option selected value="">Select Gift Amount</option>
			<option value="5">$5 - Buy me a Cuppa</option>
			<option value="10">$10 - Buy me Lunch</option>
			<option value="20">$20 - Support a Minor Bugfix</option>
			<option value="50">$50 - Support a Minor Update</option>
			<option value="100">$100 - Support a Major Bugfix/Update</option>
			<option value="250">$250 - Support a Minor Feature</option>
			<option value="500">$500 - Support a Major Feature</option>
			<option value="1000">$1000 - Improve my Outsourcing Budget</option>
			<option value="">Be Unique: Enter Custom Amount</option>
			</select>
			<input type="image" src="'.WP_PLUGIN_URL.'/'.$vpluginslug.'/pp-donate.jpg" border="0" name="I1">
			</center></form>
		';

		echo "<script language='javascript' type='text/javascript'>
		function showrecurringform() {
			document.getElementById('recurradio').checked = true;
			document.getElementById('onetimedonation').style.display = 'none';
			document.getElementById('recurringdonation').style.display = '';
		}
		function showonetimeform() {
			document.getElementById('onetimeradio').checked = true;
			document.getElementById('recurringdonation').style.display = 'none';
			document.getElementById('onetimedonation').style.display = '';
		}
		</script>";

		if (function_exists($vpre.'_donations_special_bottom')) {
			$vfuncname = $vpre.'_donations_special_bottom';
			call_user_func($vfuncname);
		}
	}
}

// ---------------
// Testimonial Box
// ---------------

if (!function_exists('prn_sidebar_testimonial_box')) {
	function prn_sidebar_testimonial_box($vpre,$vpluginslug) {
		$vpluginslug = str_replace('-','',$vpluginslug);
		echo "<script language='javascript' type='text/javascript'>
		function showhidetestimonialbox() {
			if (document.getElementById('sendtestimonial').style.display == '') {
				document.getElementById('sendtestimonial').style.display = 'none';
			}
			else {
				document.getElementById('sendtestimonial').style.display = '';
				document.getElementById('testimonialbox').style.display = 'none';
			}
		}
		function submittestimonial() {
			document.getElementById('testimonialbox').style.display='';
			document.getElementById('sendtestimonial').style.display='none';
		}</script>";

		echo "<center><a href='javascript:void(0);' onclick='showhidetestimonialbox();'>Send me a thank you or testimonial.</a><br>";
		echo "<div id='sendtestimonial' style='display:none;' align='center'>";
		echo "<center><form action='http://pluginreview.net' method='post' target='testimonialbox' onsubmit='submittestimonial();'>";
		echo "<b>Your Testimonial:</b><br>";
		echo "<textarea rows='5' cols='25' name='message'></textarea><br>";
		echo "<input type='text' placeholder='Your Name... (optional)' style='width:200px;' name='testimonial_sender' value=''><br>";
		echo "<input type='text' placeholder='Your Website... (optional)' style='width:200px;' name='testimonial_website' value=''><br>";
		echo "<input type='hidden' name='sending_plugin_testimonial' value='yes'>";
		echo "<input type='hidden' name='for_plugin' value='".$vpluginslug."'>";
		echo "<input type='submit' class='button-secondary' value='Send Testimonial'>";
		echo "</form>";
		echo "</div>";
		echo "<iframe name='testimonialbox' id='testimonialbox' frameborder=0 src='javascript:void(0);' style='display:none;' width='250' height='50' scrolling='no'></iframe>";
	}
}

// ---------------------
// Save Sidebar Settings
// ---------------------
if (!function_exists('prn_update_sidebar_options')) {
	function prn_update_sidebar_options() {
		$vpre = $_REQUEST['sidebarprefix'];
		if (current_user_can('manage_options')) {
			// Update Options
			// --------------
			$vdonationboxoff = $_POST[$vpre.'_donation_box_off'];
			$vreportboxoff = $_POST[$vpre.'_report_box_off'];
			$vadsboxoff = $_POST[$vpre.'_ads_box_off'];
			update_option($vpre.'_donation_box_off',$vdonationsboxoff);
			update_option($vpre.'_report_box_off',$vreportboxoff);
			update_option($vpre.'_ads_box_off',$vadsboxoff);

			// Javascript Callbacks
			// --------------------
			echo "<script language='javascript' type='text/javascript'>";
			if ($vdonationboxoff == 'checked') {echo "parent.document.getElementById('donate').style.display = 'none'; ";}
			else {echo "parent.document.getElementById('donate').style.display = ''; ";}
			if ($vreportboxoff == 'checked') {echo "parent.document.getElementById('bonusoffer').style.display = 'none'; ";}
			else {echo "parent.document.getElementById('bonusoffer').style.display = ''; ";}
			if ($vadsboxoff == 'checked') {echo "parent.document.getElementById('pluginads').style.display = 'none'; ";}
			else {echo "parent.document.getElementById('pluginads').style.display = ''; ";}
			echo "parent.document.getElementById('sidebarsaved').style.display = ''; ";
			echo "parent.document.getElementById('sidebarsettings').style.display = 'none'; ";
			echo "</script>";

			$vfuncname = $vpre.'_update_sidebar_options_special';
			if (function_exists($vfuncname)) {call_user_func($vfuncname);}
		}
		exit;
	}
}

// ---------------------
// Dashboard Feed Widget
// ---------------------

// Load the Dashboard Feed (only once)
if (!function_exists('prn_dashboard_feed_widget')) {
function prn_add_dashboard_feed_widget() {
	global $wp_meta_boxes, $current_user;
	if ( (current_user_can('manage_options')) || (current_user_can('install_plugins')) ) {
		foreach (array_keys($wp_meta_boxes['dashboard']['normal']['core']) as $vname) {
			if ($vname == 'plugin-review-network') {$vloaded = 'yes';}
		}
		if ($vloaded !='yes') {wp_add_dashboard_widget('plugin-review-network','Plugin Reviews','prn_dashboard_feed_widget');}
	}
} }

// PluginReview Dashboard Feed Widget
// ----------------------------------
if (!function_exists('prn_dashboard_feed_widget')) {
function prn_dashboard_feed_widget() {

	$vbaseurl = "http://pluginreview.net";

	// Load the News Feed
	// ------------------
	$vrssurl = $vbaseurl."/category/network-news/feed/";
	$vrssfeed = @fetch_feed($vrssurl);
	$vfeeditems = 5;
	$vfeed = prn_process_rss_feed($vrssfeed,$vfeeditems);
	if ($vfeed != '') {$vfeed = "<b>Latest News</b><br>".$vfeed."<div align='right'>&rarr;<a href='".$vbaseurl."/category/network-news/' target=_blank> More News...</a></div>";}
	echo "<div id='prnnewsdisplay'>".$vfeed."</div>";

	// Category Feed Selection
	// -----------------------
	$vcategoryurl = $vbaseurl."/?get_review_categories=yes";
	$vcategorylist = prn_download_url($vcategoryurl);

	if (strstr($vcategorylist,"::::")) {
		echo "<script language='javascript' type='text/javascript'>
		function loadprncat() {
			var selectelement = document.getElementById('prncatselector');
			var catslug = selectelement.options[selectelement.selectedIndex].value;
			var catname = getcatname(catslug);
			document.getElementById('prncatloader').src='admin.php?loadprncat='+catslug+'&catname='+catname;
		}
		</script>";

		$vcategories = explode("::::",$vcategorylist);
		if (count($vcategories) > 0) {
			$vi = 0;
			foreach ($vcategories as $vcategory) {
				$vcatinfo = explode("::",$vcategory);
				$vcats[$vi]['name'] = $vcatinfo[0];
				$vcats[$vi]['slug'] = $vcatinfo[1];
				$vcats[$vi]['count'] = $vcatinfo[2];
				$vi++;
			}

			if (count($vcats) > 0) {
				echo "<script language='javascript' type='text/javascript'>";
				echo "function getcatname(catslug) {";
				foreach ($vcats as $vcat) {
					echo "if (catslug == '".$vcat['slug']."') {catname = '".$vcat['name']."';} ";
				}
				echo " return encodeURIComponent(catname);";
				echo "}</script>";
				echo "<table><tr><td><b>Review Category:</b></td>";
				echo "<td width='7'></td>";
				echo "<td><input type='hidden' id='selectedcatname' value=''>";
				echo "<select id='prncatselector' onchange='loadprncat();'>";
				echo "<option value='MAINFEED' selected='selected'>Latest Reviews</option>";
				foreach ($vcats as $vcat) {
					echo "<option value='".$vcat['slug']."' onclick='changecatname(\"".$vcat['name']."\");'>".$vcat['name']." (".$vcat['count'].")</option>";
				}
				echo "</select></td></tr></table>";
				echo "<iframe src='javascript:void(0);' id='prncatloader' style='display:none;'></iframe>";
			}
		}
	}

	// Load the Main RSS Feed
	// ----------------------
	$vrssurl = $vbaseurl."/feed/";
	$vrssfeed = @fetch_feed($vrssurl);
	$vfeeditems = 10;
	$vfeed = prn_process_rss_feed($vrssfeed,$vfeeditems);
	if ($vfeed != '') {$vfeed .= "<div align='right'>&rarr;<a href='".$vbaseurl."/latest-reviews/' target=_blank> More Reviews...</a></div>";}
	echo "<div id='prnfeeddisplay'>".$vfeed."</div>";

} }

// Load a Category Feed
// --------------------
if (!function_exists('prn_load_category_feed')) {
function prn_load_category_feed() {

	$vbaseurl = "http://pluginreview.net";
	$vcatslug = $_GET['loadprncat'];

	if ($vcatslug == "MAINFEED") {
		$vcategoryurl = $vbaseurl."/feed/";
		$vmorelink = "<div align='right'>&rarr;<a href='".$vbaseurl."/latest-reviews/' target=_blank>More Reviews...</a></div>";
	}
	else {
		$vcategoryurl = $vbaseurl."/category/".$vcatslug."/feed/";
		$vmorelink = "<div align='right'>&rarr;<a href='".$vbaseurl."/category/".$vcatslug."/' target=_blank> More Reviews...</a></div>";
	}
	$vcategoryrss = @fetch_feed($vcategoryurl);
	$vfeeditems = 10;

	// Process the Feed
	// ----------------
	$vcategoryfeed = prn_process_rss_feed($vcategoryrss,$vfeeditems);
	if ($vcategoryfeed != '') {$vcategoryfeed .= $vmorelink;}

	echo '<script language="javascript" type="text/javascript">
	var categoryfeed = "'.$vcategoryfeed.'";
	parent.document.getElementById("prnfeeddisplay").innerHTML = categoryfeed;
	</script>';

	exit;
} }

// Process RSS Feed
// ----------------
if (!function_exists('prn_process_rss_feed')) {
function prn_process_rss_feed($vrss,$vfeeditems) {

	if (!is_wp_error($vrss)) {
		$vmaxitems = $vrss->get_item_quantity($vfeeditems);
		$vrssitems = $vrss->get_items(0,$vmaxitems);
	}

	if ($vmaxitems == 0) {$vprocessed = "";}
	else {
		$vprocessed = "<ul style='list-style:none;'>";
		foreach ($vrssitems as $vitem ) {
			$vprocessed .= "<li>&rarr; <a href='".esc_url($vitem->get_permalink())."' target='_blank' ";
			$vprocessed .= "title='Posted ".$vitem->get_date('j F Y | g:i a')."'>";
			$vprocessed .= esc_html($vitem->get_title())."</a></li>";
		}
		$vprocessed .= "</ul>";
	}
	return $vprocessed;
} }

// Download Page Function
// ----------------------
if (!function_exists('prn_download_url')) {
function prn_download_url($vurl) {
	$vch = curl_init();
	curl_setopt($vch, CURLOPT_URL,$vurl);
	curl_setopt($vch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($vch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($vch, CURLOPT_TIMEOUT, 20);
	$vurlcontents = curl_exec($vch);
	$vhttp_code = curl_getinfo($vch, CURLINFO_HTTP_CODE);
	curl_close ($vch); unset($vch);

	if ($vhttp_code == 200) {return $vurlcontents;}
} }

// ---------------------
// === FLOATING MENU ===
// ---------------------

if (!function_exists('prn_sidebar_get_floatmenuscript')) {
	function prn_sidebar_get_floatmenuscript() {
		return "
		<style>.floatbox {position:absolute;width:250px;top:30px;right:15px;z-index:100;}</style>

		<script language='javascript' type='text/javascript'>
		/* Script by: www.jtricks.com
		 * Version: 1.8 (20111103)
		 * Latest version: www.jtricks.com/javascript/navigation/floating.html
		 *
		 * License:
		 * GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
		 */
		var floatingMenu =
		{
		    hasInner: typeof(window.innerWidth) == 'number',
		    hasElement: typeof(document.documentElement) == 'object'
			&& typeof(document.documentElement.clientWidth) == 'number'
		};

		var floatingArray =
		[
		];

		floatingMenu.add = function(obj, options)
		{
		    var name;  var menu;
		    if (typeof(obj) === 'string') name = obj; else menu = obj;
		    if (options == undefined) {
			floatingArray.push( {id: name, menu: menu, targetLeft: 0, targetTop: 0, distance: .07, snap: true});
		    }
		    else  {
			floatingArray.push(
			    {id: name, menu: menu, targetLeft: options.targetLeft, targetRight: options.targetRight,
				targetTop: options.targetTop, targetBottom: options.targetBottom, centerX: options.centerX,
				centerY: options.centerY, prohibitXMovement: options.prohibitXMovement,
				prohibitYMovement: options.prohibitYMovement, distance: options.distance != undefined ? options.distance : .07,
				snap: options.snap, ignoreParentDimensions: options.ignoreParentDimensions, scrollContainer: options.scrollContainer,
				scrollContainerId: options.scrollContainerId
			    });
		    }
		};

		floatingMenu.findSingle = function(item) {
		    if (item.id) item.menu = document.getElementById(item.id);
		    if (item.scrollContainerId) item.scrollContainer = document.getElementById(item.scrollContainerId);
		};

		floatingMenu.move = function (item) {
		    if (!item.prohibitXMovement) {item.menu.style.left = item.nextX + 'px'; item.menu.style.right = '';}
		    if (!item.prohibitYMovement) {item.menu.style.top = item.nextY + 'px'; item.menu.style.bottom = '';}
		};

		floatingMenu.scrollLeft = function(item) {
		    // If floating within scrollable container use it's scrollLeft
		    if (item.scrollContainer) return item.scrollContainer.scrollLeft;
		    var w = window.top; return this.hasInner ? w.pageXOffset : this.hasElement
			  ? w.document.documentElement.scrollLeft : w.document.body.scrollLeft;
		};
		floatingMenu.scrollTop = function(item) {
		    // If floating within scrollable container use it's scrollTop
		    if (item.scrollContainer)
			return item.scrollContainer.scrollTop;
		    var w = window.top; return this.hasInner ? w.pageYOffset : this.hasElement
			  ? w.document.documentElement.scrollTop : w.document.body.scrollTop;
		};
		floatingMenu.windowWidth = function() {
		    return this.hasElement ? document.documentElement.clientWidth : document.body.clientWidth;
		};
		floatingMenu.windowHeight = function() {
		    if (floatingMenu.hasElement && floatingMenu.hasInner) {
			// Handle Opera 8 problems
			return document.documentElement.clientHeight > window.innerHeight
			    ? window.innerHeight : document.documentElement.clientHeight
		    }
		    else {
			return floatingMenu.hasElement ? document.documentElement.clientHeight : document.body.clientHeight;
		    }
		};
		floatingMenu.documentHeight = function() {
		    var innerHeight = this.hasInner ? window.innerHeight : 0;
		    var body = document.body, html = document.documentElement;
		    return Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight,
			html.scrollHeight, html.offsetHeight, innerHeight);
		};
		floatingMenu.documentWidth = function() {
		    var innerWidth = this.hasInner ? window.innerWidth : 0;
		    var body = document.body, html = document.documentElement;
		    return Math.max(body.scrollWidth, body.offsetWidth, html.clientWidth, html.scrollWidth, html.offsetWidth,
			innerWidth);
		};
		floatingMenu.calculateCornerX = function(item) {
		    var offsetWidth = item.menu.offsetWidth;
		    if (item.centerX)
			return this.scrollLeft(item) + (this.windowWidth() - offsetWidth)/2;
		    var result = this.scrollLeft(item) - item.parentLeft;
		    if (item.targetLeft == undefined) {result += this.windowWidth() - item.targetRight - offsetWidth;}
		    else {result += item.targetLeft;}
		    if (document.body != item.menu.parentNode && result + offsetWidth >= item.confinedWidthReserve)
		    {result = item.confinedWidthReserve - offsetWidth;}
		    if (result < 0) result = 0;
		    return result;
		};
		floatingMenu.calculateCornerY = function(item) {
		    var offsetHeight = item.menu.offsetHeight;
		    if (item.centerY) return this.scrollTop(item) + (this.windowHeight() - offsetHeight)/2;
		    var result = this.scrollTop(item) - item.parentTop;
		    if (item.targetTop === undefined) {result += this.windowHeight() - item.targetBottom - offsetHeight;}
		    else {result += item.targetTop;}

		    if (document.body != item.menu.parentNode && result + offsetHeight >= item.confinedHeightReserve) {
			result = item.confinedHeightReserve - offsetHeight;
		    }

		    if (result < 0) result = 0;
		    return result;
		};
		floatingMenu.computeParent = function(item) {
		    if (item.ignoreParentDimensions) {
			item.confinedHeightReserve = this.documentHeight(); item.confinedWidthReserver = this.documentWidth();
			item.parentLeft = 0; item.parentTop = 0; return;
		    }
		    var parentNode = item.menu.parentNode; var parentOffsets = this.offsets(parentNode, item);
		    item.parentLeft = parentOffsets.left; item.parentTop = parentOffsets.top;
		    item.confinedWidthReserve = parentNode.clientWidth;

		    // We could have absolutely-positioned DIV wrapped
		    // inside relatively-positioned. Then parent might not
		    // have any height. Try to find parent that has
		    // and try to find whats left of its height for us.
		    var obj = parentNode; var objOffsets = this.offsets(obj, item);
		    while (obj.clientHeight + objOffsets.top < item.menu.offsetHeight + parentOffsets.top) {
			obj = obj.parentNode; objOffsets = this.offsets(obj, item);
		    }
		    item.confinedHeightReserve = obj.clientHeight - (parentOffsets.top - objOffsets.top);
		};
		floatingMenu.offsets = function(obj, item)
		{
		    var result = {left: 0, top: 0};
		    if (obj === item.scrollContainer) return;
		    while (obj.offsetParent && obj.offsetParent != item.scrollContainer) {
			result.left += obj.offsetLeft; result.top += obj.offsetTop; obj = obj.offsetParent;
		    }
		    if (window == window.top) return result;

		    // we are IFRAMEd
		    var iframes = window.top.document.body.getElementsByTagName('IFRAME');
		    for (var i = 0; i < iframes.length; i++)
		    {
			if (iframes[i].contentWindow != window) continue;
			obj = iframes[i];
			while (obj.offsetParent) {
			    result.left += obj.offsetLeft; result.top += obj.offsetTop; obj = obj.offsetParent;
			}
		    }
		    return result;
		};
		floatingMenu.doFloatSingle = function(item) {
		    this.findSingle(item); var stepX, stepY; this.computeParent(item);
		    var cornerX = this.calculateCornerX(item); var stepX = (cornerX - item.nextX) * item.distance;
		    if (Math.abs(stepX) < .5 && item.snap || Math.abs(cornerX - item.nextX) == 1) {
			stepX = cornerX - item.nextX;
		    }
		    var cornerY = this.calculateCornerY(item);
		    var stepY = (cornerY - item.nextY) * item.distance;
		    if (Math.abs(stepY) < .5 && item.snap || Math.abs(cornerY - item.nextY) == 1) {
			stepY = cornerY - item.nextY;
		    }
		    if (Math.abs(stepX) > 0 || Math.abs(stepY) > 0) {
			item.nextX += stepX; item.nextY += stepY; this.move(item);
		    }
		};
		floatingMenu.fixTargets = function() {};
		floatingMenu.fixTarget = function(item) {};
		floatingMenu.doFloat = function() {
		    this.fixTargets();
		    for (var i=0; i < floatingArray.length; i++) {
			this.fixTarget(floatingArray[i]); this.doFloatSingle(floatingArray[i]);
		    }
		    setTimeout('floatingMenu.doFloat()', 20);
		};
		floatingMenu.insertEvent = function(element, event, handler) {
		    // W3C
		    if (element.addEventListener != undefined) {
			element.addEventListener(event, handler, false); return;
		    }
		    var listener = 'on' + event;
		    // MS
		    if (element.attachEvent != undefined) {
			element.attachEvent(listener, handler);
			return;
		    }
		    // Fallback
		    var oldHandler = element[listener];
		    element[listener] = function (e) {
			    e = (e) ? e : window.event;
			    var result = handler(e);
			    return (oldHandler != undefined)
				&& (oldHandler(e) == true)
				&& (result == true);
			};
		};

		floatingMenu.init = function() {
		    floatingMenu.fixTargets();
		    for (var i=0; i < floatingArray.length; i++) {
			floatingMenu.initSingleMenu(floatingArray[i]);
		    }
		    setTimeout('floatingMenu.doFloat()', 100);
		};
		// Some browsers init scrollbars only after
		// full document load.
		floatingMenu.initSingleMenu = function(item) {
		    this.findSingle(item); this.computeParent(item); this.fixTarget(item); item.nextX = this.calculateCornerX(item);
		    item.nextY = this.calculateCornerY(item); this.move(item);
		};
		floatingMenu.insertEvent(window, 'load', floatingMenu.init);

		// Register ourselves as jQuery plugin if jQuery is present
		if (typeof(jQuery) !== 'undefined') {
		    (function ($) {
			$.fn.addFloating = function(options) {
			    return this.each(function() {
				floatingMenu.add(this, options);
			    });
			};
		    }) (jQuery);
		}
		</script>";
	}
}

?>