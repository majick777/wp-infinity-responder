<?php
     if ($config['tinyMCE'] == 1) {
?>
<script language="javascript" type="text/javascript" src="<?php echo WP_PLUGIN_URL; ?>/wp-infinity-responder/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "textareas",
        convert_urls : false
});
 </script>
<?php
     }
?>