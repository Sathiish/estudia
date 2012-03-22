<?php Configure::write('debug', '0');?>
<?php echo $this->Html->script('tiny_mce/tiny_mce_popup.js'); ?>
<script type="text/javascript">
	var win = window.dialogArugments || opener || parent || top;
	win.send_to_editor('<iframe frameborder="0" width="560" height="420" src="http://www.dailymotion.com/embed/video/xdfndb"></iframe><br /><a href="http://www.dailymotion.com/video/xdfndb_maths-faciles-les-probabilites-term_tech" target="_blank">Maths Faciles - Les probabilit&eacute;s - Terminale ES</a> <i>par <a href="http://www.dailymotion.com/MathsFaciles" target="_blank">MathsFaciles</a></i>');
	tinyMCEPopup.close();
</script>