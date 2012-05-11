<?php echo $this->Form->create('Ressource'); ?>
<?php echo $this->Form->input('name', array('label' => 'Donnez un titre à ce contenu :')); ?>
<?php echo $this->Form->input('type', array('label' => 'Sous quel format voulez-vous présenter ce contenu ?')); ?>
<?php echo $this->Form->input('classe', array('label' => 'Classe concernée')); ?>
<?php echo $this->Form->input('matiere', array('label' => 'Matière ?', 'type' => 'select')); ?>
<?php echo $this->Form->input('theme_id', array('label' => 'Chapitre ?', 'type' => 'select')); ?>
<?php echo $this->Form->end('Enregistrer'); ?>

<script>

jQuery(function(){
    $('select#RessourceClasse').live('click', function(data){
        var classe = $('select#RessourceClasse option:selected').val();
        if(typeof classe != "undefined"){            
            var url = "/ressources/listMatiere/"+classe;
            $.get(url, function(data) {
              $('#RessourceMatiere').html(data);
            });
        }
    });

    $('select#RessourceMatiere').live('click', function(data){
        var matiere = $('select#RessourceMatiere option:selected').val();
        if(typeof matiere != "undefined"){
            var url = "/ressources/listTheme/"+matiere;
            $.get(url, function(data) {
              $('#RessourceThemeId').html(data);
            });    
        }
    });
});

</script>