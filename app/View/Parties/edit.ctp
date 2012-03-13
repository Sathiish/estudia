<?php echo $this->Html->css('form', null, array('inline'=>true)); ?>

    <div id="cours-edit" class="content-bloc">
        <h3>Modifier une partie</h3>
        <div class="inside">
<?php 
        echo $this->Form->create('Partie', array('controller' => 'parties', 'action' => "edit", $this->data['Partie']['id']));
        echo $this->Form->input('id');
        echo $this->Form->input('name', array('label' => 'Titre:'));
        echo $this->Tinymce->input('Partie.contenu', 
                        array('label' => 'Introduction'),
                        array(
                            'image_explorer' => $this->Html->url(array('controller'=>'medias','action'=>'index', "cours", $this->data['Partie']['cour_id'])),
                            'image_edit' => $this->Html->url(array('controller'=>'medias','action'=>'show'))
                        ),
                      'perso'
            );  
?>
        <a href="" onClick="$(this).parent().parent().parent().remove(); return false;" class="modifier">Annuler</a>
<?php   echo $this->Form->end('Enregistrer'); ?>
        
        <div class="clr"></div>
        
        </div>
        

