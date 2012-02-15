<?php echo $this->Html->css('forum', null, array('inline' => false));?>

<div class="forum">
    
    <div class="titre"><span>Tous les forums sur <?php echo $CategoryActive['Category']['name'];?></span></div>

    <?php foreach ($forums as $forum): ?>

        <h2><?php echo $this->Html->link($forum['Forum']['name'], array("controller" => "topics", "action" => "index", $forum['Forum']['id'], $forum['Forum']['slug'])); ?></h2>
        <table>
             <tr>
                 <th class="first">Topic</th>
                 <th>Réponses</th>
                 <th>Vues</th>
                 <th class="last">Dernier message</th>
             </tr>
            <?php foreach($forum['Topic'] as $topic):  ?>
            <tr>
                 <td>   
                     <span class="forum titre"><?php echo $this->Html->link($topic['name'], array("controller" => "posts", "action" => "index", $topic['id'], $topic['slug']));?></span><br />
                     <span class="forum description"><?php echo $topic['created'];?></span>
                 </td>
                 <td>Réponses</td>
                 <td>Vues</td>
                 <td>Dernier message</td>
             </tr>

                 <?php endforeach; ?>
        </table>
     <?php endforeach; ?>

</div>
