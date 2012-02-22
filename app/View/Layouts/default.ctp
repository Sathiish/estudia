<!DOCTYPE html>
<html lang="fr">
<head>
    <title><?php echo $title_for_layout?></title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <?php echo $this->Html->css('main'); ?>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
</head>

<body>
    <div id="header">
      <?php echo $this->element('menu'); ?>
      <div class="header_resize">
        <?php echo $this->Html->image('logo_beta_blanc.png', array('alt' => 'logo','width'=>'220', 'height'=>'60', 'class' => 'logo'))?>   
      </div>
    </div>

      <div class='content main'>
        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>
        <?php echo $content_for_layout; ?>
      </div>

<?php echo $this->element('footer'); ?>