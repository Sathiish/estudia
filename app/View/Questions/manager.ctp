<?php echo $this->Html->css('form', null, array('inline' => false));?>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css" type="text/css" media="all" />
<?php $this->Html->script('tiny_mce/tiny_mce.js',array('inline'=>false)); ?>

<div id="breadcrumbs">
	<?php echo $this->Html->link("Gérer mes quiz", array("controller" => "quiz", "action" => "manager"), array("title" => "Voir tous mes quiz"));?>
        >> <?php echo strip_tags($info['Quiz']['name']); ?>
</div>

<?php echo $this->Html->link('Créer une nouvelle question', array('action'=> 'add', $info['Quiz']['id'], $info['Quiz']['slug']), array('class' => 'button')); ?>

<?php if($questions != array()): ?>
<table class="manager">
   <thead>
     <tr>
        <th class="first" style="text-align: center">Question</th>
        <th style="text-align: center; width:40px">Déplacer</th>
        <th class="last" style="text-align: center; width:180px">Actions</th>
     </tr>
     </thead>
     <tbody>

     <?php $i=1; foreach($questions as $question): $question = current($question); ?>
        <tr>
             <td><?php echo $question['sort_order'].') '.strip_tags($question['question']);?></td>
             <td style="text-align: center">
                <?php echo $this->Html->image('fleche_haut.png', array(
                    "url"=> array("action"=>"monter", $question['id'])
                ));?> / 
                <?php echo $this->Html->image('fleche_bas.png', array(
                    "url"=> array("action"=>"descendre", $question['id'])
                ));?>
             </td>
             <td style="text-align: center">
            <?php echo $this->Html->link($this->Html->image('editer.png'), array("controller"=>"questions","action"=>"edit", $question['id']),
                    array("title" => "Editer","title" =>"Ajouter/supprimer/modifier les réponses", "escape" => false)); ?>
            <?php echo $this->Html->link($this->Html->image('supprimer.png'), 
                     array("controller"=>"questions", "action"=>"delete", $question['id']),
                     array("title" =>"Supprimer cette", 'escape' => false),
                     "Etes-vous certain de vouloir définitivement supprimer ce cours ?"
             );?></td>

         </tr>
     <?php endforeach; ?>
     </tbody>
 </table>

<div class="modalbox"></div>

<script>
            $(document).ready(function(){
              $(".modifier").click(function () {                
                page = ($(this).attr("href"));          
                $.ajax({
                  url: page,
                  cache: false,
                  success: function(html) {
                    afficher(html);
                 },
                    error:function(XMLHttpRequest, textStatus, errorThrows){
                    }
                });
                return false;
              });
            });
         
         function afficher(data) {
              $(".modalbox").empty();
              $(".modalbox").append(data);
            }

	$(function() {		                        
		$( ".modalbox" ).dialog({
			autoOpen: false,
			height: 500,
			width: 600,
			modal: true			
		});

		$( ".modifier" )
			.button()
			.click(function() {
				$( ".modalbox" ).dialog( "open" );
			});
	});
</script>

<?php else: ?>

<p>Vous n'avez pas encore créé de questions pour ce quiz. Cliquez sur le bouton ci-dessus pour créer votre première question.<p>

<?php endif; ?>