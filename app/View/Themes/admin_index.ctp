<?php echo $this->Element('menu-admin'); ?>

<h1>Rechercher un thème</h1>

<?php echo $this->Form->create('Theme', array('type' => 'post')); ?>
<?php echo $this->Form->input('matiere_id'); ?>
<?php echo $this->Form->input('classe_id'); ?>
<?php echo $this->Form->end('Rechercher'); ?>

<?php echo $this->Html->link('Ajouter un nouveau thème', array('action' => 'add'), array('class' => 'modifier')); ?>

<table class="manager">
    <tr>
        <th>Titre</th>
        <th>Action</th>
    </tr>

    <?php foreach($themes as $t): $t = current($t); ?>
    <tr>
        <td><?php echo $t['name']; ?></td>
        <td><?php echo $this->Html->link($this->Html->image('editer.png'), array('action' => 'edit', $t['id'], $t['slug']), array('escape' => false)); ?>
            <?php echo $this->Html->link($this->Html->image('supprimer.png'), array('action' => 'delete', $t['id'], $t['slug']), array('escape' => false)); ?></td>
    </tr>
    <?php endforeach; ?>

</table>

