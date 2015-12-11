<?php // Modified 04/15/2014 by Plugin Review Network ?>
<table width="550" bgcolor="##1EABDF" cellpadding="0" cellspacing="3" style="border: 1px solid #000000;">
   <tr>
      <td>
         <p align="center" style="font-size: 18px"><font color="#FFFFFF">Exported Subscribers</font></p>
      </td>
   </tr>
</table>

<table><tr>
  <table width="550" bgcolor="#F0F0F0" cellpadding="0" cellspacing="3" style="border: 1px solid #000000;">
   <tr>
      <td width="260" align="right" style="vertical-align:top;">
         <font size="3" color="#330000"><b>Exported Subscribers From:</b><br></font>
      </td>
      <td width="30"></td>
      <td width="260" align="left">
         <?php echo $ResponderInfo['Name']; ?>
      </td>
    </tr>
    <tr height="10"><td> </td></tr>
   <tr>
      <td colspan="3" align="center">
	        <?php echo "<textarea rows=20 cols=80>".$list_data."</textarea><br>";	?>
		<?php echo "<br><a href='".$siteURL.$ResponderDirectory.'/exported/'.$file_name."' target=_blank>CSV File Download Link</a><br>"; ?>
      </td>
   </tr>
</table>