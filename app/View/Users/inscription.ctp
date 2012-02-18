<?php echo $this->Html->css('form', null, array('inline'=>false)); ?>

<?php echo $this->Form->create('User');?>
<?php echo 'Formulaire d\'inscription'; 

echo $this->Form->input('username', array('label' => 'Pseudo'));
echo $this->Form->input('email', array('label' => 'E-mail'));
echo $this->Form->input('password', array('label' => 'Mot de passe','type' => 'password'));
echo $this->Form->input('temppassword', array('label' => 'Confirmer votre mot de passe','type' => 'password'));
echo $this->Form->input('tos', array('style' => 'float:left',
                        'label' => 'J\'ai lu et j\'accepte les '. $this->Html->link('conditions d\'utilisation', array('controller' => 'pages', 'action' => 'tos')) 
                  ));
echo $this->Form->end('Créer mon compte');
