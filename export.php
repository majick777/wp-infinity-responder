<?php

	// To Export Subscribers from an existing Infinity Responder list,
	// PASTE OVER (non-)existing functions for list_export and list_export_do
	// in your admin.php file in your old Infinity Responder installation
	// You can then call admin.php?action=list_export in your browser

	elseif  ($action == "list_export") {
		# List export

		echo '<table width="550" bgcolor="##1EABDF" cellpadding="0" cellspacing="3" style="border: 1px solid #000000;">';
		echo '<tr><td><p align="center" style="font-size: 18px"><font color="#FFFFFF">Export Subscribers</font></p> </td> </tr></table><br>';

		echo "<tr><td><form method='post'><table><tr>";
		echo "<td><b>Export Subscribers From:</b></td><td width=20></td>";
		echo "<td><input type='hidden' name='action' value='list_export_do'>";
		ResponderPulldown('r_ID');
		echo "</td></tr><tr height=10><td></td></tr>";
		echo "<tr><td>Only Export Confirmed Subscribers?</td><td width=20></td>":
		echo "<td><input type='checkbox' name='exportconfirmed' value='yes'> (Double Optin Lists Only)</td></tr>";
		echo "<tr height=10><td></td></tr>";
		echo "<tr><td></td><td align='center'><input type='submit' value='Export Subscriber(s)'></td></tr>";
		echo "</table><br>";

		$return_action = "list";
		include('templates/back_button.admin.php');
		echo "</td></tr></table>";
	}
	elseif  ($action == "list_export_do") {
		# List export output

		echo "<h3>Exported List</h3>";

		if ($_POST['exportconfirmed'] == 'yes') {
			$query = "SELECT * FROM InfResp_subscribers WHERE Confirmed = '1' AND ResponderID = '".$ResponderID."'";
			$DB_Subscriber_Result = mysql_query($query) or die("Invalid query: " . mysql_error());
		}
		else {
			$query = "SELECT * FROM InfResp_subscribers WHERE ResponderID = '".$ResponderID."'";
			$DB_Subscriber_Result = mysql_query($query) or die("Invalid query: " . mysql_error());
		}

		for ($i=0; $i < mysql_num_rows($DB_Subscriber_Result); $i++) {
			$this_row = mysql_fetch_assoc($DB_Subscriber_Result);
			$list_data .= $this_row['EmailAddress'];
			$list_data .= ",".$this_row['FirstName'];
			$list_data .= ",".$this_row['LastName'];
			$list_data .= ",".$this_row['CanReceiveHTML'];
			$list_data .= ",".$this_row['Confirmed'];
			$list_data .= ",".$this_row['IP_Addy'];
			$list_data .= ",".$this_row['ReferralSource'];
			$list_data .= ",".$this_row['UniqueCode'];
			$list_data .= ",".str_replace(',','|',$this_row['SentMsgs']);
			$list_data .= ",".$this_row['TimeJoined'];
			$list_data .= ",".$this_row['Real_TimeJoined'];
			$list_data .= ",".$this_row['LastActivity'];
			$list_data .= PHP_EOL;
		}
		mysql_free_result($DB_Subscriber_Result);

		echo "Format: Email,Firstname,Lastname,HTML,Confirmed,IP,RefSource,<br>";
		echo "SentMessages,JoinedTime,RealJoinedTime,LastActivityTime<br><br>";

		echo "<textarea rows=20 cols=80>".$list_data."</textarea>";

		# FIle Link
		umask(0000);
		if (is_dir(dirname(__FILE__).'/exported')) {@chmod(dirname(__FILE__).'/exported',0755);}
		else {@mkdir(dirname(__FILE__).'/exported',0755); @chmod(dirname(__FILE__).'/exported',0755);}

		$file_name = "ExportedResponder".$ResponderID."-".date('Y-m-d').".csv";
		$export_file = dirname(__FILE__).'/exported/'.$file_name;
		$fh = fopen($export_file,'w');
		fwrite($fh,$list_data);
		fclose($fh);

		echo "<br><br><a href='".$siteURL.$ResponderDirectory.'/exported/'.$file_name."' target=_blank>CSV File Download Link</a><br>";

		$return_action = "list";
		include('templates/back_button.admin.php');
	}
?>