<?php
	// echo "-----";
	// echo $config['tinyMCE'];
	// echo "-----";
    if ($config['tinyMCE'] == 1) {
?>
<script language="javascript" type="text/javascript" src="<?php echo WP_PLUGIN_URL; ?>/wp-infinity-responder/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
 tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	editor_selector : "html_area",
	editor_deselector : "text_area",
        convert_urls : false
 });
 </script>
<?php
     }
   if ($config['tinyMCE'] == 2) {
?>
<script language="javascript" type="text/javascript" src="<?php echo WP_PLUGIN_URL; ?>/wp-infinity-responder/jscripts/tinymce/tinymce.min.js"></script>
 <script language="javascript" type="text/javascript">
 tinyMCE.init({
 	selector : "textarea.html_area",
 	plugins : "advlist autolink charmap contextmenu fullscreen hr image legacyoutput link lists media paste preview searchreplace table textcolor visualblocks visualchars wordcount"
 });</script>
 <?php

   }
?>