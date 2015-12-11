<?php # Modified 07/04/2013 by Plugin Review Network ?>
<table width="550">
<tr bgcolor="#1EABDF" height="54"><td align="center"><font color="#FFFFFF" style="font-size:18px;">Messages</font></td></tr>
<?php
	if ($_SESSION['inf_resp_msg'] != '') {
		echo "<tr><td>";
		echo "<center><p><div id='inf_resp_msg'><table width='50%' style='background-color: lightYellow; border-style:solid; border-width:1px; border-color: #E6DB55; padding: 0 0.6em; text-align:center;'><tr><td align='center'><p class='message'>";
		echo "<font style='font-size:11pt;'>".$_SESSION['inf_resp_msg']."</font>";
		echo "</p></td></tr></table></div></p></center>";
		echo "</td></tr>";
		unset($_SESSION['inf_resp_msg']);
	}
?>
</table>
<br />
<center>
<table border="0" width="550" cellpadding="0" cellspacing="0" style="border: 1px solid #000000;"><tr><td>
   <table border="0" width="100%" cellpadding="0" cellspacing="2" bgcolor="#1EABDF"><tr>
      <td width="300" align="center"><font color="#FFFFFF">Message Subject</font></td>
      <td width="200" align="center"><font color="#FFFFFF">Send Delay Timing</font></td>
      <td width="25">&nbsp;</td>
      <td width="25">&nbsp;</td>
   </tr></table>