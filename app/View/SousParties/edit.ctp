<?php echo $this->Html->css('form'); ?>
      
 <div id="cours-edit" class="content-bloc">
        <h3>Modifier une sous-partie</h3>
        <div class="inside">
<?php
        echo $this->Form->create('SousPartie', array('url' => "edit/"));
        echo $this->Form->input('id');
        echo $this->Form->input('name', array('label' => 'Titre de la partie :', 'style' => 'width:590px'));
        echo $this->Tinymce->input('SousPartie.contenu', 
                        array('label' => 'Contenu'),
                        array(
                            'width' => '610',
                            'height' => '400',
                            'image_explorer' => $this->Html->url(array('controller'=>'medias','action'=>'index', "cours", $path['Partie']['Cour']['id'])),
                            'image_edit' => $this->Html->url(array('controller'=>'medias','action'=>'show'))
                        ),
                      'perso'
            );  
?>
        <a href="" onClick="$(this).parent().parent().parent().remove(); return false;" class="modifier">Annuler</a>
<?php echo $this->Form->end('Enregistrer'); ?>
<div class="clr"></div>
        </div>