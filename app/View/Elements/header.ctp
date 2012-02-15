<!DOCTYPE html>
<html lang="fr">
<head>
<title><?php echo $title_for_layout?></title>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

<?php echo $this->Html->css('style'); ?>
<?php echo $this->Html->css('table'); ?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<?php echo $scripts_for_layout; ?>
</head>

<body>

    <div class="main">


<div class="header">
    <div class="header_resize">
        <div class="menu_nav">
        <ul>
           <li><?php echo $this->Html->link('Accueil', '/', array()); ?></li>
          <li><?php echo $this->Html->link(' | Ressources', array('controller'=>'ressources', 'action' => 'index')); ?></li>
          <li><?php echo $this->Html->link(' | Quiz', array('controller'=>'quiz', 'action' => 'index')); ?></li>
          <li><?php echo $this->Html->link(' | Forum', array('controller'=>'categories', 'action' => 'index')); ?></li>
          <li><a href="http://zeschool.fr/blog" target="_blank">| Actualité</a></li>
          
              <?php if(isset($_SESSION['Auth']['User']['id'])){ ?>
                    <li><?php echo $this->Html->link('| Se déconnecter', array('controller'=>'users', 'action' => 'logout')); ?></li>
              <?php } else{ ?>
                    <li><?php echo $this->Html->link('| Se connecter', array('controller'=>'users', 'action' => 'login')); ?></li>
                    <li><?php echo $this->Html->link('| S\'inscrire', array('controller'=>'users', 'action' => 'inscription')); ?></li>
            <?php  } ?>   
        </ul>
      </div>
        <div class="clr"></div>
        
        <?php echo $this->Html->image('logo2.png', array('alt' => 'logo','width'=>'194', 'height'=>'49', 'class' => 'logo'))?>
        
        
        <div class="clr"></div>
                 
      
    </div>
</div>
     
        <?php if(isSet($_SESSION['Auth']['User']['username'])): ?>
<div class="barre_hori">
    
</div>
          <?php endif; ?>

</div>
<!-- END Header -->

<div class="content">	
           
    <div class="content_resize">