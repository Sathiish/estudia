<!DOCTYPE html>
<html lang="fr">
<head>
<title><?php echo $title_for_layout?></title>
<?php if(isset($meta_description)) echo '<meta name="description" content="'.$meta_description.'">'; ?>
<?php if(isset($meta_keywords)) echo '<meta name="keywords" content="'.$meta_keywords.'">'; ?>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<?php echo $this->Html->css('main'); ?>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<?php echo $this->Html->script('menu'); ?>

<?php echo $scripts_for_layout ?>
    <?php if($_SERVER['HTTP_HOST'] == "zeschool.com"): ?>
        <?php echo $this->Element('analytics'); ?>
    <?php endif; ?>
</head>

  <div id="headerintro">
      
      <div class="header_resize">

        <?php echo $this->element('menu'); ?>
        
        <?php echo $this->Html->image('logo_beta_blanc.png', array('alt' => 'logo','width'=>'200', 'height'=>'54', 'class' => 'logo'))?>
        
        
        <div class="clr"></div>
        <div style="float:left; margin-top:0px; margin-left: -25px;">
        <?php echo $this->Html->image('/img/frise4.png', array('width' => '737', 'height' => '259')); ?>
        </div>
        
        <div id="intro">   
            <img src="/img/enviedeprogresser.png"/><br /><br />
                <p>ZeSchool est une plateforme collaborative de e-learning permettant l’édition et le partage de cours et d'exercices en quelques clics. <br />
                    C'est 100% gratuit et efficace.</p>
            <button class="button" style="margin-left: 100px"><a href="/arguments" style="color:#fff;">Besoin d'être convaincu?</a></button>
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