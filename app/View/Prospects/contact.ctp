<?php if(isset($message)): ?>
    <div class="alert-message <?php echo isset($type)?$type:'success'; ?>">
            <a href="#" class="close" onclick="$(this).parent().slideUp(); return false;">x</a>
            <?php echo $message; ?>
    </div>

    <?php if(!isset($type)): ?>
    <script>
    setTimeout("$('#dialog-form').dialog('close');",3000);
    </script>
    <?php endif; ?>
<?php endif; ?>


<?php echo $this->Form->create('Prospect', array('url' => '/prospects/contact')); ?>

<?php echo $this->element('matiere_liste', array('cache'=>'+1 week')); ?>
<?php echo $this->Form->input('tag_id', array('label' => 'Votre classe')); ?>
<?php echo $this->Form->input('name', array('label' => 'Votre nom')); ?>
<?php echo $this->Form->input('email', array('label' => 'Votre email')); ?>
<?php echo $this->Form->input('phone', array('label' => 'Votre numéro de téléphone')); ?>
<?php echo $this->Form->input('zip', array('label' => 'Votre code postal')); ?>

</form>


