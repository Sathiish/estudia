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
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-29775947-1']);
  _gaq.push(['_setDomainName', 'zeschool.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>

  <div id="headerintro">
      
      <div class="header_resize">

        <?php echo $this->element('menu'); ?>
        
        <?php echo $this->Html->image('logo_beta_blanc.png', array('alt' => 'logo','width'=>'200', 'height'=>'54', 'class' => 'logo'))?>
        
        
        <div class="clr"></div>
        <div style="float:left; margin-top: 6px; margin-left:70px">
        <?php echo $this->Html->image('/img/frise4.png', array('width' => '382', 'height' => '246')); ?>
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