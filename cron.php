<?php
# Modified 04/29/2013 by Plugin Review Network

if (!function_exists('add_action')) {die();}
include_once('config.php');

global $table_prefix;
$infrespconfig = $table_prefix.'InfResp_config';

if (current_user_can('manage_options')) {

	# Top template
	include('templates/open.page.php');

	$vsecretkey = get_option('inf_resp_cron_key');
	
	$vsiteurl = site_url();
	$vphppaths = explode(":",$_SERVER['PATH']);
	foreach ($vphppaths as $vapath) {
		if ($vapath != "") {
			if (strstr('/usr/bin',$vapath)) {$vphppath = "/usr/bin/php";}
			if (strstr('/usr/local/bin',$vapath)) {$vphppath = "/usr/local/bin/php";}
		}
	}
	$vcronurl = WP_PLUGIN_URL."/wp-infinity-responder/sendmails.php";
	$vfullcronurl = $vsiteurl."/?ir=sendmail";
	
	?>
				
	<table width="550" border="0" cellspacing="5" cellpadding="1" style="border: 1px solid #000000;">
	<tr height="54">
	  <td colspan="2" bgcolor="#1EABDF">
	      <font color="#FFFFFF" style="font-size:18px;" face="Tahoma, Arial, Helvetica">
	         <center>Cron Job</center>
	      </font>
	  </td>
	</tr>
	<tr>
	  <td>

	<?php 
	
	echo "Here you can set up a Cron Job (scheduled task) to send out regular mailings...<br><br>";
	
	$vfrequency = get_option('inf_resp_wpcron_frequency');
	echo "The first option is to set a Cron Job interval for sendmails via WP Cron.<br>";
	echo "While easier to setup WP Cron is a pseudo-cron not an exactly timed one.<br>";
	echo "<form method='post' action='admin.php?page=infinityresponder&subpage=cron'>";
	echo "<center><table><tr><td><font style='font-weight:bold;'>Frequency: </td>";
	echo "<td width='10'></td><td><input type='hidden' name='inf_resp_update_wpcron' value='yes'>";
	echo "<select name='wpcron_frequency'>";
	echo "<option value='off'"; if ($vfrequency == 'off') {echo " selected='selected'";} echo ">OFF</option>";
	echo "<option value='5minutes'"; if ($vfrequency == '5minutes') {echo " selected='selected'";} echo ">Every 5 minutes</option>";
	echo "<option value='10minutes'"; if ($vfrequency == '10minutes') {echo " selected='selected'";} echo ">Every 10 minutes</option>";
	echo "<option value='15minutes'"; if ($vfrequency == '15minutes') {echo " selected='selected'";} echo ">Every 15 minutes</option>";
	echo "<option value='20minutes'"; if ($vfrequency == '20minutes') {echo " selected='selected'";} echo ">Every 20 minutes</option>";
	echo "<option value='30minutes'"; if ($vfrequency == '30minutes') {echo " selected='selected'";} echo ">Every 30 minutes</option>";
	echo "<option value='hourly'"; if ($vfrequency == 'hourly') {echo " selected='selected'";} echo ">Hourly</option>";
	echo "<option value='2hours'"; if ($vfrequency == '2hours') {echo " selected='selected'";} echo ">Every 2 Hours</option>";
	echo "<option value='3hours'"; if ($vfrequency == '3hours') {echo " selected='selected'";} echo ">Every 3 Hours</option>";
	echo "<option value='6hours'"; if ($vfrequency == '6hours') {echo " selected='selected'";} echo ">Every 6 Hours</option>";
	echo "<option value='twicedaily'"; if ($vfrequency == 'twicedaily') {echo " selected='selected'";} echo ">Every 12 Hours</option>";
	echo "<option value='daily'"; if ($vfrequency == 'daily') {echo " selected='selected'";} echo ">Daily</option></select>";
	echo "</td><td width='10'></td><td>";
	echo "<input type='submit' class='button-primary' value='Update WP Cron Setting'>";
	echo "</td></tr></table></center></form><br><br>";
		
	// 5minutes,10minutes,15minutes,20minutes,30minutes,hourly,2hours,3hours,6hours,twicedaily,daily
	
	echo "Alternatively you can trigger Infinity Responder sendmails via a standard Cron Job.<br>";	
	echo "Probably easiest to just set the schedule to every five or ten minutes,<br>";
	echo "and adjust the emails per run value in your Config to suit your hosting.<br>";
	echo "eg. */5 * * * * or */10 * * * *<br><br>";
	
	echo "You should be able to just copy and paste one of the following cron lines into your Cpanel.<br><br>";

	echo "Using Curl:";
	// echo "<div id='cron' style='width:400px;'><textarea readonly rows=3 cols=60 style='width:400px; font-face:helvetica;font-size:9pt;font-weight:bold;' id='cronline' onclick='selectcronline();'>curl -A 'Mozilla/5.0' '".$vcronurl."' >".ABSPATH."wp_ir_cron.html</textarea></div>";
	// echo "or just<br>";
	echo "<div id='cron' style='width:400px;'><textarea readonly rows=3 cols=60 style='width:400px; font-face:helvetica;font-size:9pt;font-weight:bold;' id='cronlineb' onclick='selectcronlineb();'>curl -A 'Mozilla/5.0' '".$vfullcronurl."' >/dev/null</textarea></div><br>";
	echo "Using PHP:<br>";
	echo "<div id='cron' style='width:400px;'><textarea readonly rows=3 cols=60 style='width:400px; font-face:helvetica;font-size:9pt;font-weight:bold;' id='cronlinec' onclick='selectcronlinec();'>".$vphppath." ".$vcronurl." >/dev/null</textarea></div><br>";

	echo "<font style='font-weight:bold;'>Cron Output</font> (Optional)<br>";
	echo "For security purposes, you need to set a Secret Key to generate output,<br>";
	echo "otherwise, you can call sendmails without it as above with no output.<br>";
	echo "(Note: generating an output can be handy for testing purposes!)<br><br>";
	
	echo "<form action='?page=infinityresponder&subpage=cron' method='post'>";
	echo "<input type='hidden' name='inf_resp_update_cron_key' value='yes'>";
	echo "<table><tr><td><font style='font-weight:bold;'>Secret Key</font> (alphanumeric): </td><td width='10'></td>";
	echo "<td><input type='text' size='20' maxlength='24' name='inf_resp_secret_cron_key' value='".$vsecretkey."'></td><td width='10'></td>";
	echo "<td><input type='submit' class='button-primary' value='Save Secret Key'></td></tr></table></form><br><br>";
	
	if ($vsecretkey != '') {
		echo "Using Curl:";
		echo "<div id='cron' style='width:400px;'><textarea readonly rows=3 cols=60 style='width:400px; font-face:helvetica;font-size:9pt;font-weight:bold;' id='cronlined' onclick='selectcronlined();'>curl -A 'Mozilla/5.0' '".$vfullcronurl."&cronkey=".$vsecretkey." >".ABSPATH."wpir_cron.html</textarea></div><br>";
		echo "Using PHP:<br>";
		echo "<div id='cron' style='width:400px;'><textarea readonly rows=3 cols=60 style='width:400px; font-face:helvetica;font-size:9pt;font-weight:bold;' id='cronlinee' onclick='selectcronlinee();'>".$vphppath." ".$vcronurl." ".$vsecretkey." >".ABSPATH."wpir_cron.html</textarea></div><br>";
		
		echo "This will mean you should be able to see the latest sendmails output at:<br>";
		echo "<a href='".$vsiteurl."/wp_ir_cron.html' target=_blank>".$vsiteurl."/wpir_cron.html</a> (or whatever path/filename you chose.)<br>";
		echo "You can always nullify this output later by using &gt;/dev/null instead.<br><br>";
	}
	else {echo "<i>Cron lines implementing the Secret Key will appear upon saving.</i><br>";}
	
	echo "<br>";	
	echo "Lost? Confused? <a href='javascript:void(0);' onclick='document.getElementById(\"originalnotes\").style.display=\"\";'>Click here to read the original Infinity Responder cron notes.</a><br><br>";
	
	echo "<script type='text/javascript'>
	function selectcronline() {document.getElementById('cronline').focus();document.getElementById('cronline').select();} 
	function selectcronlineb() {document.getElementById('cronlineb').focus();document.getElementById('cronlineb').select();}
	function selectcronlinec() {document.getElementById('cronlinec').focus();document.getElementById('cronlinec').select();}
	function selectcronlined() {document.getElementById('cronlined').focus();document.getElementById('cronlined').select();}
	function selectcronlinee() {document.getElementById('cronlinee').focus();document.getElementById('cronlinee').select();}
	document.getElementById('cronlineb').select();
	</script>";
	
?>

	<div id="originalnotes" style="display:none;"><p><b>Cron notes from the original Infinity Responder manual:</b></p>

	Crontab is an program that runs the background of most unix servers. All it does it wait for timing instructions and runs things according to the schedule. You can change your scheduled crontabs by running.</p>

	<p>crontab -e</p>

	<p>From a *nix command line. Also, a lot of hosts offer a crontab utility that gives you access to the crontab from a control panel. Setting up a crontab manually isn't simple if you have no unix experience. It's doubly difficult as the standard editor is VI, a very complex editor that is difficult for beginners to learn.</p>

	<p>
	Once you get into the crontab edit you need to figure out 4 things:<br />
	How often do you want it ran?<br />
	How do you want to run it?<br />
	And where is the file you want to run?<br />
	Where do you want output to go?<br />
	<p>

	<p>
	1)<br />
	The first is the most complex. There are 5 time entries to crontab. The last 3 are day settings, and as they're not often enough for this script we're going to leave them as just *'s.
	</p>

	<p>This leaves you with:<br />
	minutes hours * * *</p>

	<p>Minutes is the minutes that you want to run the script on. Hours is the hours.</p>

	<p>Lets say you want to run the script at 3:30 every morning:<br />
	30 3 * * *</p>

	<p>30 minutes at 3 o'clock, every day.</p>

	<p>If you only want to run it every hour, do this:<br />
	0 1-24 * * *</p>

	<p>That's at the zero minute marker of every hour.</p>

	<p>Some people suggest that you run it constantly with:<br />
	* * * * *</p>

	<p>But in my experience this risks putting a high load on your server if you have a lot users, messages, responders or mails to sort thru. There are 1440 minutes in a day, there is no reason to run it this script 1440 times per day.</p>

	<p>Most of the time 10 minute intrevals are enough:<br />
	00,10,20,30,40,50 * * * * </p>

	<p>That only runs it 144 times per day, which should be enough and not put too much stress on the machine.</p>

	<p>If you've got a small list or need to check things more often try this:<br />
	0,5,10,15,20,25,30,35,40,45,50,55 * * * *</p>

	<p>While that's a big long, it runs the script every 5 minutes. That's 12 times an hour or 288 times per day. </p>

	<p>2)<br />
	The second thing you need to know is how you're going to call the script. You can set up a seperate shell script or CGI wrapper if you need to, but again... if you don't have a lot of unix experience then doing this would be very time consuming.</p>

	<p>You can call the PHP file directly by calling PHP. Depending on how crontab is ran, you may be able to do this by just using:<br />
	PHP sendmails.php</p>

	<p>But that's not likely. You can also use lynx if you have it available with:</br>
	lynx -dump http://www.yourdomain.com/responder/sendmails.php</p>

	<p>That works very well, but it does take some time to load lynx. This isn't enough to stop you on a small list, but on a big list... or on a server without lynx, you'll need to do it another way.</p>

	<p>The easiest and quickest way is to call PHP by it's complete path name with:<br />
	/usr/local/bin/php sendmails.php</p>

	<p>Again, that will depend on where your php is. You can find either lynx or php with the whereis command.</p>

	<p>Just type:<br />
	whereis php<br />
	or<br />
	whereis lynx<p>

	<p>From the command line. If you don't have whereis then ask your admin or tech support.</p>

	<p>3)<br />
	Where the file you're running is. This is important because cron won't run things from the directory you want it to. It needs the full path of the filename in almost every setup. This isn't a problem. You can get the name of full system path of the install from the first line in the config menu.</p>

	<p>It'll look like:<br />
	/home/user/www/responder</p>

	<p>Then just tack on the name of the script at the end like this:<br />
	/home/user/www/responder/sendmails.php</p>

	<p>Simple enough.</p>

	<p>4)<br />
	Now, where do you want output to go? By default, most systems will send it to your email address. You don't want this. Why? Because you'll get an email each and every time it runs. Do you want 300 emails per day telling you that it actually ran your crontab? Yea. I wouldn't either.</p>

	<p>At the end of the filename this: <br />
	 > /home/user/www/responder/cron.log</p>

	<p>And all information will be sent to cron.log Or, if you don't want to use a file (I wouldn't, it takes up space) just send it to a special "black hole" file.<br />
	 > /dev/null</p>

	<p>Putting it all together:<br />
	Now just add all of it together.</p>

	<p>0,5,10,15,20,25,30,35,40,45,50,55 * * * * /usr/local/bin/php /home/user/www/responder/sendmails.php > /dev/null</p>

	<p>That runs your script thru PHP every 5 minutes and drops the the output into the great void.</p>

	<p>A convenient resource for this can be found at:<br />
	<A HREF="http://htmlbasix.com/crontab.shtml" target="_blank">http://htmlbasix.com/crontab.shtml</A></p>
	</div>
	<br>

  </td>
 </tr>
</table>

<?php 

	# Display back to admin button
	include('templates/back_button.config.php');

	# Display the bottom template
	include('templates/close.page.php');
}
else  {admin_redirect();}

DB_disconnect();
?>