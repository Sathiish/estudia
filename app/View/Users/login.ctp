<?php echo $this->Html->css('form', null, array('inline'=>false));

echo $this->Form->create('User', array(	'action' => 'login'));
echo $this->Form->input('username', array('label' => 'Pseudo'));
echo $this->Form->input('password',  array('label' => 'Mot de passe'));
echo 'Rester connecté' . $this->Form->checkbox('remember_me');
echo $this->Form->end('Me connecter');

echo $this->Html->link("J'ai oublié mon mot de passe", array("controller" => "users", "action" => "recover_password"));

?>

