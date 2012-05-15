<div class="sidebar">
    <div class="sidebar-bloc">
        <h3>Chapitre</h3>
        <a href="" class="handlediv" title="Agrandir"></a>
        <div class="inside" style="position:relative">
            <?php echo $this->Form->create('Ressource'); ?>
            <?php echo $this->Form->input('id'); ?>

            <?php echo $this->Form->input('niveau', array('type' => 'select', 'style' => 'display:none')); ?>
            <span id="niveau"><?php echo $filAriane['Theme']['Matiere']['Classe']['Niveau']['name']; ?></span>
            
            <?php echo $this->Form->input('classe', array('type' => 'select', 'style' => 'display:none')); ?>
            <span id="classe"><?php echo $filAriane['Theme']['Matiere']['Classe']['name']; ?></span>
            
            <?php echo $this->Form->input('matiere', array('type' => 'select', 'style' => 'display:none')); ?>
            <span id="matiere"><?php echo $filAriane['Theme']['Matiere']['name']; ?></span>
            
            <?php echo $this->Form->input('theme_id', array('type' => 'select', 'style' => 'display:none')); ?>
            <span id="theme"><?php echo $filAriane['Theme']['name']; ?></span>
            
            
            <div id="chapitre-submit" style="visibility: hidden">
                <?php echo $this->Form->end('Enregistrer'); ?>
            </div>
            
            <a href="#" id="annuler" class="modifier" style="margin-top: 20px; display:none; position: absolute; right:30px; bottom: 10px;">Annuler</a>
            <a href="#" id="modifier" class="modifier" style="margin-top: 20px; position: absolute; right:30px; bottom: 10px;">Modifier</a>
            
        </div>
    </div>
    
    <div class="sidebar-bloc">
        <h3>Niveau de difficulté</h3>
        <a href="" class="handlediv" title="Agrandir"></a>
        <div class="inside">
            <?php echo $this->Form->create('Ressource'); ?>
            <?php echo $this->Form->input('id'); ?>
            <?php echo $this->Form->radio('difficulty', $difficulty, array('label' => '', 'legend' => 'Niveau de difficulté')); ?>
            <?php echo $this->Form->end('Enregistrer'); ?>
        </div>
    </div>
    
    <div class="sidebar-bloc">
        <h3>Format</h3>
        <a href="" class="handlediv" title="Agrandir"></a>
        <div class="inside">
            <?php echo $this->Form->create('Ressource'); ?>
            <?php echo $this->Form->input('id'); ?>
            <?php echo $this->Form->input('type', array('label' => 'Type de ressource')); ?>
            <?php echo $this->Form->end('Enregistrer'); ?>
        </div>
    </div>
           <div class="sidebar-bloc">
        <h3>Publier</h3>
        <a href="" class="handlediv" title="Agrandir"></a>
        <div class="inside">
            <?php echo $this->Html->link('Prévisualiser les modifications', array("controller" => "cours", "action" => "preview", $this->data['Ressource']['id'], $this->data['Ressource']['slug']), array('class' => 'modifier', 'target' => 'onBlank')); ?>
            <div class="clr"></div>

            <p><span class="bold">Statut :</span> 
                <?php if($this->data['Ressource']['validation']){
                        if($this->data['Ressource']['published']){
                                echo '<span class="waiting">En attente de dépublication</span>';
                            }
                            else{
                                echo '<span class="waiting">En attente de publication</span>';
                            }
                        }else{
                            if($this->data['Cour']['published']){
                                echo '<span class="published">Publié</span>';
                            }
                            else{
                                echo '<span class="unpublished">Non-publié</span>';
                            }                    
                        }
                ?></p>
            <?php 

                 if(!$this->data['Ressource']['validation']){
                     if($this->data['Ressource']['published']){
                        echo $this->Html->link('Demander la mise hors-ligne', 
                             array("action"=>"askforunreleased", $this->data['Ressource']['id']),
                             array("title" =>"Demander la publication de ce quiz", 'class' => 'modifier', 'escape' => false),
                             "Une fois dépublié, ce quiz n'apparaitra plus en ligne. Vous pourrez toutefois demander sa publication à nouveau. Souhaitez-vous toujours demander sa dépublication dès maintenant ?"
                        );
                     }else{
                        echo $this->Html->link('Publier', 
                             array("action"=>"publier", $this->data['Ressource']['id']),
                             array("title" =>"Demander la publication de ce quiz", 'class' => 'modifier', 'escape' => false),
                             "Une fois publié, pour modifier ce quiz, vous devrez d'abord demander sa dépublication. Souhaitez-vous toujours demander la publication dès maintenant ?"
                        );  
                     }      
                 }else{
                    echo $this->Html->link('Annuler la demande', 
                         array("action"=>"askforunreleased", $this->data['Ressource']['id']),
                         array("title" =>"Demander la publication de ce quizz", 'class' => 'modifier', 'escape' => false),
                         "Une fois dépublié, ce quiz n'apparaitra plus en ligne. Vous pourrez toutefois demander sa publication à nouveau. Souhaitez-vous toujours demander sa dépublication dès maintenant ?"
                    );      
                 }
                 ?>
            <div class="clr"></div>
        </div>
    </div>
        
</div>
    
<div id="breadcrumbs">
        <?php echo $filAriane['Theme']['Matiere']['Classe']['name']; ?> 
        >> <?php echo $filAriane['Theme']['Matiere']['name']; ?> 
        >> <?php echo $filAriane['Theme']['name']; ?> 
        >> <?php echo $filAriane['Ressource']['name']; ?> 
</div>

<?php echo $this->Form->create('Ressource'); ?>
<?php echo $this->Form->input('id'); ?>
<?php echo $this->Form->input('name', array('label' => '')); ?>
<?php echo $this->Tinymce->input('Ressource.content', 
                        array('label' => ''),
                        array(
                            'image_explorer' => $this->Html->url(array('controller'=>'medias','action'=> 'index', "ressource", $this->request->data['Ressource']['id'])),
                            'image_edit' => $this->Html->url(array('controller'=>'medias','action'=>'show'))
                        ),
                      'ressource'
            ); ?>
<?php echo $this->Form->end('Enregistrer'); ?>

<?php $this->Html->script('ressource', array('inline' => false)); ?>
