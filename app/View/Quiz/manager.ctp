<?php echo $this->Html->css('form', null, array('inline' => false));?>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css" type="text/css" media="all" />
<?php $this->Html->script('tiny_mce/tiny_mce.js',array('inline'=>false)); ?>

<?php echo $this->Html->link('Créer un nouveau quiz', array('action'=> 'add'), array( 'class' => 'button')); ?>

<table class="manager">
   <thead>
     <tr>
        <th class="first" style="width:650px">Quiz</th>
        <th class="last" style="width:100px">Actions</th>
     </tr>
     </thead>
     <tbody>
     <?php foreach($quizz as $quiz_info): $quiz = current($quiz_info); ?>
        <tr>
             <td><?php echo $quiz['name'];?><br />
             <span class="etat ressourceTitre"><?php echo $quiz_info['Theme']['name'];?></span>
             <?php if($quiz['validation']){
                    if($quiz['public']){
                        echo '<span class="etat en_attente">En attente de dépublication</span>';
                    }
                    else{
                        echo '<span class="etat en_attente">En attente de publication</span>';
                    }
                }else{
                    if($quiz['public']){
                        echo '<span class="etat publie">Publié</span>';
                    }
                    else{
                        echo '<span class="etat non_publie">Non-publié</span>';
                    }                    
               
                }
                ?></td>
             <td style="text-align: center; vertical-align: middle">
             <?php if(!($quiz_info['Quiz']['public']) AND !($quiz_info['Quiz']['validation'])): ?>    
             <?php echo $this->Html->link($this->Html->image('editer.png'), array("action"=>"edit", $quiz['id'], $quiz['slug']),array("escape" => false)); ?>
             <?php echo $this->Html->link($this->Html->image('supprimer.png'), 
                     array("action"=>"delete", $quiz['id']),
                     array("title" =>"Supprimer cette", 'escape' => false),
                     "Etes-vous certain de vouloir définitivement supprimer ce cours ?"
             );?>
             <?php endif; ?>
             <?php 
             
             if(!$quiz['validation']){
                 if($quiz['public']){
                    echo $this->Html->link('<span class="etat action">Dépublier</span>', 
                         array("action"=>"askforunreleased", $quiz['id']),
                         array("title" =>"Demander la publication de ce quizz", 'escape' => false),
                         "Une fois dépublié, ce quiz n'apparaitra plus en ligne. Vous pourrez toutefois demander sa publication à nouveau. Souhaitez-vous toujours demander sa dépublication dès maintenant ?"
                    );
                 }else{
                    echo $this->Html->link('<span class="etat action">Publier</span>', 
                         array("action"=>"askforreleased", $quiz['id']),
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