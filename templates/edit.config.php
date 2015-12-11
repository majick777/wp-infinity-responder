<?php
# Modified 04/29/2014 by Plugin Review Network
# Modified by Infinity Responder development team: 2009-06-04

    $charset = $config['charset'];
    $charset_selected[$charset] = " SELECTED";
    if ($config['autocall_sendmails'] == "1") {
         $acs_1 = " CHECKED";
         $acs_2 = "";
    }
    else {
         $acs_1 = "";
         $acs_2 = " CHECKED";
    }
    if ($config['check_mail'] == "1") {
         $chk_m1 = " CHECKED";
         $chk_m2 = "";
    }
    else {
         $chk_m1 = "";
         $chk_m2 = " CHECKED";
    }
    if ($config['check_bounces'] == "1") {
         $chk_b1 = " CHECKED";
         $chk_b2 = "";
    }
    else {
         $chk_b1 = "";
         $chk_b2 = " CHECKED";
    }

    $mce_0 = ""; $mce_1 = ""; $mce_2 = ""; $mce_3 = ""; $mce_4 = "";
    if ($config['tinyMCE'] == "4") {$mce_4 = " CHECKED";}
    if ($config['tinyMCE'] == "3") {$mce_3 = " CHECKED";}
    if ($config['tinyMCE'] == "2") {$mce_2 = " CHECKED";}
    if ($config['tinyMCE'] == "1") {$mce_1 = " CHECKED";}
    if ($config['tinyMCE'] == "0") {$mce_0 = " CHECKED";}

    # Subs per page
    $blah = $config['subs_per_page'];
    $sbp[10]    = "";
    $sbp[25]    = "";
    $sbp[50]    = "";
    $sbp[75]    = "";
    $sbp[100]   = "";
    $sbp[250]   = "";
    $sbp[1000]  = "";
    $sbp[5000]  = "";
    $sbp[10000] = "";
    $sbp[$blah] = " SELECTED";

    # Add sub size
    $blah = $config['add_sub_size'];
    $asz[1]   = "";
    $asz[3]   = "";
    $asz[5]   = "";
    $asz[10]  = "";
    $asz[15]  = "";
    $asz[20]  = "";
    $asz[25]  = "";
    $asz[50]  = "";
    $asz[100] = "";
    $asz[$blah] = " SELECTED";

    // include_once('popup_js.php');
?>

<table cellpadding="0" cellspacing="0" border="0">
   <tr>
      <td width="550">
         &nbsp;
      </td>
      <td>
         <a href="manual.html#configure" onclick="return popper('manual.html#configure')">Help</a>
      </td>
   </tr>
</table>
<br />

<!-- MOD Action to Wordpress Menu -->
<FORM action="" method=POST>
<table width="550" border="0" cellspacing="5" cellpadding="1" style="border: 1px solid #000000;">
<tr height="54">
  <td colspan="2" bgcolor="#1EABDF">
      <font color="#FFFFFF" style="font-size:18px;" face="Tahoma, Arial, Helvetica">
         <center>Edit Configuration</center>
      </font>
  </td>
</tr>
<tr>
  <td width="300" colspan="2">
    <strong>
      <font color="#000000" face="arial" size="2">
        System Directory for this Install:
      </font>
    </strong>
    <br>
    <strong><?php echo WP_PLUGIN_DIR."/wp-infinity-responder"; // echo $abs_directory; ?></strong>
  </td>
</tr>
<tr>
  <td width="300" colspan="2">
    <strong>
      <font color="#000000" face="arial" size="2">
        Infinity Responder URL:
      </font>
    </strong>
    <br>
    <input maxlength="95" size="80" name="infinityURL" value="<?php echo $config['infinityURL']; ?>">
  </td>
