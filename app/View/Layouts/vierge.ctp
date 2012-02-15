<?php   echo $this->element('header'); ?>

<div class="content">		
    <div class="content_resize">        

            
        <?php 
            echo $this->Session->flash();
            echo $this->Session->flash('auth');
        ?>
        

<?php echo $content_for_layout ?>

    </div>
<?php echo $this->element('footer'); ?>