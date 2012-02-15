<!DOCTYPE html>
<html lang="fr">
<head>
<title><?php echo $title_for_layout?></title>
<?php echo $this->Html->css('table'); ?>


<?php echo $scripts_for_layout ?>

</head>

      <div class='content main'>
              <?php echo $this->Session->flash(); echo $this->Session->flash('auth'); ?>
          <?php echo $content_for_layout ?>
      </div>