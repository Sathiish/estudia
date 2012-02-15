<?php echo $this->element('header'); ?>


    
<?php   if(isSet($_SESSION['Auth']['User']['username'])): 
            echo $this->element('sidebar');
        endif; ?>
    <div class="mainbar">
    <?php echo $this->Session->flash(); echo $this->Session->flash('auth'); ?>
    <?php echo $content_for_layout ?>
    

<?php   echo $this->element('footer'); ?>
</div>