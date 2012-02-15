<?php Configure::write('debug', 0); ?>
<?php if(isset($error)): ?>
    <div class="mini-alert-message error">
	<a href="#" class="close" onclick="$(this).parent().slideUp()">x</a>
	<p><?php echo $error; ?></p>
    </div>
<?php endif; ?>

        <?php foreach($relatedTags as $tag): ?>
                <span class="etat tag">
                    <?php echo $tag['Tag']['name']; ?> 
                    <?php echo $this->Html->link("x", array("controller" => "courtags", "action" => "delete", $tag['CourTag']['id'])); ?> 
                </span>
        <?php endforeach; ?>