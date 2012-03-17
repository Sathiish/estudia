<!DOCTYPE html>
<html lang="fr">
<head>
    <title><?php echo $title_for_layout; ?></title>
    <?php if(isset($meta_description)) echo '<meta name="description" content="'.$meta_description.'">'; ?>
    <?php if(isset($meta_keywords)) echo '<meta name="keywords" content="'.$meta_keywords.'">'; ?>
    
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <?php echo $this->Html->css('main'); ?>
    <?php echo $this->Html->css('print', 'stylesheet', array('media' => 'print')); ?>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <?php if($_SERVER['HTTP_HOST'] == "zeschool.com"): ?>
        <?php echo $this->Element('analytics'); ?>
    <?php endif; ?>
</head>

<body>
    <div id="header">
      <div class="header_resize">
      <?php echo $this->element('menu'); ?>
        <?php echo $this->Html->link($this->Html->image('logo_beta_blanc.png', 
                array('alt' => 'logo','width'=>'200', 'height'=>'54', 'class' => 'logo')), '/', 
                array('escape' => false));?>
        
      </div>
    </div>

      <div class='content main'>
        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>
        <?php echo $content_for_layout; ?>
          <div class="clr"></div>
      </div>

<?php echo $this->element('footer'); ?>