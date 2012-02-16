<?php echo $this->Html->css('form', null, array('inline'=>false)); ?>

<div class="users form">
<div class="titre"><?php echo $this->Html->image('titre/titre_monprofil.png', array('alt' => 'Titre dashboard','width'=>'104', 'height'=>'22')); ?></div>
    <?php 
        
        echo $this->Form->create('User',array("enctype"=>"multipart/form-data"));
        echo $this->Form->input('id');
        echo $this->Form->input('name', array('label' => 'Votre nom :'));
        echo $this->Form->input('lastname', array('label' => 'Votre prénom :'));
        echo $this->Form->input('email', array('label' => 'Votre adresse email :'));
        echo $this->Form->input('file',array('label'=>"Image (format png/jpg)","type"=>"file"));
        echo $this->Form->end('Mettre à jour mon profil');
    ?>    
          <div style="font-size:18px; color:black; font-weight:bold; margin:30px 40px 20px 40px">
                    <div style="float:left; border-bottom:1px solid grey; width:250px; padding-bottom:10px"></div>
                    <div style="float:left; padding:0 14px">OU</div>
                    <div style="float:left; border-bottom:1px solid grey; width:250px; padding-bottom:10px"></div>
                    <div class="clr"></div>
            </div>
        
    <?php  echo $this->Html->link("Changer mon mot de passe", array("controller"=>"users", "action" => "change_password"), array("class" => "button")); ?>
    
</div>