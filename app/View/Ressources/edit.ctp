<div class="sidebar">
    <div class="sidebar-bloc">
        <h3>Classement</h3>
        <a href="" class="handlediv" title="Agrandir"></a>
        <div class="inside">
            <?php echo $this->Form->create('Theme'); ?>
            <?php echo $this->Form->create('Ressource'); ?>
            <?php echo $this->Form->input('id'); ?>
            <?php echo $this->Form->input('matiere_id'); ?>
            <?php echo $this->Form->input('type', array('label' => 'Type de ressource')); ?>
            <?php echo $this->Form->radio('difficulty', $difficulty, array('label' => '', 'legend' => 'Niveau de difficulté')); ?>
            <?php echo $this->Form->end('Enregistrer'); ?>
        </div>
    </div>

    <div class="sidebar-bloc">
        <h3>Niveaux</h3>
        <a href="" class="handlediv" title="Agrandir"></a>
        <div class="inside">
            <?php echo $this->Form->input('classes', array('label' => '','id' => 'ClasseClasse'));?> 
            <?php echo $this->Autocomplete->autocomplete('ClasseClasse','Classe/name',array('ClasseId'=>'id')); ?>
<!--            <div id="tags">
                <?php foreach($relatedTags as $tag): ?>
                        <span class="etat tag">
                            <?php echo $tag['Tag']['name']; ?> 
                            <?php echo $this->Html->link("x", array("controller" => "courtags", "action" => "delete", $tag['CourTag']['id'])); ?> 
                        </span>
                <?php endforeach; ?>
            </div>-->
        </div>
    </div>
        
        
        
        
</div>
    
<?php echo $this->Form->create('Ressource'); ?>
<?php echo $this->Form->input('id'); ?>
<?php echo $this->Form->input('name', array('label' => '')); ?>
<?php echo $this->Tinymce->input('Ressource.content', 
                        array('label' => ''),
                        array(
                            'image_explorer' => $this->Html->url(array('controller'=>'medias','action'=> 'index', "cours", $this->request->data['Ressource']['id'])),
                            'image_edit' => $this->Html->url(array('controller'=>'medias','action'=>'show'))
                        ),
                      'ressource'
            ); ?>
<?php echo $this->Form->end('Enregistrer'); ?>
