<p>Bonjour <?php echo $username; ?>,</p>

<p>Vous avez fait une demande de changement de mot de passe. Afin de finaliser votre demande, veuillez cliquer sur le lien ci-dessous : </p>
<p><?php echo $this->Html->link('Je souhaite changer mon mot de passe',$this->Html->url($link,true)); ?></p>

<p>Si vous n'avez pas fait cette demande, veuillez ne pas tenir compte de ce message.</p>