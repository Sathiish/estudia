<div id="breadcrumbs">
        <?php echo $this->Html->link('Matière', array("controller" => "matieres", "action" => "index", 'cours'), array('title' => 'Toutes les matières')); ?>
        >> <?php echo $this->Html->link(strip_tags($path['Matiere']['name']), array("controller" => "cours", "action" => "theme", $path['Matiere']['id'], $path['Matiere']['slug'])); ?>
        >> <?php echo strip_tags($path['Theme']['name']); ?>
</div>

<h1>Liste des cours: <?php echo $path['Theme']['name']; ?></h1>

<br />

<table class="manager" style="width: 100%">
    <tr>
        <th class="first">Titre du cours</th>
        <th>Auteur</th>
        <th>Vues</th>
        <th class="last">Note</th>
    </tr>
<?php foreach ($cours as $c): ?>
    <tr>
    <td><?php echo $this->Html->link($c['Cour']['name'], 
            array(
                "controller" => "cours", 
                "action" => "show", 
                $c['Cour']['id'], 
                $c['Cour']['slug']
                )); ?></td>
    <td style="text-align: center"><?php echo $this->Html->link(ucfirst($c['User']['username']), 
            array(
                "controller" => "users", 
                "action" => "index", 
                $c['User']['slug']
                )); ?></td>
    <td style="text-align: center"><?php echo $c['Cour']['count']; ?></td>
    <td style="text-align: center; width: 110px;"><?php if(ceil($c['Cour']['moyenne']) >=1) echo $this->Html->image(ceil($c['Cour']['moyenne']).'etoiles.png'); ?></td>
    
    </tr>
<?php endforeach; ?>

</table>
