<?php echo $this->Html->css('forum', null, array('inline' => false));?>
<?php echo $this->Html->css('form', null, array('inline' => false));?>
<?php echo $this->Html->css('jquery-ui', null, array('inline' => false));?>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>

<?php $this->Html->script('tiny_mce/tiny_mce.js',array('inline'=>false)); ?>

<?php debug($ForumActive); ?>

    <div id="breadcrumbs">
	<?php echo $this->Html->link("Forum", array("controller" => "categories", "action" => "index"));?>
         >> <?php echo $ForumActive['Forum']['name'];?>
    </div>

<div class="right"><?php echo $this->Html->link('Créer une nouvelle discussion', array('admin'=>false, 'controller' => 'topics','action'=> 'add', $ForumActive['Forum']['id'], $ForumActive['Forum']['slug']),array("class"=>"modifier")); ?></div>

<?php if(!empty($topics)):?>
<div class="forum">

    <table>
     <tr>
         <th class="first">Topic</th>
         <th>Réponses</th>
         <th>Vues</th>
         <th class="last">Dernier message</th>
     </tr>
    <?php foreach ($topics as $topic): ?>
            
            <tr>
                 <td style="width: 64%">   
                     <span class="forum titre">
                        <?php echo $this->Html->link($topic['Topic']['name'], array(
                            "controller" => "posts", "action" => "index", "id" => $topic['Topic']['id'], "slug" => $topic['Topic']['slug']
                            ));?>
                     </span>
                     Par <span class="bold"><?php echo ucfirst($topic['User']['username'].','); ?></span>
                     <span class="forum description">
                        <?php echo $this->Date->show($topic['Topic']['created'], true);?>
                     </span>
                 </td>
                 <td style="width: 8%;" class="center"><?php echo $topic['Topic']['nombre_reponse']; ?></td>
                 <td style="width: 8%;" class="center"><?php echo $topic['Topic']['nombre_vue']; ?></td>
                 <td style="width: 20%;">
                     Par    <?php echo $topic['Topic']['username_last_post']; ?><br />
                            <?php echo $this->Date->Compare($topic['Topic']['modified']); ?>
                 </td>
             </tr>

                 <?php endforeach; ?>
        </table>

</div>

<?php endif; ?>

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