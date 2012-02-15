<?php echo $this->Html->css('profil', null, array('inline'=>false)); ?>


     <div class="titre"><?php echo $this->Html->image('titre/titre_monprofil.png', array('alt' => 'Titre dashboard','width'=>'104', 'height'=>'22')); ?></div>
    <div class="mes_infos">
                <div class="fond_blanc">
                   <img src="/img/<?php echo $_SESSION['Auth']['User']['avatar']; ?>" class="profile" alt="profile" width="80" height="65"/>
                   <img src="/img/cours/bottom_matiere.png" class="bottom" />
                
                <?php echo '<span class="capitalize" style="color:#333;font-weight: bold; margin-left:10px">'.$_SESSION['Auth']['User']['username'].'</span>';?><br />
                <a class="message_profil" href="#"><span style="color:#00ccff">(0)</span> message</a><br />
                <a class="message_profil" href="#"><span style="color:#00ccff">(0)</span> alerte</a><br />
                <?php echo $this->Html->image("sidebar/plus2.png", array("alt" => "Edition profil", "title"=>"Editer mon profil", "class"=>"right",'url' => array('controller'=>'users', 'action' => 'edit'))); ?>
                </div>
            </div>
     
    <div class="uppercase bolder"><?php echo $this->Html->image('/img/profil/fleche_bas.png', array('alt' => 'fleche','width'=>'10', 'height'=>'6')).'   '.$user['User']['username']; ?></div>
	
	

		<?php echo $user['User']['id']; ?> <br />
		<?php echo $user['User']['username']; ?><br />
		
		<?php echo $user['User']['name']; ?> <?php echo $user['User']['lastname']; ?><br />
		<?php echo $user['User']['email']; ?><br />
		

		