</tr>
<tr>
  <td width="300">
    <strong>
      <font color="#000000" face="arial" size="2">
          Character Set:
      </font>
    </strong>
  </td>
  <td>
    <select name="charset">
         <OPTION value="ISO-8859-1"<?php echo $charset_selected['ISO-8859-1']; ?>>ISO-8859-1</option>
         <OPTION value="ISO-8859-15"<?php echo $charset_selected['ISO-8859-15']; ?>>ISO-8859-15</option>
         <OPTION value="UTF-8"<?php echo $charset_selected['UTF-8']; ?>>UTF-8</option>
         <OPTION value="cp866"<?php echo $charset_selected['cp866']; ?>>cp866</option>
         <OPTION value="cp1251"<?php echo $charset_selected['cp1251']; ?>>cp1251</option>
         <OPTION value="cp1252"<?php echo $charset_selected['cp1252']; ?>>cp1252</option>
         <OPTION value="KOI8-R"<?php echo $charset_selected['KOI8-R']; ?>>KOI8-R</option>
         <OPTION value="BIG5"<?php echo $charset_selected['BIG5']; ?>>BIG5</option>
         <OPTION value="GB2312"<?php echo $charset_selected['GB2312']; ?>>GB2312</option>
         <OPTION value="BIG5-HKSCS"<?php echo $charset_selected['BIG5-HKSCS']; ?>>BIG5-HKSCS</option>
         <OPTION value="Shift_JIS"<?php echo $charset_selected['Shift_JIS']; ?>>Shift_JIS</option>
         <OPTION value="EUC-JP"<?php echo $charset_selected['EUC-JP']; ?>>EUC-JP</option>
    </select>
  </td>
</tr>
<tr height="10"><td> </td></tr>
<tr>
  <td width="300">
    <strong>
      <font color="#000000" face="arial" size="2">
        Max Sends per Sendmails Run:
      </font>
    </strong>
  </td>
  <td>
    <input maxlength="95" size="10" name="max_send_count" value="<?php echo $config['max_send_count']; ?>">
  </td>
</tr>
<tr>
  <td width="300">
    <strong>
      <font color="#000000" face="arial" size="2">
        Daily Send Limit:
      </font>
    </strong>
  </td>
  <td>
    <input maxlength="95" size="10" name="daily_limit" value="<?php echo $config['daily_limit']; ?>">
  </td>
</tr>
<tr>
  <td width="300">
    <strong>
      <font color="#000000" face="arial" size="2">
          Months of Inactivity that Trims:
      </font>
    </strong>
  </td>
  <td>
    <input maxlength="10" size="2" name="last_activity_trim" value="<?php echo $config['last_activity_trim']; ?>"> months (0 disables)
  </td>
</tr>
<tr height="10"><td> </td></tr>
<tr>
  <td width="300">
    <strong>
      <font color="#000000" face="arial" size="2">
          Check Mail on sendmails.php:
      </font>
    </strong>
  </td>
  <td>
    <input type="RADIO" name="check_mail" value="1"<?php echo $chk_m1; ?>> Yes &nbsp;
    <input type="RADIO" name="check_mail" value="0"<?php echo $chk_m2; ?>> No
  </td>
</tr>
<tr>
  <td width="300">
    <strong>
      <font color="#000000" face="arial" size="2">
          Check Bounces on sendmails.php:
      </font>
    </strong>
  </td>
  <td>
    <input type="RADIO" name="check_bounces" value="1"<?php echo $chk_b1; ?>> Yes &nbsp;
    <input type="RADIO" name="check_bounces" value="0"<?php echo $chk_b2; ?>> No
  </td>
</tr>
<tr>
  <td width="300">
    <strong>
      <font color="#000000" face="arial" size="2">
          Autocall sendmails.php on Subscribe:
      </font>
    </strong>
  </td>
  <td>
    <input type="RADIO" name="autocall_sendmails" value="1"<?php echo $acs_1; ?>> Yes &nbsp;
    <input type="RADIO" name="autocall_sendmails" value="0"<?php echo $acs_2; ?>> No
  </td>
</tr>
<tr>
  <td width="300" style="vertical-align:top;">
    <strong>
      <font color="#000000" face="arial" size="2">
          HTML Message Editor:
      </font>
    </strong>
  </td>
  <td>
    <input type="RADIO" name="tinyMCE" value="4"<?php echo $mce_4; ?>> NicEdit<br>
  	<input type="RADIO" name="tinyMCE" value="3"<?php echo $mce_3; ?>> TinyEditor<br>
    <input type="RADIO" name="tinyMCE" value="2"<?php echo $mce_2; ?>> TinyMCE 4<br>
    <input type="RADIO" name="tinyMCE" value="1"<?php echo $mce_1; ?>> TinyMCE 2<br>
    <input type="RADIO" name="tinyMCE" value="0"<?php echo $mce_0; ?>> Off (Use Source Code)
  </td>
