<?php echo $this->Html->css('form'); ?>

 <div id="cours-edit" class="content-bloc">
        <h3>Ajouter une sous-partie</h3>
        <div class="inside">
<?php
        echo $this->Form->create('SousPartie', array('url' => "add/".$path['Partie']['id']));
        echo $this->Form->input('name', array('label' => 'Titre de la sous-partie :'));
        echo $this->Tinymce->input('SousPartie.contenu', 
                        array('label' => 'Contenu'),
                        array(
                            'image_explorer' => $this->Html->url(array('controller'=>'medias','action'=>'index', "cours", $path['Cour']['id'])),
                            'image_edit' => $this->Html->url(array('controller'=>'medias','action'=>'show'))
                        ),
                      'perso'
            ); 
?>
        <a href="" onClick="$(this).parent().parent().parent().slideUp(); return false;" class="modifier">Annuler</a>
<?php echo $this->Form->end('Enregistrer'); ?>      
        <div style="height:35px;"></div>
</div>
