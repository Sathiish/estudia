<?php echo $this->Html->css('form'); ?>
        
 <div id="cours-edit" class="content-bloc">
        <h3>Ajouter une partie</h3>
        <div class="inside">
<?php 
        echo $this->Form->create('Partie', array('url' => "add/".$path['Cour']['id']));
        echo $this->Form->input('name', array('label' => 'Titre de la partie :'));
        echo $this->Tinymce->input('Partie.contenu', 
                        array('label' => 'Introduction'),
                        array(
                            'image_explorer' => $this->Html->url(array('controller'=>'medias','action'=>'index', "cours", $path['Cour']['id'])),
                            'image_edit' => $this->Html->url(array('controller'=>'medias','action'=>'show'))
                        ),
                      'perso'
            );    
?>
        <a href="" onClick="$(this).parent().parent().parent().remove(); return false;" class="modifier">Annuler</a>
<?php 
        echo $this->Form->end('Enregistrer');
?>
        <div class="clr"></div>
        </div>