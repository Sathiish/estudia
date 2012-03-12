<?php echo $this->Element('menu-admin'); ?>

<h1>Liste des classes</h1>
    
<table class="manager">
    <tr>
    <th class="first">Nom</th> 
    <th class="last">Action</th> 
    </tr>
    
    <?php foreach ($classes as $m):  $m = current($m); ?>
    <tr>
        <td><?php echo $m['name']; ?></td>
        <td style="text-align: center"><?php echo $this->Html->link($this->Html->image('editer.png'), array('action' => 'edit', $m['id']), array('escape' => false)); ?>
            <?php echo $this->Html->link($this->Html->image('supprimer.png'), array('action' => 'delete', $m['id']), array('escape' => false)); ?></td>
    </tr>
    
    <?php endforeach; ?>
    
    
</table>

<?php echo $this->Html->link('Ajouter une classe', array('action' => 'add'), array('class' => 'modifier'));