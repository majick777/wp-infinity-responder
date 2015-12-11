<?php
# Modified 10/20/2013 by Plugin Review Network
# Modified by Infinity Responder development team: 2009-06-04

# MOD Use Wordpress Admin Color Scheme
$colorscheme = inf_resp_get_color_scheme();

# MOD Set Help Section if not set
if ($help_section == "") {
	if ($action == "edit_users") {$help_section = "editusers";}
	else {$help_section = "mainscreen";}
}

// if ($Is_Auth) {
# MOD replaced with capability
if (current_user_can('manage_options')) {
	?>

<style>.hoverblue {font-family:verdana;font-size:10pt;}
input[type="submit"]:hover {background-color:<?php echo $colorscheme[2]; ?>;}</style>
<table border="0" width="550" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
 <tr height="15"><td> </td></tr>
 <tr>
  <td align="center">
	<table border="0" width="550" cellpadding="0" cellspacing="0">
	  <tr>
		<td align="center" width="170">
			<!-- # MOD Action to Wordpress Menu -->
		   <form action="" method=GET>
		   	  <input type="hidden" name="page" value="infinityresponder">
		   	  <input type="hidden" name="subpage" value="responders">
			  <input type="hidden" name="action" value="list">
			  <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
			  <input type="submit" name="submit" value="Responders" alt="Edit Responders" class="hoverblue"  style="color:
			  <?php
				if ($_REQUEST['subpage'] == 'responders') {echo $colorscheme[0].'; border: 1px solid '.$colorscheme[1].'; background-color:'.$colorscheme[2].';">';}
				else {echo $colorscheme[0].'; border: 1px solid '.$colorscheme[1].'; background-color:'.$colorscheme[3].';" onMouseover="this.style.backgroundColor=\''.$colorscheme[2].'\';" onMouseout="this.style.backgroundColor=\''.$colorscheme[3].'\';">';}
			  ?>
		   </form>
		</td>
		<?php
		# MOD remove old buttons
		# <td width="96">
		#   <form action="admin.php" method=GET>
		#      <input type="hidden" name="action" value="list">
		#      <input type="image" name="submit" src="images/editusers.gif" border="0" alt="Edit Users">
		#   </form>
		# </td>
		# <td width="220" nowrap>
		#      <form action="admin.php" method=GET>
		#         <input type="hidden" name="action" value="Form_Gen">
		#         <input type="image" name="submit" src="images/generatecode.gif" border="0" alt="Generate Code" align="absbottom"> &nbsp;
		#          php ResponderPulldown('r_ID');
		#      </form>
		#  </td> 
		?>
		<td align="center" width="170">
			<!-- # MOD Action to Wordpress Menu -->
		   <form action="" method=GET>
		   	  <input type="hidden" name="page" value="infinityresponder">
		   	  <input type="hidden" name="subpage" value="admin">
			  <input type="hidden" name="action" value="sub_addnew">
			  <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
			  <input type="submit" name="submit" value="Add Subscribers" alt="Add Subscribers" class="hoverblue"  style="color:
			  <?php
					if (($_REQUEST['subpage'] == 'admin') && ($_REQUEST['action'] == 'sub_addnew')) {echo $colorscheme[0].'; border: 1px solid '.$colorscheme[1].'; background-color:'.$colorscheme[2].';">';}
					else {echo $colorscheme[0].'; border: 1px solid '.$colorscheme[1].'; background-color:'.$colorscheme[3].';" onMouseover="this.style.backgroundColor=\''.$colorscheme[2].'\';" onMouseout="this.style.backgroundColor=\''.$colorscheme[3].'\';">';}
			  ?>
		   </form>
		</td>
		<td align="center" width="140">
		<!-- # MOD Action to Wordpress Menu -->
		   <form action="" method=GET>
		   	  <input type="hidden" name="page" value="infinityresponder">
		   	  <input type="hidden" name="subpage" value="admin">
			  <input type="hidden" name="action" value="bulk_add">
			  <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
			  <input type="submit" name="submit" value="Import" alt="Bulk Import"  class="hoverblue"  style="color:
			  <?php
				if (($_REQUEST['subpage'] == 'admin') && ($_REQUEST['action'] == 'bulk_add')) {echo $colorscheme[0].'; border: 1px solid '.$colorscheme[1].'; background-color:'.$colorscheme[2].';">';}
				else {echo $colorscheme[0].'; border: 1px solid '.$colorscheme[1].'; background-color:'.$colorscheme[3].';" onMouseover="this.style.backgroundColor=\''.$colorscheme[2].'\';" onMouseout="this.style.backgroundColor=\''.$colorscheme[3].'\';">';}
			  ?>
		   </form>
		</td>
		<td align="center" width="140">
		   <form action="" method=GET>
			  <input type="hidden" name="page" value="infinityresponder">
			  <input type="hidden" name="subpage" value="admin">
			  <input type="hidden" name="action" value="list_export">
			  <input type="hidden" name="r_ID"   value="<?php echo $Responder_ID; ?>">
			  <input type="submit" name="submit" value="Export" alt="Export"  class="hoverblue"  style="color:
			  <?php
				if (($_REQUEST['subpage'] == 'admin') && ($_REQUEST['action'] == 'list_export')) {echo $colorscheme[0].'; border: 1px solid '.$colorscheme[1].'; background-color:'.$colorscheme[2].';">';}
				else {echo $colorscheme[0].'; border: 1px solid '.$colorscheme[1].'; background-color:'.$colorscheme[3].';" onMouseover="this.style.backgroundColor=\''.$colorscheme[2].'\';" onMouseout="this.style.backgroundColor=\''.$colorscheme[3].'\';">';}
			  ?>
		   </form>
		</td>
	</tr>
</table><br>
<table border="0" width="550" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" width="110">
			<!-- # MOD Action to Wordpress Menu -->
		   <form action="" method=GET>
			  <input type="hidden" name="page" value="infinityresponder">
			  <input type="hidden" name="subpage" value="editconfig">
			  <input type="hidden" name="action" value="edit">
			  <input type="submit" name="submit" value="Config" alt="Configure"  class="hoverblue"  style="color:
			  <?php
				if ($_REQUEST['subpage'] == 'editconfig') {echo $colorscheme[0].'; border: 1px solid '.$colorscheme[1].'; background-color:'.$colorscheme[2].';">';}
				else {echo $colorscheme[0].'; border: 1px solid '.$colorscheme[1].'; background-color:'.$colorscheme[3].';" onMouseover="this.style.backgroundColor=\''.$colorscheme[2].'\';" onMouseout="this.style.backgroundColor=\''.$colorscheme[3].'\';">';}
			  ?>
		   </form>
		</td>
		<td align="center" width="110">
		<!-- # MOD Add new Cron Menu -->
		   <form action="" method=GET>
			  <input type="hidden" name="page" value="infinityresponder">
			  <input type="hidden" name="subpage" value="cron">
			  <input type="hidden" name="action" value="view">
			  <input type="submit" name="submit" value="Cron" alt="Cron Job"  class="hoverblue"  style="color:
			  <?php
				if ($_REQUEST['subpage'] == 'cron') {echo $colorscheme[0].'; border: 1px solid '.$colorscheme[1].'; background-color:'.$colorscheme[2].';">';}
				else {echo $colorscheme[0].'; border: 1px solid '.$colorscheme[1].'; background-color:'.$colorscheme[3].';" onMouseover="this.style.backgroundColor=\''.$colorscheme[2].'\';" onMouseout="this.style.backgroundColor=\''.$colorscheme[3].'\';">';}
			  ?>
	   	</form>
		</td>
		<td align="center" width="110">
			<!-- # MOD Action to Wordpress Menu -->
		   <form action="" method=GET>
		      <input type="hidden" name="page" value="infinityresponder">
		   	  <input type="hidden" name="subpage" value="tools">
			  <input type="hidden" name="action" value="list">
			  <input type="submit" name="submit" value="Tools" alt="Tools"  class="hoverblue"  style="color:
			  <?php
					if ($_REQUEST['subpage'] == 'tools') {echo $colorscheme[0].'; border: 1px solid '.$colorscheme[1].'; background-color:'.$colorscheme[2].';">';}
					else {echo $colorscheme[0].'; border: 1px solid '.$colorscheme[1].'; background-color:'.$colorscheme[3].';" onMouseover="this.style.backgroundColor=\''.$colorscheme[2].'\';" onMouseout="this.style.backgroundColor=\''.$colorscheme[3].'\';">';}
			  ?>
		   </form>
		</td>
		<td align="center" width="110">
			<!-- # MOD Action to Wordpress Menu -->
		   <form action="" method=GET>
		   	  <input type="hidden" name="page" value="infinityresponder">
		   	  <input type="hidden" name="subpage" value="bouncers">
			  <input type="hidden" name="action" value="list">
			  <input type="submit" name="submit" value="Bouncers" alt="Bouncers"  class="hoverblue"  style="color:
			  <?php
				if ($_REQUEST['subpage'] == 'bouncers') {echo $colorscheme[0].'; border: 1px solid '.$colorscheme[1].'; background-color:'.$colorscheme[2].';">';}
				else {echo $colorscheme[0].'; border: 1px solid '.$colorscheme[1].'; background-color:'.$colorscheme[3].';" onMouseover="this.style.backgroundColor=\''.$colorscheme[2].'\';" onMouseout="this.style.backgroundColor=\''.$colorscheme[3].'\';">';}
			  ?>
		   </form>
		</td>
		<td align="center" width="110">
			<!-- # MOD Action to Wordpress Menu -->
		   <form action="" method=GET>
			  <input type="hidden" name="page" value="infinityresponder">
			  <input type="hidden" name="subpage" value="blacklist">
			  <input type="hidden" name="action" value="list">
			  <input type="submit" name="submit" value="Blacklist" alt="Blacklist"  class="hoverblue"  style="color:
			  <?php
				if ($_REQUEST['subpage'] == 'blacklist') {echo $colorscheme[0].'; border: 1px solid '.$colorscheme[1].'; background-color:'.$colorscheme[2].';">';}
				else {echo $colorscheme[0].'; border: 1px solid '.$colorscheme[1].'; background-color:'.$colorscheme[3].';" onMouseover="this.style.backgroundColor=\''.$colorscheme[2].'\';" onMouseout="this.style.backgroundColor=\''.$colorscheme[3].'\';">';}
			  ?>
		   </form>
		</td>
	  </tr>
	 <tr height="15"><td> </td></tr>
	</table>

	<?php
	// <table align="right" border="0" cellpadding="0" cellspacing="0">
	//  <tr>
	//   <!-- MOD ACTION -->
	//	<td>[<a href="manual.html#'.$help_section.'" onclick="return popper(\'manual.html#'.$help_section,'\')" style="color: #000099; text-decoration: none;">Help</a>]
	//	<!-- MOD Removed Logout -->
	//	<!--[<a href="logout.php?action=logout" style="color: #000099; text-decoration: none;">Logout</a>]</td> -->
	//  </tr>
	//</table>
	?>

<?php
}

?>