<?php echo $this->Html->css('form', null, array('inline'=>false)); ?>

<div class="users form">
    <?php 
        echo $this->Html->link("Changer mon mot de passe", array("controller"=>"users", "action" => "change_password"), array("class" => "modifier"));
        
        echo $this->Form->create('User',array("enctype"=>"multipart/form-data"));
        echo $this->Form->input('id');
        echo $this->Form->input('name', array('label' => 'Votre nom :'));
        echo $this->Form->input('lastname', array('label' => 'Votre prénom :'));
        echo $this->Form->input('email', array('label' => 'Votre adresse email :'));
        echo $this->Form->input('file',array('label'=>"Image (format png/jpg)","type"=>"file"));
        echo $this->Form->end('Mettre à jour');
    ?>
</div>