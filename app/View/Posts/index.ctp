<?php echo $this->Html->css('forum', null, array('inline' => false));?>
<?php echo $this->Html->css('form', null, array('inline' => false));?>

<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css" type="text/css" media="all" />
<?php $this->Html->script('tiny_mce/tiny_mce.js',array('inline'=>false)); ?>

<?php echo $this->Html->link('Répondre', array('controller' => 'posts','action'=> 'add', $TopicActive['Topic']['id'], $TopicActive['Topic']['slug']),array("class"=>"modifier")); ?>

<?php //debug($TopicActive); ?>
<div id="breadcrumbs">
	<?php echo $this->Html->link("Forum", array("controller" => "categories", "action" => "index"));?>
            >> <?php echo $this->Html->link($TopicActive['Forum']['name'], array("controller" => "topics", "action" => "index", $TopicActive['Forum']['id'], $TopicActive['Forum']['slug']));?>
            >> <?php echo $TopicActive['Topic']['name'];?>
</div>

<div class="forum">

    <table>
     <tr>
         <th class="first">Auteur</th>
         <th class="last" style="text-align: left"># <?php echo $TopicActive['Topic']['name'];?></th>
     </tr>
     <tr>
                 <td><?php echo $TopicActive['User']['username'];?></td>
                 <td>   
                     <span class="forum titre"><?php echo $TopicActive['Topic']['created'];?></span><br />
                     <span class="forum description"><?php echo $TopicActive['Topic']['content'];?></span>
                 </td>
     </tr>
    <?php foreach ($posts as $post): ?>
            
            <tr>
                 <td><?php echo $post['User']['username'];?></td>
                 <td>   
                     <span class="forum titre"><?php echo $post['Post']['created'];?></span><br />
                     <span class="forum description"><?php echo $post['Post']['content'];?></span>
                 </td>
             </tr>

                 <?php endforeach; ?>
        </table>
    <?php echo $this->Html->link('Répondre', array('controller' => 'posts','action'=> 'add', $TopicActive['Topic']['id'], $TopicActive['Topic']['slug']),array("class"=>"modifier")); ?>

</div>

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
			height: 560,
			width: 700,
			modal: true			
		});

		$( ".modifier" )
			.button()
			.click(function() {
				$( ".modalbox" ).dialog( "open" );
			});
	});
	</script>