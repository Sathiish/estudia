<div class="alert-message <?php echo isset($type)?$type:'success'; ?>">
	<a href="#" class="close" onclick="$(this).parent().slideUp(); return false;">x</a>
	<?php echo $message; ?>
</div>