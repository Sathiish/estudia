<?php Configure::write('debug', '0');?>
<?php echo $this->Html->script('tiny_mce/tiny_mce_popup.js'); ?>
<script type="text/javascript">
	var win = window.dialogArugments || opener || parent || top;
	win.send_to_editor('<img src="<?php echo $src; ?>" alt="<?php echo $alt; ?>" title="<?php echo $alt; ?>" class="<?php echo $class; ?>">');
	tinyMCEPopup.close();
</script>