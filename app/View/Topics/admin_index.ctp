<?php echo $this->Html->css('form', null, array('inline' => false));?>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css" type="text/css" media="all" />
<?php $this->Html->script('tiny_mce/tiny_mce.js',array('inline'=>false)); ?>

<h1>Créer/modifier les topics de <?php echo $ForumActive['Forum']['name'];?></h1>

<?php echo $this->Html->link('+ Ajouter un nouveau topic', array('admin' => false,'controller' => 'topics','action'=> 'add', $this->params->pass[0]),array("class"=>"modifier")); ?>

<table id="parties">
    <thead>
         <tr>
            <th style="text-align: center">Titre de la partie</th>
            <th style="text-align: center">Actions</th>
         </tr>
     </thead>
     <tbody>
       <?php foreach($topics as $id=>$titre): ?>
        <tr>
             <td><?php echo $titre;?></td>
             <td style="text-align: center">  
                <?php echo $this->Html->link($this->Html->image('editer.png')." Modifier", 
                        array("action"=>"edit", $id),
                        array("class"=>"modifier", "escape"=>false)); ?>
                <?php echo $this->Html->link($this->Html->image('editer.png')." Gérer les posts", 
                        array("controller" => "posts","action"=>"index", $id),
                        array("escape"=>false)); ?>
                <?php echo $this->Html->link($this->Html->image('supprimer.png'), 
                     array('controller' => 'topics', "action"=>"delete", $id),
                     array("title" =>"Supprimer cette partie", 'escape' => false),
                     "Etes-vous certain de vouloir définitivement supprimer ce cours ?"
                );?>
             </td>
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