</tr>
<tr height="10"><td> </td></tr>
<tr>
  <td width="300">
    <strong>
      <font color="#000000" face="arial" size="2">
          Lines on the Subscriber Add Page:
      </font>
    </strong>
  </td>
  <td>
    <select name="add_sub_size">
         <OPTION value="1"<?php echo $asz[1]; ?>>1</option>
         <OPTION value="3"<?php echo $asz[3]; ?>>3</option>
         <OPTION value="5"<?php echo $asz[5]; ?>>5</option>
         <OPTION value="10"<?php echo $asz[10]; ?>>10</option>
         <OPTION value="15"<?php echo $asz[15]; ?>>15</option>
         <OPTION value="20"<?php echo $asz[20]; ?>>20</option>
         <OPTION value="25"<?php echo $asz[25]; ?>>25</option>
         <OPTION value="50"<?php echo $asz[50]; ?>>50</option>
         <OPTION value="100"<?php echo $asz[100]; ?>>100</option>
    </select>
  </td>
</tr>
<tr>
  <td width="300">
    <strong>
      <font color="#000000" face="arial" size="2">
          Subscribers per page on Subscriber List:
      </font>
    </strong>
  </td>
  <td>
    <select name="subs_per_page">
         <OPTION value="10"<?php echo $sbp[10]; ?>>10</option>
         <OPTION value="25"<?php echo $sbp[25]; ?>>25</option>
         <OPTION value="50"<?php echo $sbp[50]; ?>>50</option>
         <OPTION value="75"<?php echo $sbp[75]; ?>>75</option>
         <OPTION value="100"<?php echo $sbp[100]; ?>>100</option>
         <OPTION value="250"<?php echo $sbp[250]; ?>>250</option>
         <OPTION value="500"<?php echo $sbp[500]; ?>>500</option>
         <OPTION value="1000"<?php echo $sbp[1000]; ?>>1000</option>
         <OPTION value="5000"<?php echo $sbp[5000]; ?>>5000</option>
         <OPTION value="10000"<?php echo $sbp[10000]; ?>>10000</option>
    </select>
  </td>
</tr>
<?php
# MOD remove sitecode
//  <tr>
//   <td width="300">
//     <strong>
//       <font color="#000000" face="arial" size="2">
//           Site Code:
//       </font>
//     </strong>
//   </td>
//   <td>
//     <input maxlength="200" size="50" name="site_code" value="<!-- php echo $config['site_code']; -->">
//   </td>
// </tr>
# MOD Remove username and password
// <tr>
//   <td width="300">
//     <strong>
//       <font color="#000000" face="arial" size="2">
//           Admin username:
//       </font>
//     </strong>
//   </td>
//   <td>
//     <input maxlength="100" size="50" name="admin_user" value="<!-- php echo $config['admin_user']; -->">
//   </td>
// </tr>
// <tr>
//   <td width="300">
//     <strong>
//       <font color="#000000" face="arial" size="2">
//           Admin password:
//       </font>
//     </strong>
//   </td>
//   <td>
//     <input maxlength="100" size="50" name="admin_pass" value="<!-- php echo $config['admin_pass']; -->">
//   </td>
// </tr>
?>
 <!-- MOD New Mailer Options -->
 <tr height="15"><td> </td></tr>
 <tr>
  <td colspan="2" align="center">
 	<strong><font face="arial" size="3">Mailer Options</font></strong>
  </td>
 </tr>
<tr>
  <td width="300">
      <strong>
        <font color="#000000" face="arial" size="2">
            Mailer to Use:
        </font>
      </strong>
  </td>
  <td>
    <font color="#000000" face="arial" size="2">
     <input type="RADIO" name="inf_resp_mailer" value="wp_mail"<?php if ($infrespmailer == 'wp_mail') {echo " checked";} ?>> wp_mail (phpmailer)
     <input type="RADIO" name="inf_resp_mailer" value="mail"<?php if ($infrespmailer == 'mail') {echo " checked";} ?>> mail &nbsp;
    </font>
  </td>
