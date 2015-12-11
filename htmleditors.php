<?php
# Modified 06/13/2013 by Plugin Review Network
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
    if ($config['tinyMCE'] == 3) {
?>
<script language="javascript" type="text/javascript" src="<?php echo WP_PLUGIN_URL; ?>/wp-infinity-responder/jscripts/tinyeditor/tiny.editor.js"></script>
<script language="javascript" type="text/javascript">
var editor = new TINY.editor.edit('editor', {
	id: 'bodyhtml',
	cssclass: 'tinyeditor',
	controlclass: 'tinyeditor-control',
	rowclass: 'tinyeditor-header',
	dividerclass: 'tinyeditor-divider',
	controls: ['bold', 'italic', 'underline', 'strikethrough', '|', 'subscript', 'superscript', '|',
		'orderedlist', 'unorderedlist', '|', 'outdent', 'indent', '|', 'leftalign',
		'centeralign', 'rightalign', 'blockjustify', '|', 'unformat', '|', 'undo', 'redo', 'n',
		'font', 'size', 'style', '|', 'image', 'hr', 'link', 'unlink', '|', 'print'],
	footer: true,
	fonts: ['Verdana','Arial','Georgia','Trebuchet MS'],
	cssfile: '<?php echo WP_PLUGIN_URL; ?>/wp-infinity-responder/jscripts/tinyeditor/tinyeditor.css',
	bodyid: 'editor',
	footerclass: 'tinyeditor-footer',
	toggle: {text: 'source', activetext: 'wysiwyg', cssclass: 'toggle'},
	resize: {cssclass: 'resize'}
});
</script>
<style>
.tinyeditor-header {background:url('<?php echo WP_PLUGIN_URL; ?>/wp-infinity-responder/jscripts/tinyeditor/images/header-bg.gif') repeat-x;}
.tinyeditor-control {background-image:url('<?php echo WP_PLUGIN_URL; ?>/wp-infinity-responder/jscripts/tinyeditor/images/icons.png');}
.resize {background:url('<?php echo WP_PLUGIN_URL; ?>/wp-infinity-responder/jscripts/tinyeditor/images/resize.gif') 15px 15px no-repeat;}
</style>
<?php
      }
    if ($config['tinyMCE'] == 4) {
?>
<script language="javascript" type="text/javascript" src="<?php echo WP_PLUGIN_URL; ?>/wp-infinity-responder/jscripts/nicedit/nicEdit.js"></script>
<script type="text/javascript">
bkLib.onDomLoaded(addnicedit);
function addnicedit() {
   htmlarea = new nicEditor({fullPanel : true}).panelInstance('bodyhtml');
}
</script>
<style>.nicEdit-main {background-color:#FFF; text-align:left;}</style>
<?php
   }
?>