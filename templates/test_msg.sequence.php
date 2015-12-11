<FORM action="admin.php?page=infinityresponder&subpage=messages&action=do_test" method=POST>
<input type="hidden" name="r_ID" value="<?php echo $Responder_ID; ?>">
<table width="550" bgcolor="#1EABDF" style="border: 1px solid #000000;"><tr><td>
  <p align="center" style="font-size: 18px"><font color="#FFFFFF">Send Test Sequence</font></p>
</td></tr></table>
<table width="550" bgcolor="#FFFFFF" style="border: 1px solid #000000;">
<tr height="14"><td> </td></tr>
<tr>
	<td align="center">
	         <table cellpadding="0" cellspacing="0">
	         	<tr>
	         		<td><b>Email Address:</b></td><td width="14"> </td>
	         		<td><input name="testemail" size=30 maxlength=100 value="<?php $DB_OwnerEmail; ?>" class="fields"></td>
	         	</tr>
	          	<tr height="14"><td> </td></tr>
	          	<tr>
	          		<td><b>First Name:</b></td><td width="14"> </td>
	          		<td><input name="testfirstname" size=20 maxlength=40 class="fields"></td>
			</tr>	          
		         <tr height="14"><td> </td></tr>
		         <tr>
		         	<td><b>Last Name:</b></td><td width="14"> </td>
		         	<td><input name="testlastname" size=20 maxlength=40 class="fields"></td>
		         </tr>
		         <tr height="14"><td> </td></tr>
		         <tr>
		         	<td><b>HTML:</b></td><td width="14"> </td>
		         	<td align="center">
		         	<table><tr>
		         	<td><input type="RADIO" name="testhtml" value="1" checked="checked">Yes </td>
		         	<td width="14"></td>
	 	 		<td><input type="RADIO" name="testhtml" value="0"> No</td>
	 	 		</tr></table>
	 	 	</tr>
	 	 </table>
	</td>
</tr>
<tr height="14"><td> </td></tr>
<tr>
	<td align="center">
		<input type="submit" class="button-primary" name="Send Test" value="Send Test Sequence Now">
	</td>
</tr>
<tr height="14"><td> </td></tr>
</table>
<br>
</FORM>
