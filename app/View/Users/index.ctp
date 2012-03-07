<?php echo $this->Html->css('profil', null, array('inline'=>false)); ?>
    
    <div class="uppercase bolder"><?php echo $this->Html->image('/img/profil/fleche_bas.png', array('alt' => 'fleche','width'=>'10', 'height'=>'6')).'   '.$user['User']['username']; ?></div>

    <?php echo $user['User']['username']; ?><br />

    <?php echo $user['User']['name']; ?> <?php echo $user['User']['lastname']; ?><br />
    <?php echo $user['User']['email']; ?><br />
		

		

