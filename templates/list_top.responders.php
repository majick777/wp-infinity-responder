<?php
# Modified 04/19/2014 by Plugin Review Network
# Modified by Infinity Responder development team: 2009-06-04
?>

<table width="550">
<tr bgcolor="#1EABDF" height="54"><td align="center"><font color="#FFFFFF" style="font-size:18px;">Responders</font></td></tr>
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
<tr><td>
<br>
<div align="right"><font style="font-size:10pt;">(Note: Enabled Responders have bolded titles.)</font></div>
<br>
<table border="0" width="550" cellpadding="0" cellspacing="0" style="border: 1px solid #000000;"><tr><td>
   <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#1EABDF"><tr>
      <td width="30" align="center"><font color="#FFFFFF" style="font-size:11pt;">ID</font></td>
      <td width="220" align="center"><font color="#FFFFFF" style="font-size:11pt;">Responder Name</font></td>
      <td width="40" align="center"><font color="#FFFFFF" style="font-size:11pt;">Subs</font></td>
      <td width="40" align="center"><font color="#FFFFFF" style="font-size:10pt;">Pend</font></td>
      <td width="40" align="center"><font color="#FFFFFF" style="font-size:10pt;">Msgs</font></td>
      <td width="30">&nbsp;</td>
      <td width="30">&nbsp;</td>
      <td width="30">&nbsp;</td>
      <td width="30">&nbsp;</td>
      <td width="30">&nbsp;</td>
      <td width="30">&nbsp;</td>
   </tr></table>

