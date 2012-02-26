<div class="alert-message <?php echo isset($type)?$type:'success'; ?>">
	<a href="#" class="close" onclick="$(this).parent().slideUp()">x</a>
	<?php echo $message; ?>
</div>