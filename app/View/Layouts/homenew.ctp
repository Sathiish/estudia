<!DOCTYPE html>
<html lang="fr">
<head>
<title><?php echo $title_for_layout?></title>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<?php echo $this->Html->css('main'); ?>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<?php echo $this->Html->script('menu'); ?>
<script type="text/javascript">
  $(function() {
    $('#nav').droppy();
  });
</script>

<?php echo $scripts_for_layout ?>

</head>

  <div id="headerintro">
      <?php echo $this->element('menu'); ?>
      <div class="header_resize">

        <div class="clr"></div>
        
        <?php echo $this->Html->image('logo_beta_blanc.png', array('alt' => 'logo','width'=>'258', 'height'=>'70', 'class' => 'logo'))?>
        
        
        <div class="clr"></div>
        <div style="float:left; margin-top: 6px">
        <?php echo $this->Html->image('/img/frise4.png', array('width' => '600', 'height' => '246')); ?>
        </div>
        
        <div id="intro">   
            <img src="/img/titre_accueil.png"/><br /><br />
            <p>ZeSchool est une plateforme de e-Learning collaborative permettant l’édition et le partage de ressources éducatives. Toute personne (même toi !) 
                disposant d’un savoir peut créer un contenu pédagogique et le partager. 
                Ici la connaissance n’est pas une honte, car nous on aime les premiers de la classe ! </p><br />
            <p><a class="need-convincing" href="/arguments">Besoin d'être convaincu?</a></p>
        </div>      
      
    </div>

  </div>

      <div class='content main'>
              <?php 
              echo $this->Session->flash(); 
              echo $this->Session->flash('auth');           
              echo $content_for_layout ?>
      </div>

          <?php echo $this->element('footer'); ?>