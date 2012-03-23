<div id="breadcrumbs">
        <?php echo $filAriane['Classe']['name']; ?> 
        >> <?php echo $filAriane['Matiere']['name']; ?> 
</div>

<h1>Les chapitres en <?php echo strtolower($filAriane['Matiere']['name']); ?></h1>

<?php foreach ($themes as $theme): $t = current($theme); ?>
    <h3><?php echo $this->Html->link($t['name'], 
            array(
                "controller" => "cours", 
                "action" => "view", 
                $t['id'], 
                $t['slug']
                )); ?></h3>
        
<table class="manager" style="width: 100%">
    <tr>
        <th class="first">Titre du cours</th>
        <th>Auteur</th>
        <th>Vues</th>
        <th class="last">Note</th>
    </tr>
<?php foreach ($theme['Cour'] as $c): ?>
    <tr>
    <td><?php echo $this->Html->link($c['name'], 
            array(
                "controller" => "cours", 
                "action" => "show", 
                $c['id'], 
                $c['slug']
                )); ?></td>
    <td style="text-align: center"><?php echo $this->Html->link(ucfirst($c['User']['username']), 
            array(
                "controller" => "users", 
                "action" => "index", 
                $c['User']['slug']
                )); ?></td>
    <td style="text-align: center"><?php echo $c['count']; ?></td>
    <td style="text-align: center; width: 110px;"><?php if(ceil($c['moyenne']) >=1) echo $this->Html->image(ceil($c['moyenne']).'etoiles.png'); ?></td>
    
    </tr>
<?php endforeach; ?>
    
    <?php foreach ($theme['Ressource'] as $c): ?>
    <tr>
    <td><?php echo $this->Html->link($c['name'], 
            array(
                "controller" => "ressources", 
                "action" => "show", 
                $c['id'], 
                $c['slug']
                )); ?></td>
    <td style="text-align: center"><?php echo $this->Html->link(ucfirst($c['User']['username']), 
            array(
                "controller" => "users", 
                "action" => "index", 
                $c['User']['slug']
                )); ?></td>
    <td style="text-align: center"><?php echo $c['count']; ?></td>
    <td style="text-align: center; width: 110px;"><?php if(ceil($c['note']) >=1) echo $this->Html->image(ceil($c['note']).'etoiles.png'); ?></td>
    
    </tr>
<?php endforeach; ?>

</table>                      

   
    
    
    </ul>
<?php endforeach; ?>
