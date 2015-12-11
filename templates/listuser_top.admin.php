<?php
# Modified 07/02/2013 by Plugin Review Network
# Modified by Infinity Responder development team: 2009-06-04
?>

<!-- MOD Added showsubscriber javascript -->
<script language="javascript" type="text/javascript">
function showsubscriber(subid) {
 if (document.getElementById(subid).style.display == 'none') {document.getElementById(subid).style.display = '';}
 else {document.getElementById(subid).style.display = 'none';}
}
</script>

<br />
<!-- MOD Action to Wordpress Menu -->
<form action="" method=GET>
  <input type="hidden" name="page" value="infinityresponder">
  <input type="hidden" name="subpage" value="admin">
  <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
  <input type="hidden" name="action" value="bulk_add">
  <input class="button-primary" type="submit" name="Import Subscribers" value="Import Subscribers">
  <!-- MOD was class="butt" -->
</form>
<br />

<center>
<table border="0" width="550" cellpadding="0" cellspacing="0" style="border: 1px solid #000000;"><tr><td>
   <table border="0" width="100%" cellpadding="0" cellspacing="2" bgcolor="#1EABDF"><tr>
      <td width="40" align="center"><font color="#FFFFFF">ID #</font></td>
      <td width="300"><font color="#FFFFFF">Email Address</font></td>
      <td width="40" align="center"><font color="#FFFFFF">HTML</font></td>
      <td width="30">&nbsp;</td>
      <td width="30">&nbsp;</td>
   </tr></table>
