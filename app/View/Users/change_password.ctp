<?php echo $this->Html->css('form', null, array('inline'=>false)); ?>

<h2>Changer mon mot de passe</h2>
<p>Pour des raisons de sécurité, vous devez d'abord rentrer votre ancien mot de passe avant de pouvoir en changer.</p>
<?php
echo $this->Form->create('User', array('action' => 'change_password'));
	echo $this->Form->input('old_password', array(
		'label' => "Votre ancien mot de passe",
		'type' => 'password'));
	echo $this->Form->input('new_password', array(
		'label' => "Saisissez votre nouveau mot de passe",
		'type' => 'password'));
	echo $this->Form->input('confirm_password', array(
		'label' => "Confirmer le nouveau mot de passe",
		'type' => 'password'));
echo $this->Form->end(__d('users', 'Submit'));