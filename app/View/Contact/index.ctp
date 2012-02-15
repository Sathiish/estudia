<?php $this->set('title_for_layout',"Me contacter"); ?>
<?php echo $this->Html->css('form', null, array('inline' => false)); ?>

<h2>Formulaire de contact</h2>
<?php echo $this->Form->create('Contact'); ?>
	<?php echo $this->Form->input('name',array('label'=>"Votre nom","required")); ?>
	<?php echo $this->Form->input('email',array('label'=>"Votre email","type"=>"email","required")); ?>
	<?php echo $this->Form->input('website',array('label'=>false,"type"=>"text","class"=>"code")); ?>
	<?php echo $this->Form->input('message',array('label'=>"Votre message","type"=>"textarea","required")); ?>
<?php echo $this->Form->end('Envoyer'); ?>

<h3>Vous pouvez également nous contacter par mail ou téléphone</h3>
        <p>Email: <a href="#">contact@zeschool.com</a><br>Tél: 01 83 74 09 17
        </p>