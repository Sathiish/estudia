<?php $this->set('title_for_layout',"Mot de passe oublié "); ?>


<?php echo $this->Form->create('User'); ?>
<?php echo $this->Form->input('mail',array('label'=>"Email utilisé lors de l'inscription")); ?>
<?php echo $this->Form->end("Changer mon mot de passe"); ?>