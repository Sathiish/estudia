<?php echo $this->Html->css('form', null, array('inline'=>false)); ?>

<?php echo $this->Form->create('User');?>
<?php echo 'Formulaire d\'inscription'; ?>
	<?php
			echo $this->Form->input('username', array(
                                'label' => 'Pseudo'
//                            ,
//				'error' => 	array(
//					'unique_username' => __d('users', 'Please select a username that is not already in use', true),
//					'username_min' => __d('users', 'Must be at least 3 characters', true),
//					'alpha' => __d('users', 'Username must contain numbers and letters only', true),
//					'required' => __d('users', 'Please choose username', true))
                            ));
			echo $this->Form->input('email', array(
						'label' => 'E-mail'
//						,'error' => array('isValid' => __d('users', 'Must be a valid email address', true),
//							'isUnique' => __d('users', 'An account with that email already exists', true))
                            ));
			echo $this->Form->input('password', array(
						'label' => 'Mot de passe',
						'type' => 'password'
//                                                ,'error' => __d('users', 'Must be at least 5 characters long', true)
                            ));
			echo $this->Form->input('temppassword', array(
						'label' => __d('users', 'Password (confirm)', true),
						'type' => 'password'
//                                                ,'error' => __d('users', 'Passwords must match', true)
						)
					);
			echo $this->Form->input('tos', array(
                                                'style' => 'float:left',
						'label' => 'J\'ai lu et j\'accepte les '. $this->Html->link('conditions d\'utilisation', array('controller' => 'pages', 'action' => 'tos')) 
//						,'error' => __d('users', 'You must verify you have read the Terms of Service', true)
						)
					);

			echo $this->Form->end('Créer mon compte');
	?>
        

<?php debug($this); ?>