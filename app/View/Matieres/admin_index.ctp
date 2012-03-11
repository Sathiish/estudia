<?php echo $this->Element('menu-admin'); ?>

<h1>Liste des matières</h1>
    
<table class="manager">
    <tr>
    <th class="first">Nom</th> 
    <th class="last">Action</th> 
    </tr>
    
    <?php foreach ($matieres as $m):  $m = current($m); ?>
    <tr>
        <td><?php echo $this->Html->link($m['name'], array('controller' => 'themes','action' => 'index', $m['id'])); ?></td>
        <td style="text-align: center"><?php echo $this->Html->link($this->Html->image('editer.png'), array('action' => 'edit', $m['id']), array('escape' => false)); ?>
            <?php echo $this->Html->link($this->Html->image('supprimer.png'), array('action' => 'delete', $m['id']), array('escape' => false)); ?></td>
    </tr>
    
    <?php endforeach; ?>
    
    
</table>

<?php echo $this->Html->link('Ajouter une matière', array('action' => 'add'), array('class' => 'modifier'));