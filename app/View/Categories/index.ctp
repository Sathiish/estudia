<?php echo $this->Html->css('forum', null, array('inline' => false));?>

<div class="titre"><?php echo $this->Html->image('titre/titre_forum.png', array('alt' => 'Titre Forum','width'=>'86', 'height'=>'21')); ?></div>
    
     
<div class="forum">
     <?php foreach($categories as $category):  ?>
<div class="bulle category"><?php echo $category['Category']['name'];?></div>
     
     <table>
         <tr>
             <th colspan="2" class="first">Forums</th>
             <th>Sujets</th>
             <th class="last">Dernier message</th>
         </tr>
         <?php foreach($category['Forum'] as $forum):  ?>
        <tr>
            <td></td>
             <td style="width:60%">   
                 <span class="forum titre"><?php echo $this->Html->link($forum['name'], array("controller" => "topics", "action" => "index", "id" => $forum['id'], "slug" => $forum['slug']));?></span>
                 <span class="forum description"><?php echo strip_tags($forum['description']);?></span>
             </td>
             <td style="width:5%;" class="center"><?php echo $forum['nombre_topic']; ?></td>
             <td style="width:35%">
                <?php echo $this->Html->link($forum['name_last_topic'], array("controller" => "posts", "action" => "index", $forum['last_topic'])); ?>
                <?php echo $this->Date->Compare($forum['modified']); ?>
             </td>
         </tr>

             <?php endforeach; ?>
   </table>

     <?php endforeach; ?>

</div>