</tr>
<tr>
   <td width="300">
       <strong>
         <font color="#000000" face="arial" size="2">
             Embed (Attach Inline) Images?
         </font>
       </strong>
   </td>
   <td>
     <input type="RADIO" name="inf_resp_embed_images" value="yes"<?php if ($infrespembedimages == 'yes') {echo " checked";} ?>> Yes &nbsp;
     <input type="RADIO" name="inf_resp_embed_images" value="no"<?php if ($infrespembedimages == 'no') {echo " checked";} ?>> No
   </td>
</tr>
<tr>
   <td width="300">
       <strong>
         <font color="#000000" face="arial" size="2">
             Base Image URL:
         </font>
       </strong>
   </td>
   <td>
     <input maxlength="95" size="40" name="inf_resp_image_url" value="<?php echo $infrespimageurl; ?>"><br>
     eg. <?php echo "http://".$_SERVER['HTTP_HOST']."/images/"; ?>
   </td>
</tr>
<tr>
   <td width="300">
       <strong>
         <font color="#000000" face="arial" size="2">
             Base Image Directory:
         </font>
       </strong>
   </td>
   <td>
     <input maxlength="95" size="40" name="inf_resp_image_dir" value="<?php echo $infrespimagedir; ?>"><br>
   </td>
</tr>
<tr>
   <td width="300">
       <strong>
         <font color="#000000" face="arial" size="2">
             Download and Embed External Images?
         </font>
       </strong>
   </td>
   <td>
     <input type="RADIO" name="inf_resp_embed_external" value="yes"<?php if ($infrespembedexternal == 'yes') {echo " checked";} ?>> Yes &nbsp;
     <input type="RADIO" name="inf_resp_embed_external" value="no"<?php if ($infrespembedexternal == 'no') {echo " checked";} ?>> No
   </td>
</tr>
<tr>
   <td width="300">
         <font color="#000000" face="arial" size="2">
             <strong>Wrap Lines at:</strong> (phpmailer)
         </font>
   </td>
   <td>
     <input type="text" size="3" name="inf_resp_word_wrap" value="<?php echo $infrespwordwrap; ?>"> characters
   </td>
</tr>
 <!-- END new wp_mail / phpmailer options -->

<tr height="15">
	<td>
	</td>
</tr>

<tr>
  <td colspan="2" align="center">
 	<strong><font face="arial" size="3">Replacement Values</font></strong>
  </td>
</tr>

<tr>
   <td width="300" style="vertical=align:top;">
         <font color="#000000" face="arial" size="2">
             <strong>Signature:</strong> %signature% replacement value
         </font>
   </td>
   <td>
     <textarea rows="2" cols="50" name="inf_resp_address"><?php echo $infrespaddress; ?></textarea>
   </td>
</tr>

<tr>
   <td width="300" style="vertical-align:top;">
         <font color="#000000" face="arial" size="2">
             <strong>Address:</strong> %address% replacement value
         </font>
   </td>
   <td>
     <textarea rows="2" cols="50" name="inf_resp_address"><?php echo $infrespaddress; ?></textarea>
   </td>
</tr>


 <tr>
  <td>
  </td>
  <td align="center">
    <input type="hidden" name="page" value="infinityresponder">
    <input type="hidden" name="subpage" value="editconfig">
	<input type="hidden" name="action" value="save">
    <input class="button-primary" id="submit" type="submit" value="Save Changes">
  </td>
</tr>

 <tr><td colspan="2" align="center"><br>
Note: While there is no in-built SMTP functionality, this is easy <br>
to set up using another plugin.  Make sure you are set to wp_ mail,<br>
then install an SMTP Wordpress plugin to do this for you... <br>
eg. <a href="https://wordpress.org/plugins/postman-smtp/" target=_blank>Postman SMTP Mailer</a> (recommended), Configure SMTP,<br>
WP Mail SMTP, WP SMTP, Easy WP SMTP, Easy SMTP Mail...<br>
see my <a href="http://pluginreview.net/guides/mailing-guide/" target=_blank>SMTP Setup Guide</a> for more information and recommendations.<br>
<br>
</td></tr>

</table>
</form>
