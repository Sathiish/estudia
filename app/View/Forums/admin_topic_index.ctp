<?php echo $this->Html->css('form', null, array('inline' => false));?>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css" type="text/css" media="all" />
<?php $this->Html->script('tiny_mce/tiny_mce.js',array('inline'=>false)); ?>

<?php echo $this->Html->link('+ Créer un nouveau topic', array('controller' => 'forums','action'=> 'topic_add'),array("class"=>"modifier")); ?>

<table id="parties">
   <thead>
     <tr>
        <th style="text-align: center">Titre du cours</th>
        <th style="text-align: center">Actions</th>
     </tr>
     </thead>
     <tbody>
     <?php foreach($topics as $id=>$name):  ?>
        <tr>
             <td><?php echo $name;?></td>
             <td style="text-align: center">
             <?php echo $this->Html->link($this->Html->image('editer.png')." Modifier", array("controller" => "topics","action"=>"edit", $id),array("class" =>"modifier", "escape" => false)); ?>
             
            <?php echo $this->Html->link("Gérer les topics", array("controller" => "topics","action"=>"edit", $id),array("title" =>"Gérer les posts", "escape"=>false)); ?>
            <?php echo $this->Html->link($this->Html->image('supprimer.png'), 
                     array("action"=>"delete", $id),
                     array("title" =>"Supprimer ce cours", 'escape' => false),
                     "Etes-vous certain de vouloir définitivement supprimer ce cours ?"
             );?> </td>

         </tr>
     <?php endforeach; ?>
     </tbody>
 </table>

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
        
<div class="modalbox"></div>