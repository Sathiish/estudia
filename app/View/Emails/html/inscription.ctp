<p>Bonjour <?php echo $username; ?>,</p>
    
<p>Bienvenue sur Zeschool, le premier site ...</p>
    
<p>Merci de vous être inscrit(e) sur ZeSchool. Votre compte a déjà été créé et doit être confirmé avant que vous ne puissez l'utiliser.</p>

<p>Pour confirmer votre inscription et activer votre compte, il vous suffit de cliquer sur le lien ci-dessous :</p>

<p><?php echo $this->Html->link('Activer mon compte',$this->Html->url($link,true)); ?></p>
  
<p>Vous serez tout de suite connecté et vous pourrez ainsi finir de compléter votre profil, et naviguer sur toutes les pages réservées aux membres.</p>

<p>Veuillez noter que pour des raisons de sécurité, le lien d'activation ci-dessus ne sera valable que 7 jours.</p>
   
<p>A tout de suite !</p>
    
<p>L'équipe ZeSchool</p>