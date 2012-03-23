<?php echo $this->Html->css('form', null, array('inline' => false));?>

<?php echo $this->Html->link('Créer un nouveau cours', array('controller' => 'ressources', 'action'=> 'add'), array('class' => 'button')); ?>
<?php echo $this->Html->link('Créer un nouveau quiz', array("controller" => "quiz", 'action'=> 'add'), array( 'class' => 'button')); ?>

<table class="manager">
   <thead>
     <tr>
        <th class="first" colspan="2" style="text-align: center; width:450px">Cours</th>
        <th class="last" style="text-align: center; width:210px">Actions</th>
     </tr>
     </thead>
     <tbody>
     <?php foreach($ressources as $ressource): $r = current($ressource); ?>
         <tr>
             <td style="width: 30px"><?php echo $this->Html->image('/img/'.$r['type'].'.png'); ?></td>
             <td><?php echo $this->Html->link($r['name'], array("controller" => "ressources", "action" => "preview", $r['id'], $r['slug']));?></td>
             <td style="text-align: left;">
               
             <?php echo $this->Html->link($this->Html->image('editer.png'), 
                     array("controller" => "ressources", "action"=>"edit", $r['id'], $r['slug']),
                     array('class' => 'not-ajax', "escape" => false, "title" => "Editer")); ?>
             <?php echo $this->Html->link($this->Html->image('supprimer.png'), 
                     array("controller" => "ressources", "action"=>"delete", $r['id']),
                     array('class' => 'not-ajax', "title" =>"Supprimer ce cours", 'escape' => false),
                     "Etes-vous certain de vouloir définitivement supprimer ce cours et toutes les parties associées ?"
                    );
                    echo $this->Html->link('<span class="etat action">Publier</span>', 
                         array("action"=>"publier", $r['id']),
                         array("title" =>"Demander la publication de ce quizz", 'escape' => false),
                         "Une fois publié, pour modifier ce quiz, vous devrez d'abord demander sa dépublication. Souhaitez-vous toujours demander la publication dès maintenant ?"
                    );
             ?></td>
         </tr>
     <?php endforeach; ?>
         
     <?php foreach($cours as $cours_info): $c = current($cours_info); ?>
        <tr>
            <td style="width: 30px"><?php echo $this->Html->image('/img/cours-structure.png'); ?></td>
             <td><?php echo $this->Html->link($c['name'], array("controller" => "cours", "action" => "visualiser", $c['id'], $c['slug']));?><br />
             <span class="etat ressourceTitre"><?php echo $cours_info['Theme']['name'];?></span>
             <?php if($c['validation']){
                    if($c['published']){
                        echo '<span class="etat en_attente">En attente de dépublication</span>';
                    }
                    else{
                        echo '<span class="etat en_attente">En attente de publication</span>';
                    }
                }else{
                    if($c['published']){
                        echo '<span class="etat publie">Publié</span>';
                    }
                    else{
                        echo '<span class="etat non_publie">Non-publié</span>';
                    }                    
               
                }
                ?></td>
             <td style="text-align: left;">
             <?php if(!($c['published']) AND !($c['validation'])): ?>    
             <?php echo $this->Html->link($this->Html->image('editer.png'), 
                     array("controller" => "cours", "action"=>"edit", $c['id'], $c['slug']),
                     array('class' => 'not-ajax', "escape" => false, "title" => "Editer")); ?>
             <?php echo $this->Html->link($this->Html->image('supprimer.png'), 
                     array("controller" => "cours", "action"=>"delete", $c['id']),
                     array('class' => 'not-ajax', "title" =>"Supprimer ce cours", 'escape' => false),
                     "Etes-vous certain de vouloir définitivement supprimer ce cours et toutes les parties associées ?"
             );?>
             <?php endif; ?>
             <?php 
             
             if(!$c['validation']){
                 if($c['published']){
                    echo $this->Html->link('<span class="etat action">Modifier</span>', 
                         array("controller" => "parties","action"=>"manager", $c['id'], $c['slug']),
                         array("escape" => false, "title" => "Editer"));
                    echo $this->Html->link('<span class="etat action">Dépublier</span>', 
                         array("action"=>"publier", $c['id'], false),
                         array("title" =>"Demander la dépublication", 'escape' => false),
                         "Une fois dépublié, ce cours n'apparaitra plus en ligne. Vous pourrez toutefois demander sa publication à nouveau. Souhaitez-vous toujours demander sa dépublication dès maintenant ?"
                    );
                 }else{
                    echo $this->Html->link('<span class="etat action">Publier</span>', 
                         array("action"=>"publier", $c['id']),
                         array("title" =>"Demander la publication de ce quizz", 'escape' => false),
                         "Une fois publié, pour modifier ce quiz, vous devrez d'abord demander sa dépublication. Souhaitez-vous toujours demander la publication dès maintenant ?"
                    );  
                 }
                 
             
             }
             ?></td>
         </tr>
     <?php endforeach; ?>
     </tbody>
 </table>