<?php echo $this->Html->css('form', null, array('inline' => false));?>

<span class="etat action"><?php echo $this->Html->link('En attente de publication', array('controller' => 'quiz', 'action'=> 'manager', "unpublished","enattente")); ?></span>
<span class="etat action"><?php echo $this->Html->link('En attente de dépublication', array('controller' => 'quiz', 'action'=> 'manager', "published","enattente")); ?></span>
<span class="etat action"><?php echo $this->Html->link('Publié', array('controller' => 'quiz', 'action'=> 'manager', "published")); ?></span>
<span class="etat action"><?php echo $this->Html->link('Non-Publié', array('controller' => 'quiz', 'action'=> 'manager', "unpublished")); ?></span>


<table class="manager">
   <thead>
     <tr>
        <th class="first" style="text-align: center">Cours</th>
        <th class="last" style="text-align: center; width:210px">Actions</th>
     </tr>
     </thead>
     <tbody>
     <?php foreach($q as $quiz_info): $c = current($quiz_info); ?>
        <tr>
             <td><?php echo $this->Html->link($c['name'], array("controller" => "quiz", "action" => "visualiser", $c['id'], $c['slug']));?><br />
             <span class="etat ressourceTitre"><?php echo $quiz_info['Theme']['name'];?></span>
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
                     array("action"=>"edit", $c['id'], $c['slug'], "admin" => false),
                     array("escape" => false, "title" => "Editer")); ?>
             <?php echo $this->Html->link($this->Html->image('supprimer.png'), 
                     array("action"=>"delete", $c['id'], "admin" => false),
                     array("title" =>"Supprimer ce quiz", 'escape' => false),
                     "Etes-vous certain de vouloir définitivement supprimer ce cours et toutes les parties associées ?"
             );?>
             <?php endif; ?>
             <?php 
             
             if(!$c['validation']){
                 if($c['published']){
                    echo $this->Html->link('<span class="etat action">Ajouter/dépublier une partie</span>', 
                         array("controller" => "questions","action"=>"manager", $c['id'], $c['slug']),
                         array("escape" => false, "title" => "Editer"));
                    echo $this->Html->link('<span class="etat action">Mettre hors-ligne</span>', 
                         array("action"=>"publier", $c['id'], "admin" => false),
                         array('escape' => false),
                         "Mettre hors-ligne maintenant ?"
                    );
                 }else{
                    echo $this->Html->link('<span class="etat action">Mettre en ligne</span>', 
                         array("action"=>"publier", $c['id'], "admin" => false),
                         array('escape' => false),
                         "Mettre en ligne maintenant ?"
                    );  
                 }             
             }else{
                 if($c['published']){
                    echo $this->Html->link('<span class="etat action">Mettre hors-ligne</span>', 
                         array("action"=>"publier", $c['id'], "unpublish", $c['token'], "admin" => false),
                         array('escape' => false),
                         "Mettre hors-ligne maintenant ?"
                    );
                 }else{
                    echo $this->Html->link('<span class="etat action">Mettre en ligne</span>', 
                         array("action"=>"publier", $c['id'], "publish", $c['token'], "admin" => false),
                         array('escape' => false),
                         "Mettre en ligne maintenant ?"
                    );  
                 }     
             }
             ?></td>
         </tr>
     <?php endforeach; ?>
     </tbody>
 </table>